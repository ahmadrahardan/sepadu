@extends('layouts.app')
@section('title', 'Jadwal')
@section('content')

    <section x-data="jadwalModal" class="font-sans min-h-screen bg-cover bg-center relative"
        style="background-image: url({{ asset('assets/industry.png') }})">

        <!-- Main Content -->
        <div class="flex flex-col items-center justify-center min-h-screen pt-20 px-8 relative z-10">
            <div class="h-[100%] w-full bg-black/30 absolute bottom-0 z-10"></div>

            <!-- Box Header Jadwal -->
            <div
                class="w-full max-w-5xl bg-fit bg-center rounded-xl p-6 mb-6 text-black z-20" style="background-image: url({{ asset('assets/scrolll.png') }})">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold">Jadwal Pelatihan</h3>
                        <p class="text-sm text-black">*Pendaftaran pelatihan ditutup H-1 Pelaksaan Kegiatan!</p>
                    </div>
                    <!-- Filter Bulan & Tahun + Tambahan Opsi Terbaru -->
                    @php
                        $currentYear = now()->year;
                        $currentMonth = now()->month;
                    @endphp
                    <div>
                        <label class="block text-sm font-light mb-1 text-black">Pilih Bulan & Tahun:</label>
                        <select name="bulan_tahun" x-model="selectedMonthYear" @change="filterByMonthYear"
                            class="bg-green-600 text-white border border-white/40 px-3 py-1 rounded-md focus:outline-none focus:ring-2 focus:ring-white/50">

                            <!-- Opsi Terbaru -->
                            <option value="terbaru" {{ request('bulan', 'terbaru') === 'terbaru' ? 'selected' : '' }}>
                                Terbaru</option>

                            <!-- Opsi Bulan & Tahun -->
                            @for ($y = $currentYear; $y <= $currentYear + 2; $y++)
                                @for ($m = 1; $m <= 12; $m++)
                                    @php
                                        $value = sprintf('%04d-%02d', $y, $m);
                                        $label = \Carbon\Carbon::createFromDate($y, $m, 1)->translatedFormat('F Y');
                                    @endphp
                                    <option value="{{ $value }}" @selected($value === request('bulan', now()->format('Y-m')))>
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
                @if ($data->isEmpty())
                    <div class="text-white text-center mt-10 text-lg font-semibold">
                        Tidak ada jadwal untuk bulan ini.
                    </div>
                @else
                    @foreach ($data as $item)
                        <!-- Simulasi 5 card, akan scroll -->
                        <div
                            class="bg-fit bg-center h-[110px] rounded-xl p-5 text-black" style="background-image: url({{ asset('assets/scrolll.png') }})">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                                <div>
                                    <div class="flex gap-3">
                                        <p class="text-sm text-black">
                                            <i class="fa fa-calendar mr-1"></i>
                                            {{ $item->tanggal }}
                                        </p>
                                        <p class="text-sm text-black">
                                            <i class="fas fa-clock mr-1"></i>
                                            {{ \Carbon\Carbon::createFromFormat('H:i:s', $item->pukul)->format('H:i') }}
                                        </p>
                                        <p class="text-sm text-black">
                                            <i class="fa-solid fa-user-group"></i>
                                            {{ $item->pesertas_count }} / {{$item->kuota}}
                                        </p>
                                    </div>
                                    <h4 class="text-lg font-semibold truncate">{{ $item->topik }}</h4>
                                    <p class="text-sm text-black break-words"><i class="fa fa-map-marker mr-1"></i>
                                        {{ $item->lokasi }}</p>
                                </div>
                                <div class="flex items-center justify-between gap-5">
                                    @php
                                        $jadwalTanggal = \Carbon\Carbon::parse($item->tanggal);
                                        $limitDaftar = $jadwalTanggal->copy()->subDay();
                                        $today = \Carbon\Carbon::today();
                                        $sisaKuotaJadwal = (int)$item->kuota - $item->pesertas_count;
                                    @endphp

                                    @if (in_array($item->id, $sudahDaftar))
                                        <button disabled
                                            class="bg-gray-400 text-white px-4 py-1 rounded-md">Terdaftar</button>
                                    @elseif ($today->gte($limitDaftar) || $sisaKuotaJadwal <= 0)
                                        <button disabled
                                            class="bg-gray-400 text-white px-4 py-1 rounded-md opacity-50 cursor-not-allowed">
                                            Pendaftaran Ditutup
                                        </button>
                                    @else
                                        <button @click="openDaftar('{{ $item->id }}', {{ $sisaKuotaJadwal }})"
                                            class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-1 rounded-md">Daftar</button>
                                    @endif
                                    <button
                                        @click="openDetail({
                                        topik: '{{ $item->topik }}',
                                        deskripsi: '{{ $item->deskripsi }}',
                                        tanggal: '{{ $item->tanggal }}',
                                        pukul: '{{ $item->pukul }}',
                                        lokasi: '{{ $item->lokasi }}',
                                        kuota: '{{ $item->kuota }}'
                                    })"
                                        class="bg-green-500 hover:bg-green-700 text-white px-4 py-1 rounded-md transition">
                                        Detail
                                    </button>
                                </div>
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
                class="bg-white rounded-2xl px-8 py-5 w-[800px] max-w-full relative text-gray-800 shadow-xl bg-fit bg-center"
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
                        <textarea x-model="detailJadwal.deskripsi" readonly class="w-full border rounded-lg px-4 py-2 bg-gray-100 resize-none"
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
                </div>

                <div class="flex justify-end mt-6">
                    <button @click="showDetailModal = false"
                        class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg font-semibold">
                        Tutup
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal Daftar Jadwal -->
        <div x-show="showDaftarModal" x-cloak x-transition
            class="fixed inset-0 z-40 flex items-center justify-center bg-black/60 backdrop-blur-sm">
            <div @click.outside="showDaftarModal = false"
                class="bg-white rounded-2xl p-8 w-[800px] max-w-full relative text-gray-800 shadow-xl bg-fit bg-center"
                style="background-image: url('{{ asset('assets/big_bg.png') }}')">

                <h2 class="text-2xl font-bold text-center mb-6">Daftar Pelatihan</h2>

                <form action="{{ route('jadwal.daftar') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <input type="hidden" name="jadwal_id" :value="jadwalId">
                    <input type="hidden" name="modal" value="daftar">

                    <!-- Field Peserta Dinamis Menggunakan AlpineJS-->
                    <div id="peserta-fields" x-ref="fieldsContainer" class="space-y-3 max-h-80 overflow-y-auto p-1">
                        <template x-for="(nama, index) in pendaftar" :key="index">
                            <div>
                                <label :for="'pendaftar_' + index" class="block text-sm font-semibold mb-1" x-text="'Peserta ' + (index + 1)"></label>
                                <input
                                    type="text"
                                    :id="'pendaftar_' + index"
                                    name="pendaftar[]"
                                    x-model="pendaftar[index]"
                                    class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                    placeholder="Masukkan Nama Lengkap Peserta">
                            </div>
                        </template>
                    </div>

                    <div class="flex items-center justify-start space-x-3 pt-2">
                        <button type="button"
                            @click="
                                pendaftar.push('');
                                $nextTick(() => {
                                    $refs.fieldsContainer.scrollTop = $refs.fieldsContainer.scrollHeight
                                })
                            "
                            :disabled="pendaftar.length >= sisaKuota || pendaftar.length >= 5"
                            class="bg-green-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-600 disabled:bg-gray-400 disabled:cursor-not-allowed">
                            Tambah Peserta
                        </button>
                        <button type="button"
                            @click="pendaftar.length > 1 ? pendaftar.pop() : null"
                            :disabled="pendaftar.length <= 1"
                            class="bg-yellow-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-yellow-600 disabled:bg-gray-400 disabled:cursor-not-allowed">
                            Hapus Peserta
                        </button>
                    </div>

                    <div class="flex justify-end mt-6 space-x-3">
                        <button type="button" @click="showDaftarModal = false"
                            class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg ml-2">
                            Batal
                        </button>
                        <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg ml-2">
                            Simpan
                        </button>
                    </div>
                </form>
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
            Alpine.data("jadwalModal", () => ({
                showDetailModal: false,
                showDaftarModal: @json($errors->any() && old('modal') === 'daftar'),
                jadwalId: '{{ old('jadwal_id', '') }}',
                sisaKuota: 0,
                pendaftar: @json(old('pendaftar', [''])),
                selectedMonthYear: '{{ request()->get('bulan', now()->format('Y-m')) }}',
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
                },
                openDaftar(id, sisa) {
                    this.showDetailModal = false;
                    this.jadwalId = id;
                    this.sisaKuota = sisa;
                    this.pendaftar = [''];
                    this.showDaftarModal = true;
                },
                selectedMonthYear: '{{ request()->get('bulan', 'terbaru') }}',
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
