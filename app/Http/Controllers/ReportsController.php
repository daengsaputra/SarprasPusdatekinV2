<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ReportsController extends Controller
{
    private function resolveRange(Request $request): array
    {
        $range = $request->query('range', 'month');
        $now = Carbon::now();

        return match ($range) {
            'week' => [$range, $now->copy()->subDays(7)->startOfDay(), $now->copy()->endOfDay(), '7 Hari Terakhir'],
            'year' => [$range, $now->copy()->startOfYear(), $now->copy()->endOfDay(), 'Tahun Ini'],
            'custom' => [
                $range,
                Carbon::parse($request->query('start', $now->copy()->startOfMonth()))->startOfDay(),
                Carbon::parse($request->query('end', $now))->endOfDay(),
                'Rentang Kustom',
            ],
            default => ['month', $now->copy()->subDays(30)->startOfDay(), $now->copy()->endOfDay(), '30 Hari Terakhir'],
        };
    }

    private function resolveType(Request $request): string
    {
        $type = (string) $request->query('type', 'all');
        return in_array($type, ['all', 'loans', 'returns'], true) ? $type : 'all';
    }

    private function buildReportQuery(Request $request, Carbon $start, Carbon $end, string $type)
    {
        $search = trim((string) $request->query('q'));
        $unit = $request->query('unit');
        $status = $request->query('status');

        $dateColumn = $type === 'returns' ? 'return_date_actual' : 'loan_date';

        return Loan::query()
            ->with('asset')
            ->when($type === 'returns', fn($q) => $q->where('status', 'returned'))
            ->when($type !== 'returns' && $status, fn($q) => $q->where('status', $status))
            ->when($unit, fn($q) => $q->where('unit', $unit))
            ->when($search, function ($query) use ($search) {
                $pattern = '%' . $search . '%';
                $query->where(function ($q) use ($pattern) {
                    $q->where('borrower_name', 'like', $pattern)
                        ->orWhereHas('asset', fn($asset) => $asset
                            ->where('name', 'like', $pattern)
                            ->orWhere('code', 'like', $pattern));
                });
            })
            ->whereBetween($dateColumn, [$start->toDateTimeString(), $end->toDateTimeString()]);
    }

    private function applySorting($query, string $sort, string $dir, string $type)
    {
        $map = [
            'loan_date' => 'loan_date',
            'return_date_actual' => 'return_date_actual',
            'return_date_planned' => 'return_date_planned',
            'quantity' => 'quantity',
            'borrower_name' => 'borrower_name',
            'unit' => 'unit',
            'status' => 'status',
        ];

        if ($sort === 'asset') {
            $query->leftJoin('assets as a', 'a.id', '=', 'loans.asset_id')
                ->select('loans.*')
                ->orderBy('a.name', $dir);
        } elseif (array_key_exists($sort, $map)) {
            $query->orderBy($map[$sort], $dir);
        } else {
            $query->orderBy($type === 'returns' ? 'return_date_actual' : 'loan_date', 'desc');
        }

        return $query;
    }

    public function index(Request $request)
    {
        [$rangeKey, $start, $end, $rangeLabel] = $this->resolveRange($request);
        $type = $this->resolveType($request);
        $sort = $request->query('sort', $type === 'returns' ? 'return_date_actual' : 'loan_date');
        $dir = $request->query('dir', 'desc') === 'asc' ? 'asc' : 'desc';

        $baseQuery = $this->buildReportQuery($request, $start, $end, $type);
        $tableQuery = $this->applySorting(clone $baseQuery, $sort, $dir, $type);
        $records = $tableQuery->paginate(15)->withQueryString();

        $summary = [
            'periode' => $rangeLabel,
            'start' => $start->toDateString(),
            'end' => $end->toDateString(),
            'total_transaksi' => (clone $baseQuery)->count(),
            'total_jumlah' => (clone $baseQuery)->sum('quantity'),
            'total_dikembalikan' => (clone $baseQuery)->where('status', 'returned')->count(),
        ];

        return view('reports.index', [
            'records' => $records,
            'summary' => $summary,
            'rangeKey' => $rangeKey,
            'start' => $start,
            'end' => $end,
            'units' => config('bpip.units', []),
            'filters' => $request->all(),
            'sort' => $sort,
            'dir' => $dir,
            'type' => $type,
        ]);
    }

    public function pdf(Request $request)
    {
        [$rangeKey, $start, $end] = $this->resolveRange($request);
        $type = $this->resolveType($request);
        $rows = $this->buildReportQuery($request, $start, $end, $type)
            ->orderBy($type === 'returns' ? 'return_date_actual' : 'loan_date')
            ->get();

        $title = match ($type) {
            'loans' => 'Laporan Peminjaman',
            'returns' => 'Laporan Pengembalian',
            default => 'Laporan Peminjaman & Pengembalian',
        };

        $pdf = Pdf::loadView('reports.pdf.loans', [
            'rows' => $rows,
            'title' => $title,
            'period' => [$start->toDateString(), $end->toDateString()],
        ])->setPaper('a4', 'portrait');

        return $pdf->download('laporan-' . $type . '-' . $start->format('Ymd') . '-' . $end->format('Ymd') . '.pdf');
    }

    public function excel(Request $request)
    {
        [$rangeKey, $start, $end] = $this->resolveRange($request);
        $type = $this->resolveType($request);
        $rows = $this->buildReportQuery($request, $start, $end, $type)
            ->orderBy($type === 'returns' ? 'return_date_actual' : 'loan_date')
            ->get();

        return $this->streamCsv($rows, 'laporan-' . $type, ['Tanggal Pinjam', 'Tanggal Kembali', 'Aset', 'Peminjam', 'Unit', 'Status', 'Jumlah', 'Rencana Kembali']);
    }

    public function loans(Request $request)
    {
        return redirect()->route('reports.index', array_merge($request->query(), ['type' => 'loans']));
    }

    public function returns(Request $request)
    {
        return redirect()->route('reports.index', array_merge($request->query(), ['type' => 'returns']));
    }

    public function loansPdf(Request $request)
    {
        $request->merge(['type' => 'loans']);
        return $this->pdf($request);
    }

    public function returnsPdf(Request $request)
    {
        $request->merge(['type' => 'returns']);
        return $this->pdf($request);
    }

    public function loansExcel(Request $request)
    {
        $request->merge(['type' => 'loans']);
        return $this->excel($request);
    }

    public function returnsExcel(Request $request)
    {
        $request->merge(['type' => 'returns']);
        return $this->excel($request);
    }

    private function streamCsv($rows, string $basename, array $headers)
    {
        $filename = $basename . '-' . now()->format('Ymd-His') . '.csv';

        $callback = static function () use ($rows, $headers) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $headers);
            foreach ($rows as $row) {
                fputcsv($handle, [
                    optional($row->loan_date)->format('Y-m-d'),
                    optional($row->return_date_actual)->format('Y-m-d'),
                    ($row->asset->code ?? '-') . ' - ' . ($row->asset->name ?? '-'),
                    $row->borrower_name,
                    $row->unit,
                    $row->status,
                    $row->quantity,
                    optional($row->return_date_planned)->format('Y-m-d'),
                ]);
            }
            fclose($handle);
        };

        return Response::streamDownload($callback, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
