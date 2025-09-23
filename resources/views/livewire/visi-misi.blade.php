<div>
    <x-page-header title="Visi & Misi" />
    
    <div class="py-8 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($visiMisi)
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Visi</h2>
                    <p class="text-gray-700 mb-6">{{ $visiMisi->visi }}</p>
                    
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Misi</h2>
                    <div class="text-gray-700 space-y-2">
                        {!! nl2br(e($visiMisi->misi)) !!}
                    </div>
                </div>
            @else
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                Data visi dan misi belum tersedia. Silakan hubungi administrator untuk mengisi data ini.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
