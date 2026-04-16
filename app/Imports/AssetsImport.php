<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Asset;

class AssetsImport implements ToCollection, WithHeadingRow
{
    private ?string $defaultKind = null;

    public array $stats = [
        'inserted' => 0,
        'updated' => 0,
        'skipped' => 0,
    ];

    public function __construct(?string $defaultKind = null)
    {
        $this->defaultKind = in_array($defaultKind, [Asset::KIND_LOANABLE, Asset::KIND_INVENTORY], true)
            ? $defaultKind
            : null;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $code = trim((string)($row['code'] ?? $row['kode'] ?? ''));
            $name = trim((string)($row['name'] ?? $row['nama'] ?? ''));
            if ($code === '' || $name === '') {
                $this->stats['skipped']++;
                continue;
            }

            $category = (string)($row['category'] ?? $row['kategori'] ?? null);
            $description = (string)($row['description'] ?? $row['deskripsi'] ?? null);
            $photo = trim((string) ($row['foto_sarpras'] ?? $row['photo'] ?? ''));
            $bastDocument = trim((string) ($row['dokument_bast'] ?? $row['dokumen_bast'] ?? $row['bast_document'] ?? ''));
            $total = (int)($row['quantity_total'] ?? $row['jumlah_total'] ?? $row['stok'] ?? 0);
            $statusRaw = strtolower(trim((string)($row['status'] ?? 'active')));
            $status = in_array($statusRaw, ['active', 'aktif'])
                ? 'active'
                : (in_array($statusRaw, ['inactive', 'nonaktif', 'non aktif']) ? 'inactive' : 'active');

            $kindSource = $row['kind'] ?? $row['jenis'] ?? ($this->defaultKind ?? Asset::KIND_LOANABLE);
            $kindRaw = strtolower(trim((string)$kindSource));
            $kind = in_array($kindRaw, [Asset::KIND_LOANABLE, Asset::KIND_INVENTORY], true)
                ? $kindRaw
                : ($this->defaultKind ?? Asset::KIND_LOANABLE);

            $asset = Asset::where('code', $code)->first();
            if (!$asset) {
                Asset::create([
                    'code' => $code,
                    'name' => $name,
                    'category' => $category ?: null,
                    'description' => $description ?: null,
                    'kind' => $kind,
                    'quantity_total' => $total,
                    'quantity_available' => $total,
                    'status' => $status,
                    'photo' => $photo !== '' ? $photo : null,
                    'bast_document_path' => $bastDocument !== '' ? $bastDocument : null,
                ]);
                $this->stats['inserted']++;
            } else {
                $borrowed = max(0, $asset->quantity_total - $asset->quantity_available);
                $newAvailable = max(0, $total - $borrowed);
                $asset->update([
                    'name' => $name,
                    'category' => $category ?: null,
                    'description' => $description ?: null,
                    'kind' => $kind,
                    'quantity_total' => $total,
                    'quantity_available' => $newAvailable,
                    'status' => $status,
                    'photo' => $photo !== '' ? $photo : $asset->photo,
                    'bast_document_path' => $bastDocument !== '' ? $bastDocument : $asset->bast_document_path,
                ]);
                $this->stats['updated']++;
            }
        }
    }
}
