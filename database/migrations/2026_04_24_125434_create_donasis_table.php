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
        Schema::create('donasi', function (Blueprint $table) {
            $table->id('id_donasi');
            $table->string('kode_transaksi')->unique();
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_program');
            $table->unsignedBigInteger('id_rekening');
            $table->double('nominal');
            $table->text('pesan_doa')->nullable();
            $table->boolean('is_anonim')->default(false);
            $table->string('status', 20)->default('Pending');
            $table->timestamp('tanggal_donasi')->useCurrent();
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('user')->onDelete('restrict');
            $table->foreign('id_program')->references('id_program')->on('program')->onDelete('restrict');
            $table->foreign('id_rekening')->references('id_rekening')->on('rekening')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donasi');
    }
};
