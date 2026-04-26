<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $table = 'program';
    protected $primaryKey = 'id_program';

    protected $fillable = [
        'id_kategori', 
        'nama_program', 
        'slug', 
        'deskripsi', 
        'target_dana', 
        'banner', 
        'tenggat_waktu', // Tambahkan ini
        'status'
    ];

    // Accessor untuk menghitung dana terkumpul otomatis
    public function getDanaTerkumpulAttribute()
    {
        return $this->donasi()->where('status', 'Berhasil')->sum('nominal');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function donasi()
    {
        return $this->hasMany(Donasi::class, 'id_program', 'id_program');
    }

    public function kabar_program()
    {
        return $this->hasMany(KabarProgram::class, 'id_program', 'id_program');
    }

    public function rekenings()
    {
        return $this->belongsToMany(Rekening::class, 'detail_rekening_program', 'id_program', 'id_rekening');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}