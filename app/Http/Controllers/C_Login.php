<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class C_Login extends Controller
{
    public function masuk()
    {
        return view('auth.V_Login');
    }

    public function cekData(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'Username belum terisi!',
            'password.required' => 'Password belum terisi!',
        ]);

        $credentials = [
        'username' => $request->username,
        'password' => $request->password
    ];

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        // Tambahkan pengecekan status verifikasi
        if (!Auth::user()->verifikasi) {
            Auth::logout(); // keluarin user dari session
            return redirect('/login')->with('failed', 'Akun Anda belum diverifikasi.');
        }

        return redirect()->route('V_Dashboard');
    }

        return redirect('/login')->with('failed', 'Username atau Password Salah!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing');
    }
}
