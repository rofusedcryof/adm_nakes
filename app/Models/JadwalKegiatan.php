<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKegiatan extends Model
{
    use HasFactory;

    protected $table = 'jadwal_kegiatan';

    protected $fillable = [
        'id_jadwal', 'lansia_id', 'medis_user_id', 'tanggal', 'waktu', 'aktivitas', 'jadwal_pada', 'lokasi', 'status', 'catatan',
    ];

    protected $casts = [
        'tanggal' => 'date',
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


