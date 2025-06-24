<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

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

        $credentials = $request->only('username', 'password');

        $admin = Admin::where('username', $credentials['username'])->first();

        if ($admin) {
            if (Auth::guard('admin')->attempt($credentials)) {
                $request->session()->regenerate();
                session(['guard' => 'admin']);
                return redirect()->route('V_Dashboard');
            }
        } else {
            if (Auth::guard('web')->attempt($credentials)) {
                if (!Auth::guard('web')->user()->verifikasi) {
                    Auth::guard('web')->logout();
                    return redirect('/login')->with('failed', 'Akun belum diverifikasi.');
                }

                $request->session()->regenerate();
                session(['guard' => 'web']);
                return redirect()->route('V_Dashboard');
            }
        }

        return redirect('/login')->with('failed', 'Username atau Password salah!');
    }

    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing');
    }
}
