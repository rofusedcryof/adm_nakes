<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function lansiaMedis()
    {
        return $this->belongsToMany(Lansia::class, 'medis_lansia', 'medis_user_id', 'lansia_id');
    }

    public function lansiaKeluarga()
    {
        return $this->belongsToMany(Lansia::class, 'keluarga_lansia', 'keluarga_user_id', 'lansia_id')->withPivot('hubungan');
    }

    public function instruksiObat()
    {
        return $this->hasMany(InstruksiObat::class, 'medis_user_id');
    }

    public function jadwalKegiatan()
    {
        return $this->hasMany(JadwalKegiatan::class, 'medis_user_id');
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class);
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function nakes()
    {
        return $this->hasOne(Nakes::class);
    }
}
