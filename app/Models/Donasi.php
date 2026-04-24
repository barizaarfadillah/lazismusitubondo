<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donasi extends Model
{
    protected $table = 'donasi';
    protected $primaryKey = 'id_donasi';

    protected $fillable = [
        'id_user', 'id_program', 'id_rekening', 'nominal', 'pesan_doa', 'is_anonim', 'status', 'tanggal_donasi'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'id_program', 'id_program');
    }

    public function rekening()
    {
        return $this->belongsTo(Rekening::class, 'id_rekening', 'id_rekening');
    }
}