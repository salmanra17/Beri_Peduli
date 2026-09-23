<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BuktiPenyaluran extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'penarikan_dana_id',
        'user_id',
        'deskripsi',
        'foto_bukti',
        'status',
        'catatan_admin',
    ];

    public function penarikanDana(): BelongsTo
    {
        return $this->belongsTo(PenarikanDana::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * URL penuh ke file bukti (gambar/PDF).
     */
    public function getFotoBuktiUrlAttribute(): string
    {
        return asset('storage/'.$this->foto_bukti);
    }

    /**
     * Apakah file bukti berupa PDF?
     */
    public function getIsPdfAttribute(): bool
    {
        return str_ends_with(strtolower($this->foto_bukti), '.pdf');
    }
}
