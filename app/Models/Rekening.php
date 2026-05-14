<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    protected $table = 'rekening';
    protected $primaryKey = 'id_rekening';

    protected $fillable = ['nama_bank', 'logo', 'no_rekening', 'atas_nama', 'qris'];

    public function donasi()
    {
        return $this->hasMany(Donasi::class, 'id_rekening', 'id_rekening');
    }

    public function programs()
    {
        return $this->belongsToMany(Program::class, 'detail_rekening_program', 'id_rekening', 'id_program')->withTimestamps();;
    }
}