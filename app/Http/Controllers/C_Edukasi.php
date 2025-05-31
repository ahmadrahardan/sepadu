<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\Edukasi;

class C_Edukasi extends Controller
{
    public function edukasi()
    {
        $data = Edukasi::latest()->get();
        return view('user.V_Edukasi', compact('data'));
    }

    public function adminEdukasi()
    {
        $data = Edukasi::latest()->get();
        return view('admin.V_Edukasi', compact('data'));
    }

    public function konten($slug)
    {
        $edukasi = Edukasi::where('slug', $slug)->firstOrFail();
        return view('master.V_KontenEdukasi', compact('edukasi'));
    }

    public function simpan(Request $request)
    {
        $rules = [
            'topik' => 'required|string|max:255',
            'thumbnail' => 'required|image|max:2048',
            'konten' => 'required|file|mimes:txt|max:10240',
            'link' => 'nullable|url|max:255',
        ];

        $messages = [
            'topik.required' => 'Topik belum diisi!',
            'topik.max' => 'Topik terlalu panjang.',
            'thumbnail.required' => 'Thumbnail belum diunggah!',
            'thumbnail.image' => 'File thumbnail harus berupa gambar!',
            'thumbnail.max' => 'Ukuran thumbnail maksimal 2MB.',
            'konten.required' => 'File belum diunggah!',
            'konten.file' => 'Format file tidak valid.',
            'konten.mimes' => 'File harus dalam format txt.',
            'konten.max' => 'Ukuran file maksimal 10MB.',
            'link.url' => 'Link YouTube harus berupa URL yang valid.',
            'link.max' => 'Link Youtube terlalu panjang.',
        ];

        $validated = $request->validate($rules, $messages);

        // Simpan file
        $thumbnailPath = $request->file('thumbnail')->storeAs(
            'file_edukasi',
            Str::random(10) . '.' . $request->file('thumbnail')->getClientOriginalExtension(),
            'public'
        );

        $dokumenPath = $request->file('konten')->storeAs(
            'file_edukasi',
            Str::random(10) . '.' . $request->file('konten')->getClientOriginalExtension(),
            'public'
        );

        Edukasi::create([
            'user_id' => auth()->id() ?? 1,
            'topik' => $validated['topik'],
            'slug' => Str::slug($validated['topik']),
            'thumbnail' => 'storage/' . $thumbnailPath,
            'konten' => 'storage/' . $dokumenPath,
            'link' => $validated['link'] ?? null,
        ]);

        return back()->with('success', 'Edukasi berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->merge([
            'id' => $id,
            'edit_mode' => 1,
        ]);

        $rules = [
            'topik' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|max:2048',
            'konten' => 'nullable|file|mimes:txt|max:10240',
            'link' => 'nullable|url|max:255',
        ];

        $messages = [
            'topik.required' => 'Topik belum diisi!',
            'topik.max' => 'Topik terlalu panjang.',
            'thumbnail.image' => 'File thumbnail harus berupa gambar!',
            'thumbnail.max' => 'Ukuran thumbnail maksimal 2MB.',
            'konten.file' => 'Format file tidak valid.',
            'konten.mimes' => 'File harus dalam format txt.',
            'konten.max' => 'Ukuran file maksimal 10MB.',
            'link.url' => 'Link YouTube harus berupa URL yang valid.',
            'link.max' => 'Link Youtube terlalu panjang.',
        ];

        $validated = $request->validate($rules, $messages);

        $edukasi = Edukasi::findOrFail($id);
        $edukasi->topik = $validated['topik'];
        $edukasi->slug = Str::slug($validated['topik']);
        $edukasi->link = $validated['link'] ?? null;

        // Hapus file lama dan simpan yang baru jika ada
        if ($request->hasFile('thumbnail')) {
            if ($edukasi->thumbnail && Storage::disk('public')->exists(str_replace('storage/', '', $edukasi->thumbnail))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $edukasi->thumbnail));
            }

            $thumbnailPath = $request->file('thumbnail')->storeAs(
                'file_edukasi',
                Str::random(10) . '.' . $request->file('thumbnail')->getClientOriginalExtension(),
                'public'
            );
            $edukasi->thumbnail = 'storage/' . $thumbnailPath;
        }

        if ($request->hasFile('konten')) {
            if ($edukasi->konten && Storage::disk('public')->exists(str_replace('storage/', '', $edukasi->konten))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $edukasi->konten));
            }

            $kontenPath = $request->file('konten')->storeAs(
                'file_edukasi',
                Str::random(10) . '.' . $request->file('konten')->getClientOriginalExtension(),
                'public'
            );
            $edukasi->konten = 'storage/' . $kontenPath;
        }

        $edukasi->save();

        return redirect()->route('edukasi.konten', $edukasi->slug)
            ->with('success', 'Edukasi berhasil diperbarui!');
    }


    public function hapus($id)
    {
        $edukasi = Edukasi::findOrFail($id);

        if (File::exists(public_path($edukasi->thumbnail))) {
            File::delete(public_path($edukasi->thumbnail));
        }

        if (File::exists(public_path($edukasi->konten))) {
            File::delete(public_path($edukasi->konten));
        }

        $edukasi->delete();

        return back()->with('success', 'Data edukasi berhasil dihapus!');
    }
}
