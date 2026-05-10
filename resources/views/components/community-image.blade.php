@props([
    'src' => null,
    'alt' => '',
])

@php
    $fallback = config('images.community_fallback');
    $url = filled($src)
        ? (\Illuminate\Support\Str::startsWith($src, ['http://', 'https://'])
            ? $src
            : asset('storage/'.$src))
        : $fallback;
@endphp

<img
    src="{{ $url }}"
    alt="{{ $alt }}"
    {{ $attributes->merge(['class' => 'h-full w-full object-cover']) }}
    onerror="this.onerror=null;this.src={{ json_encode($fallback) }}"
/>
