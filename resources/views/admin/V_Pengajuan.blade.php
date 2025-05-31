@extends('master.public')
@section('title', 'Pengajuan')
@section('content')

    <section x-data="pengajuanModal" class="font-sans min-h-screen bg-cover bg-center relative"
        style="background-image: url({{ asset('assets/background_1.png') }})">

        <!-- Header -->
        @include('master.navbar')

        <!-- Notifikasi Sukses -->
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" data-success-alert
                class="fixed bottom-5 right-5 z-50 w-full max-w-sm bg-green-600 text-white rounded-xl p-4 shadow-lg flex items-start gap-3 animate-slide-up transition-all duration-500 ease-in-out">

                <!-- Logo -->
                <div
                    class="flex-shrink-0 bg-transparent rounded-full w-14 h-14 flex items-center justify-center overflow-hidden">
                    <img src="{{ asset('assets/rawlogo.png') }}" alt="Logo" class="h-6 w-6 object-cover">
                </div>

                <!-- Isi alert -->
                <div class="flex-grow">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-bold">Berhasil!</h3>
                        <button @click="show = false"
                            class="text-white hover:text-gray-200 text-xl leading-none">&times;</button>
                    </div>
                    <p class="text-sm mt-1">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Main Content -->
        <div class="flex flex-col items-center justify-center min-h-screen pt-16 px-8 relative z-10">
            <div class="h-[5%] w-full bg-gradient-to-t from-slate-950 to-transparent absolute bottom-0 z-10"></div>
            <img src="{{ asset('assets/Ornament.png') }}" alt="" class="h-[1012px] w-[1440px] absolute bottom-0">

            <div class="bg-white/10 backdrop-blur-md border border-white/60 rounded-2xl shadow-lg p-6 w-full max-w-5xl">
                <div class="flex justify-between">
                    <h2 class="text-xl font-semibold text-white pl-4 mb-4">Pengajuan Pelatihan</h2>
                    <div class="flex justify-end mb-4 pr-4">
                        <select x-model="selectedStatus" @change="filterByStatus"
                            class="bg-green-600 text-white border border-white/40 px-4 py-1 rounded-md focus:outline-none focus:ring-2 focus:ring-white/50">
                            <option value="">Semua Status</option>
                            <option value="Proses">Proses</option>
                            <option value="Disetujui">Disetujui</option>
                            <option value="Ditolak">Ditolak</option>
                        </select>
                    </div>
                </div>
                <div class="overflow-y-auto max-h-[300px] min-h-[300px] px-4 custom-scrollbar">
                    <table class="min-w-full text-sm text-white">
                        <thead>
                            <tr class="border-b border-white/60 text-left">
                                <th class="p-3">No.</th>
                                <th class="p-3">Tanggal</th>
                                <th class="p-3">Kode Pengajuan</th>
                                <th class="p-3">Status</th>
                                <th class="p-3">Topik</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/60">
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
                                            @php
                                                $warna = match ($item->status) {
                                                    'Proses' => 'bg-blue-500',
                                                    'Disetujui' => 'bg-green-500',
                                                    'Ditolak' => 'bg-red-500',
                                                };
                                            @endphp
                                            <span class="w-3 h-3 rounded-full {{ $warna }}"></span>
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
                                            nama: '{{ $item->user->nama }}',
                                            email: '{{ $item->user->email }}',
                                            topik: '{{ $item->topik }}',
                                            feedback: '{{ $item->feedback }}',
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
                                    <td colspan="6" class="p-3 text-center text-gray-400">Belum ada pengajuan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <style>
                    /* Scrollbar container */
                    .custom-scrollbar::-webkit-scrollbar {
                        width: 6px;
                    }

                    /* Track (latar belakang) */
                    .custom-scrollbar::-webkit-scrollbar-track {
                        background: transparent;
                    }

                    /* Thumb (batangnya) */
                    .custom-scrollbar::-webkit-scrollbar-thumb {
                        background-color: rgba(255, 255, 255, 0.4);
                        /* warna putih transparan */
                        border-radius: 9999px;
                    }
                </style>
            </div>
        </div>

        <!-- Modal Detail Pengajuan -->
        <div x-show="showDetailModal" x-cloak x-transition
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">
            <div @click.outside="showDetailModal = false"
                class="bg-white rounded-2xl p-8 w-[800px] max-w-full relative text-gray-800 shadow-xl bg-fit bg-center"
                style="background-image: url('{{ asset('assets/big_bg.png') }}')">

                <h2 class="text-2xl font-bold text-center mb-6">Detail Ajuan</h2>

                <div class="space-y-4">
                    <!-- Row 1: ID Pengajuan dan Nama IHT -->
                    <div class="flex gap-4">
                        <div class="w-1/2">
                            <label class="block text-sm font-semibold mb-1">Kode Pengajuan</label>
                            <input type="text" x-model="detailPengajuan.kode" readonly
                                class="w-full border rounded-lg px-4 py-2 bg-gray-100">
                        </div>
                        <div class="w-1/2">
                            <label class="block text-sm font-semibold mb-1">Topik</label>
                            <input type="text" x-model="detailPengajuan.topik" readonly
                                class="w-full border rounded-lg px-4 py-2 bg-gray-100">
                        </div>
                    </div>

                    <!-- Row 2: Email IHT dan Topik -->
                    <div class="flex gap-4">
                        <div class="w-1/2">
                            <label class="block text-sm font-semibold mb-1">Nama IHT</label>
                            <input type="text" x-model="detailPengajuan.nama" readonly
                                class="w-full border rounded-lg px-4 py-2 bg-gray-100">
                        </div>
                        <div class="w-1/2">
                            <label class="block text-sm font-semibold mb-1">Email IHT</label>
                            <input type="text" x-model="detailPengajuan.email" readonly
                                class="w-full border rounded-lg px-4 py-2 bg-gray-100">
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <template x-if="detailPengajuan.status === 'Proses'">
                            <div class="w-1/2">
                                <label class="block text-sm font-semibold mb-1">Feedback (opsional)</label>
                                <textarea x-model="detailPengajuan.feedback" name="feedback"
                                    class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 resize-none"
                                    placeholder="Masukkan feedback jika ada" rows="3"></textarea>
                            </div>
                        </template>

                        <template x-if="detailPengajuan.status !== 'Proses'">
                            <div class="w-1/2">
                                <label class="block text-sm font-semibold mb-1">Feedback dari Admin</label>
                                <div
                                    class="w-full bg-gray-100 border rounded-lg px-4 py-2 text-sm text-gray-800 min-h-[72px]">
                                    <span x-text="detailPengajuan.feedback || '-'"></span>
                                </div>
                            </div>
                        </template>
                        <div class="w-1/2">
                            <label class="block text-sm font-semibold mb-1">Dokumen Pendukung</label>
                            <a :href="'{{ route('dokumen.download', '') }}/' + detailPengajuan.dokumen.split('/').pop()"
                                download
                                class="block bg-gray-200 px-4 py-2 rounded text-sm text-center hover:bg-gray-300 transition">
                                Download Dokumen
                            </a>
                        </div>
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
                    <template x-if="detailPengajuan.status === 'Proses'">
                        <div class="flex mt-6 w-[30%] ml-auto relative" x-data="{ showDropdown: false }">
                            <!-- Tombol utama -->
                            <button @click="showDropdown = !showDropdown"
                                class="bg-green-700 hover:bg-green-800 text-white px-6 py-2 rounded-lg w-full font-semibold transition">
                                Ubah Status
                            </button>

                            <!-- Dropdown -->
                            <div x-show="showDropdown" x-cloak x-transition
                                class="absolute top-full right-0 mt-2 bg-white shadow-lg rounded-xl border p-4 space-y-3 w-full z-50">
                                <!-- Tombol Status -->
                                <form method="POST"
                                    x-bind:action="'/admin/pengajuan/update-status/' + detailPengajuan.id">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="Disetujui">
                                    <input type="hidden" name="feedback" :value="detailPengajuan.feedback">
                                    <button type="submit"
                                        class="w-full text-center bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md font-semibold">
                                        Setujui
                                    </button>
                                </form>

                                <form method="POST"
                                    x-bind:action="'/admin/pengajuan/update-status/' + detailPengajuan.id">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="Ditolak">
                                    <input type="hidden" name="feedback" :value="detailPengajuan.feedback">
                                    <button type="submit"
                                        class="w-full text-center bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md font-semibold">
                                        Tolak
                                    </button>
                                </form>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="flex justify-end mt-6">
                    <button @click="showDetailModal = false"
                        class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg font-semibold">
                        Tutup
                    </button>
                </div>
            </div>
        </div>

        <!-- Footer -->
        @include('master.footer')
    </section>
    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("pengajuanModal", () => ({
                showDetailModal: false,
                selectedStatus: '{{ request()->get('status', '') }}',
                detailPengajuan: {
                    id: '',
                    nama: '',
                    kode: '',
                    email: '',
                    topik: '',
                    dokumen: '',
                    status: '',
                    feedback: '',
                },
                openDetail(data) {
                    this.detailPengajuan = {
                        ...data,
                        feedback: data.feedback || '',
                    };
                    this.showDetailModal = true;
                },
                filterByStatus() {
                    const url = new URL(window.location.href);
                    url.searchParams.set('status', this.selectedStatus);
                    window.location.href = url.toString();
                },
            }))
        });
    </script>
@endsection
