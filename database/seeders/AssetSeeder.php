<?php

namespace Database\Seeders;

use App\Models\Asset;
use Illuminate\Database\Seeder;

class AssetSeeder extends Seeder
{
    public function run(): void
    {
        Asset::query()->delete();

        $loanableAssets = [
            ['PJ-001', 'Laptop Operasional', 'Elektronik', 12, 'Digunakan untuk kegiatan rapat dan presentasi.', 'active'],
            ['PJ-002', 'Proyektor Mini', 'Elektronik', 6, 'Unit portabel untuk kegiatan sosialisasi.', 'active'],
            ['PJ-003', 'Sound System Portable', 'Audio', 4, 'Perangkat audio untuk acara internal.', 'inactive'],
            ['PJ-004', 'Kamera DSLR', 'Dokumentasi', 3, 'Digunakan untuk dokumentasi kegiatan resmi.', 'active'],
        ];

        foreach ($loanableAssets as [$code, $name, $category, $qty, $description, $status]) {
            Asset::create([
                'code' => $code,
                'name' => $name,
                'category' => $category,
                'description' => $description,
                'kind' => Asset::KIND_LOANABLE,
                'quantity_total' => $qty,
                'quantity_available' => $qty,
                'status' => $status,
            ]);
        }

        $inventoryAssets = [
            ['INV-001', 'Printer Kantor', 'Elektronik', 8, 'Perangkat cetak untuk tiap unit kerja.', 'active'],
            ['INV-002', 'Kursi Ergonomis', 'Furniture', 20, 'Kursi kerja dengan sandaran kepala.', 'active'],
            ['INV-003', 'Lemari Arsip Besi', 'Furniture', 10, 'Penyimpanan arsip dokumen penting.', 'active'],
            ['INV-004', 'Sofa Tamu', 'Furniture', 5, 'Kursi tamu untuk ruang tunggu.', 'inactive'],
        ];

        foreach ($inventoryAssets as [$code, $name, $category, $qty, $description, $status]) {
            Asset::create([
                'code' => $code,
                'name' => $name,
                'category' => $category,
                'description' => $description,
                'kind' => Asset::KIND_INVENTORY,
                'quantity_total' => $qty,
                'quantity_available' => $qty,
                'status' => $status,
            ]);
        }
    }
}