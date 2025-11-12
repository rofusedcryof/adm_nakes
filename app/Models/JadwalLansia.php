<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalLansia extends Model
{
    use HasFactory;

    protected $table = 'jadwal_lansia';

    protected $fillable = [
        'lansia_id', 'id_jadwal', 'tanggal', 'waktu', 'aktivitas', 'lokasi', 'catatan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'waktu' => 'datetime',
    ];

    public function lansia()
    {
        return $this->belongsTo(Lansia::class);
    }
}
