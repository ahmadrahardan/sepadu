<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Jadwal;
use App\Models\Admin;
use App\Models\Komoditas;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            AdminSeeder::class,
            KomoditasSeeder::class,
            UserSeeder::class,
            PengajuanSeeder::class,
            JadwalSeeder::class,
            FaqSeeder::class,
        ]);
    }
}
