<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Asset extends Model
{
    public const KIND_LOANABLE = 'loanable';
    public const KIND_INVENTORY = 'inventory';

    protected $fillable = [
        'code',
        'name',
        'category',
        'description',
        'kind',
        'quantity_total',
        'quantity_available',
        'status',
        'photo',
        'bast_document_path',
        'bast_photo_path',
    ];

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->resolvePublicFileUrl($this->photo);
    }

    protected function resolvePublicFileUrl(?string $value): ?string
    {
        $path = trim((string) $value);
        if ($path === '') {
            return null;
        }

        if (preg_match('/^https?:\/\//i', $path)) {
            return $path;
        }

        $normalized = ltrim(str_replace('\\', '/', $path), '/');

        $publicCandidates = [
            $normalized,
            'images/' . basename($normalized),
            'storage/' . $normalized,
        ];
        foreach ($publicCandidates as $candidate) {
            if (is_file(public_path($candidate))) {
                return asset($candidate);
            }
        }

        $diskCandidates = [
            $normalized,
            'assets/photos/' . basename($normalized),
            basename($normalized),
        ];
        foreach ($diskCandidates as $candidate) {
            if (Storage::disk('public')->exists($candidate)) {
                return asset('storage/' . $candidate);
            }
        }

        return asset('storage/' . $normalized);
    }
}
