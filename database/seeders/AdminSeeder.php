<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'nama' => 'Admin Sepadu',
            'username' => 'adminsepadu',
            'email' => 'disperindag@jemberkab.go.id',
            'password' => Hash::make('admin123'),
            'telepon' => '(0331)334497',
            'alamat' => 'Jl. Kalimantan No. 71, Kec. Sumbersari, Kabupaten Jember, Jawa Timur 68121',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
    }
}
