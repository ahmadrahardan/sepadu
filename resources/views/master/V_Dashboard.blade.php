@extends('master.public')
@section('title', 'Dashboard')
@section('content')

@section('content')

    <!-- Section Background -->
    <section x-data="pengajuanModal" class="font-sans h-[85vh] bg-cover bg-center relative"
        style="background-image: url({{ asset('assets/industry.png') }})">
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
    @php
        $isAdmin = Auth::user()->isAdmin();
    @endphp
    <div class="bg-green-100">
        <div
            class="-mt-44 w-full max-w-6xl mx-auto px-4 pb-8 relative z-30 flex flex-col md:flex-row justify-center items-center gap-10">
            <!-- Card 1 -->
            <a href="{{ $isAdmin ? route('admin.pengajuan') : route('V_Pengajuan') }}""
                class="relative rounded-xl overflow-hidden shadow-xl group cursor-pointer hover:scale-105 transition w-full md:w-1/2 bg-white">
                <img src="{{ asset('assets/Ajuan.png') }}" alt="Pengajuan Pelatihan" class="w-full h-64 object-cover">
                <div class="absolute inset-0  bg-gradient-to-t from-black/30 to-transparent"></div>
                <div class="absolute bottom-4 left-4 text-white text-xl font-semibold">Pengajuan Pelatihan</div>
            </a>

            <!-- Card 2 -->
            <a href="{{ $isAdmin ? route('admin.jadwal') : route('V_Jadwal') }}""
                class="relative rounded-xl overflow-hidden shadow-xl group cursor-pointer hover:scale-105 transition w-full md:w-1/2 bg-white">
                <img src="{{ asset('assets/Jadwalan.png') }}" alt="Jadwal Pelatihan" class="w-full h-64 object-cover">
                <div class="absolute inset-0  bg-gradient-to-t from-black/30 to-transparent"></div>
                <div class="absolute bottom-4 left-4 text-white text-xl font-semibold">Jadwal Pelatihan</div>
            </a>
        </div>
    </div>

    <!-- Footer -->
    @include('master.footer')

@endsection
