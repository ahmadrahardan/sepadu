@extends('layouts.app')
@section('title', 'Verifikasi')
@section('content')

    <section x-data="pengajuanModal" class="font-sans min-h-screen bg-cover bg-center relative"
        style="background-image: url({{ asset('assets/industry.png') }})">

        <!-- Main Content -->
        <div class="flex flex-col items-center justify-center min-h-screen pt-16 px-8 relative z-10">
            <div class="h-[100%] w-full bg-black/30 absolute bottom-0 z-10"></div>

            <div class="rounded-2xl bg-cover bg-center p-6 w-full max-w-5xl z-20"
                style="background-image: url({{ asset('assets/bg.png') }})">
                <h2 class="text-xl font-semibold text-black pl-4 mb-4">Daftar Registrasi</h2>
                <div class="overflow-y-auto max-h-[300px] min-h-[430px] px-4 custom-scrollbar">
                    <table class="min-w-full text-sm text-black">
                        <thead>
                            <tr class="border-b border-black text-left">
                                <th class="p-3">No.</th>
                                <th class="p-3">Nama</th>
                                <th class="p-3">Username</th>
                                <th class="p-3">Email</th>
                                <th class="p-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-black">
                            @forelse ($users as $index => $item)
                                <tr class="hover:bg-white/10 transition">
                                    <td class="p-3">{{ $index + 1 }}</td>
                                    <td class="p-3">{{ $item->nama }}</td>
                                    <td class="p-3">{{ $item->username }}</td>
                                    <td class="p-3">{{ $item->email }}</td>
                                    <td class="p-3 text-green-400 font-medium">Belum Terverifikasi</td>
                                    <td class="p-3 text-center">
                                        <button
                                            @click="openDetail({
                                                id: '{{ $item->id }}',
                                                nama: '{{ $item->nama }}',
                                                username: '{{ $item->username }}',
                                                email: '{{ $item->email }}',
                                                telepon: '{{ $item->telepon }}',
                                                siinas: '{{ $item->siinas }}',
                                                kbli: '{{ $item->kbli }}',
                                                komoditas: '{{ $item->komoditas->komoditas ?? '-' }}',
                                                alamat: '{{ $item->alamat }}'
                                            })"
                                            class="bg-green-500 hover:bg-green-700 text-white px-4 py-1 rounded-md transition">
                                            Detail
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-3 text-center text-gray-400">Tidak ada user yang menunggu
                                        verifikasi.</td>
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
        </div>

        <!-- Modal Detail User -->
        <div x-show="showDetailModal" x-cloak x-transition
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">
            <div @click.outside="showDetailModal = false"
                class="bg-white rounded-2xl p-8 w-[800px] max-w-full relative text-gray-800 shadow-xl bg-fit bg-center"
                style="background-image: url('{{ asset('assets/big_bg.png') }}')">

                <h2 class="text-2xl font-bold text-center mb-6">Detail User</h2>

                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-semibold mb-1">Nama</label>
                            <input type="text" x-model="detailUser.nama"
                                class="w-full bg-gray-100 border rounded-lg px-4 py-2" readonly>
                        </div>
                        <div>
                            <label class="text-sm font-semibold mb-1">Username</label>
                            <input type="text" x-model="detailUser.username"
                                class="w-full bg-gray-100 border rounded-lg px-4 py-2" readonly>
                        </div>
                        <div>
                            <label class="text-sm font-semibold mb-1">Email</label>
                            <input type="text" x-model="detailUser.email"
                                class="w-full bg-gray-100 border rounded-lg px-4 py-2" readonly>
                        </div>
                        <div>
                            <label class="text-sm font-semibold mb-1">Telepon</label>
                            <input type="text" x-model="detailUser.telepon"
                                class="w-full bg-gray-100 border rounded-lg px-4 py-2" readonly>
                        </div>
                        <div>
                            <label class="text-sm font-semibold mb-1">SIINAS</label>
                            <input type="text" x-model="detailUser.siinas"
                                class="w-full bg-gray-100 border rounded-lg px-4 py-2" readonly>
                        </div>
                        <div>
                            <label class="text-sm font-semibold mb-1">KBLI</label>
                            <input type="text" x-model="detailUser.kbli"
                                class="w-full bg-gray-100 border rounded-lg px-4 py-2" readonly>
                        </div>
                        <div>
                            <label class="text-sm font-semibold mb-1">Komoditas</label>
                            <input type="text" x-model="detailUser.komoditas"
                                class="w-full bg-gray-100 border rounded-lg px-4 py-2" readonly>
                        </div>
                        <div>
                            <label class="text-sm font-semibold mb-1">Alamat</label>
                            <textarea x-model="detailUser.alamat" rows="2" class="resize-none w-full bg-gray-100 border rounded-lg px-4 py-2"
                                readonly></textarea>
                        </div>
                    </div>

                    <div class="flex justify-end mt-6 space-x-3">
                        <div class="relative" x-data="{ openDropdown: false }">
                            <!-- Tombol utama -->
                            <button @click="openDropdown = !openDropdown"
                                class="bg-green-700 hover:bg-green-800 text-white px-6 py-2 rounded-lg font-semibold transition">
                                Verifikasi
                            </button>

                            <!-- Dropdown -->
                            <div x-show="openDropdown" @click.outside="openDropdown = false" x-cloak
                                class="absolute right-0 mt-2 bg-white shadow-lg rounded-xl border px-4 py-3 flex gap-3 z-50">

                                <!-- Verifikasi -->
                                <form method="POST" :action="'/admin/verifikasi/' + detailUser.id">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                        class="text-center bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md font-semibold">
                                        Verifikasi
                                    </button>
                                </form>

                                <!-- Tolak -->
                                <form method="POST" :action="'/admin/tolak/' + detailUser.id"
                                    onsubmit="return confirm('Yakin ingin menolak dan menghapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-center bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md font-semibold">
                                        Tolak
                                    </button>
                                </form>
                            </div>

                        </div>
                        <button @click="showDetailModal = false"
                            class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg font-semibold">
                            Tutup
                        </button>
                    </div>
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
                showDetailModal: false,
                detailUser: {
                    id: '',
                    nama: '',
                    username: '',
                    email: '',
                    telepon: '',
                    siinas: '',
                    kbli: '',
                    komoditas: '',
                    alamat: '',
                },
                openDetail(user) {
                    this.detailUser = user;
                    this.showDetailModal = true;
                },
            }))
        });
    </script>

@endsection
