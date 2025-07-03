<div class="container mx-auto px-4 py-8">
    <x-page-header title="Pengumuman" />
    
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        @if($pengumuman->count() > 0)
            <ul class="divide-y divide-gray-200">
                @foreach($pengumuman as $item)
                    <li class="p-4 hover:bg-gray-50 transition duration-150">
                        <a href="{{ route('pengumuman.show', $item->slug) }}" class="block">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">{{ $item->judul }}</h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        {{ $item->created_at->translatedFormat('d F Y') }}
                                    </p>
                                </div>
                                <div class="ml-4">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
            
            <div class="px-4 py-3 bg-gray-50 border-t border-gray-200 sm:px-6">
                {{ $pengumuman->links() }}
            </div>
        @else
            <div class="p-8 text-center text-gray-500">
                <p>Tidak ada pengumuman saat ini.</p>
            </div>
        @endif
    </div>
</div>
