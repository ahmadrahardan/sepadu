<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class C_Profil extends Controller
{
    public function profil()
    {
        return view('master.V_Profil');
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $inputFields = ['username', 'password', 'nama', 'telepon', 'alamat'];

        $filledAny = false;
        foreach ($inputFields as $field) {
            if ($request->filled($field)) {
                $filledAny = true;
                break;
            }
        }

        if (!$filledAny) {
            return redirect()->back()->withErrors(['form' => 'Tidak ada field yang diisi!'])->withInput();
        }

        $rules = [
            'username' => 'nullable|string|max:255|unique:users,username,' . $user->id,
            'password' => 'nullable|string|min:8|max:8',
        ];

        if (!$user->isAdmin()) {
            $rules = array_merge($rules, [
                'nama' => 'nullable|string|max:255',
                'telepon' => 'nullable|digits_between:12,16',
                'alamat' => 'nullable|string|max:255',
            ]);
        }

        $messages = [
            'username.unique' => 'Username sudah digunakan!',
            'password.min' => 'Password minimal 8 karakter!',
            'password.max' => 'Password maksimal 8 karakter!',
            'nama.required' => 'Nama belum diisi!',
            'telepon.digits_between' => 'Nomor telepon tidak valid!',
            'alamat.max' => 'Alamat terlalu panjang!',
        ];

        $validated = $request->validate($rules, $messages);

        if (isset($validated['username'])) {
            $user->username = $validated['username'];
        }

        if (!$user->isAdmin()) {
            if (isset($validated['nama'])) {
                $user->nama = $validated['nama'];
            }
            if ($request->filled('telepon')) {
                $user->telepon = $validated['telepon'];
            }
            if ($request->filled('alamat')) {
                $user->alamat = $validated['alamat'];
            }
        }

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
}
