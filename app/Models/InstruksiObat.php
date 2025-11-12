<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstruksiObat extends Model
{
    use HasFactory;

    protected $table = 'instruksi_obat';

    protected $fillable = [
        'lansia_id', 'medis_user_id', 'nama_obat', 'dosis', 'frekuensi', 
        'mulai_pada', 'selesai_pada', 'status', 'catatan',
    ];

    protected $casts = [
        'mulai_pada' => 'date',
        'selesai_pada' => 'date',
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
