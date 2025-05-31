@extends('master.public')
@section('title', 'Jadwal')
@section('content')

    <section x-data="jadwalModal" class="font-sans min-h-screen bg-cover bg-center relative"
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

        <!-- Notifikasi Gagal Validasi -->
        @if ($errors->any())
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" data-error-alert
                class="fixed bottom-5 right-5 z-50 w-full max-w-sm bg-red-600 text-white rounded-xl p-4 shadow-lg flex items-start gap-3 animate-slide-up transition-all duration-500 ease-in-out">

                <!-- Logo -->
                <div
                    class="flex-shrink-0 bg-transparent rounded-full w-14 h-14 flex items-center justify-center overflow-hidden">
                    <img src="{{ asset('assets/rawlogo.png') }}" alt="Logo" class="h-6 w-6 object-cover">
                </div>

                <!-- Isi alert -->
                <div class="flex-grow">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-bold">Alert!</h3>
                        <button @click="show = false"
                            class="text-white hover:text-gray-200 text-xl leading-none">&times;</button>
                    </div>
                    <ul class="text-sm mt-1 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Main Content -->
        <div class="flex flex-col items-center justify-center min-h-screen pt-20 px-8 relative z-10">
            <div class="h-[5%] w-full bg-gradient-to-t from-slate-950 to-transparent absolute bottom-0 z-10"></div>
            <img src="{{ asset('assets/Ornament.png') }}" alt="" class="h-[1012px] w-[1440px] absolute bottom-0">

            <!-- Box Header Jadwal -->
            <div
                class="w-full max-w-5xl bg-white/10 border border-white/30 backdrop-blur-md rounded-xl p-6 mb-6 text-white">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold">Jadwal Pelatihan</h3>
                        <p class="text-sm text-white/80">Temukan jadwal pelatihan sesuai dengan agendamu!</p>
                    </div>
                    <!-- Filter Bulan & Tahun + Tambahan Opsi Terbaru -->
                    @php
                        $currentYear = now()->year;
                        $currentMonth = now()->month;
                    @endphp
                    <div>
                        <label class="block text-sm font-light mb-1 text-white">Pilih Bulan & Tahun:</label>
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
            <div class="w-full max-w-5xl h-[240px] overflow-y-auto px-2 custom-scrollbar space-y-4">
                @if ($data->isEmpty())
                    <div class="text-white text-center mt-10 text-lg font-semibold">
                        Tidak ada jadwal untuk bulan ini.
                    </div>
                @else
                    @foreach ($data as $item)
                        <!-- Simulasi 5 card, akan scroll -->
                        <div
                            class="bg-white/10 border border-white/30 backdrop-blur-md h-[110px] rounded-xl p-5 text-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="flex gap-3">
                                        <p class="text-sm text-white/70"><i class="fa fa-calendar mr-1"></i>
                                            {{ $item->tanggal }}</p>
                                        <p class="text-sm text-white/70"><i class="fas fa-clock mr-1"></i>
                                            {{ \Carbon\Carbon::createFromFormat('H:i:s', $item->pukul)->format('H:i') }}</p>
                                    </div>
                                    <h4 class="text-lg font-semibold">{{ $item->topik }}</h4>
                                    <p class="text-sm text-white/70"><i class="fa fa-map-marker mr-1"></i>
                                        {{ $item->lokasi }}</p>
                                </div>
                                <div class="flex items-center justify-between gap-5">
                                    @if (in_array($item->id, $sudahDaftar))
                                        <button disabled class="bg-gray-400 text-white px-4 py-1 rounded-md">Terdaftar</button>
                                    @else
                                        <button @click="openDaftar('{{ $item->id }}')"
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

                    <div>
                        <label class="block text-sm font-semibold mb-1">Peserta 1</label>
                        <input type="text" name="pendaftar_1" value="{{ old('pendaftar_1') }}"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                            placeholder="Masukkan Nama Lengkap Peserta">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Peserta 2</label>
                        <input type="text" name="pendaftar_2" value="{{ old('pendaftar_2') }}"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                            placeholder="Masukkan Nama Lengkap Peserta">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Peserta 3</label>
                        <input type="text" name="pendaftar_3" value="{{ old('pendaftar_3') }}"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                            placeholder="Masukkan Nama Lengkap Peserta">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Peserta 4</label>
                        <input type="text" name="pendaftar_4" value="{{ old('pendaftar_4') }}"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                            placeholder="Masukkan Nama Lengkap Peserta">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Peserta 5</label>
                        <input type="text" name="pendaftar_5" value="{{ old('pendaftar_5') }}"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                            placeholder="Masukkan Nama Lengkap Peserta">
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

        <!-- Footer -->
        @include('master.footer')
    </section>
    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("jadwalModal", () => ({
                showDetailModal: false,
                showDaftarModal: @json($errors->any() && old('modal') === 'daftar'),
                jadwalId: '{{ old('jadwal_id', '') }}',
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
                openDaftar(id) {
                    this.showDetailModal = false;
                    this.jadwalId = id;
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
