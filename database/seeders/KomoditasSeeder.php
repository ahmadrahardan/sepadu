<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KomoditaS;

class KomoditasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $komoditases = [
            'Tekstil dan Barang Kulit',
            'Makanan',
            'Minuman',
            'Tembakau',
            'Pupuk Kimia',
            'Kertas',
            'Barang Kayu',
        ];

        foreach ($komoditases as $komoditas) {
            Komoditas::create([
                'admin_id' => 1,
                'komoditas' => $komoditas,
            ]);
        }
    }
}
