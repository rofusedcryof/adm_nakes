<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKontrol extends Model
{
    use HasFactory;

    protected $table = 'jadwal_kegiatan';

    protected $fillable = [
        'lansia_id', 'medis_user_id', 'jadwal_pada', 'lokasi', 'status', 'catatan',
    ];

    protected $casts = [
        'jadwal_pada' => 'datetime',
    ];

    public function lansia()
    {
        return $this->belongsTo(Lansia::class);
    }

    public function medis()
    {
        return $this->belongsTo(User::class, 'medis_user_id');
    }
}


