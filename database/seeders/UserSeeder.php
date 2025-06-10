<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nama' => 'BIN Cigar',
            'username' => 'bincigar',
            'email' => 'bincigar@gmail.com',
            'password' => Hash::make('user1234'),
            'telepon' => '081272030617',
            'siinas' => '12345678901234567',
            'kbli' => '12001',
            'komoditas_id' => 6,
            'alamat' => 'Jl. Brawijaya No. 3, Kec. Sukorambi, Kabupaten Jember, Jawa Timur 68151',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'verifikasi' => true,
        ]);

        User::create([
            'nama' => 'Villiger Cigars',
            'username' => 'villigercigars',
            'email' => 'villigercigars@gmail.com',
            'password' => Hash::make('user5678'),
            'telepon' => '081272030613',
            'siinas' => '12345678901234568',
            'kbli' => '12002',
            'komoditas_id' => 6,
            'alamat' => 'Jl. Wolter Monginsidi No. 888 A, Kec. Ajung, Kabupaten Jember, Jawa Timur 68175',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'verifikasi' => false,
        ]);

        User::create([
            'nama' => 'UD. Anugerah Printing',
            'username' => 'anugerahprinting',
            'email' => 'anugerahprinting@gmail.com',
            'password' => Hash::make('user4321'),
            'telepon' => '081272030615',
            'siinas' => '12345678901234569',
            'kbli' => '12003',
            'komoditas_id' => 1,
            'alamat' => 'Jl. Kasuari, Kec. Patrang, Kabupaten Jember, Jawa Timur 68182',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'verifikasi' => true,
        ]);

        User::create([
            'nama' => 'Supermadu',
            'username' => 'supermadu',
            'email' => 'supermadu@gmail.com',
            'password' => Hash::make('user8765'),
            'telepon' => '081272030615',
            'siinas' => '12345678901234569',
            'kbli' => '12003',
            'komoditas_id' => 7,
            'alamat' => 'Jl. Kacapiring, Kec. Patrang, Kabupaten Jember, Jawa Timur 68184',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'verifikasi' => true,
        ]);
    }
}

