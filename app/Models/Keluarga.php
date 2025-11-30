<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keluarga extends Model
{
    use HasFactory;

    protected $table = 'keluarga';

    protected $fillable = [
        'nama', 'alamat', 'no_telepon', 'hubungan', 'lansia_id', 'email', 'user_id',
    ];

    public function lansia()
    {
        return $this->belongsTo(Lansia::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
