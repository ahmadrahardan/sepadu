@extends('layouts.app')
@section('title', 'Jadwal')
@section('content')

    <section x-data="jadwalModal" class="font-sans min-h-screen bg-cover bg-center relative"
        style="background-image: url({{ asset('assets/industry.png') }})">

        <!-- Main Content -->
        <div class="flex flex-col items-center justify-center min-h-screen pt-20 px-8 relative z-10">
            <div class="h-[100%] w-full bg-black/30 absolute bottom-0 z-10"></div>

            <!-- Box Header Jadwal -->
            <div class="w-full max-w-5xl bg-fit bg-center rounded-xl p-6 mb-6 text-black z-20"
                style="background-image: url({{ asset('assets/scrolll.png') }})">
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
                    <div class="flex gap-2">
                        <!-- Dropdown Filter Komoditas -->
                        <div>
                            <label class="block text-sm font-light mb-1 text-black">Pilih Komoditas:</label>
                            <select name="komoditas" x-model="selectedKomoditas" @change="filterByKomoditas"
                                class="bg-green-600 text-white px-3 py-1 rounded-md focus:outline-none focus:ring-2 focus:ring-white/50">
                                <option value="">Semua Komoditas</option>
                                @foreach ($komoditas as $k)
                                    <option value="{{ $k->id }}" @selected(request('komoditas') == $k->id)>{{ $k->komoditas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-light mb-1 text-black">Pilih Bulan & Tahun:</label>
                            <select name="bulan_tahun" x-model="selectedMonthYear" @change="filterByMonthYear"
                                class="bg-green-600 text-white px-3 py-1 rounded-md focus:outline-none focus:ring-2 focus:ring-white/50">

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
            </div>

            <!-- Container Scroll Kartu Pelatihan -->
            <div class="w-full max-w-5xl h-[350px] overflow-y-auto px-2 custom-scrollbar space-y-2 z-20">
                @if ($data->isEmpty())
                    <div class="text-white text-center mt-10 text-lg font-semibold">
                        Tidak ada jadwal.
                    </div>
                @else
                    @foreach ($data as $item)
                        <div class="bg-fit bg-center h-[110px] rounded-xl p-5 text-black"
                            style="background-image: url({{ asset('assets/scrolll.png') }})">
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
                                <div class="flex items-center gap-5">
                                    <div class="flex items-center justify-between gap-3">
                                        <!-- Tombol Peserta -->
                                        <button @click="openPeserta('{{ $item->id }}')"
                                            class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-1 rounded-md transition">
                                            Peserta
                                        </button>
                                        <!-- Tombol Detail -->
                                        <button
                                            @click="openDetail({
                                            topik: '{{ $item->topik }}',
                                            deskripsi: '{{ $item->deskripsi }}',
                                            tanggal: '{{ $item->tanggal }}',
                                            pukul: '{{ $item->pukul }}',
                                            lokasi: '{{ $item->lokasi }}',
                                            kuota: '{{ $item->kuota }}',
                                            komoditas: '{{ $item->komoditas->komoditas }}',
                                        })"
                                            class="bg-green-500 hover:bg-green-700 text-white px-4 py-1 rounded-md transition">
                                            Detail
                                        </button>
                                    </div>
                                    <div class="flex items-center justify-between gap-3">
                                        <!-- Tombol Edit -->
                                        <button type="button"
                                            @click="editJadwal({
                                            id: '{{ $item->id }}',
                                            topik: '{{ $item->topik }}',
                                            deskripsi: '{{ $item->deskripsi }}',
                                            tanggal: '{{ $item->tanggal }}',
                                            pukul: '{{ $item->pukul }}',
                                            komoditas_id: '{{ $item->komoditas_id }}',
                                            kuota: '{{ $item->kuota }}',
                                            lokasi: '{{ $item->lokasi }}',
                                        })"
                                            class="bg-orange-500 hover:bg-orange-600 text-white p-1 rounded-md border-2 border-white/40 flex items-center justify-center">
                                            <img src="{{ asset('assets/edit.png') }}" alt="edit">
                                        </button>
                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('jadwal.hapus', $item->id) }}" method="POST"
                                            onsubmit="event.stopPropagation(); return confirm('Yakin ingin menghapus data ini?')"
                                            class="ignore-click">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-600 hover:bg-red-700 text-white p-1 rounded-md border-2 border-white/40 flex items-center justify-center">
                                                <img src="{{ asset('assets/Trash.png') }}" alt="trash">
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Tombol Tambah -->
            <div class="w-full max-w-[62rem] mt-4 mx-auto">
                <div class="flex justify-end">
                    <button @click="showTambahJadwal = true"
                        class="bg-green-600 hover:bg-green-500 text-white px-6 py-2 rounded-lg shadow-md transition z-10">
                        Tambah
                    </button>
                </div>
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
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">
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
                    <div class="flex gap-8">
                        <div class="w-1/2">
                            <label class="block text-sm font-semibold mb-1">Kuota</label>
                            <input type="text" x-model="detailJadwal.kuota" readonly
                                class="w-full border rounded-lg px-4 py-2 bg-gray-100">
                        </div>
                        <div class="w-1/2">
                            <label class="block text-sm font-semibold mb-1">Komoditas</label>
                            <input type="text" x-model="detailJadwal.komoditas" readonly
                                class="w-full border rounded-lg px-4 py-2 bg-gray-100">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Lokasi</label>
                        <input type="text" x-model="detailJadwal.lokasi" readonly
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

        <!-- Modal Form Tambah Jadwal -->
        <div x-show="showTambahJadwal && !editMode" x-cloak x-transition
            class="fixed inset-0 z-40 flex items-center justify-center bg-black/60 backdrop-blur-sm">
            <div @click.outside="showTambahJadwal = false"
                class="bg-white rounded-2xl px-8 py-5 w-[800px] max-w-full relative text-gray-800 shadow-xl bg-fit bg-center"
                style="background-image: url('{{ asset('assets/big_bg.png') }}')">

                <h2 class="text-2xl font-bold text-center mb-6">Tambah Jadwal</h2>

                <form action="{{ route('jadwal.simpan') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold mb-1">Topik</label>
                        <input type="text" name="topik" value="{{ old('topik') }}"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                            placeholder="Masukkan Topik">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Deskripsi</label>
                        <textarea name="deskripsi"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 resize-none"
                            placeholder="Masukkan Deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                    </div>

                    <div class="flex gap-8">
                        <div class="w-1/2">
                            <label class="block text-sm font-semibold mb-1">Tanggal</label>
                            <input type="date" name="tanggal" value="{{ old('tanggal') }}"
                                class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                        <div class="w-1/2">
                            <label class="block text-sm font-semibold mb-1">Pukul</label>
                            <input type="time" name="pukul" value="{{ old('pukul') }}"
                                class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                    </div>

                    <div class="flex gap-8">
                        <div class="w-1/2">
                            <label class="block text-sm font-semibold mb-1">Kuota</label>
                            <input type="number" name="kuota" value="{{ old('kuota') }}"
                                class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                placeholder="Masukkan Kuota">
                        </div>
                        <div class="w-1/2">
                            <label class="block text-sm font-semibold mb-1">Komoditas</label>
                            <select name="komoditas_id"
                                class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                                <option value="">Pilih Komoditas</option>
                                @foreach ($komoditas as $k)
                                    <option value="{{ $k->id }}"
                                        {{ old('komoditas_id') == $k->id ? 'selected' : '' }}>
                                        {{ $k->komoditas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Lokasi</label>
                        <input type="text" name="lokasi" value="{{ old('lokasi') }}"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                            placeholder="Masukkan Lokasi">
                    </div>

                    <div class="flex justify-end mt-6 space-x-3">
                        <button type="button" @click="showTambahJadwal = false"
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

        <!-- Modal Form Edit Jadwal -->
        <div x-show="showTambahJadwal && editMode" x-cloak x-transition
            class="fixed inset-0 z-40 flex items-center justify-center bg-black/60 backdrop-blur-sm">
            <div @click.outside="showTambahJadwal = false; editMode = false"
                class="bg-white rounded-2xl py-5 px-8 w-[800px] max-w-full relative text-gray-800 shadow-xl bg-fit bg-center"
                style="background-image: url('{{ asset('assets/big_bg.png') }}')">

                <h2 class="text-2xl font-bold text-center mb-6">Edit Jadwal</h2>

                <form :action="'/jadwal/' + detailJadwal.id" method="POST" enctype="multipart/form-data"
                    class="space-y-4">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="edit_mode" value="1">

                    <div>
                        <label class="block text-sm font-semibold mb-1">Topik</label>
                        <input type="text" name="topik" x-model="detailJadwal.topik"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                            placeholder="Masukkan Topik">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Deskripsi</label>
                        <textarea name="deskripsi" x-model="detailJadwal.deskripsi"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 resize-none"
                            placeholder="Masukkan Deskripsi" rows="3"></textarea>
                    </div>

                    <div class="flex gap-8">
                        <div class="w-1/2">
                            <label class="block text-sm font-semibold mb-1">Tanggal</label>
                            <input type="date" name="tanggal" x-model="detailJadwal.tanggal"
                                class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                        <div class="w-1/2">
                            <label class="block text-sm font-semibold mb-1">Pukul</label>
                            <input type="time" name="pukul" x-model="detailJadwal.pukul"
                                class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                    </div>

                    <div class="flex gap-8">
                        <div class="w-1/2">
                            <label class="block text-sm font-semibold mb-1">Kuota</label>
                            <input type="text" name="kuota" x-model="detailJadwal.kuota"
                                class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                placeholder="Masukkan Kuota">
                        </div>
                        <div class="w-1/2">
                            <label class="block text-sm font-semibold mb-1">Komoditas</label>
                            <select name="komoditas_id" x-model="detailJadwal.komoditas_id"
                                class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                                <option value="">Pilih Komoditas</option>
                                @foreach ($komoditas as $k)
                                    <option value="{{ $k->id }}">{{ $k->komoditas }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Lokasi</label>
                        <input type="text" name="lokasi" x-model="detailJadwal.lokasi"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                            placeholder="Masukkan Lokasi">
                    </div>

                    <div class="flex justify-end mt-6 space-x-3">
                        <button type="button" @click="showTambahJadwal = false; editMode = false"
                            class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg ml-2">
                            Batal
                        </button>
                        <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg ml-2">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Form Peserta -->
        <div x-show="showPesertaModal" x-cloak x-transition
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">
            <div @click.outside="showPesertaModal = false"
                class="bg-white rounded-2xl px-8 py-5 w-[800px] max-w-full max-h-[85vh] overflow-y-auto hide-scrollbar relative text-gray-800 shadow-xl bg-fit bg-center"
                style="background-image: url('{{ asset('assets/big_bg.png') }}')">

                <h2 class="text-2xl font-bold text-center mb-6">Daftar Peserta</h2>

                <template x-if="pesertaList.length === 0">
                    <p class="text-center text-gray-600">Belum ada peserta terdaftar untuk jadwal ini.</p>
                </template>

                <template x-for="(peserta, index) in pesertaList" :key="index">
                    <div class="pb-2 text-gray-800">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="font-semibold">Peserta <span x-text="index + 1"></span>:</span>
                                <span x-text="peserta.nama"></span>
                            </div>
                            <div class="text-sm text-gray-500 italic">oleh: <span x-text="peserta.user"></span></div>
                        </div>
                    </div>
                </template>

                <div class="flex justify-end mt-6">
                    <button @click="showPesertaModal = false"
                        class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-semibold">
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
        if (performance.getEntriesByType("navigation")[0].type === "back_forward") {
            const successAlert = document.querySelector('[data-success-alert]');
            if (successAlert) successAlert.remove();

            const errorAlert = document.querySelector('[data-error-alert]');
            if (errorAlert) errorAlert.remove();
        }

        document.addEventListener("alpine:init", () => {
            Alpine.data("jadwalModal", () => ({
                showTambahJadwal: @json($errors->any()),
                editMode: @json(old('edit_mode') == 1),
                showDetailModal: false,
                showPesertaModal: false,
                pesertaList: [],
                selectedMonthYear: '{{ request()->get('bulan', 'terbaru') }}',
                selectedKomoditas: '{{ request()->get('komoditas', '') }}',
                detailJadwal: {
                    id: '{{ old('id') ?? '' }}',
                    topik: '{{ old('topik') ?? '' }}',
                    deskripsi: '{{ old('deskripsi') ?? '' }}',
                    tanggal: '{{ old('tanggal') ?? '' }}',
                    pukul: '{{ old('pukul') ?? '' }}',
                    kuota: '{{ old('kuota') ?? '' }}',
                    komoditas_id: '{{ old('komoditas_id') ?? '' }}',
                    lokasi: '{{ old('lokasi') ?? '' }}',
                },
                openDetail(data) {
                    this.detailJadwal = data;
                    this.showDetailModal = true;
                },
                editJadwal(data) {
                    this.detailJadwal = data;
                    this.editMode = true;
                    this.showTambahJadwal = true;
                },
                openPeserta(jadwalId) {
                    fetch(`/api/admin/peserta/${jadwalId}`)
                        .then(res => res.json())
                        .then(data => {
                            this.pesertaList = data;
                            this.showPesertaModal = true;
                        })
                        .catch(() => {
                            this.pesertaList = [];
                            this.showPesertaModal = true;
                        });
                },
                filterByMonthYear() {
                    const url = new URL(window.location.href);
                    url.searchParams.set('bulan', this.selectedMonthYear);
                    url.searchParams.set('komoditas', this.selectedKomoditas);
                    window.location.href = url.toString();
                },
                filterByKomoditas() {
                    const url = new URL(window.location.href);
                    url.searchParams.set('komoditas', this.selectedKomoditas);
                    url.searchParams.set('bulan', this.selectedMonthYear);
                    window.location.href = url.toString();
                },
                init() {
                    if (this.editMode && !this.detailJadwal.id) {
                        this.editMode = false;
                        this.showTambahJadwal = true;
                    }
                }
            }));
        });

        if (performance.getEntriesByType("navigation")[0].type === "back_forward") {
            history.replaceState(null, '', location.href);
            location.reload();
        }
    </script>
@endsection
