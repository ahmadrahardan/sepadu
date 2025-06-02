@extends('layouts.auth')
@section('title', 'Homepage')
@section('content')

<section class="font-sans h-screen bg-cover bg-center" style="background-image: url({{ asset('assets/industry.png') }})">
    <div class="absolute inset-0 bg-gradient-to-t from-slate-900 to-transparent z-10"></div>

    <!-- Hero Section -->
    <div class="relative h-screen flex items-center justify-center text-center px-4 z-10">
        <div class="flex flex-col items-center gap-4">
            <div class="flex flex-col items-center  justify-center text-white font-bold">
                <div class="text-7xl">
                    Selamat Datang
                </div>
                <div class="text-4xl">
                    di
                </div>
                <div>
                    <img src="{{ asset('assets/SepaduWhite.png') }}" alt="Sepadu Logo" class="h-28">
                </div>
            </div>
            <div class="flex items-center gap-4 mt-5">
                <a href="login"
                    class="flex items-center gap-1 text-white border border-white rounded-full px-4 py-1.5 hover:bg-white hover:text-black transition">
                    Masuk
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
                <a href="register"
                    class="bg-white text-black font-semibold px-4 py-1.5 rounded-full hover:bg-gray-200 transition">
                    Daftar Sekarang!
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
