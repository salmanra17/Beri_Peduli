<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kampanye_id',
        'jumlah_donasi',
        'metode_pembayaran',
        'status_pembayaran',
        'pesan',
        'anonim',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kampanye()
    {
        return $this->belongsTo(Kampanye::class);
    }
}
