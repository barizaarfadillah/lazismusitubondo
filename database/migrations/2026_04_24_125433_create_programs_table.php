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
        Schema::create('program', function (Blueprint $table) {
            $table->id('id_program');
            $table->unsignedBigInteger('id_kategori'); 
            $table->string('nama_program');
            $table->text('deskripsi');
            $table->double('target_dana');
            $table->string('banner')->nullable();
            $table->date('tenggat_waktu');
            $table->string('status', 20)->default('Aktif');
            $table->timestamps();

            $table->foreign('id_kategori')->references('id_kategori')->on('kategori')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program');
    }
};
