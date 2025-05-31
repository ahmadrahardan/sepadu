@extends('master.public')
@section('title', 'Dashboard')
@section('content')

    <section class="font-sans min-h-screen bg-cover bg-center"
        style="background-image: url({{ asset('assets/background_1.png') }})">

        <!-- Header -->
        @include('master.navbar')

        <!-- Hero + Cards Container -->
        <div class="flex flex-col items-center justify-end min-h-screen pt-30 relative">
            <div class="h-[5%] w-full bg-gradient-to-t from-slate-950 to-transparent -bottom-0 absolute z-10"></div>

            <!-- Hero -->
            <div class="relative w-full flex justify-center items-center mb-12">
                <div
                    class="text-6xl md:text-8xl bg-gradient-to-b from-white via-white/90 to-transparent bg-clip-text text-transparent drop-shadow-lg z-10">
                    Selamat Datang
                </div>
                <div
                    class="absolute mt-20 text-4xl md:text-8xl bg-gradient-to-b from-white via-white/90 to-transparent bg-clip-text text-transparent drop-shadow-md z-20">
                    {{ Auth::user()->nama }}
                </div>
            </div>

            <!-- Cards -->
            <div class="flex flex-wrap gap-6 justify-center px-4 group/card-container overflow-hidden pt-5">
                @foreach (['Pengajuan', 'Jadwal', 'Edukasi'] as $item)
                    @php
                        $user = Auth::user();
                        $routeName = 'V_' . $item;

                        if ($user && $user->isAdmin()) {
                            if ($item === 'Pengajuan') {
                                $routeName = 'admin.pengajuan';
                            } elseif ($item === 'Jadwal') {
                                $routeName = 'admin.jadwal';
                            } elseif ($item === 'Edukasi') {
                                $routeName = 'admin.edukasi';
                            }
                        }
                    @endphp
                    <div
                        class="relative w-[316px] h-[371px] -bottom-[130px] hover:bottom-5 hover:bg-green-800 rounded-3xl text-white border border-white bg-white/10 shadow-lg backdrop-blur-sm transition-all duration-500 ease-in-out">
                        <div class="text-2xl p-5 bottom-1 mb-3 border-b">{{ $item }}</div>
                        <div class="relative mt-16 flex items-center justify-center">
                            <div class="absolute -top-8 w-[248px] h-[110px] bg-[#757575] rounded-3xl z-0"></div>
                            <div class="absolute -top-4 w-[288px] h-[110px] bg-[#9E9D9D] rounded-3xl z-0"></div>
                            <img src="{{ asset('assets/' . $item . '.png') }}" alt="{{ $item }}"
                                class="relative z-10 w-full h-full object-cover rounded-xl" />
                        </div>
                        <a href="{{ route($routeName) }}"
                            class="absolute bottom-4 right-4 w-16 h-16 bg-green-800 hover:bg-green-500 rounded-full flex items-center justify-center z-20 transition">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5h10M19 5v10M19 5L5 19"></path>
                            </svg>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Footer --}}
        @include('master.footer')
    </section>
@endsection
