<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lansia extends Model
{
    use HasFactory;

    protected $table = 'lansia';

    protected $fillable = [
        'nama_lansia',
        'umur',
        'alamat',
        'id_lansia',
        'jenis_kelamin',
    ];

    protected $casts = [
        'umur' => 'date',
    ];

    public function tenagaMedis()
    {
        return $this->belongsToMany(User::class, 'medis_lansia', 'lansia_id', 'medis_user_id');
    }

    public function keluarga()
    {
        return $this->belongsToMany(User::class, 'keluarga_lansia', 'lansia_id', 'keluarga_user_id')->withPivot('hubungan');
    }

    public function instruksiObat()
    {
        return $this->hasMany(InstruksiObat::class);
    }

    public function riwayatKondisi()
    {
        return $this->hasMany(RiwayatKondisi::class);
    }

    public function jadwalKegiatan()
    {
        return $this->hasMany(JadwalKegiatan::class);
    }

    public function jadwalLansia()
    {
        return $this->hasMany(JadwalLansia::class);
    }

    public function riwayatKondisiLansia()
    {
        return $this->hasMany(RiwayatKondisiLansia::class);
    }
}
