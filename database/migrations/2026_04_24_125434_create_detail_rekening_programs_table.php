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
        Schema::create('detail_rekening_program', function (Blueprint $table) {
            $table->id('id_detail');
            $table->unsignedBigInteger('id_program');
            $table->unsignedBigInteger('id_rekening');
            $table->timestamps();

            $table->foreign('id_program')->references('id_program')->on('program')->onDelete('cascade');
            $table->foreign('id_rekening')->references('id_rekening')->on('rekening')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_rekening_program');
    }
};
