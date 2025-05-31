@extends('master.public')
@section('title', 'Edukasi')
@section('content')

    <section x-data="edukasiModal" class="font-sans min-h-screen bg-cover bg-center relative"
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
        <div class="flex flex-col items-center justify-center min-h-screen pt-24 px-8 relative z-10">
            <div class="h-[5%] w-full bg-gradient-to-t from-slate-950 to-transparent absolute bottom-0 z-10"></div>
            <img src="{{ asset('assets/Ornament.png') }}" alt="" class="h-[1012px] w-[1440px] absolute bottom-0">

            <!-- Container Slider Wrapper -->
            <div class="relative w-full max-w-[1300px] flex items-center justify-center px-5">
                <!-- Left Scroll Button -->
                <span class="scroll-btn scroll-left-btn left absolute left-0 z-20" @click="scrollLeft">
                    <i class="fa fa-angle-left" aria-hidden="true"></i>
                </span>

                <!-- Card Slider -->
                <div x-ref="scrollContainer" x-init="scrollContainer = $refs.scrollContainer"
                    class="flex gap-5 overflow-x-auto scroll-smooth no-scrollbar w-full py-3 inner_card">
                    @foreach ($data as $item)
                        <div onclick="if (!event.target.closest('.ignore-click')) window.location='{{ route('edukasi.konten', $item->slug) }}'"
                            class="cursor-pointer bg-white/10 border-2 border-white/40 backdrop-blur-md rounded-xl p-3 shadow-xl hover:scale-95 transition-transform duration-300 w-[300px] h-[250px] flex-shrink-0 relative group">
                            <!-- Gambar + Tombol Edit & Hapus -->
                            <div class="overflow-hidden rounded-xl relative z-10">
                                <!-- Tombol -->
                                <div class="absolute top-2 right-2 flex gap-2 z-20">
                                    <!-- Tombol Edit -->
                                    <button type="button"
                                        @click.stop="editEdukasi({
                                            id: '{{ $item->id }}',
                                            topik: '{{ $item->topik }}',
                                            link: '{{ $item->link }}',
                                            thumbnail: '{{ asset($item->thumbnail) }}',
                                            konten: '{{ asset($item->konten) }}',
                                        })"
                                        class="ignore-click bg-orange-500 hover:bg-orange-600 text-white p-1 rounded-md border-2 border-white/40 flex items-center justify-center">
                                        <img src="{{ asset('assets/edit.png') }}" alt="edit">
                                    </button>
                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('edukasi.hapus', $item->id) }}" method="POST"
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

                                <!-- Gambar -->
                                <img src="{{ asset($item->thumbnail) }}" alt="{{ $item->topik }}"
                                    class="w-full h-[150px] object-cover">
                            </div>

                            <!-- Judul -->
                            <div class="overflow-hidden z-0">
                                <p class="text-white text-md text-center mt-2 leading-tight break-words px-3">
                                    {{ $item->topik }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Right Scroll Button -->
                <span class="scroll-btn scroll-right-btn right absolute right-0 z-20" @click="scrollRight">
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                </span>
            </div>

            <!-- Tombol Tambah -->
            <div class="w-full max-w-6xl mt-4 mx-auto">
                <div class="flex justify-end">
                    <button @click="showTambahEdukasi = true"
                        class="bg-green-600 hover:bg-green-500 text-white px-6 py-2 rounded-lg shadow-md transition z-10">
                        Tambah
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal Form Tambah Edukasi -->
        <div x-show="showTambahEdukasi && !editMode" x-cloak x-transition
            class="fixed inset-0 z-40 flex items-center justify-center bg-black/60 backdrop-blur-sm">
            <div @click.outside="showTambahEdukasi = false"
                class="bg-white rounded-2xl p-8 w-[800px] max-w-full relative text-gray-800 shadow-xl bg-fit bg-center"
                style="background-image: url('{{ asset('assets/big_bg.png') }}')">

                <h2 class="text-2xl font-bold text-center mb-6">Tambah Edukasi</h2>

                <form action="{{ route('edukasi.simpan') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold mb-1">Topik</label>
                        <input type="text" name="topik" value="{{ old('topik') }}"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                            placeholder="Masukkan Topik">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Link Youtube</label>
                        <input type="text" name="link" value="{{ old('link') }}"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                            placeholder="Masukkan URL Link">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Thumbnail</label>
                        <input type="file" name="thumbnail" accept="image/*"
                            class="w-full border rounded-lg px-4 py-4 text-center bg-gray-100 file:hidden">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">File Edukasi<span
                                class="text-red-500">*</span></label>
                        <input type="file" name="konten"
                            class="w-full border rounded-lg px-4 py-4 text-center bg-gray-100 file:hidden">
                    </div>
                    <p class="text-xs text-orange-500 mt-1">*File txt maksimal 10 MB</p>

                    <div class="flex justify-end mt-6 space-x-3">
                        <button type="button" @click="showTambahEdukasi = false"
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

        <!-- Modal Form Edit Edukasi -->
        <div x-show="showTambahEdukasi && editMode" x-cloak x-transition
            class="fixed inset-0 z-40 flex items-center justify-center bg-black/60 backdrop-blur-sm">
            <div @click.outside="showTambahEdukasi = false; editMode = false"
                class="bg-white rounded-2xl p-8 w-[800px] max-w-full relative text-gray-800 shadow-xl bg-fit bg-center"
                style="background-image: url('{{ asset('assets/big_bg.png') }}')">

                <h2 class="text-2xl font-bold text-center mb-6">Edit Edukasi</h2>

                <form :action="'/edukasi/' + formData.id" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="edit_mode" value="1">
                    <input type="hidden" name="id" :value="formData.id">

                    <div>
                        <label class="block text-sm font-semibold mb-1">Topik</label>
                        <input type="text" name="topik" x-model="formData.topik"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                            placeholder="Masukkan Topik">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Link Youtube</label>
                        <input type="text" name="link" x-model="formData.link"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                            placeholder="Masukkan URL Link">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Thumbnail</label>
                        <input type="file" name="thumbnail" accept="image/*"
                            class="w-full border rounded-lg px-4 py-4 text-center bg-gray-100 file:hidden">
                        <p class="text-xs text-gray-600 mt-1 italic">Kosongkan jika tidak ingin mengganti file.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">File Edukasi<span
                                class="text-red-500">*</span></label>
                        <input type="file" name="konten"
                            class="w-full border rounded-lg px-4 py-4 text-center bg-gray-100 file:hidden">
                        <p class="text-xs text-gray-600 mt-1 italic">Kosongkan jika tidak ingin mengganti file.</p>
                    </div>
                    <p class="text-xs text-orange-500 mt-1">*File txt maksimal 10 MB</p>

                    <div class="flex justify-end mt-6 space-x-3">
                        <button type="button" @click="showTambahEdukasi = false; editMode = false"
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

        <!-- Footer -->
        @include('master.footer')

        <style>
            .scroll-btn {
                position: absolute;
                font-size: 25px;
                display: flex;
                justify-content: center;
                align-items: center;
                border-radius: 3px;
                height: 100%;
                width: 30px;
                cursor: pointer;
                color: white;
                box-shadow: rgba(12, 12, 12, 0.5) 0 0 35px 8px inset;
                z-index: 50;
            }

            .scroll-left-btn {
                opacity: 0;
                left: 30px;
                transform: translateX(-100%);
            }

            .scroll-right-btn {
                opacity: 1;
                right: 30px;
                transform: translateX(100%);
            }

            .scroll-btn:hover {
                background: rgba(255, 255, 255, 0.3);
            }
        </style>

    </section>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let scrollableContent = document.querySelector('.inner_card');
            let leftBtn = document.querySelector('.left');
            let rightBtn = document.querySelector('.right');

            function updateScrollButtons() {
                if (scrollableContent.scrollLeft <= 0) {
                    leftBtn.style.opacity = 0;
                } else {
                    leftBtn.style.opacity = 1;
                }

                let maxScroll = scrollableContent.scrollWidth - scrollableContent.clientWidth;
                if (scrollableContent.scrollLeft >= maxScroll - 10) {
                    rightBtn.style.opacity = 0;
                } else {
                    rightBtn.style.opacity = 1;
                }
            }

            scrollableContent.addEventListener("scroll", updateScrollButtons);
            updateScrollButtons();
        });

        if (performance.getEntriesByType("navigation")[0].type === "back_forward") {
            const successAlert = document.querySelector('[data-success-alert]');
            if (successAlert) successAlert.remove();

            const errorAlert = document.querySelector('[data-error-alert]');
            if (errorAlert) errorAlert.remove();
        }

        document.addEventListener("alpine:init", () => {
            Alpine.data("edukasiModal", () => ({
                scrollContainer: null,
                scrollRight() {
                    this.scrollContainer.scrollBy({
                        left: 1280,
                        behavior: 'smooth'
                    });
                },
                scrollLeft() {
                    this.scrollContainer.scrollBy({
                        left: -1280,
                        behavior: 'smooth'
                    });
                },
                showTambahEdukasi: {{ $errors->any() ? 'true' : 'false' }},
                editMode: {{ old('edit_mode') == 1 ? 'true' : 'false' }},
                formData: {
                    id: '{{ old('id', '') }}',
                    topik: '{{ old('topik', '') }}',
                    link: '{{ old('link', '') }}'
                },
                editEdukasi(data) {
                    this.formData = data;
                    this.editMode = true;
                    this.showTambahEdukasi = true;
                }
            }))
        });

        if (performance.getEntriesByType("navigation")[0].type === "back_forward") {
            history.replaceState(null, '', location.href);
            location.reload();
        }
    </script>
@endsection
