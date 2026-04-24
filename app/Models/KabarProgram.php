<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KabarProgram extends Model
{
    protected $table = 'kabar_program';
    protected $primaryKey = 'id_kabar';

    protected $fillable = ['id_program', 'judul', 'deskripsi', 'dokumentasi'];

    public function program()
    {
        return $this->belongsTo(Program::class, 'id_program', 'id_program');
    }
}