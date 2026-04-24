<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('program', function (Blueprint $table) {
            // Kita letakkan setelah nama_program
            $table->string('slug')->unique()->after('nama_program');
        });
    }

    public function down(): void
    {
        Schema::table('program', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
