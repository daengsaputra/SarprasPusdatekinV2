<?php

namespace App\Exports;

use App\Models\Asset;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AssetsExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(private array $filters = []) {}

    public function collection()
    {
        $q = $this->filters['q'] ?? null;
        $status = $this->filters['status'] ?? null;
        $category = $this->filters['category'] ?? null;
        $kind = $this->filters['kind'] ?? null;

        $query = Asset::query();
        if ($q) {
            $query->where(function ($w) use ($q) {
                $w->where('name', 'like', "%$q%")
                  ->orWhere('code', 'like', "%$q%")
                  ->orWhere('description', 'like', "%$q%");
            });
        }
        if ($status) $query->where('status', $status);
        if ($category) $query->where('category', $category);
        if ($kind) $query->where('kind', $kind);

        return $query->orderBy('code')->get();
    }

    public function headings(): array
    {
        return [
            'Kode', 'Nama', 'Kategori', 'Deskripsi', 'Jenis', 'Jumlah Total', 'Jumlah Tersedia', 'Status', 'Dibuat', 'Diperbarui'
        ];
    }

    public function map($asset): array
    {
        return [
            $asset->code,
            $asset->name,
            $asset->category,
            $asset->description,
            $asset->kind,
            $asset->quantity_total,
            $asset->quantity_available,
            $asset->status,
            optional($asset->created_at)->format('Y-m-d H:i'),
            optional($asset->updated_at)->format('Y-m-d H:i'),
        ];
    }
}
