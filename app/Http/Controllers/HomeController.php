<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Loan;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('root');
    }

    /**
     * Menampilkan halaman utama
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function root()
    {
        $videoMeta = SiteSetting::landingVideoMeta();

        $availableAssetsQuery = Asset::query()
            ->where('kind', Asset::KIND_LOANABLE)
            ->where('status', 'active')
            ->where('quantity_available', '>', 0);

        $availableAssets = (clone $availableAssetsQuery)
            ->orderByDesc('quantity_available')
            ->orderBy('name')
            ->get();

        $availableUnits = (int) (clone $availableAssetsQuery)->sum('quantity_available');

        $activeLoansQuery = Loan::query()
            ->with('asset:id,name,code,photo')
            ->whereIn('status', ['borrowed', 'partial'])
            ->whereRaw('quantity > COALESCE(quantity_returned, 0)');

        $activeLoans = (clone $activeLoansQuery)
            ->orderByDesc('loan_date')
            ->orderByDesc('id')
            ->get();

        $inUseUnits = (int) (clone $activeLoansQuery)
            ->selectRaw('COALESCE(SUM(CASE WHEN quantity > COALESCE(quantity_returned, 0) THEN quantity - COALESCE(quantity_returned, 0) ELSE 0 END), 0) as total')
            ->value('total');

        return view('landing', [
            'landingVideoUrl' => $videoMeta['url'],
            'landingVideoMime' => $videoMeta['mime'],
            'summaryData' => [
                'available' => $availableUnits,
                'in_use' => $inUseUnits,
            ],
            'availableAssets' => $availableAssets,
            'activeLoans' => $activeLoans,
        ]);
    }

    /**
     * Menampilkan halaman dashboard
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('dashboard');
    }

    /**
     * Data grafik peminjaman petugas bulan berjalan (untuk auto-refresh dashboard).
     */
    public function petugasMonthlyChart(): JsonResponse
    {
        return response()->json($this->buildPetugasMonthlyChartData());
    }

    /**
     * Bangun dataset grafik peminjaman petugas untuk bulan berjalan.
     */
    private function buildPetugasMonthlyChartData(): array
    {
        $periodStart = now()->copy()->startOfMonth();
        $periodEnd = now()->copy()->endOfDay();

        $dayKeys = collect(range(0, $periodStart->diffInDays($periodEnd)))
            ->map(fn ($offset) => $periodStart->copy()->addDays($offset)->format('Y-m-d'));

        $dayLabels = $dayKeys
            ->map(function ($key) {
                try {
                    return \Carbon\Carbon::createFromFormat('Y-m-d', $key)->translatedFormat('d M');
                } catch (\Throwable $e) {
                    return $key;
                }
            })
            ->values();

        $petugasNames = User::query()
            ->where('role', User::ROLE_PETUGAS)
            ->pluck('name')
            ->filter(fn ($name) => !empty($name))
            ->values();

        $petugasLoanRows = Loan::query()
            ->selectRaw("DATE(loan_date) as day_key, borrower_name, COUNT(*) as total")
            ->whereBetween('loan_date', [$periodStart->toDateString(), $periodEnd->toDateString()])
            ->whereNotNull('borrower_name')
            ->when($petugasNames->isNotEmpty(), fn ($query) => $query->whereIn('borrower_name', $petugasNames))
            ->groupBy('day_key', 'borrower_name')
            ->get();

        $topPetugas = $petugasLoanRows
            ->groupBy('borrower_name')
            ->map(fn ($rows) => (int) $rows->sum('total'))
            ->sortDesc()
            ->keys()
            ->take(6)
            ->values();

        if ($topPetugas->isEmpty() && $petugasNames->isNotEmpty()) {
            $topPetugas = $petugasNames->take(6)->values();
        }

        $series = $topPetugas->map(function ($petugas) use ($dayKeys, $petugasLoanRows) {
            return [
                'name' => $petugas,
                'data' => $dayKeys
                    ->map(function ($dayKey) use ($petugas, $petugasLoanRows) {
                        $row = $petugasLoanRows->first(function ($item) use ($petugas, $dayKey) {
                            return $item->borrower_name === $petugas && $item->day_key === $dayKey;
                        });

                        return (int) ($row->total ?? 0);
                    })
                    ->values()
                    ->all(),
            ];
        })->values();

        return [
            'labels' => $dayLabels->all(),
            'series' => $series->all(),
            'grand_total' => (int) $petugasLoanRows->sum('total'),
            'officer_count' => (int) $series->count(),
            'period_start' => $periodStart->translatedFormat('d M Y'),
            'period_end' => $periodEnd->translatedFormat('d M Y'),
            'generated_at' => now()->toIso8601String(),
        ];
    }
}
