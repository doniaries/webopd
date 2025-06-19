<x-filament-widgets::widget class="filament-infografis-overview-widget">
    <x-filament::card>
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                    {{ $record->judul }}
                </h2>
                <div class="flex items-center space-x-2">
                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ $record->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                        {{ $record->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                    <span class="px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-200">
                        {{ ucfirst($record->kategori) }}
                    </span>
                </div>
            </div>

            <!-- Published Date -->
            <div class="text-sm text-gray-500 dark:text-gray-400">
                Diterbitkan pada: {{ \Carbon\Carbon::parse($record->published_at)->translatedFormat('d F Y H:i') }}
            </div>

            <!-- Image -->
            <div class="overflow-hidden bg-gray-100 rounded-lg dark:bg-gray-800">
                <img 
                    src="{{ asset('storage/' . $record->gambar) }}" 
                    alt="{{ $record->judul }}"
                    class="object-cover w-full h-auto max-h-[70vh] mx-auto"
                    loading="lazy"
                >
            </div>

            <!-- Description -->
            @if($record->keterangan)
                <div class="prose dark:prose-invert max-w-none">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Keterangan</h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        {{ $record->keterangan }}
                    </p>
                </div>
            @endif

            <!-- Meta Information -->
            <div class="pt-4 mt-6 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                    <div>
                        <span>Dibuat: {{ $record->created_at->diffForHumans() }}</span>
                        @if($record->created_at != $record->updated_at)
                            <span class="mx-2">•</span>
                            <span>Diperbarui: {{ $record->updated_at->diffForHumans() }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </x-filament::card>
</x-filament-widgets::widget>
