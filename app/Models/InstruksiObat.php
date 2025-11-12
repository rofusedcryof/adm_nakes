<?php

namespace App\Models;

<<<<<<< HEAD
=======
use Illuminate\Database\Eloquent\Factories\HasFactory;
>>>>>>> e14299cce1be7374f18d8414c9f80dd052c2adb4
use Illuminate\Database\Eloquent\Model;

class InstruksiObat extends Model
{
<<<<<<< HEAD
    //
}
=======
    use HasFactory;

    protected $table = 'instruksi_obat';

    protected $fillable = [
        'lansia_id', 'medis_user_id', 'nama_obat', 'dosis', 'frekuensi', 'mulai_pada', 'selesai_pada', 'status', 'catatan',
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


>>>>>>> e14299cce1be7374f18d8414c9f80dd052c2adb4
