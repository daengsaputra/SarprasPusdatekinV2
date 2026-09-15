<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PegawaiSearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = trim((string) $request->input('q', ''));

        if (mb_strlen($query) < 2) {
            return response()->json(['results' => []]);
        }

        $token = session('brin_sso_access_token');
        if (!$token) {
            return response()->json([
                'results' => [],
                'message' => 'Token SSO tidak ditemukan. Silakan login ulang.',
            ], 401);
        }

        $baseUrl = rtrim((string) config('sso.api_siatap_url'), '/');
        if ($baseUrl === '') {
            return response()->json([
                'results' => [],
                'message' => 'URL API SIATAP BPIP belum dikonfigurasi.',
            ], 500);
        }

        try {
            $pegawai = Cache::remember($this->cacheKey($token), now()->addMinutes(30), function () use ($baseUrl, $token) {
                $response = Http::withToken($token)
                    ->acceptJson()
                    ->timeout(30)
                    ->get($baseUrl . '/hrms/pegawai/allasn');

                if (!$response->successful()) {
                    throw new \RuntimeException('API pegawai BPIP mengembalikan HTTP ' . $response->status());
                }

                $data = $response->json('data');
                if (!is_array($data)) {
                    throw new \RuntimeException('Response API pegawai BPIP tidak memiliki field data.');
                }

                return $data;
            });
        } catch (\Throwable $e) {
            Log::error('Gagal mengambil daftar pegawai BPIP: ' . $e->getMessage());

            return response()->json([
                'results' => [],
                'message' => 'Gagal mengambil daftar pegawai BPIP.',
            ], 502);
        }

        $needle = Str::lower($query);
        $results = collect($pegawai)
            ->filter(function (array $item) use ($needle) {
                $haystack = Str::lower(implode(' ', array_filter([
                    Arr::get($item, 'nip'),
                    Arr::get($item, 'nama'),
                    Arr::get($item, 'name'),
                    Arr::get($item, 'jabatan_name'),
                    Arr::get($item, 'satker_affiliate_text'),
                    Arr::get($item, 'satker_administrative_text'),
                ])));

                return Str::contains($haystack, $needle);
            })
            ->take(15)
            ->map(fn (array $item) => $this->normalizePegawai($item))
            ->values();

        return response()->json(['results' => $results]);
    }

    private function normalizePegawai(array $item): array
    {
        $nip = (string) Arr::get($item, 'nip', '');
        $nama = (string) (Arr::get($item, 'nama') ?: Arr::get($item, 'name') ?: $nip);
        $gelarDepan = trim((string) Arr::get($item, 'front_academic_title', ''));
        $gelarBelakang = trim((string) Arr::get($item, 'back_academic_title', ''));

        $namaLengkap = trim(($gelarDepan && $gelarDepan !== '-' ? $gelarDepan . ' ' : '') . $nama);
        if ($gelarBelakang !== '' && $gelarBelakang !== '-') {
            $namaLengkap .= ', ' . $gelarBelakang;
        }

        $unit = (string) (Arr::get($item, 'satker_affiliate_text') ?: Arr::get($item, 'satker_administrative_text') ?: Arr::get($item, 'satker_penempatan_text') ?: '');
        $contact = (string) (Arr::get($item, 'email') ?: Arr::get($item, 'email_kantor') ?: Arr::get($item, 'no_hp') ?: $nip);

        return [
            'nip' => $nip,
            'name' => $namaLengkap,
            'contact' => $contact,
            'unit' => $unit,
            'jabatan' => Arr::get($item, 'jabatan_name'),
            'pangkat' => Arr::get($item, 'gp_pangkat_text'),
        ];
    }

    private function cacheKey(string $token): string
    {
        return 'bpip_pegawai_allasn_' . sha1($token);
    }
}
