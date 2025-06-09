<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Komoditas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class C_Pengajuan extends Controller
{
    // public function pengajuan(Request $request)
    // {
    //     $status = $request->get('status');
    //     $komoditasId = $request->get('komoditas_id');

    //     $query = Pengajuan::with('user')
    //         ->whereHas('user', function ($q) {
    //             $q->whereNotNull('id');
    //         });

    //     if ($status) {
    //         $query->where('status', $status);
    //     }

    //     if ($komoditasId) {
    //         $query->whereHas('user', function ($q) use ($komoditasId) {
    //             $q->where('komoditas_id', $komoditasId);
    //         });
    //     }

    //     $data = $query->orderBy('created_at', 'desc')->get();
    //     $komoditasList = Komoditas::all();

    //     return view('user.V_Pengajuan', compact('data', 'komoditasList'));
    // }

    public function pengajuan()
    {
        $data = Pengajuan::where('status', 'Proses')
            ->where('user_id', getUserId())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.V_Pengajuan', compact('data'));
    }

    public function adminPengajuan(Request $request)
    {
        $query = Pengajuan::with('user');

        // Filter status jika ada
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter komoditas jika ada
        if ($request->filled('komoditas_id')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('komoditas_id', $request->komoditas_id);
            });
        }

        $data = $query->orderByDesc('created_at')->get();
        $komoditasList = Komoditas::all();

        return view('admin.V_Pengajuan', compact('data', 'komoditasList'));
    }

    public function simpan(Request $request)
    {
        $rules = [
            'topik' => 'required|string|max:255',
            'dokumen' => 'required|file|mimes:pdf,doc,docx|max:10240',
        ];

        $messages = [
            'topik.required' => 'Topik belum diisi!',
            'topik.max' => 'Topik terlalu panjang (maks 255 karakter).',
            'dokumen.required' => 'Dokumen harus diunggah!',
            'dokumen.file' => 'Format dokumen tidak valid.',
            'dokumen.mimes' => 'Dokumen harus dalam format PDF, DOC, atau DOCX.',
            'dokumen.max' => 'Ukuran dokumen maksimal 10MB.',
        ];

        $validated = $request->validate($rules, $messages);

        $filePath = $request->file('dokumen')->store('dokumen_pengajuan', 'public');

        // Generate kode: IHT-0001, IHT-0002, dst
        $last = \App\Models\Pengajuan::latest('id')->first();
        $nextNumber = $last ? $last->id + 1 : 1;
        $kode = 'IHT-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        Pengajuan::create([
            'user_id' => Auth::id(),
            'topik' => $validated['topik'],
            'dokumen' => $filePath,
            'kode' => $kode,
        ]);

        return redirect()->back()->with('success', 'Pengajuan berhasil dikirim!');
    }

    public function ubahStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak',
            'feedback' => 'nullable|string|max:1000',
        ]);
        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->status = $request->status;
        $pengajuan->feedback = $request->feedback;
        $pengajuan->save();

        return redirect()->back()->with('success', 'Status berhasil diubah.');
    }
}
