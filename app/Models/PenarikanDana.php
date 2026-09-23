<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenarikanDana extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'kampanye_id',
        'kode_transaksi',
        'jumlah',
        'bank_tujuan',
        'nomor_rekening',
        'nama_pemilik_rekening',
        'status',
        'alasan_penolakan',
        'catatan',
        'disetujui_pada',
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
        'disetujui_pada' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function kampanye(): BelongsTo
    {
        return $this->belongsTo(Kampanye::class);
    }

    public function buktiPenyaluran(): HasOne
    {
        return $this->hasOne(BuktiPenyaluran::class);
    }

    /**
     * Tampilan nomor rekening yang disensor seperti desain: BCA - 882012****
     */
    public function getRekeningMaskedAttribute(): string
    {
        $nomor = (string) $this->nomor_rekening;
        $len = strlen($nomor);

        if ($len > 6) {
            $masked = substr($nomor, 0, 6).'****';
        } else {
            $masked = substr($nomor, 0, max(1, $len - 2)).'****';
        }

        return "{$this->bank_tujuan} - {$masked}";
    }
}
