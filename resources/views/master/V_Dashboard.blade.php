@extends('master.public')
@section('title', 'Dashboard')
@section('content')

@section('content')

    <!-- Section Background -->
    <section x-data="{
        current: 0,
        backgrounds: [
            '{{ asset('assets/disperindag5.png') }}',
            '{{ asset('assets/disperindag2.png') }}',
            '{{ asset('assets/disperindag3.png') }}',
            '{{ asset('assets/disperindag4.png') }}'
        ]
    }" x-init="setInterval(() => { current = (current + 1) % backgrounds.length }, 5000)" :style="'background-image: url(' + backgrounds[current] + ')'"
        class="font-sans h-[85vh] bg-cover bg-center relative transition-all duration-700 ease-in-out">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 to-transparent z-10"></div>

        <!-- Header -->
        @include('master.navbar')

        <!-- Hero Section (optional) -->
        <div class="h-full flex flex-col items-center justify-center text-center text-white relative z-20">
            <div class="text-5xl md:text-7xl font-semibold">Selamat Datang</div>
            <div class="text-5xl md:text-7xl font-semibold"> {{ Auth::user()->nama }}</div>
        </div>
    </section>

    <!-- Cards -->
    <div
        class="-mt-44 w-full max-w-6xl mx-auto px-4 pb-24 relative z-30 flex flex-col md:flex-row justify-center items-center gap-10">
        <!-- Card 1 -->
        <div
            class="relative rounded-xl overflow-hidden shadow-xl group cursor-pointer hover:scale-105 transition w-full md:w-1/2 bg-white">
            <img src="{{ asset('assets/Pengajuan.jpg') }}" alt="Pengajuan Pelatihan" class="w-full h-64 object-cover">
            <div class="absolute inset-0  bg-gradient-to-t from-black/50 to-transparent"></div>
            <div class="absolute bottom-4 left-4 text-white text-xl font-semibold">Pengajuan Pelatihan</div>
        </div>

        <!-- Card 2 -->
        <div
            class="relative rounded-xl overflow-hidden shadow-xl group cursor-pointer hover:scale-105 transition w-full md:w-1/2 bg-white">
            <img src="{{ asset('assets/Jadwal.jpg') }}" alt="Jadwal Pelatihan" class="w-full h-64 object-cover">
            <div class="absolute inset-0  bg-gradient-to-t from-black/50 to-transparent"></div>
            <div class="absolute bottom-4 left-4 text-white text-xl font-semibold">Jadwal Pelatihan</div>
        </div>
    </div>

    <!-- Footer -->
    @include('master.footer')

@endsection
