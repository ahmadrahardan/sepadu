@props(['message'])

<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
    class="fixed bottom-5 right-5 z-50 w-full max-w-sm bg-green-600 text-white rounded-xl p-4 shadow-lg flex items-start gap-3 animate-slide-up transition-all duration-500 ease-in-out">

    <div class="flex-shrink-0 w-14 h-14 flex items-center justify-center overflow-hidden">
        <img src="{{ asset('assets/rawlogo.png') }}" alt="Logo" class="h-6 w-6 object-cover">
    </div>

    <div class="flex-grow">
        <div class="flex justify-between items-center">
            <h3 class="text-lg font-bold">Berhasil!</h3>
            <button @click="show = false" class="text-white hover:text-gray-200 text-xl leading-none">&times;</button>
        </div>
        <p class="text-sm mt-1">{{ $message }}</p>
    </div>
</div>
