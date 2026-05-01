<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('donasi', function (Blueprint $table) {
            $table->string('kode_transaksi')->unique()->after('id_donasi')->nullable();
        });
    }

    public function down()
    {
        Schema::table('donasi', function (Blueprint $table) {
            $table->dropColumn('kode_transaksi');
        });
    }
};