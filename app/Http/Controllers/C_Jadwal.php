<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Pendaftaran;
use App\Models\Peserta;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Komoditas;

class C_Jadwal extends Controller
{
    public function jadwal(Request $request)
    {
        $user = auth()->user();

        $bulan = $request->get('bulan', 'terbaru');

        $query = Jadwal::withCount('pesertas')
            ->where('komoditas_id', $user->komoditas_id);

        if ($bulan === 'terbaru') {
            $query->orderBy('tanggal', 'desc')->limit(5);
        } else {
            $tahun = substr($bulan, 0, 4);
            $bulanAngka = substr($bulan, 5, 2);

            $query->whereYear('tanggal', $tahun)
                ->whereMonth('tanggal', $bulanAngka)
                ->orderBy('tanggal', 'asc');
        }

        $data = $query->get();

        $userId = $user->id;
        $sudahDaftar = Pendaftaran::where('user_id', $userId)
            ->pluck('jadwal_id')
            ->toArray();

        return view('user.V_Jadwal', compact('data', 'sudahDaftar'));
    }

    public function adminJadwal(Request $request)
    {
        $komoditas = Komoditas::all();

        $bulan = $bulan = $request->get('bulan', 'terbaru');
        $komoditasId = $request->get('komoditas');

        $query = Jadwal::withCount('pesertas');

        if ($bulan === 'terbaru') {

            $query->orderBy('tanggal', 'desc')->limit(5);
        } else {
            $tahun = substr($bulan, 0, 4);
            $bulanAngka = substr($bulan, 5, 2);
            $query->whereYear('tanggal', $tahun)
                ->whereMonth('tanggal', $bulanAngka)
                ->orderBy('tanggal', 'asc');
        }

        if (!empty($komoditasId)) {
            $query->where('komoditas_id', $komoditasId);
        }

        $data = $query->get();

        return view('admin.V_Jadwal', compact('data', 'komoditas'));
    }

    public function simpan(Request $request)
    {
        $rules = [
            'topik' => 'required|string|max:64',
            'deskripsi' => 'required|string|max:500',
            'tanggal' => 'required|date',
            'pukul' => 'required|date_format:H:i',
            'lokasi' => 'required|string|max:64',
            'kuota' => 'required|integer',
            'komoditas_id' => 'required|exists:komoditas,id',
        ];

        $messages = [
            'topik.required' => 'Topik belum diisi!',
            'topik.max' => 'Topik terlalu panjang.',
            'deskripsi.required' => 'Deskripsi belum diisi!',
            'deskripsi.max' => 'Deskripsi terlalu panjang.',
            'tanggal.required' => 'Tanggal belum diisi!',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'pukul.required' => 'Waktu pelatihan belum diisi!',
            'pukul.date_format' => 'Format waktu tidak valid.',
            'lokasi.required' => 'Lokasi belum diisi!',
            'lokasi.max' => 'Lokasi terlalu panjang.',
            'kuota.required' => 'kuota peserta belum diisi!',
            'komoditas_id.required' => 'Komoditas wajib dipilih!',
            'komoditas_id.exists' => 'Komoditas tidak valid!',
        ];

        $validated = $request->validate($rules, $messages);

        Jadwal::create([
            'admin_id' => getUserId(),
            'topik' => $validated['topik'],
            'deskripsi' => $validated['deskripsi'],
            'tanggal' => $validated['tanggal'],
            'pukul' => $validated['pukul'],
            'lokasi' => $validated['lokasi'],
            'kuota' => $validated['kuota'],
            'komoditas_id' => $validated['komoditas_id'],
        ]);

        return back()->with('success', 'Jadwal berhasil dibuat!');
    }

    public function update(Request $request, $id)
    {
        $request->merge([
            'id' => $id,
            'edit_mode' => 1,
        ]);

        $rules = [
            'topik' => 'required|string|max:64',
            'deskripsi' => 'required|string|max:500',
            'tanggal' => 'required|date',
            'pukul' => 'required|date_format:H:i:s',
            'lokasi' => 'required|string|max:64',
            'kuota' => 'required|integer',
            'komoditas_id' => 'required|exists:komoditas,id',
        ];

        $messages = [
            'topik.required' => 'Topik belum diisi!',
            'topik.max' => 'Topik terlalu panjang.',
            'deskripsi.required' => 'Deskripsi belum diisi!',
            'deskripsi.max' => 'Deskripsi terlalu panjang.',
            'tanggal.required' => 'Tanggal belum diisi!',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'pukul.required' => 'Waktu pelatihan belum diisi!',
            'pukul.date_format' => 'Format waktu tidak valid.',
            'lokasi.required' => 'Lokasi belum diisi!',
            'lokasi.max' => 'Lokasi terlalu panjang.',
            'kuota.required' => 'kuota peserta belum diisi!',
            'komoditas_id.required' => 'Komoditas wajib dipilih!',
            'komoditas_id.exists' => 'Komoditas tidak valid!',
        ];

        $validated = $request->validate($rules, $messages);

        $jadwal = Jadwal::findOrFail($id);
        $jadwal->topik = $validated['topik'];
        $jadwal->deskripsi = $validated['deskripsi'];
        $jadwal->tanggal = $validated['tanggal'];
        $jadwal->pukul = $validated['pukul'];
        $jadwal->lokasi = $validated['lokasi'];
        $jadwal->kuota = $validated['kuota'];
        $jadwal->komoditas_id = $validated['komoditas_id'];


        $jadwal->save();

        return back()->with('success', 'Jadwal berhasil diperbarui!');
    }

    public function hapus($id)
    {
        $jadwal = Jadwal::findOrFail($id);

        $jadwal->delete();

        return back()->with('success', 'Data jadwal berhasil dihapus!');
    }

    public function daftar(Request $request)
    {
        $validated = $request->validate([
            'jadwal_id' => 'required|exists:jadwal,id',
            'pendaftar' => 'required|array|min:1',
            'pendaftar.*' => ['required', 'string', 'max:64', 'regex:/^[^0-9,+]*$/']
        ], [
            'pendaftar.required' => 'Daftar peserta tidak boleh kosong.',
            'pendaftar.*.required' => "Nama peserta tidak boleh kosong.",
            'pendaftar.*.max' => "Nama peserta terlalu panjang (max 64 karakter).",
            'pendaftar.*.regex' => "Nama peserta tidak boleh mengandung angka atau simbol."
        ]);

        $pendaftarBaru = $validated['pendaftar'];


        $jumlahPeserta = count($pendaftarBaru);

        try {
            DB::transaction(function () use ($validated, $jumlahPeserta, $pendaftarBaru) {
                $jadwal = Jadwal::withCount('pesertas')->lockForUpdate()->findOrFail($validated['jadwal_id']);

                $sisaKuota = $jadwal->kuota - $jadwal->pesertas_count;

                if ($sisaKuota < $jumlahPeserta) {
                    throw new \Exception('Kuota tidak mencukupi. Sisa kuota hanya ' . $sisaKuota);
                }

                $pendaftaran = Pendaftaran::create([
                    'user_id' => getUserId(),
                    'jadwal_id' => $jadwal->id,
                ]);

                foreach ($pendaftarBaru as $nama) {
                    if ($nama) {
                        Peserta::create([
                            'pendaftaran_id' => $pendaftaran->id,
                            'nama' => $nama,
                        ]);
                    }
                }
            });

            return back()->with('success', 'Berhasil mendaftar!');
        } catch (\Exception $e) {
            return back()->withErrors(['pendaftar_1' => $e->getMessage()]);
        }
    }
}
