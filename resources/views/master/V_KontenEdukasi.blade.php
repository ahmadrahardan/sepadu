@extends('master.public')
@section('title', 'Konten')
@section('content')

    @php
        $isAdmin = Auth::user()->isAdmin();
    @endphp

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
        <div class="flex flex-col items-center justify-center min-h-screen pt-20 px-8 relative z-10">
            <div class="h-[5%] w-full bg-gradient-to-t from-slate-950 to-transparent absolute bottom-0 z-10"></div>
            <img src="{{ asset('assets/Ornament.png') }}" alt="" class="h-[1012px] w-[1440px] absolute bottom-0">

            <div class="border border-white/60 rounded-2xl shadow-lg p-6 w-full bg-fit bg-center z-20 max-w-5xl"
                style="background-image: url({{ asset('assets/biggbg.png') }})">
                <div class="overflow-y-auto h-[450px] px-6 custom-scrollbar relative text-white font-sans">

                    <div class="absolute top-0 left-0 mt-4 ml-2 flex gap-2">
                        <a href="{{ $isAdmin ? route('admin.edukasi') : route('V_Edukasi') }}"
                            class="bg-green-500 hover:bg-green-700 py-1 px-3 rounded-lg backdrop-blur flex items-center justify-center">
                            <i class="fa fa-arrow-left"></i>
                        </a>
                        @if ($isAdmin)
                            <button type="button"
                                @click.stop="editEdukasi({
                                    id: '{{ $edukasi->id }}',
                                    topik: '{{ $edukasi->topik }}',
                                    link: '{{ $edukasi->link }}',
                                    thumbnail: '{{ asset($edukasi->thumbnail) }}',
                                    konten: '{{ asset($edukasi->konten) }}',
                                })"
                                class="ignore-click bg-orange-500 hover:bg-orange-600 text-white p-1 rounded-md border-2 border-white/40 flex items-center justify-center">
                                <img src="{{ asset('assets/edit.png') }}" alt="edit">
                            </button>
                        @endif
                        {{-- <form action="{{ route('edukasi.hapus', $edukasi->id) }}" method="POST"
                            onsubmit="event.stopPropagation(); return confirm('Yakin ingin menghapus data ini?')"
                            class="ignore-click">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white p-1 rounded-md border-2 border-white/40 flex items-center justify-center">
                                <img src="{{ asset('assets/Trash.png') }}" alt="trash">
                            </button>
                        </form> --}}
                    </div>

                    <!-- Tanggal -->
                    <div
                        class="absolute top-0 right-0 mt-4 mr-4 bg-green-500 text-sm text-gray-100 px-3 py-1 rounded-md backdrop-blur">
                        {{ $edukasi->created_at->diffForHumans() }}
                    </div>

                    <!-- Judul -->
                    <h2 class="text-center text-xl font-semibold mt-12 text-black">
                        {{ $edukasi->topik }}
                    </h2>

                    @php
                        if (!function_exists('youtubeEmbed')) {
                            function youtubeEmbed($url)
                            {
                                if (Str::contains($url, 'watch?v=')) {
                                    return Str::replace('watch?v=', 'embed/', $url);
                                } elseif (Str::contains($url, 'youtu.be/')) {
                                    $id = Str::after($url, 'youtu.be/');
                                    return 'https://www.youtube.com/embed/' . $id;
                                }
                                return $url;
                            }
                        }
                    @endphp

                    @if ($edukasi->link)
                        <div class="flex justify-center mt-6">
                            <iframe class="w-[320px] h-[180px] rounded-2xl border border-white/30"
                                src="{{ youtubeEmbed($edukasi->link) }}" frameborder="0" allowfullscreen>
                            </iframe>
                        </div>
                    @endif

                    <!-- Isi Paragraf -->
                    <p class="mt-4 text-justify text-sm leading-relaxed text-black">
                        {!! nl2br(e(file_get_contents(public_path($edukasi->konten)))) !!}
                    </p>

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
        </div>

        <!-- Modal Edit Edukasi -->
        <div x-show="showEditEdukasi" x-cloak x-transition
            class="fixed inset-0 z-40 flex items-center justify-center bg-black/60 backdrop-blur-sm">
            <div @click.outside="showModal = false"
                class="bg-white rounded-2xl p-8 w-[800px] max-w-full relative text-gray-800 shadow-xl bg-fit bg-center"
                style="background-image: url('{{ asset('assets/big_bg.png') }}')">

                <h2 class="text-2xl font-bold text-center mb-6">Edit Edukasi</h2>

                <form action="{{ route('edukasi.update', $edukasi->id) }}" method="POST" enctype="multipart/form-data"
                    class="space-y-4">
                    @csrf
                    <input type="hidden" name="edit_mode" value="1">
                    <input type="hidden" name="id" value="{{ $edukasi->id }}">
                    @method('PUT')
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
                        <button type="button" @click="showEditEdukasi = false"
                            class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg mr-2">
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
            Alpine.data("edukasiModal", () => ({
                showEditEdukasi: {{ $errors->any() && old('edit_mode') == 1 ? 'true' : 'false' }},
                formData: {
                    id: '{{ old('id', $edukasi->id ?? '') }}',
                    topik: '{{ old('topik', $edukasi->topik ?? '') }}',
                    link: '{{ old('link', $edukasi->link ?? '') }}'
                },
                editEdukasi(data) {
                    this.formData = data;
                    this.showEditEdukasi = true;
                }
            }));
        });

        if (performance.getEntriesByType("navigation")[0].type === "back_forward") {
            history.replaceState(null, '', location.href);
            location.reload();
        }
    </script>
@endsection
