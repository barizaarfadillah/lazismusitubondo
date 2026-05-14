<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Kategori;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Akun Admin
        User::create([
            'nama' => 'Admin Lazismu',
            'email' => 'admin@lazismu.com',
            'password' => Hash::make('lazismu123'), // Password untuk login admin
            'no_telp' => '081234567890',
            'alamat' => 'Kantor Lazismu Situbondo',
            'is_admin' => true,
            'status_user' => 'Aktif',
        ]);

        // 2. Buat Akun Donatur (Untuk uji coba)
        User::create([
            'nama' => 'Hamba Allah',
            'email' => 'donatur@gmail.com',
            'password' => Hash::make('donatur123'), // Password untuk login donatur
            'no_telp' => '089876543210',
            'alamat' => 'Situbondo',
            'is_admin' => false,
            'status_user' => 'Aktif',
        ]);

        // 3. Buat Kategori Dasar
        $kategoris = [
            'Zakat',
            'Infaq Umum',
            'Infaq Pendidikan',
            'Infaq Sosial Dakwah',
            'Infaq Kemanusiaan',
            'Infaq Kesehatan',
            'Infaq Ekonomi',
            'Infaq Lingkungan',
            'Qurban',
            'Fidyah'
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create([
                'nama_kategori' => $kategori
            ]);
        }
    }
}