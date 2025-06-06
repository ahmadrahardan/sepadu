@php
    $guard = session('guard');
    $user = Auth::guard($guard)->user();
    $isAdmin = $guard === 'admin';
    $isDashboard = request()->routeIs('V_Dashboard');
@endphp

<header x-data="{ scrolled: false, open: false }" @scroll.window="scrolled = (window.pageYOffset > 10)"
    :class="{ 'bg-gradient-to-b from-black/70 to-transparent': scrolled }"
    class="fixed top-0 left-0 w-full z-40 transition-all duration-300">


    <div class=" px-20 py-6 flex justify-between items-center">

        <!-- Logo -->
        <div class="flex items-center text-white text-xl font-semibold">
            <a href="{{ route('V_Dashboard') }}">
                <img src="{{ asset('assets/SepaduWhite.png') }}" alt="Sepadu Logo" class="h-8">
            </a>
        </div>

        <!-- Hamburger (Mobile Only) -->
        <div class="lg:hidden">
            <button @click="open = !open" class="text-white focus:outline-none">
                <svg x-show="!open" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
                <svg x-show="open" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        <!-- Desktop Menu -->
        <nav class="hidden lg:flex items-center gap-10 text-white text-md">
            @if ($isAdmin)
                <a href="{{ route('V_Verifikasi') }}"
                    class="text-white hover:bg-white/10 hover:rounded-lg px-1 hover:border-t hover:border-white">Verifikasi</a>
            @endif

            @if (!$isDashboard)
                @if ($isAdmin)
                    <a href="{{ route('admin.pengajuan') }}"
                        class="text-white hover:bg-white/10 hover:rounded-lg px-1 hover:border-t hover:border-white">Pengajuan</a>
                    <a href="{{ route('admin.jadwal') }}"
                        class="text-white hover:bg-white/10 hover:rounded-lg px-1 hover:border-t hover:border-white">Jadwal</a>
                @endif
                @if (!$isAdmin)
                    <a href="{{ route('V_Pengajuan') }}"
                        class="text-white hover:bg-white/10 hover:rounded-lg px-1 hover:border-t hover:border-white">Pengajuan</a>
                    <a href="{{ route('V_Jadwal') }}"
                        class="text-white hover:bg-white/10 hover:rounded-lg px-1 hover:border-t hover:border-white">Jadwal</a>
                @endif
            @endif

            <a href="{{ route('V_FAQ') }}"
                class="text-white hover:bg-white/10 hover:rounded-lg px-1 hover:border-t hover:border-white">FAQ</a>

            @unless ($isAdmin)
                <a href="{{ route('V_Riwayat') }}"
                    class="text-white hover:bg-white/10 hover:rounded-lg px-1 hover:border-t hover:border-white">Riwayat</a>
                <a href="{{ route('V_Pelatihan') }}"
                    class="text-white hover:bg-white/10 hover:rounded-lg px-1 hover:border-t hover:border-white">Pelatihan</a>
            @endunless

            <a href="{{ route('V_Profil') }}"
                class="flex items-center gap-3 text-black border border-green-700 bg-white rounded-full px-4 py-1.5 hover:bg-green-700 hover:text-white hover:border-white transition">
                Halo, {{ $user->nama }}
                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4S8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                </svg>
            </a>
        </nav>

        <!-- Drawer -->
        <div x-show="open" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="fixed top-0 right-0 h-full w-64 bg-green-700 text-white z-50 shadow-lg p-6 flex flex-col space-y-6 lg:hidden"
            @click.outside="open = false" x-cloak>
            <!-- Close Button -->
            <div class="flex justify-end">
                <button @click="open = false" class="text-white text-2xl font-bold">&times;</button>
            </div>

            <!-- Menu Items -->
            <nav class="flex flex-col space-y-4 text-md font-medium">
                @if ($isAdmin)
                    <a href="{{ route('V_Verifikasi') }}" @click="open = false" class="hover:underline">Verifikasi</a>
                @endif

                @if (!$isDashboard)
                    @if ($isAdmin)
                        <a href="{{ route('admin.pengajuan') }}" @click="open = false"
                            class="hover:underline">Pengajuan</a>
                        <a href="{{ route('admin.jadwal') }}" @click="open = false" class="hover:underline">Jadwal</a>
                    @endif
                    @if (!$isAdmin)
                        <a href="{{ route('V_Pengajuan') }}" @click="open = false"
                            class="hover:underline">Pengajuan</a>
                        <a href="{{ route('V_Jadwal') }}" @click="open = false" class="hover:underline">Jadwal</a>
                    @endif
                @endif

                <a href="{{ route('V_FAQ') }}" @click="open = false" class="hover:underline">FAQ</a>

                @unless ($isAdmin)
                    <a href="{{ route('V_Riwayat') }}" @click="open = false" class="hover:underline">Riwayat</a>
                    <a href="{{ route('V_Pelatihan') }}" @click="open = false" class="hover:underline">Pelatihan</a>
                @endunless

                <hr class="border-white/30">

                <a href="{{ route('V_Profil') }}" @click="open = false"
                    class="flex items-center bg-white text-green-700 px-4 py-2 rounded-full gap-3 border border-green-700 justify-center  hover:bg-green-500 hover:text-white hover:border-white transition">
                    Halo, {{ $user->nama }}
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4S8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                    </svg>
                </a>
            </nav>
        </div>

    </div>
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</header>
