<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SsoRoleOverride;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\GenericProvider;

/**
 * SSO Broker (OAuth2 authorization-code flow) untuk login pegawai BPIP.
 *
 * Pola alur ini diadaptasi dari project sinergi (SSOBrokerController) tetapi
 * disederhanakan: role hanya 3 nilai (super_admin, petugas, peminjam) dan
 * dimapping melalui tabel `sso_role_overrides` (default: peminjam).
 */
class SsoController extends Controller
{
    private function provider(): GenericProvider
    {
        return new GenericProvider([
            'clientId'                => config('sso.client_id'),
            'clientSecret'            => config('sso.client_secret'),
            'redirectUri'             => config('sso.redirect_uri'),
            'urlAuthorize'            => config('sso.authorization_url'),
            'urlAccessToken'          => config('sso.access_token_url'),
            'urlResourceOwnerDetails' => config('sso.resource_owner_details_url'),
        ]);
    }

    /** Halaman /login: tombol "Masuk dengan SSO BPIP". */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->intended('/dashboard');
        }

        return view('auth.login');
    }

    /** Mulai authorization-code flow. */
    public function redirectToProvider(Request $request)
    {
        if (!config('sso.enabled')) {
            return redirect('/')->with('error', 'SSO sedang dinonaktifkan.');
        }

        $missing = collect([
            'client_id', 'client_secret', 'redirect_uri',
            'authorization_url', 'access_token_url', 'resource_owner_details_url',
        ])->filter(fn ($k) => empty(config('sso.' . $k)))->values();

        if ($missing->isNotEmpty()) {
            Log::error('SSO config tidak lengkap', ['missing' => $missing->all()]);
            return redirect('/login')->with('error', 'Konfigurasi SSO belum lengkap. Hubungi administrator.');
        }

        $provider = $this->provider();
        $authUrl  = $provider->getAuthorizationUrl();

        $request->session()->put('oauth2state', $provider->getState());
        $request->session()->save();

        return redirect()->away($authUrl);
    }

    /** Callback dari SSO provider. */
    public function callback(Request $request)
    {
        if (!$request->has('code')) {
            return redirect('/login')->with('error', 'Kode otorisasi tidak ditemukan.');
        }

        $expectedState = $request->session()->pull('oauth2state');
        if (!$request->input('state') || $request->input('state') !== $expectedState) {
            Log::warning('SSO state mismatch', [
                'received' => $request->input('state'),
                'expected' => $expectedState,
            ]);
            return redirect('/login')->with('error', 'State tidak valid. Silakan login kembali.');
        }

        $provider = $this->provider();

        try {
            $accessToken = $provider->getAccessToken('authorization_code', [
                'code' => $request->input('code'),
            ]);
        } catch (IdentityProviderException $e) {
            Log::error('SSO token exchange gagal: ' . $e->getMessage());
            return redirect('/login')->with('error', 'Gagal mendapatkan akses token: ' . $e->getMessage());
        } catch (Exception $e) {
            Log::error('SSO token exchange exception: ' . $e->getMessage());
            return redirect('/login')->with('error', 'Terjadi kesalahan saat autentikasi.');
        }

        // Simpan token utk pemakaian API SIMPEG selanjutnya.
        session(['brin_sso_access_token' => $accessToken->getToken()]);

        try {
            $apiRequest = $provider->getAuthenticatedRequest(
                'GET',
                rtrim((string) config('sso.api_bpip_url'), '/') . '/auth/detail',
                $accessToken,
                ['headers' => ['Content-Type' => 'application/json']]
            );
            $detail = $provider->getParsedResponse($apiRequest);
        } catch (Exception $e) {
            Log::error('SSO get user detail gagal: ' . $e->getMessage());
            return redirect('/login')->with('error', 'Gagal mengambil data user dari SSO.');
        }

        $pegawai  = $detail['pegawaiData'] ?? [];
        $userData = $detail['userData'] ?? [];
        $nip      = $pegawai['nip'] ?? null;

        if (!$nip) {
            Log::warning('SSO response tanpa NIP', ['detail_keys' => array_keys($detail)]);
            return redirect('/login')->with('error', 'Data pegawai tidak lengkap dari SSO.');
        }

        $email = $userData['email'] ?? null;
        if (!$email || $email === 'sdm@bpip.id') {
            $email = $nip . '@bpip.go.id';
        }

        $user = User::where('nip', $nip)->first();

        $assignedRole = SsoRoleOverride::roleFor($nip) ?? config('sso.default_role');

        $payload = [
            'nip'             => $nip,
            'name'            => $pegawai['name'] ?? ($userData['name'] ?? $nip),
            'email'           => $email,
            'username_intra'  => $userData['username'] ?? null,
            'jabatan'         => $pegawai['jabatan_name'] ?? null,
            'unit_kerja'      => $pegawai['satker_affiliate_text'] ?? null,
            'photo_url'       => $userData['photo_url'] ?? null,
            'role'            => $assignedRole,
            'last_sso_login_at' => now(),
        ];

        if ($user) {
            // Selalu refresh role dari override (atau default) supaya perubahan langsung berlaku.
            $user->fill($payload);
            $user->save();
        } else {
            $user = User::create(array_merge($payload, [
                'password' => bcrypt(str()->random(40)), // tidak dipakai login
            ]));
        }

        Auth::login($user, true);
        $request->session()->regenerate();

        // Simpan ringkasan data SSO untuk konsumsi UI (contoh: autofill borrower).
        session([
            'authUserData' => json_decode(json_encode($detail)),
        ]);

        return redirect()->intended('/dashboard')->with('success', 'Selamat datang, ' . $user->name);
    }

    /** Logout lokal lalu redirect ke SSO logout (kalau dikonfigurasi). */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $ssoDomain = (string) config('sso.sso_domain');
        if ($ssoDomain !== '') {
            $redirect = config('app.url');
            return redirect()->away(rtrim($ssoDomain, '/') . '/logout?redirect_uri=' . urlencode((string) $redirect));
        }

        return redirect('/');
    }
}
