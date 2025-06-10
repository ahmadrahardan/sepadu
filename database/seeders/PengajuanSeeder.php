<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pengajuan;

class PengajuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pengajuan::create([
            'user_id' => 1,
            'kode' => 'IND-0001',
            'topik' => 'Pengenalan Varietas Tembakau berdasarkan tempat tumbuhnya',
            'dokumen' => 'dokumen_pengajuan/232410101027_Ahmad Rahardan.pdf',
            'status' => 'Proses',
            'feedback' => null,
        ]);

        Pengajuan::create([
            'user_id' => 3,
            'kode' => 'IND-0002',
            'topik' => 'Pengolahan Tekstil menjadi Batik Printing',
            'dokumen' => 'dokumen_pengajuan/232410101027_Ahmad Rahardan.pdf',
            'status' => 'Proses',
            'feedback' => null,
        ]);
    }
}
