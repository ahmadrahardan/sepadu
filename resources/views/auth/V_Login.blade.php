@extends('master.public')
@section('title', 'Login')
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

        <!-- Notifikasi Login Gagal -->
        @if (session('failed'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" data-login-alert
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
                    <p class="text-sm mt-1">{{ session('failed') }}</p>
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

        <div class="bg-white/70 backdrop-blur-md rounded-3xl p-10 w-full max-w-md relative shadow-xl bg-fit bg-center"
            style="background-image: url('{{ asset('assets/bg_form.png') }}')">
            <!-- Buat Akun Button -->
            <div class="absolute top-6 right-6 text-xs text-gray-600">
                <p class="mb-2">Belum mempunyai akun?</p>
                <a href="register"
                    class="inline-flex items-center gap-2 border border-green-700 text-brown-700 ml-3 px-4 py-1 rounded-full font-semibold transition hover:bg-green-700 hover:text-white">
                    Buat Akun
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
            <h2 class="text-3xl font-bold text-black mb-8">Masuk</h2>

            <form action="/login" method="POST" class="space-y-5">
                @csrf
                <!-- Username -->
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Username</label>
                    <input type="text" name="username" placeholder="Masukkan username"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-green-500">
                </div>

                <!-- Password -->
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Password</label>
                    <input type="password" name="password" placeholder="Masukkan password"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-green-500">
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-green-700 text-white font-semibold py-3 rounded-lg hover:bg-green-800 transition">
                    Masuk
                </button>
            </form>
        </div>
    </section>
    <script>
        if (performance.getEntriesByType("navigation")[0].type === "back_forward") {
            // Hapus alert login gagal
            const loginAlert = document.querySelector('[data-login-alert]');
            if (loginAlert) loginAlert.remove();

            // Hapus alert validasi/form error
            const errorAlert = document.querySelector('[data-error-alert]');
            if (errorAlert) errorAlert.remove();
        }
    </script>

@endsection
