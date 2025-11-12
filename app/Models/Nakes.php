<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nakes extends Model
{
    use HasFactory;

    protected $table = 'nakes';

    protected $fillable = [
        'user_id', 'nip', 'spesialisasi', 'no_sip',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Access lansia through user relationship: $nakes->user->lansiaMedis
}
