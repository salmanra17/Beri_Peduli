<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kampanye_id',
        'donasi_id',
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

    public function donasi()
    {
        return $this->belongsTo(Donasi::class);
    }
}
