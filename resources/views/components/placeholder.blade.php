@props([
    'text' => 'Gambar tidak tersedia',
    'class' => '',
    'bgColor' => 'bg-gray-200',
    'type' => 'placeholder'
])

@php
    // Combine all classes and clean up extra spaces
    $classes = 'flex items-center justify-center w-full h-48 ' . $bgColor . ' ' . $class;
    $classes = trim(preg_replace('/\s+/', ' ', $classes));
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    <div class="text-center">
        <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
        <span class="text-sm font-medium text-gray-500">{{ $text }}</span>
    </div>
</div>
