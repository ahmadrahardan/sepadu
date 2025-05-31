@extends('master.public')
@section('title', 'FAQ')
@section('content')

    @php
        $isAdmin = Auth::user()->isAdmin();
    @endphp

    <section x-data="faqModal" class="font-sans min-h-screen bg-cover bg-center relative"
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

            <div class="border border-white/60 rounded-2xl shadow-lg p-6 w-full bg-fit bg-center max-w-2xl z-20"
                style="background-image: url({{ asset('assets/big_bg.png') }})">
                <div class="overflow-y-auto h-[400px] px-6 custom-scrollbar relative text-white font-sans">

                    <h2 class="text-4xl font-bold text-black text-center mb-6">FAQ</h2>

                    <div x-data="{ openIndex: null }" class="space-y-4">
                        @foreach ($data as $index => $faq)
                            <div class="relative rounded-lg overflow-hidden shadow-lg">
                                <div class="flex items-center justify-between bg-green-700 text-white px-4 py-3 rounded-md">
                                    <!-- Teks Pertanyaan -->
                                    <span class="font-semibold">{{ $faq->pertanyaan }}</span>

                                    <!-- Aksi -->
                                    <div class="ml-4 flex items-center gap-2">
                                        <!-- Panah -->
                                        <button
                                            @click="openIndex === {{ $index }} ? openIndex = null : openIndex = {{ $index }}">
                                            <i
                                                :class="openIndex === {{ $index }} ? 'fas fa-chevron-up' :
                                                    'fas fa-chevron-down'"></i>
                                        </button>

                                        <!-- Tombol Edit & Hapus Admin -->
                                        @if ($isAdmin)
                                            <button type="button"
                                                @click="editFAQ({
                                                id: '{{ $faq->id }}',
                                                pertanyaan: '{{ $faq->pertanyaan }}',
                                                jawaban: '{{ $faq->jawaban }}',
                                            })"
                                                class="bg-orange-500 hover:bg-orange-600 text-white p-1 rounded-md border border-white/40">
                                                <img src="{{ asset('assets/edit.png') }}" alt="edit" class="w-4 h-4">
                                            </button>
                                            <form action="{{ route('faq.hapus', $faq->id) }}" method="POST"
                                                onsubmit="event.stopPropagation(); return confirm('Yakin ingin menghapus data ini?')"
                                                class="ignore-click">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-600 hover:bg-red-700 text-white p-1 rounded-md border-2 border-white/40">
                                                    <img src="{{ asset('assets/Trash.png') }}" alt="trash"
                                                        class="w-4 h-4">
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>

                                <!-- Isi FAQ -->
                                <div x-show="openIndex === {{ $index }}" x-transition
                                    class="bg-white text-black px-4 py-3 rounded-b-md text-sm">
                                    <p>{{ $faq->jawaban }}</p>
                                </div>
                            </div>
                        @endforeach
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
                        border-radius: 9999px;
                    }
                </style>
            </div>
            <!-- Tombol Tambah -->
            @if ($isAdmin)
                <div class="w-full max-w-2xl mt-4 mx-auto">
                    <div class="flex justify-end">
                        <button @click="showTambahFAQ = true"
                            class="bg-green-600 hover:bg-green-500 text-white px-6 py-2 rounded-lg shadow-md transition z-10">
                            Tambah
                        </button>
                    </div>
                </div>
            @endif
        </div>

        <!-- Modal Form Tambah FAQ -->
        <div x-show="showTambahFAQ && !editMode" x-cloak x-transition
            class="fixed inset-0 z-40 flex items-center justify-center bg-black/60 backdrop-blur-sm">
            <div @click.outside="showTambahFAQ = false"
                class="bg-white rounded-2xl p-8 w-[600px] max-w-full relative text-gray-800 shadow-xl bg-fit bg-center"
                style="background-image: url('{{ asset('assets/big_bg.png') }}')">

                <h2 class="text-2xl font-bold text-center mb-6">Tambah FAQ</h2>

                <form action="{{ route('faq.simpan') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold mb-1">Pertanyaan</label>
                        <textarea name="pertanyaan"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 resize-none"
                            placeholder="Masukkan Pertanyaan">{{ old('pertanyaan') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Jawaban</label>
                        <textarea name="jawaban"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 resize-none"
                            placeholder="Masukkan Jawaban">{{ old('jawaban') }}</textarea>
                    </div>

                    <div class="flex justify-end mt-6 space-x-3">
                        <button type="button" @click="showTambahFAQ = false"
                            class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg ml-2">
                            Batal
                        </button>
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg ml-2">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Form Edit FAQ -->
        <div x-show="showTambahFAQ && editMode" x-cloak x-transition
            class="fixed inset-0 z-40 flex items-center justify-center bg-black/60 backdrop-blur-sm">
            <div @click.outside="showTambahFAQ = false; editMode = false"
                class="bg-white rounded-2xl p-8 w-[600px] max-w-full relative text-gray-800 shadow-xl bg-fit bg-center"
                style="background-image: url('{{ asset('assets/big_bg.png') }}')">

                <h2 class="text-2xl font-bold text-center mb-6">Edit FAQ</h2>

                <form :action="'/faq/' + detailFAQ.id" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="edit_mode" value="1">

                    <div>
                        <label class="block text-sm font-semibold mb-1">Pertanyaan</label>
                        <textarea name="pertanyaan" x-model="detailFAQ.pertanyaan"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 resize-none"
                            placeholder="Masukkan Pertanyaan"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Jawaban</label>
                        <textarea name="jawaban" x-model="detailFAQ.jawaban"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 resize-none"
                            placeholder="Masukkan Jawaban"></textarea>
                    </div>

                    <div class="flex justify-end mt-6 space-x-3">
                        <button type="button"
                            @click="showTambahFAQ = false; editMode = false; detailFAQ = {id: null, pertanyaan: '', jawaban: ''}"
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
    </section>
    <script>
        if (performance.getEntriesByType("navigation")[0].type === "back_forward") {
            const successAlert = document.querySelector('[data-success-alert]');
            if (successAlert) successAlert.remove();

            const errorAlert = document.querySelector('[data-error-alert]');
            if (errorAlert) errorAlert.remove();
        }

        document.addEventListener("alpine:init", () => {
            Alpine.data("faqModal", () => ({
                showTambahFAQ: {{ $errors->any() ? 'true' : 'false' }},
                editMode: {{ old('edit_mode') == 1 ? 'true' : 'false' }},
                detailFAQ: {
                    id: '{{ old('id', '') }}',
                    pertanyaan: '{{ old('pertanyaan', '') }}',
                    jawaban: '{{ old('jawaban', '') }}'
                },
                editFAQ(data) {
                    this.detailFAQ = data;
                    this.editMode = true;
                    this.showTambahFAQ = true;
                },
                init() {
                    if (this.editMode && !this.detailFAQ.id) {
                        this.editMode = false;
                        this.showTambahFAQ = true;
                    }
                }
            }))
        });

        if (performance.getEntriesByType("navigation")[0].type === "back_forward") {
            history.replaceState(null, '', location.href);
            location.reload();
        }
    </script>
@endsection
