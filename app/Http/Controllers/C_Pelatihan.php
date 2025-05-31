<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\Peserta;

class C_Pelatihan extends Controller
{
    public function pelatihan(Request $request)
    {
        $bulan = $request->get('bulan', 'terbaru');
        $userId = auth()->id();

        $query = Jadwal::whereHas('pendaftaran', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        });

        if ($bulan === 'terbaru') {
            // Ambil 5 riwayat pelatihan terbaru yang diikuti user
            $query->orderBy('tanggal', 'desc')->limit(5);
        } else {
            // Filter riwayat pelatihan user berdasarkan bulan dan tahun
            $tahun = substr($bulan, 0, 4);
            $bulanAngka = substr($bulan, 5, 2);
            $query->whereYear('tanggal', $tahun)
                ->whereMonth('tanggal', $bulanAngka)
                ->orderBy('tanggal', 'asc');
        }

        $riwayat = $query->get();

        return view('user.V_Pelatihan', compact('riwayat'));
    }
}
