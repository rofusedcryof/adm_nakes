<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatKondisi extends Model
{
    use HasFactory;

    protected $table = 'riwayat_kondisi';

    protected $fillable = [
        'lansia_id', 'diukur_pada', 'sistol', 'diastol', 'nadi', 'suhu', 'gula_darah', 'catatan',
    ];

    protected $casts = [
        'diukur_pada' => 'datetime',
        'suhu' => 'decimal:1',
    ];

    public function lansia()
    {
        return $this->belongsTo(Lansia::class);
    }
}


