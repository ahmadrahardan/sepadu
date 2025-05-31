@extends('master.public')
@section('title', 'Profil')
@section('content')

    <section x-data="profilModal" class="font-sans min-h-screen bg-cover bg-center"
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

        {{-- Main --}}
        <div class="flex flex-col items-center justify-center min-h-screen pt-16 px-16 relative z-10 bg-cover bg-center">
            <div class="h-[5%] w-full bg-gradient-to-t from-slate-950 to-transparent -bottom-0 absolute z-10"></div>
            <img src="{{ asset('assets/Ornament.png') }}" alt="" class="h-[1012px] w-[1440px] -bottom-0 absolute">

            <!-- WRAPPER: dua kolom sejajar -->
            <div class="flex flex-row gap-6 relative z-20">
                <!-- KIRI -->
                <div class="flex flex-col w-[500px] gap-4">
                    <!-- PROFIL -->
                    <div
                        class="h-[370px] w-[500px] bg-white/10 backdrop-blur-md border border-white/60 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex flex-col items-center justify-center border-b border-white">
                            <div class="flex flex-col items-center mb-4">
                                <h2 class="text-2xl font-semibold">Profil</h2>
                                @if (!Auth::user()->isAdmin())
                                    <p class="text-sm">Data profil anda dalam Simbako</p>
                                @endif
                            </div>
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-16 h-16 rounded-full flex items-center justify-center text-sm">
                                    <img src="{{ asset('assets/avatar.png') }}" alt="">
                                </div>
                                <div class="text-xl">{{ Auth::user()->username }}</div>
                            </div>
                        </div>

                        <div class="py-2 border-b border-white flex justify-between">
                            <span>Nama</span>
                            <span class="ml-auto text-right">{{ Auth::user()->nama }}</span>
                        </div>
                        <div class="py-2 border-b border-white flex justify-between">
                            <span>Nomor Telepon</span>
                            <span class="ml-auto text-right">{{ Auth::user()->telepon }}</span>
                        </div>
                        <div class="py-2 flex justify-between">
                            <span>Alamat</span>
                            <span class="ml-auto text-right break-words" style="max-width: 250px;">
                                {{ Auth::user()->alamat }}
                            </span>
                        </div>
                    </div>

                    <!-- PENGATURAN -->
                    <div
                        class="w-[500px] bg-white/10 backdrop-blur-md border border-white/60 rounded-2xl p-6 text-white shadow-lg">
                        <div class="flex flex-col items-center justify-center border-b border-white">
                            <h2 class="text-xl font-bold mb-2">Pengaturan</h2>
                        </div>
                        <form action="{{ route('logout') }}" method="POST" class="inline"">
                            @csrf
                            <button
                                class="bg-orange-600 text-white py-1 px-4 rounded flex items-center gap-2 mt-3 transition-all duration-500 ease-in-out w-fit group hover:w-full hover:animate-[bounce-expand-left_0.4s_ease-in-out]">
                                <span>Keluar</span>
                                <svg class="ml-auto transition-all duration-500 ease-in-out group-hover:translate-x-2"
                                    xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path
                                        d="M5 22C4.44772 22 4 21.5523 4 21V3C4 2.44772 4.44772 2 5 2H19C19.5523 2 20 2.44772 20 3V6H18V4H6V20H18V18H20V21C20 21.5523 19.5523 22 19 22H5ZM18 16V13H11V11H18V8L23 12L18 16Z">
                                    </path>
                                </svg>
                            </button>
                        </form>
                        <style>
                            @keyframes bounce-expand-left {
                                0% {
                                    transform: scaleX(1);
                                    transform-origin: left;
                                }

                                30% {
                                    transform: scaleX(1.05);
                                    transform-origin: left;
                                }

                                60% {
                                    transform: scaleX(0.98);
                                    transform-origin: left;
                                }

                                100% {
                                    transform: scaleX(1);
                                    transform-origin: left;
                                }
                            }
                        </style>
                    </div>

                </div>

                <!-- KANAN -->
                <div
                    class="w-[500px] bg-white/10 backdrop-blur-md border border-white/60 rounded-2xl p-6 text-white shadow-lg">
                    <div class="flex flex-col items-center mb-8">
                        <h2 class="text-2xl font-semibold">Data Kredensial</h2>
                        @if (!Auth::user()->isAdmin())
                            <p class="text-sm">Data penting anda yang telah kami verifikasi</p>
                        @endif
                    </div>
                    <div class="py-2 border-b border-white flex justify-between">
                        <span>Email<span class="text-red-500">*</span></span>
                        <span class="ml-auto text-right">{{ Auth::user()->email }}</span>
                    </div>
                    @if (!Auth::user()->isAdmin())
                        <div class="py-2 border-b border-white flex justify-between">
                            <span>Nomor SIINAS<span class="text-red-500">*</span></span>
                            <span class="ml-auto text-right">{{ Auth::user()->siinas }}</span>
                        </div>
                        <div class="py-2 border-b border-white flex justify-between">
                            <span>Nomor KBLI<span class="text-red-500">*</span></span>
                            <span class="ml-auto text-right">{{ Auth::user()->kbli }}</span>
                        </div>
                    @endif

                    <div class="py-2 flex justify-between">
                        <span>Username</span>
                        <span class="ml-auto text-right">{{ Auth::user()->username }}</span>
                    </div>
                    <div class="py-2 border-b border-white flex justify-between">
                        <span>Password</span>
                        <span class="ml-auto text-right">********</span>
                    </div>
                    @if (!Auth::user()->isAdmin())
                        <div class="text-xs text-red-500 mt-4 mb-4">
                            *Data kredensial tidak dapat diubah karena telah melalui verifikasi data ketika anda melakukan
                            registrasi.
                        </div>
                    @endif

                    <!-- Tombol Ubah Profil -->
                    <div class="flex justify-end">
                        <button @click="showUbahProfil = true"
                            class="bg-white text-black border-2 border-green-900 font-semibold mt-2 py-2 px-4 rounded hover:bg-green-900 hover:border-white hover:text-white transform transition-transform duration-300 hover:scale-110">
                            Ubah Profil
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Ubah Profil -->
        <div x-show="showUbahProfil" x-cloak x-transition
            class="fixed inset-0 z-40 flex items-center justify-center pt-4 bg-black/60 backdrop-blur-sm">
            <div @click.outside="showUbahProfil = false"
                class="bg-white rounded-2xl p-8 w-[400px] max-w-full relative text-gray-800 shadow-xl bg-fit bg-center"
                style="background-image: url('{{ asset('assets/bg_form_2.png') }}')">

                <h2 class="text-2xl font-bold text-center mb-6">Ubah Profil</h2>

                <form action="{{ route('profil.update') }}" method="POST" class="space-y-2">
                    @method('PUT')
                    @csrf
                    @if (!Auth::user()->isAdmin())
                        <div>
                            <label class="block text-sm font-semibold mb-1">Nama</label>
                            <input type="text" name="nama"
                                class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                placeholder="Masukkan Nama">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-1">Username</label>
                            <input type="text" name="username"
                                class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                placeholder="Masukkan Username">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-1">Nomor Telepon</label>
                            <input type="text" name="telepon"
                                class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                placeholder="Masukkan Nomor Telepon">
                        </div>
                    @endif
                    <div>
                        <label class="block text-sm font-semibold mb-1">Password</label>
                        <input type="password" name="password"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                            placeholder="Masukkan Password">
                    </div>
                    @if (!Auth::user()->isAdmin())
                        <div>
                            <label class="block text-sm font-semibold mb-1">Alamat</label>
                            <textarea name="alamat" rows="2" placeholder="Masukkan alamat"
                                class="w-full border border-gray-300 resize-none rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-green-500"></textarea>
                        </div>
                    @endif

                    <div class="flex justify-between ">
                        <button type="button" @click="showUbahProfil = false"
                            class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg w-1/2 mr-2 font-semibold">
                            Batal
                        </button>
                        <button type="submit"
                            class="bg-green-700 hover:bg-green-800 text-white px-6 py-2 rounded-lg w-1/2 ml-2 font-semibold">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Footer --}}
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
            Alpine.data("profilModal", () => ({
                showUbahProfil: @json($errors->any()),
            }))
        });

        if (performance.getEntriesByType("navigation")[0].type === "back_forward") {
            history.replaceState(null, '', location.href);
            location.reload();
        }
    </script>

@endsection
