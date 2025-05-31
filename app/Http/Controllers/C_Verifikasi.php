<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class C_Verifikasi extends Controller
{
    public function verifikasi()
    {
        $users = User::where('verifikasi', false)->get();

        return view('admin.V_Verifikasi', compact('users'));
    }

    public function verifikasiUser($id)
    {
        $user = User::findOrFail($id);
        $user->verifikasi = true;
        $user->save();

        return redirect()->back()->with('success', 'User berhasil diverifikasi.');
    }

    public function hapusUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User berhasil ditolak.');
    }
}
