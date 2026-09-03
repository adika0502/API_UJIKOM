<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name', 'email', 'password', 'role', 'no_hp', 'alamat', 'foto_profile'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function peminjaman(): HasMany {
        return $this->hasMany(Peminjaman::class);
    }

    public function logAktivitas(): HasMany {
        return $this->hasMany(LogAktivitas::class);
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed', // Laravel otomatis meng-hash teks apapun yang masuk ke properti password!
        ];
    }
}