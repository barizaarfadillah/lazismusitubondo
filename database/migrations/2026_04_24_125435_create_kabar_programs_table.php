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
        Schema::create('kabar_program', function (Blueprint $table) {
            $table->id('id_kabar');
            $table->unsignedBigInteger('id_program');
            $table->string('judul', 100);
            $table->text('deskripsi');
            $table->string('dokumentasi')->nullable();
            $table->timestamps();

            $table->foreign('id_program')->references('id_program')->on('program')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kabar_program');
    }
};
