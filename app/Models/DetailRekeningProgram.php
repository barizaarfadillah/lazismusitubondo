<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailRekeningProgram extends Model
{
    protected $table = 'detail_rekening_program';
    protected $primaryKey = 'id_detail';

    protected $fillable = ['id_program', 'id_rekening'];

    public function program()
    {
        return $this->belongsTo(Program::class, 'id_program', 'id_program');
    }

    public function rekening()
    {
        return $this->belongsTo(Rekening::class, 'id_rekening', 'id_rekening');
    }
}