<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('artikel', function (Blueprint $table) {
        $table->id('id_artikel');
        $table->string('judul');
        $table->string('slug')->unique(); // Untuk URL SEO friendly
        $table->string('thumbnail')->nullable(); // Gambar utama artikel
        $table->longText('konten'); // Isi lengkap artikel
        $table->string('kategori')->default('Berita'); // Misal: Berita, Kisah, Edukasi
        $table->enum('status', ['Draft', 'Publish'])->default('Publish');
        $table->integer('views')->default(0); // Menghitung jumlah pembaca
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artikels');
    }
};
