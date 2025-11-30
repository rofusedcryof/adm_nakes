<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Pengasuh extends Model
{
    use HasFactory;

    protected $table = 'pengasuh';

    protected $fillable = [
        'nama', 'alamat', 'no_telepon', 'email', 'password', 'user_id',
    ];

    protected $hidden = [
        'password',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
