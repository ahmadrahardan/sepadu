<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Faq;

class C_FAQ extends Controller
{
    public function faq()
    {
        $data = Faq::latest()->get();
        return view('master.V_FAQ', compact('data'));
    }

    public function simpan(Request $request)
    {
        $rules = [
            'pertanyaan' => 'required|string|max:64',
            'jawaban' => 'required|string|max:255',
        ];

        $messages = [
            'pertanyaan.required' => 'Pertanyaan belum diisi!',
            'pertanyaan.max' => 'Pertanyaan terlalu panjang.',
            'jawaban.required' => 'Jawaban belum diisi!',
            'jawaban.max' => 'Jawaban terlalu panjang.',
        ];

        $validated = $request->validate($rules, $messages);

        Faq::create([
            'user_id' => auth()->id() ?? 1,
            'pertanyaan' => $validated['pertanyaan'],
            'jawaban' => $validated['jawaban'],
        ]);

        return back()->with('success', 'FAQ baru berhasil dibuat!');
    }

    public function update(Request $request, $id)
    {
        $request->merge([
            'id' => $id,
            'edit_mode' => 1,
        ]);

        $rules = [
            'pertanyaan' => 'required|string|max:64',
            'jawaban' => 'required|string|max:255',
        ];

        $messages = [
            'pertanyaan.required' => 'Pertanyaan belum diisi!',
            'pertanyaan.max' => 'Pertanyaan terlalu panjang.',
            'jawaban.required' => 'Jawaban belum diisi!',
            'jawaban.max' => 'Jawaban terlalu panjang.',
        ];

        $validated = $request->validate($rules, $messages);

        $faq = Faq::findOrFail($id);
        $faq->pertanyaan = $validated['pertanyaan'];
        $faq->jawaban = $validated['jawaban'];

        $faq->save();

        return back()->with('success', 'FAQ berhasil diperbarui!');
    }

    public function hapus($id)
    {
        $faq = Faq::findOrFail($id);

        $faq->delete();

        return back()->with('success', 'FAQ berhasil dihapus!');
    }
}
