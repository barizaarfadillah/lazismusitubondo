<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'user'; // Kunci nama tabel
    protected $primaryKey = 'id_user'; // Kunci primary key

    protected $fillable = [
        'nama', 'email', 'password', 'no_telp', 'alamat', 'foto', 'is_admin', 'status_user'
    ];

    protected $hidden = [
        'password',
    ];

    public function donasi()
    {
        return $this->hasMany(Donasi::class, 'id_user', 'id_user');
    }
}