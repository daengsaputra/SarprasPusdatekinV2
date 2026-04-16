<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\Loan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LoanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('loans')->truncate();

        $assets = Asset::all()->keyBy('code');
        if ($assets->isEmpty()) {
            $this->command?->warn('LoanSeeder skipped because assets table is empty.');
            return;
        }

        $loans = [
            [
                'batch_code' => 'LN-' . Str::upper(Str::random(5)),
                'asset' => 'PJ-001',
                'borrower_name' => 'Bagian Umum',
                'borrower_contact' => 'umum@example.com',
                'unit' => 'Biro Perencanaan',
                'activity_name' => 'Rapat Koordinasi Internal',
                'quantity' => 4,
                'quantity_returned' => 4,
                'loan_date' => now()->subDays(10),
                'return_date_planned' => now()->subDays(5),
                'return_date_actual' => now()->subDays(6),
                'status' => 'returned',
                'notes' => 'Pengembalian lebih cepat satu hari.',
            ],
            [
                'batch_code' => 'LN-' . Str::upper(Str::random(5)),
                'asset' => 'PJ-002',
                'borrower_name' => 'Bagian Humas',
                'borrower_contact' => 'humas@example.com',
                'unit' => 'Biro Humas',
                'activity_name' => 'Sosialisasi Layanan Digital',
                'quantity' => 2,
                'quantity_returned' => 0,
                'loan_date' => now()->subDays(3),
                'return_date_planned' => now()->addDays(2),
                'return_date_actual' => null,
                'status' => 'ongoing',
                'notes' => 'Masih digunakan untuk roadshow.',
            ],
            [
                'batch_code' => 'LN-' . Str::upper(Str::random(5)),
                'asset' => 'PJ-004',
                'borrower_name' => 'Bagian Dokumentasi',
                'borrower_contact' => 'dok@example.com',
                'unit' => 'Biro Dokumentasi',
                'activity_name' => 'Peliputan Kegiatan Nasional',
                'quantity' => 1,
                'quantity_returned' => 0,
                'loan_date' => now()->subDay(),
                'return_date_planned' => now()->addDays(6),
                'return_date_actual' => null,
                'status' => 'approved',
                'notes' => null,
            ],
        ];

        foreach ($loans as $loan) {
            $asset = $assets->get($loan['asset']);
            if (!$asset) {
                $this->command?->warn("Skipping loan seeding for {$loan['asset']} because asset is missing.");
                continue;
            }

            Loan::create([
                'batch_code' => $loan['batch_code'],
                'asset_id' => $asset->id,
                'borrower_name' => $loan['borrower_name'],
                'borrower_contact' => $loan['borrower_contact'],
                'unit' => $loan['unit'],
                'activity_name' => $loan['activity_name'],
                'quantity' => $loan['quantity'],
                'quantity_returned' => $loan['quantity_returned'],
                'loan_date' => $loan['loan_date'],
                'return_date_planned' => $loan['return_date_planned'],
                'return_date_actual' => $loan['return_date_actual'],
                'status' => $loan['status'],
                'notes' => $loan['notes'],
            ]);

            $asset->quantity_available = max(
                0,
                $asset->quantity_total - ($loan['quantity'] - $loan['quantity_returned'])
            );
            $asset->save();
        }
    }
}
