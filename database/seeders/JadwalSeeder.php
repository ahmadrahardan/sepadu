<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jadwal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class JadwalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $topiks = [
            'Pengenalan Varietas Tembakau dan Kesesuaian Tempat Tumbuhnya',
            'Dampak Penggunaan Pupuk Kimia Berlebihan pada Tembakau',
            'Waktu Transplanting yang Baik pada Tembakau',
            'Teknik Pembibitan Tembakau yang Tepat',
        ];

        foreach ($topiks as $topik) {
            Jadwal::create([
                'user_id' => 1,
                'topik' => $topik,
                'deskripsi' => 'Pelatihan tembakau ini bertujuan untuk meningkatkan pengetahuan dan keterampilan peserta dalam budidaya,    pemrosesan, serta pemasaran tembakau secara modern. Melalui sesi praktis, peserta akan mempelajari teknik-teknik penanaman, perawatan, panen, hingga pengolahan daun tembakau agar menghasilkan kualitas terbaik dan bernilai jual tinggi.',
                'tanggal' => '2025-03-23',
                'pukul' => '08:30',
                'lokasi' => 'Dinas Perindustrian dan Perdagangan Kabupaten Jember',
                'kuota' => '50',
            ]);
        }
    }
}
