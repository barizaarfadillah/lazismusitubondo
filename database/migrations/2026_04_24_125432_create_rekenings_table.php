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
        Schema::create('rekening', function (Blueprint $table) {
            $table->id('id_rekening');
            $table->string('nama_bank', 50);
            $table->string('no_rekening', 30);
            $table->string('atas_nama', 100);
            $table->string('qris')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekening');
    }
};
