
@props(['href', 'active' => false])

@php
    $classes = 'relative text-white px-1 py-2 after:content-[\'\'] after:absolute after:left-0 after:bottom-0 after:h-[2px] after:bg-white after:transition-all after:duration-300';

    $classes .= ($active ?? false) ? ' after:w-full' : ' after:w-0 hover:after:w-full';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
