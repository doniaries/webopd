@props([
    'title' => null,
    'subtitle' => null,
])

<header class="bg-white py-8 shadow-sm">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        @if($title)
            <h1 class="text-3xl font-bold text-gray-900">{{ $title }}</h1>
            @if($subtitle)
                <p class="mt-2 text-lg text-gray-600">{{ $subtitle }}</p>
            @endif
        @else
            {{ $slot }}
        @endif
    </div>
</header>
