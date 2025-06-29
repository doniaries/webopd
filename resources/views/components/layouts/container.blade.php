@props([
    'fullWidth' => false,
    'padding' => 'py-8',
])

<div class="{{ $fullWidth ? 'w-full' : 'container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl' }} {{ $padding }}">
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6">
            {{ $slot }}
        </div>
    </div>
</div>
