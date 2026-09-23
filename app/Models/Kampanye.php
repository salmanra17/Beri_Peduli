<?php

namespace App\Models;

use App\Observers\KampanyeObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy(KampanyeObserver::class)]
class Kampanye extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'judul',
        'judul_en',
        'deskripsi',
        'deskripsi_en',
        'kategori',
        'lokasi',
        'target_dana',
        'dana_terkumpul',
        'batas_tanggal',
        'status',
        'gambar',
        'nik',
        'foto_ktp',
        'foto_diri',
        'jenis_akun',
        'no_hp',
        'nama_lengkap',
        'alamat',
        'foto_memegang_ktp',
        'bank_penyaluran',
        'nomor_rekening',
    ];

    protected $casts = [
        'batas_tanggal' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function donasis()
    {
        return $this->hasMany(Donasi::class);
    }

    public function komentars()
    {
        return $this->hasMany(Komentar::class);
    }

    public function penarikanDanas()
    {
        return $this->hasMany(PenarikanDana::class);
    }

    /**
     * Kampanye dianggap selesai jika statusnya sudah 'selesai'
     * atau dana yang terkumpul sudah mencapai target.
     */
    public function isSelesai(): bool
    {
        return $this->status === 'selesai'
            || ($this->target_dana > 0 && $this->dana_terkumpul >= $this->target_dana);
    }

    /**
     * Sisa saldo yang siap ditarik (dana terkumpul dikurangi penarikan berstatus berhasil atau diproses)
     */
    public function getSaldoSiapDitarikAttribute(): float
    {
        $sudahDitarik = (float) $this->penarikanDanas()
            ->whereIn('status', ['berhasil', 'diproses'])
            ->sum('jumlah');

        return max(0, (float) $this->dana_terkumpul - $sudahDitarik);
    }

    /**
     * Judul sesuai locale aktif (EN jika tersedia, fallback ke Indonesia).
     */
    public function getJudulTampilAttribute(): string
    {
        return app()->getLocale() === 'en' && $this->judul_en
            ? $this->judul_en
            : $this->judul;
    }

    /**
     * Deskripsi sesuai locale aktif (EN jika tersedia, fallback ke Indonesia).
     */
    public function getDeskripsiTampilAttribute(): string
    {
        return app()->getLocale() === 'en' && $this->deskripsi_en
            ? $this->deskripsi_en
            : $this->deskripsi;
    }
}
