@extends('master.public')
@section('title', 'Edukasi')
@section('content')

    <section x-data="{
        scrollContainer: null,
        scrollRight() { this.scrollContainer.scrollBy({ left: 1280, behavior: 'smooth' }); },
        scrollLeft() { this.scrollContainer.scrollBy({ left: -1280, behavior: 'smooth' }); }
    }" class="font-sans min-h-screen bg-cover bg-center relative"
        style="background-image: url({{ asset('assets/background_1.png') }})">

        <!-- Header -->
        @include('master.navbar')

        <!-- Main Content -->
        <div class="flex flex-col items-center justify-center min-h-screen pt-24 px-8 relative z-10">
            <div class="h-[5%] w-full bg-gradient-to-t from-slate-950 to-transparent absolute bottom-0 z-10"></div>
            <img src="{{ asset('assets/Ornament.png') }}" alt="" class="h-[1012px] w-[1440px] absolute bottom-0">

            <!-- Container Slider Wrapper -->
            <div class="relative w-full max-w-[1300px] flex items-center justify-center px-5">
                <!-- Left Scroll Button -->
                <span class="scroll-btn scroll-left-btn left absolute left-0 z-20" @click="scrollLeft">
                    <i class="fa fa-angle-left" aria-hidden="true"></i>
                </span>

                <!-- Card Slider -->
                <div x-ref="scrollContainer" x-init="scrollContainer = $refs.scrollContainer"
                    class="flex gap-5 overflow-x-auto scroll-smooth no-scrollbar w-full py-3 inner_card">
                    @foreach ($data as $item)
                        <a href="{{ route('edukasi.konten', $item->slug) }}"
                            class="bg-white/10 border border-white/30 backdrop-blur-md rounded-xl p-3 shadow-xl hover:scale-95 transition-transform duration-300 w-[300px] h-[250px] flex-shrink-0">
                            <div class="overflow-hidden rounded-xl">
                                <img src="{{ asset($item->thumbnail) }}" alt="{{ $item->topik }}"
                                    class="w-full h-[150px] object-cover">
                            </div>
                            <div class="overflow-hidden">
                                <p class="text-white text-md text-center mt-2 leading-tight break-words px-3">
                                    {{ $item->topik }}
                                </p>
                            </div>
                        </a>
                        @endforeach
                </div>

                <!-- Right Scroll Button -->
                <span class="scroll-btn scroll-right-btn right absolute right-0 z-20"
                    @click="scrollRight">
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                </span>
            </div>
        </div>


        <!-- Footer -->
        @include('master.footer')

        <style>
            .scroll-btn {
                position: absolute;
                font-size: 25px;
                display: flex;
                justify-content: center;
                align-items: center;
                border-radius: 3px;
                height: 100%;
                width: 30px;
                cursor: pointer;
                color: white;
                box-shadow: rgba(12, 12, 12, 0.5) 0 0 35px 8px inset;
                z-index: 50;
            }

            .scroll-left-btn {
                opacity: 0;
                left: 30px;
                transform: translateX(-100%);
            }

            .scroll-right-btn {
                opacity: 1;
                right: 30px;
                transform: translateX(100%);
            }

            .scroll-btn:hover {
                background: rgba(255, 255, 255, 0.3);
            }
        </style>

    </section>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let scrollableContent = document.querySelector('.inner_card');
            let leftBtn = document.querySelector('.left');
            let rightBtn = document.querySelector('.right');

            function updateScrollButtons() {
                if (scrollableContent.scrollLeft <= 0) {
                    leftBtn.style.opacity = 0;
                } else {
                    leftBtn.style.opacity = 1;
                }

                let maxScroll = scrollableContent.scrollWidth - scrollableContent.clientWidth;
                if (scrollableContent.scrollLeft >= maxScroll - 10) {
                    rightBtn.style.opacity = 0;
                } else {
                    rightBtn.style.opacity = 1;
                }
            }

            scrollableContent.addEventListener("scroll", updateScrollButtons);
            updateScrollButtons();
        });
    </script>
@endsection
