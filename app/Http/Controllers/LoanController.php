<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $q = request('q');
        $status = request('status'); // borrowed|returned|all
        $unit = request('unit');
        $from = request('from');
        $to = request('to');
        $overdueOnly = request()->boolean('overdue');

        $query = Loan::with('asset');
        $sort = request('sort');
        $dir = request('dir','desc') === 'asc' ? 'asc' : 'desc';
        if ($q) {
            $query->where(function($w) use ($q){
                $w->whereHas('asset', function($a) use ($q){
                        $a->where('name','like',"%$q%")
                          ->orWhere('code','like',"%$q%");
                    })
                  ->orWhere('borrower_name','like',"%$q%");
            });
        }
        if ($status && in_array($status, ['borrowed','partial','returned'])) {
            $query->where('status',$status);
        }
        if ($unit) {
            $query->where('unit',$unit);
        }
        if ($from) {
            $query->whereDate('loan_date','>=',$from);
        }
        if ($to) {
            $query->whereDate('loan_date','<=',$to);
        }
        if ($overdueOnly) {
            $query->whereIn('status', ['borrowed', 'partial'])
                ->whereNull('return_date_actual')
                ->whereNotNull('return_date_planned')
                ->whereDate('return_date_planned', '<', now()->toDateString());
        }

        // Sorting
        $allowed = [
            'loan_date' => 'loans.loan_date',
            'return_date_planned' => 'loans.return_date_planned',
            'status' => 'loans.status',
            'quantity' => 'loans.quantity',
            'borrower_name' => 'loans.borrower_name',
            'asset' => 'a.name',
            'unit' => 'loans.unit',
        ];
        if ($sort === 'asset') {
            $query->leftJoin('assets as a','a.id','=','loans.asset_id')->select('loans.*');
        }
        if ($sort && isset($allowed[$sort])) {
            $query->orderBy($allowed[$sort], $dir);
        } else {
            $query->orderByDesc('loans.loan_date');
        }

        $loans = $query->paginate(10)->withQueryString();
        $units = config('bpip.units');
        $totalLoanCount = Loan::count();
        $activeLoanCount = Loan::whereIn('status', ['borrowed','partial'])->count();
        $overdueCount = Loan::whereIn('status', ['borrowed','partial'])
            ->whereNotNull('return_date_planned')
            ->whereDate('return_date_planned', '<', now())
            ->count();

        return view('loans.index', compact(
            'loans',
            'units',
            'q',
            'status',
            'unit',
            'from',
            'to',
            'overdueOnly',
            'sort',
            'dir',
            'totalLoanCount',
            'activeLoanCount',
            'overdueCount'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $assets = Asset::where('status', 'active')
            ->where('kind', Asset::KIND_LOANABLE)
            ->where('quantity_available', '>', 0)
            ->orderBy('name')
            ->get();
        $units = config('bpip.units');
        return view('loans.create', compact('assets','units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'borrower_name' => 'required|string|max:255',
            'borrower_contact' => 'required|string|max:255',
            'unit' => ['required','string', \Illuminate\Validation\Rule::in(config('bpip.units'))],
            'activity_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'loan_date' => 'required|date',
            'return_date_planned' => 'required|date|after_or_equal:loan_date',
            'notes' => 'nullable|string',
            'loan_photo' => $this->attachmentArrayRule(true),
            'loan_photo.*' => $this->attachmentItemRule(),
            'request_photo' => $this->attachmentArrayRule(true),
            'request_photo.*' => $this->attachmentItemRule(),
        ]);
        $asset = Asset::findOrFail($validated['asset_id']);
        if ($asset->kind !== Asset::KIND_LOANABLE) {
            return back()->withInput()->withErrors(['asset_id' => 'Barang yang dipilih bukan data peminjaman.']);
        }
        if ($validated['quantity'] > $asset->quantity_available) {
            return back()->withInput()->withErrors(['quantity' => 'Jumlah melebihi stok tersedia.']);
        }

        $loanData = $validated;
        unset($loanData['loan_photo'], $loanData['request_photo']);

        $loanPhotoPaths = [];
        $requestPhotoPaths = [];

        try {
            $loanPhotoPaths = $this->storeAttachments($request->file('loan_photo'), 'loan-proofs');
            $requestPhotoPaths = $this->storeAttachments($request->file('request_photo'), 'loan-requests');

            $loan = Loan::create($loanData + [
                'status' => 'borrowed',
                'quantity_returned' => 0,
                'loan_photo_path' => json_encode($loanPhotoPaths),
                'request_photo_path' => json_encode($requestPhotoPaths),
            ]);

            $asset->decrement('quantity_available', $validated['quantity']);
        } catch (\Throwable $e) {
            $this->deleteAttachment($loanPhotoPaths);
            $this->deleteAttachment($requestPhotoPaths);
            throw $e;
        }

        return redirect()->route('loans.index')
            ->with('success', 'Peminjaman berhasil dicatat.')
            ->with('clear_loan_draft', true);
    }

    // Store multiple items in one submission (cart-style)
    public function storeBatch(Request $request)
    {
        $data = $request->validate([
            'borrower_name' => 'required|string|max:255',
            'borrower_contact' => 'required|string|max:255',
            'unit' => ['required','string', \Illuminate\Validation\Rule::in(config('bpip.units'))],
            'activity_name' => 'required|string|max:255',
            'loan_date' => 'required|date',
            'return_date_planned' => 'required|date|after_or_equal:loan_date',
            'notes' => 'nullable|string',
            'loan_photo' => $this->attachmentArrayRule(true),
            'loan_photo.*' => $this->attachmentItemRule(),
            'request_photo' => $this->attachmentArrayRule(true),
            'request_photo.*' => $this->attachmentItemRule(),
        ]);

        $loanData = $data;
        unset($loanData['loan_photo'], $loanData['request_photo']);

        $loanPhotoPaths = [];
        $requestPhotoPaths = [];

        try {
            $loanPhotoPaths = $this->storeAttachments($request->file('loan_photo'), 'loan-proofs');
            $requestPhotoPaths = $this->storeAttachments($request->file('request_photo'), 'loan-requests');
        } catch (\Throwable $e) {
            $this->deleteAttachment($loanPhotoPaths);
            $this->deleteAttachment($requestPhotoPaths);
            throw $e;
        }

        // Ambil items dari hidden field JSON atau array biasa
        $itemsRaw = $request->input('items');
        if (is_string($itemsRaw)) {
            $decoded = json_decode($itemsRaw, true);
            $items = json_last_error() === JSON_ERROR_NONE ? $decoded : [];
        } else {
            $items = is_array($itemsRaw) ? $itemsRaw : [];
        }
        if (!is_array($items) || count($items) === 0) {
            return back()->withInput()->withErrors(['items' => 'Pilih minimal satu item.']);
        }

        // Sanitasi
        $items = array_values(array_map(function($it){
            return [
                'asset_id' => (int)($it['asset_id'] ?? 0),
                'quantity' => max(1, (int)($it['quantity'] ?? 0)),
            ];
        }, $items));

        $batch = 'PJ'.now()->format('YmdHis');
        try {
            DB::transaction(function () use ($loanData, $items, $batch, $loanPhotoPaths, $requestPhotoPaths) {
            foreach ($items as $item) {
                $asset = Asset::lockForUpdate()->findOrFail($item['asset_id']);
                if ($asset->kind !== Asset::KIND_LOANABLE) {
                    abort(422, 'Aset ' . $asset->name . ' bukan barang peminjaman.');
                }
                if ($item['quantity'] > $asset->quantity_available) {
                    abort(422, 'Jumlah melebihi stok tersedia untuk aset '.$asset->name);
                }
                Loan::create([
                    'batch_code' => $batch,
                    'asset_id' => $asset->id,
                    'borrower_name' => $loanData['borrower_name'],
                    'borrower_contact' => $loanData['borrower_contact'] ?? null,
                    'unit' => $loanData['unit'],
                    'activity_name' => $loanData['activity_name'],
                    'quantity' => $item['quantity'],
                    'quantity_returned' => 0,
                    'loan_date' => $loanData['loan_date'],
                    'return_date_planned' => $loanData['return_date_planned'] ?? null,
                    'status' => 'borrowed',
                    'notes' => $loanData['notes'] ?? null,
                    'loan_photo_path' => json_encode($loanPhotoPaths),
                    'request_photo_path' => json_encode($requestPhotoPaths),
                ]);
                $asset->decrement('quantity_available', $item['quantity']);
            }
        });
        } catch (\Throwable $e) {
            $this->deleteAttachment($loanPhotoPaths);
            $this->deleteAttachment($requestPhotoPaths);
            throw $e;
        }

        return redirect()->route('loans.index')
            ->with('success', 'Peminjaman berhasil dicatat. Bukti siap dicetak.')
            ->with('receipt_batch', $batch)
            ->with('clear_loan_draft', true);
    }

    /**
     * Display the specified resource.
     */
    public function show(Loan $loan)
    {
        return redirect()->route('loans.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Loan $loan)
    {
        return redirect()->route('loans.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Loan $loan)
    {
        return redirect()->route('loans.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Loan $loan)
    {
        if (in_array($loan->status, ['borrowed', 'partial'])) {
            return redirect()->route('loans.index')->with('error', 'Tidak bisa menghapus pinjaman yang belum dikembalikan.');
        }
        $loan->delete();
        return redirect()->route('loans.index')->with('success', 'Data peminjaman dihapus.');
    }

    public function returnForm(Loan $loan)
    {
        if ($loan->status === 'returned' || $loan->quantity_remaining <= 0) {
            return redirect()->route('loans.index')->with('info', 'Pinjaman sudah dikembalikan.');
        }
        return view('loans.return', compact('loan'));
    }

    public function returnUpdate(Request $request, Loan $loan)
    {
        if ($loan->status === 'returned' || $loan->quantity_remaining <= 0) {
            return redirect()->route('loans.index')->with('info', 'Pinjaman sudah dikembalikan.');
        }

        $maxReturnable = $loan->quantity_remaining;

        $validated = $request->validate([
            'return_date_actual' => 'required|date|after_or_equal:' . $loan->loan_date->format('Y-m-d'),
            'return_quantity' => 'required|integer|min:1|max:' . $maxReturnable,
            'notes' => 'nullable|string',
            'return_photo' => $this->attachmentArrayRule(true),
            'return_photo.*' => $this->attachmentItemRule(),
        ]);

        $returnPhotoPaths = [];
        $previousReturnPhoto = $loan->return_photo_path;

        try {
            $returnPhotoPaths = $this->storeAttachments($request->file('return_photo'), 'loan-returns');

            DB::transaction(function () use ($loan, $validated, $returnPhotoPaths) {
            $loan->refresh();
            $outs = $loan->quantity_remaining;
            if ($outs <= 0) {
                return;
            }

            $returnedQty = min($validated['return_quantity'], $outs);
            $newReturned = $loan->quantity_returned + $returnedQty;
            $remaining = max($loan->quantity - $newReturned, 0);

            $loan->update([
                'quantity_returned' => $newReturned,
                'status' => $remaining === 0 ? 'returned' : 'partial',
                'return_date_actual' => $remaining === 0 ? $validated['return_date_actual'] : $loan->return_date_actual,
                'notes' => $validated['notes'] ?? $loan->notes,
                'return_photo_path' => !empty($returnPhotoPaths) ? json_encode($returnPhotoPaths) : $loan->return_photo_path,
            ]);

            $asset = Asset::whereKey($loan->asset_id)->lockForUpdate()->first();
            if ($asset) {
                $restored = $asset->quantity_available + $returnedQty;
                $asset->update([
                    'quantity_available' => min($asset->quantity_total, $restored),
                ]);
            }
        });
        } catch (\Throwable $e) {
            $this->deleteAttachment($returnPhotoPaths);
            throw $e;
        }

        if (!empty($returnPhotoPaths) && $previousReturnPhoto) {
            $this->deleteAttachment($previousReturnPhoto);
        }

        $redirect = redirect()->route('loans.index')
            ->with('success', 'Pengembalian berhasil diproses.');

        if ($loan->fresh()->status === 'returned') {
            $redirect->with('return_receipt_id', $loan->id);
        }

        return $redirect;
    }

    public function receipt(Request $request, string $batch)
    {
        $items = Loan::with('asset')->where('batch_code', $batch)->get();
        abort_if($items->isEmpty(), 404);

        $first = $items->first();
        $attachments = [
            'ND / Helpdesk' => $this->parseAttachmentPaths($first->request_photo_path),
            'Serah Terima' => $this->parseAttachmentPaths($first->loan_photo_path),
            'Pengembalian' => $this->parseAttachmentPaths($first->return_photo_path),
        ];

        $data = [
            'batch' => $batch,
            'borrower' => $first->borrower_name,
            'contact' => $first->borrower_contact,
            'unit' => $first->unit,
            'activity_name' => $first->activity_name,
            'loan_date' => $first->loan_date,
            'return_plan' => $first->return_date_planned,
            'officer' => auth()->user()->name ?? 'Petugas',
            'items' => $items,
            'printed_at' => now(),
            'attachments' => $attachments,
        ];

        if ($request->boolean('preview')) {
            return view('loans.receipt_preview', $data);
        }

        $pdf = Pdf::loadView('loans.receipt_pdf', $data)->setPaper('a4', 'portrait');

        if ($request->boolean('download')) {
            return $pdf->download('bukti-peminjaman-'.$batch.'.pdf');
        }

        return $pdf->stream('bukti-peminjaman-'.$batch.'.pdf');
    }

            public function returnReceipt(Request $request, Loan $loan)
    {
        abort_if($loan->status !== 'returned', 404);

        $data = [
            'loan' => $loan->load('asset'),
            'printed_at' => now(),
            'officer' => auth()->user()->name ?? 'Petugas',
        ];

        if ($request->boolean('preview')) {
            return view('loans.return_receipt_preview', $data);
        }

        $pdf = Pdf::loadView('loans.return_receipt_pdf', $data)->setPaper('a4', 'portrait');

        if ($request->boolean('download')) {
            return $pdf->download('bukti-pengembalian-'.$loan->id.'.pdf');
        }

        return $pdf->stream('bukti-pengembalian-'.$loan->id.'.pdf');
    }

    protected function attachmentArrayRule(bool $required = false): array
    {
        $rule = ['array', 'max:5'];
        if ($required) {
            array_unshift($rule, 'required');
            array_splice($rule, 1, 0, 'min:1');
        } else {
            array_unshift($rule, 'nullable');
        }
        return $rule;
    }

    protected function attachmentItemRule(): array
    {
        $mimes = config('bpip.loan_attachment_mimes', ['jpg', 'jpeg', 'png', 'webp']);
        $mimes = is_array($mimes) ? implode(',', $mimes) : (string) $mimes;
        $max = (int) config('bpip.loan_attachment_max_kb', 4096);

        return ['image', 'mimes:' . $mimes, 'max:' . $max];
    }

    protected function storeAttachments($files, string $directory): array
    {
        if (!$files) {
            return [];
        }
        $list = is_array($files) ? $files : [$files];
        $paths = [];
        foreach ($list as $file) {
            if ($file instanceof UploadedFile) {
                $paths[] = $file->store($directory, 'public');
            }
        }
        return $paths;
    }

    protected function parseAttachmentPaths($value): array
    {
        if (!$value) {
            return [];
        }
        if (is_array($value)) {
            return array_values(array_filter($value));
        }
        if (!is_string($value)) {
            return [];
        }

        $decoded = json_decode($value, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return array_values(array_filter($decoded));
        }
        return [$value];
    }

    protected function deleteAttachment($paths): void
    {
        foreach ($this->parseAttachmentPaths($paths) as $path) {
            Storage::disk('public')->delete($path);
        }
    }
}
