<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Komoditas;

class KomoditasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $komoditases = [
            'Tekstil dan Barang Kulit',
            'Alat Angkutan dan Mesin',
            'Pupuk, Kimia, dan Bara',
            'Barang Kayu dan Hias',
            'Handycraft',
            'Tembakau',
            'Makanan',
            'Minuman',
            'Kertas',
            'Semen',
            'Obat',
        ];

        foreach ($komoditases as $komoditas) {
            Komoditas::create([
                'admin_id' => 1,
                'komoditas' => $komoditas,
            ]);
        }
    }
}
