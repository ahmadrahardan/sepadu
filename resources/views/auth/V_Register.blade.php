@extends('master.public')
@section('title', 'Register')
@section('content')

    <section class="font-sans h-screen bg-cover bg-center min-h-screen flex items-center justify-center"
        style="background-image: url({{ asset('assets/background_1.png') }})">

        <!-- Header -->
        <header class="absolute top-0 left-0 w-full z-50 px-20 py-6">
            <!-- Logo -->
            <div class="flex items-center text-white text-xl font-semibold">
                <img src="{{ asset('assets/logo.png') }}" alt="Simbako Logo" class="h-8">
            </div>
        </header>

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

        <!-- Notifikasi Validasi -->
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

        <!-- Form content -->
        <div class="bg-white/70 backdrop-blur-md rounded-3xl p-10 w-[800px] relative shadow-xl bg-fit bg-center"
            style="background-image: url('{{ asset('assets/big_bg.png') }}')">

            <!-- Link ke halaman login -->
            <div class="absolute top-4 right-4 text-sm text-gray-600 text-right">
                <p class="mb-2">Sudah memiliki akun?</p>
                <a href="login"
                    class="inline-flex items-center gap-2 border border-brown-700 text-brown-700 px-4 py-1 rounded-full font-semibold hover:bg-brown-100 transition text-sm mr-4 hover:bg-green-700 hover:text-white">
                    Masuk
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <!-- Judul -->
            <h2 class="text-2xl font-bold text-black mb-6">Daftar</h2>

            <!-- Form Register -->
            <form action="{{ route('register') }}" method="POST" class="space-y-4 text-sm">
                @csrf

                <div class="flex gap-8">
                    <div class="w-1/2">
                        <label class="block mb-1 text-gray-700 font-medium">Nama</label>
                        <input type="text" name="nama" placeholder="Masukkan nama lengkap" value="{{ old('nama') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-green-500">
                    </div>
                    <div class="w-1/2">
                        <label class="block mb-1 text-gray-700 font-medium">Username</label>
                        <input type="text" name="username" placeholder="Masukkan username" value="{{ old('username') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-green-500">
                    </div>
                </div>

                <div class="flex gap-8">
                    <div class="w-1/2">
                        <label class="block mb-1 text-gray-700 font-medium">Email</label>
                        <input type="email" name="email" placeholder="Masukkan email" value="{{ old('email') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-green-500">
                    </div>
                    <div class="w-1/2">
                        <label class="block mb-1 text-gray-700 font-medium">Nomor Telepon</label>
                        <input type="text" name="telepon" placeholder="Masukkan nomor telepon"
                            value="{{ old('telepon') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-green-500">
                    </div>
                </div>

                <div class="flex gap-8">
                    <div class="w-1/2">
                        <label class="block mb-1 text-gray-700 font-medium">Nomor SIINAS</label>
                        <input type="text" name="siinas" placeholder="Nomor SIINAS" value="{{ old('siinas') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-green-500">
                    </div>
                    <div class="w-1/2">
                        <label class="block mb-1 text-gray-700 font-medium">Nomor KBLI</label>
                        <input type="text" name="kbli" placeholder="Nomor KBLI" value="{{ old('kbli') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-green-500">
                    </div>
                </div>

                <div class="flex gap-8">
                    <div class="w-1/2">
                        <label class="block mb-1 text-gray-700 font-medium">Password</label>
                        <input type="text" name="password" placeholder="Masukkan password"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-green-500">
                    </div>
                    <div class="w-1/2">
                        <label class="block mb-1 text-gray-700 font-medium">Konfirmasi Password</label>
                        <input type="text" name="password_confirmation" placeholder="Konfirmasi password"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-green-500">
                    </div>
                </div>

                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Alamat</label>
                    <textarea name="alamat" rows="2" placeholder="Masukkan alamat"
                        class="w-full border border-gray-300 resize-none rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-green-500">{{ old('alamat') }}</textarea>
                </div>

                <div class="flex m-auto w-1/3">
                    <button type="submit"
                        class="w-full bg-green-700 text-white font-semibold py-2.5 rounded-lg hover:bg-green-800 transition text-sm">
                        Daftar
                    </button>
                </div>
            </form>
        </div>
    </section>
    <script>
        if (performance.getEntriesByType("navigation")[0].type === "back_forward") {
            const successAlert = document.querySelector('[data-success-alert]');
            if (successAlert) successAlert.remove();

            const errorAlert = document.querySelector('[data-error-alert]');
            if (errorAlert) errorAlert.remove();
        }
    </script>
@endsection
