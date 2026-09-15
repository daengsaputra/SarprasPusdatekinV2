<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SsoRoleOverride extends Model
{
    protected $fillable = [
        'nip',
        'role',
        'name',
        'note',
        'created_by',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Resolve role for a given NIP. Returns null when no override.
     */
    public static function roleFor(?string $nip): ?string
    {
        if (!$nip) {
            return null;
        }

        return static::where('nip', $nip)->value('role');
    }
}
