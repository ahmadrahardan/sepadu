<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class C_Register extends Controller
{
    public function daftar()
    {
        return view("auth.V_Register");
    }

    public function daftarUser(Request $request)
    {
        $rules = [
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'telepon' => 'required|digits_between:12,16',
            'kbli' => 'required|digits:5',
            'siinas' => 'required|digits:17',
            'alamat' => 'required|string|max:255',
            'password' => 'required|string|min:8|max:8|confirmed',
        ];

        $messages = [
            'nama.required' => 'Nama belum terisi!',
            'username.required' => 'Username belum terisi!',
            'username.unique' => 'Username sudah digunakan!',
            'email.required' => 'Email belum terisi!',
            'email.email' => 'Format email tidak valid!',
            'email.unique' => 'Email sudah digunakan!',
            'telepon.required' => 'Nomor telepon belum diisi!',
            'telepon.digits_between' => 'Nomor telepon tidak valid!',
            'kbli.required' => 'KBLI wajib diisi!',
            'kbli.digits'     => 'KBLI harus terdiri dari 5 digit angka!',
            'siinas.required' => 'SIINAS wajib diisi!',
            'siinas.digits'     => 'SIINAS harus terdiri dari 17 digit angka!',
            'alamat.required' => 'Alamat wajib diisi!',
            'password.required' => 'Password belum terisi!',
            'password.min' => 'Password minimal 8 karakter!',
            'password.max' => 'Password maksimal 8 karakter!',
            'password.confirmed' => 'Konfirmasi password tidak sesuai!',
        ];

        $validated = $request->validate($rules, $messages);

        User::create([
            'nama' => $validated['nama'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'telepon' => $validated['telepon'],
            'kbli' => $validated['kbli'],
            'siinas' => $validated['siinas'],
            'alamat' => $validated['alamat'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect('/register')->with('success', 'Mohon tunggu verifikasi dari admin 2x24 jam untuk dapat login.');
    }
}
