<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    public $incrementing = true;

    protected $fillable = ['nama_kategori'];

    public function program()
    {
        return $this->hasMany(Program::class, 'id_kategori', 'id_kategori');
    }
}