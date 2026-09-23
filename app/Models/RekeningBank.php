<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $user_id
 * @property string $nama_bank
 * @property string $nomor_rekening
 * @property string $nama_pemilik
 * @property string $status
 * @property bool $is_utama
 */
#[Fillable([
    'user_id',
    'nama_bank',
    'nomor_rekening',
    'nama_pemilik',
    'status',
    'is_utama',
])]
class RekeningBank extends Model
{
    use SoftDeletes;
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_utama' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Tampilkan nomor rekening dengan masking: **** **** XXXX
     */
    public function getNomorRekeningMaskedAttribute(): string
    {
        $nomor = preg_replace('/\D/', '', $this->nomor_rekening);
        $visible = substr($nomor, -4);

        return '**** **** '.$visible;
    }
}
