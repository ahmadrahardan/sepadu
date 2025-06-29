@extends('layouts.app')
@section('title', 'Pelatihan')
@section('content')

    <section x-data="jadwalModal" class="font-sans min-h-screen bg-cover bg-center relative"
        style="background-image: url({{ asset('assets/industry.png') }})">

        <!-- Main Content -->
        <div class="flex flex-col items-center justify-center min-h-screen pt-16 px-8 relative z-10">
            <div class="h-[100%] w-full bg-black/30 absolute bottom-0 z-10"></div>

            <!-- Box Header Jadwal -->
            <div class="w-full max-w-5xl bg-fit bg-center rounded-xl p-6 mb-6 text-black z-20" style="background-image: url({{ asset('assets/scrolll.png') }})">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold">Daftar Pelatihan</h3>
                        <p class="text-sm text-black">Temukan pelatihan yang sedang atau telah diikuti</p>
                    </div>
                    <div>
                        @php
                            $currentYear = now()->year;
                            $currentMonth = now()->month;
                        @endphp
                        <label class="block text-sm font-light mb-1 text-black">Pilih Bulan & Tahun:</label>
                        <select name="bulan_tahun" x-model="selectedMonthYear" @change="filterByMonthYear"
                            class="bg-green-600 text-white border border-white/40 px-3 py-1 rounded-md focus:outline-none focus:ring-2 focus:ring-white/50">

                            <!-- Opsi Terbaru sebagai default -->
                            <option value="terbaru" {{ request('bulan', 'terbaru') === 'terbaru' ? 'selected' : '' }}>
                                Terbaru
                            </option>

                            <!-- Opsi Bulan & Tahun -->
                            @for ($y = $currentYear; $y <= $currentYear + 2; $y++)
                                @for ($m = 1; $m <= 12; $m++)
                                    @php
                                        $value = sprintf('%04d-%02d', $y, $m);
                                        $label = \Carbon\Carbon::createFromDate($y, $m, 1)->translatedFormat('F Y');
                                    @endphp
                                    <option value="{{ $value }}" {{ request('bulan') === $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endfor
                            @endfor
                        </select>
                    </div>
                </div>
            </div>

            <!-- Container Scroll Kartu Pelatihan -->
            <div class="w-full max-w-5xl h-[350px] overflow-y-auto px-2 custom-scrollbar space-y-2 z-20">
                @if ($riwayat->isEmpty())
                    <div class="text-white text-center mt-10 text-lg font-semibold">
                        Tidak ada pelatihan yang diikuti pada bulan ini.
                    </div>
                @else
                    @foreach ($riwayat as $jadwal)
                        <div
                            class="bg-fit bg-center rounded-xl h-[110px] p-5 mb-4 text-black" style="background-image: url({{ asset('assets/scrolll.png') }})">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                                <div>
                                    <div class="flex gap-3">
                                        <p class="text-sm text-black"><i class="fa fa-calendar mr-1"></i>
                                            {{ $jadwal->tanggal }}</p>
                                        <p class="text-sm text-black"><i class="fas fa-clock mr-1"></i>
                                            {{ \Carbon\Carbon::createFromFormat('H:i:s', $jadwal->pukul)->format('H:i') }}</p>
                                    </div>
                                    <h4 class="text-lg font-semibold truncate">{{ $jadwal->topik }}</h4>
                                    <p class="text-sm text-black break-words"><i
                                            class="fa fa-map-marker mr-1"></i>{{ $jadwal->lokasi }}</p>
                                </div>
                                <button
                                    @click="openDetail({
                                                id: '{{ $jadwal->id }}',
                                                topik: '{{ $jadwal->topik }}',
                                                deskripsi: '{{ $jadwal->deskripsi }}',
                                                tanggal: '{{ $jadwal->tanggal }}',
                                                pukul: '{{ $jadwal->pukul }}',
                                                lokasi: '{{ $jadwal->lokasi }}',
                                                kuota: '{{ $jadwal->kuota }}'
                                            })"
                                    class="bg-green-500 hover:bg-green-700 text-white px-4 py-1 rounded-md transition">
                                    Detail
                                </button>
                            </div>
                        </div>
                    @endforeach
                @endif
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

        <!-- Modal Detail Jadwal -->
        <div x-show="showDetailModal" x-cloak x-transition
            class="fixed inset-0 z-40 flex items-center justify-center bg-black/60 backdrop-blur-sm">
            <div @click.outside="showDetailModal = false"
                class="bg-white rounded-2xl px-8 py-5 w-[800px] max-w-full max-h-[85vh] overflow-y-auto hide-scrollbar relative text-gray-800 shadow-xl bg-fit bg-center"
                style="background-image: url('{{ asset('assets/big_bg.png') }}')">

                <h2 class="text-2xl font-bold text-center mb-6">Detail Pelatihan</h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold mb-1">Topik</label>
                        <input type="text" x-model="detailJadwal.topik" readonly
                            class="w-full border rounded-lg px-4 py-2 bg-gray-100">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Deskripsi</label>
                        <textarea x-model="detailJadwal.deskripsi" readonly
                            class="w-full border rounded-lg px-4 py-2 bg-gray-100 resize-none overflow-y-auto" style="max-height: 150px;"
                            rows="3"></textarea>
                    </div>

                    <div class="flex gap-8">
                        <div class="w-1/2">
                            <label class="block text-sm font-semibold mb-1">Tanggal</label>
                            <input type="text" x-model="detailJadwal.tanggal" readonly
                                class="w-full border rounded-lg px-4 py-2 bg-gray-100">
                        </div>
                        <div class="w-1/2">
                            <label class="block text-sm font-semibold mb-1">Pukul</label>
                            <input type="text" x-model="detailJadwal.pukul" readonly
                                class="w-full border rounded-lg px-4 py-2 bg-gray-100">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Lokasi</label>
                        <input type="text" x-model="detailJadwal.lokasi" readonly
                            class="w-full border rounded-lg px-4 py-2 bg-gray-100">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Kuota</label>
                        <input type="text" x-model="detailJadwal.kuota" readonly
                            class="w-full border rounded-lg px-4 py-2 bg-gray-100">
                    </div>

                    <!-- Peserta -->
                    <div>
                        <label class="block text-sm font-semibold mb-1">Peserta</label>
                        <div class="max-h-48 overflow-y-auto border rounded-lg bg-gray-50 p-3">
                            <template x-if="pesertaList.length > 0">
                                <ul class="space-y-2">
                                    <template x-for="(peserta, index) in pesertaList" :key="index">
                                        <li class="pb-2 text-gray-800">
                                            <span class="font-semibold">Peserta <span x-text="index + 1"></span>:</span>
                                            <span x-text="peserta"></span>
                                        </li>
                                    </template>
                                </ul>
                            </template>
                            <template x-if="pesertaList.length === 0">
                                <p class="text-gray-500 italic">Belum ada peserta yang terdaftar.</p>
                            </template>
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
            <style>
                .hide-scrollbar {
                    scrollbar-width: none;
                    -ms-overflow-style: none;
                }

                .hide-scrollbar::-webkit-scrollbar {
                    display: none;
                }
            </style>
        </div>
    </section>
    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("jadwalModal", () => ({
                showDetailModal: false,
                showDaftarModal: @json($errors->any() && old('modal') === 'daftar'),
                jadwalId: '{{ old('jadwal_id', '') }}',
                selectedMonthYear: '{{ request()->get('bulan', 'terbaru') }}',
                pesertaList: [],
                detailJadwal: {
                    topik: '',
                    deskripsi: '',
                    tanggal: '',
                    pukul: '',
                    lokasi: '',
                    kuota: '',
                },
                openDetail(data) {
                    this.detailJadwal = data;
                    this.showDetailModal = true;
                    fetch(`/api/peserta/${data.id}`)
                        .then(res => res.json())
                        .then(peserta => {
                            this.pesertaList = Array.isArray(peserta) ? peserta : Object.values(
                                peserta).filter(Boolean);
                        })
                        .catch(() => {
                            this.pesertaList = [];
                        });
                },
                filterByMonthYear() {
                    const url = new URL(window.location.href);
                    url.searchParams.set('bulan', this.selectedMonthYear);
                    window.location.href = url.toString();
                },
            }))
        });

        if (performance.getEntriesByType("navigation")[0].type === "back_forward") {
            history.replaceState(null, '', location.href);
            location.reload();
        }
    </script>
@endsection
