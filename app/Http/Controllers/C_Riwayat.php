<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;

class C_Riwayat extends Controller
{
    public function riwayat()
    {
        $data = Pengajuan::where('user_id', auth()->id())
            ->whereIn('status', ['Disetujui', 'Ditolak'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.V_Riwayat', compact('data'));
    }
}
