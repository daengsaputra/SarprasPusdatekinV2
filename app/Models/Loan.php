<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loan extends Model
{
    protected $fillable = [
        'batch_code',
        'asset_id',
        'borrower_name',
        'borrower_contact',
        'unit',
        'activity_name',
        'quantity',
        'quantity_returned',
        'loan_date',
        'return_date_planned',
        'return_date_actual',
        'status',
        'notes',
        'loan_photo_path',
        'return_photo_path',
        'request_photo_path',
    ];

    protected $casts = [
        'loan_date' => 'date',
        'return_date_planned' => 'date',
        'return_date_actual' => 'date',
        'quantity' => 'integer',
        'quantity_returned' => 'integer',
    ];

    protected $appends = [
        'quantity_remaining',
        'request_photo_paths',
        'loan_photo_paths',
        'return_photo_paths',
    ];

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function getQuantityRemainingAttribute(): int
    {
        $qty = (int) $this->quantity;
        $returned = (int) $this->quantity_returned;
        return max($qty - $returned, 0);
    }

    public function getRequestPhotoPathsAttribute(): array
    {
        return $this->normalizeAttachmentPaths($this->request_photo_path);
    }

    public function getLoanPhotoPathsAttribute(): array
    {
        return $this->normalizeAttachmentPaths($this->loan_photo_path);
    }

    public function getReturnPhotoPathsAttribute(): array
    {
        return $this->normalizeAttachmentPaths($this->return_photo_path);
    }

    protected function normalizeAttachmentPaths($value): array
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
}
