@extends('layouts.app')
@section('title', 'Pengajuan')
@section('content')

    <section x-data="pengajuanModal" class="font-sans min-h-screen bg-cover bg-center relative"
        style="background-image: url({{ asset('assets/industry.png') }})">

        <!-- Main Content -->
        <div class="flex flex-col items-center justify-center min-h-screen pt-28 px-8 relative z-10">
            <div class="h-[100%] w-full bg-black/30 absolute bottom-0 z-10"></div>

            <div class="bg-cover bg-center rounded-2xl shadow-lg p-6 w-full max-w-5xl z-20" style="background-image: url({{ asset('assets/bg.png') }})">
                <h2 class="text-xl font-semibold text-black pl-4 mb-4">Pengajuan Pelatihan</h2>
                <div class="overflow-y-auto max-h-[300px] min-h-[400px] px-4 custom-scrollbar">
                    <table class="min-w-full text-sm text-black">
                        <thead>
                            <tr class="border-b border-black text-left">
                                <th class="p-3">No.</th>
                                <th class="p-3">Tanggal</th>
                                <th class="p-3">Kode Pengajuan</th>
                                <th class="p-3">Status</th>
                                <th class="p-3">Topik</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-black">
                            @forelse ($data as $index => $item)
                                <tr class="hover:bg-white/10 transition">
                                    <td class="p-3">{{ $index + 1 }}</td>
                                    <td class="p-3">
                                        <div
                                            class="bg-white/20 backdrop-blur-sm px-3 py-1 rounded-md text-sm flex items-center justify-center">
                                            {{ $item->created_at->format('d-m-Y') }}
                                        </div>
                                    </td>
                                    <td class="p-3">{{ $item->kode }}</td>
                                    <td class="p-3">
                                        <div class="flex items-center gap-2">
                                            <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                                            {{ $item->status }}
                                        </div>
                                    </td>
                                    <td class="p-3 w-50 max-w-[14rem] break-words whitespace-normal">{{ $item->topik }}
                                    </td>
                                    <td class="p-3 text-center">
                                        <button
                                            @click="openDetail({
                                            id: '{{ $item->id }}',
                                            kode: '{{ $item->kode }}',
                                            topik: '{{ $item->topik }}',
                                            dokumen: '{{ $item->dokumen }}',
                                            status: '{{ $item->status }}'
                                        })"
                                            class="bg-green-500 hover:bg-green-700 text-white px-4 py-1 rounded-md transition">
                                            Detail
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-3 text-center text-gray-400">Tidak ada pengajuan yang sedang
                                        diproses.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <style>
                    .custom-scrollbar::-webkit-scrollbar {
                        width: 6px;
                    }
                    .custom-scrollbar::-webkit-scrollbar-track {
                        background: transparent;
                    }
                    .custom-scrollbar::-webkit-scrollbar-thumb {
                        background-color: rgba(255, 255, 255, 0.4);
                        border-radius: 9999px;
                    }
                </style>
            </div>

            <!-- Tombol Tambah -->
            <div class="w-full max-w-5xl mt-4 mx-auto">
                <div class="flex justify-end">
                    <button @click="showTambahPengajuan = true"
                        class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-lg shadow-md transition z-10">
                        Tambah
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal Tambah Pengajuan -->
        <div x-show="showTambahPengajuan" x-cloak x-transition
            class="fixed inset-0 z-40 flex items-center justify-center bg-black/60 backdrop-blur-sm">
            <div @click.outside="showModal = false"
                class="bg-white rounded-2xl p-8 w-[400px] max-w-full relative text-gray-800 shadow-xl bg-fit bg-center"
                style="background-image: url('{{ asset('assets/bg_form_2.png') }}')">

                <h2 class="text-2xl font-bold text-center mb-6">Ajuan</h2>

                <form action="{{ route('pengajuan.simpan') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold mb-1">Topik</label>
                        <input type="text" name="topik" value="{{ old('topik') }}"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                            placeholder="Masukkan Topik">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Dokumen Pendukung<span
                                class="text-red-500">*</span></label>
                        <input type="file" name="dokumen"
                            class="w-full border rounded-lg px-4 py-4 text-center bg-gray-100 file:hidden">
                    </div>
                    <p class="text-xs text-orange-500 mt-1">*Dokumen dapat berupa proposal PDF, DOC, atau DOCX maksimal 10
                        MB</p>

                    <div class="flex justify-between mt-6">
                        <button type="button" @click="showTambahPengajuan = false"
                            class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg w-1/2 mr-2">
                            Batal
                        </button>
                        <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg w-1/2 ml-2">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Detail Pengajuan -->
        <div x-show="showDetailModal" x-cloak x-transition
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">
            <div @click.outside="showDetailModal = false"
                class="bg-white rounded-2xl p-8 w-[400px] max-w-full relative text-gray-800 shadow-xl bg-fit bg-center"
                style="background-image: url('{{ asset('assets/bg_form_2.png') }}')">

                <h2 class="text-2xl font-bold text-center mb-6">Detail Ajuan</h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold mb-1">Kode Pengajuan</label>
                        <input type="text" x-model="detailPengajuan.kode" readonly
                            class="w-full border rounded-lg px-4 py-2 bg-gray-100">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Topik</label>
                        <input type="text" x-model="detailPengajuan.topik" readonly
                            class="w-full border rounded-lg px-4 py-2 bg-gray-100">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Dokumen Pendukung</label>
                        <a :href="'{{ route('dokumen.download', '') }}/' + detailPengajuan.dokumen.split('/').pop()"
                            target="_blank" download
                            class="block bg-gray-200 px-4 py-2 rounded text-sm text-center hover:bg-gray-300 transition">
                            Download Dokumen
                        </a>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Status</label>
                        <div class="flex items-center gap-2 mt-1">
                            <input type="radio" class="form-radio"
                                :class="{
                                    'accent-green-600': detailPengajuan.status === 'Disetujui',
                                    'accent-red-600': detailPengajuan.status === 'Ditolak',
                                    'accent-blue-500': detailPengajuan.status === 'Proses'
                                }"
                                checked>
                            <span x-text="detailPengajuan.status"></span>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <button @click="showDetailModal = false"
                        class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg font-semibold">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </section>
    <script>
        if (performance.getEntriesByType("navigation")[0].type === "back_forward") {
            const successAlert = document.querySelector('[data-success-alert]');
            if (successAlert) successAlert.remove();

            const errorAlert = document.querySelector('[data-error-alert]');
            if (errorAlert) errorAlert.remove();
        }

        document.addEventListener("alpine:init", () => {
            Alpine.data("pengajuanModal", () => ({
                showTambahPengajuan: @json($errors->any()),
                showDetailModal: false,
                detailPengajuan: {
                    id: '',
                    topik: '',
                    kode: '',
                    dokumen: '',
                    status: '',
                },
                openDetail(data) {
                    this.detailPengajuan = data;
                    this.showDetailModal = true;
                }
            }))
        });

        if (performance.getEntriesByType("navigation")[0].type === "back_forward") {
            history.replaceState(null, '', location.href);
            location.reload();
        }
    </script>
@endsection
