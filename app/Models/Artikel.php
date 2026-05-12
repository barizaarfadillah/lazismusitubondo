<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    use HasFactory;

    // Menentukan nama tabel (opsional, tapi bagus untuk memastikan)
    protected $table = 'artikel';

    protected $primaryKey = 'id_artikel';

    // Kolom yang diizinkan untuk diisi secara massal
    protected $fillable = [
        'judul',
        'slug',
        'thumbnail',
        'konten',
        'kategori',
        'status',
        'views',
    ];
}