@php
    $isAdmin = Auth::user()->isAdmin();
    $isDashboard = request()->routeIs('V_Dashboard');
@endphp

<header class="fixed top-0 left-0 w-full z-40">
    <div class="backdrop-blur-md bg-white/10 border-b border-white/30 px-20 py-6 flex justify-between items-center">

        <!-- Logo -->
        <div class="flex items-center text-white text-xl font-semibold">
            <a href="{{ route('V_Dashboard') }}">
                <img src="{{ asset('assets/logo.png') }}" alt="Simbako Logo" class="h-8">
            </a>
        </div>

        <!-- Navigation -->
        <div class="flex items-center gap-10">
            @if($isAdmin)
                <a href="{{ route('V_Verifikasi') }}" class="text-white hover:bg-white/10 hover:rounded-lg px-1 hover:border-t hover:border-white">Verifikasi</a>
            @endif

            {{-- Ngga tampil di dashboard --}}
            @if(!$isDashboard)
                @if($isAdmin)
                    <a href="{{ route('admin.pengajuan') }}" class="text-white hover:bg-white/10 hover:rounded-lg px-1 hover:border-t hover:border-white">Pengajuan</a>
                    <a href="{{ route('admin.jadwal') }}" class="text-white hover:bg-white/10 hover:rounded-lg px-1 hover:border-t hover:border-white">Jadwal</a>
                    <a href="{{ route('admin.edukasi') }}" class="text-white hover:bg-white/10 hover:rounded-lg px-1 hover:border-t hover:border-white">Edukasi</a>
                @endif
                @if(!$isAdmin)
                    <a href="{{ route('V_Pengajuan') }}" class="text-white hover:bg-white/10 hover:rounded-lg px-1 hover:border-t hover:border-white">Pengajuan</a>
                    <a href="{{ route('V_Jadwal') }}" class="text-white hover:bg-white/10 hover:rounded-lg px-1 hover:border-t hover:border-white">Jadwal</a>
                    <a href="{{ route('V_Edukasi') }}" class="text-white hover:bg-white/10 hover:rounded-lg px-1 hover:border-t hover:border-white">Edukasi</a>
                @endif
            @endif

            <a href="{{ route('V_FAQ') }}" class="text-white hover:bg-white/10 hover:rounded-lg px-1 hover:border-t hover:border-white">FAQ</a>

            {{-- Riwayat dan Pelatihan untuk user --}}
            @unless($isAdmin)
                <a href="{{ route('V_Riwayat') }}" class="text-white hover:bg-white/10 hover:rounded-lg px-1 hover:border-t hover:border-white">Riwayat</a>
                <a href="{{ route('V_Pelatihan') }}" class="text-white hover:bg-white/10 hover:rounded-lg px-1 hover:border-t hover:border-white">Pelatihan</a>
            @endunless

            {{-- Profil --}}
            <a href="{{ route('V_Profil') }}" class="flex items-center gap-3 text-black border border-green-700 bg-white rounded-full px-4 py-1.5 hover:bg-green-700 hover:text-white hover:border-white transition">
                Halo, {{ Auth::user()->nama }}!
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path
                        d="M20 22H18V20C18 18.3431 16.6569 17 15 17H9C7.34315 17 6 18.3431 6 20V22H4V20C4 17.2386 6.23858 15 9 15H15C17.7614 15 20 17.2386 20 20V22ZM12 13C8.68629 13 6 10.3137 6 7C6 3.68629 8.68629 1 12 1C15.3137 1 18 3.68629 18 7C18 10.3137 15.3137 13 12 13ZM12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z">
                    </path>
                </svg>
            </a>
        </div>
    </div>
</header>
