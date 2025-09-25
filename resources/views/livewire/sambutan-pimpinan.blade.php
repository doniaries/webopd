@php
    use Illuminate\Support\Facades\Storage;
@endphp

<div class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-page-header title="Sambutan Pimpinan" />

        @if ($sambutan)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-xl text-center font-semibold text-gray-800">
                        {{ $sambutan->jabatan ?? 'Sambutan Pimpinan' }}
                    </h2>
                </div>

                <div class="p-6">
                    <div class="flex flex-col lg:flex-row gap-8">
                        <!-- Konten Sambutan -->
                        <div class="lg:w-2/3">
                            <div class="prose max-w-none text-gray-700">
                                {!! strip_tags($sambutan->isi_sambutan) !!}
                            </div>
                        </div>

                        <!-- Foto Pimpinan -->
                        <div class="lg:w-1/3">
                            <div class="sticky top-24">
                                @php
                                    $pengaturan = \App\Models\Pengaturan::first();
                                    $fotoPimpinan = $pengaturan->foto_pimpinan ?? null;
                                    $namaPimpinan = $pengaturan->kepala_instansi ?? 'Pimpinan';
                                    $jabatanPimpinan = 'Kepala ' . ($pengaturan->name ?? 'Dinas Komunikasi dan Informatika');
                                    
                                    // Cek apakah file benar-benar ada di storage
                                    $fotoAda = $fotoPimpinan && Storage::disk('public')->exists($fotoPimpinan);
                                @endphp
                                
                                @if($fotoAda)
                                    <div class="relative w-64 h-[550px] mx-auto overflow-hidden shadow-md rounded-lg">
                                        <div class="w-full h-full">
                                            <img src="{{ Storage::url($fotoPimpinan) }}"
                                                alt="{{ $namaPimpinan }}"
                                                class="w-full h-full object-cover object-top">
                                            <div class="absolute inset-x-0 bottom-0 p-4 bg-gradient-to-t from-black/90 via-black/70 to-transparent">
                                                <div class="text-center space-y-1">
                                                    <p class="text-white text-sm font-semibold leading-tight">
                                                        {{ $namaPimpinan }}
                                                    </p>
                                                    <p class="text-gray-200 text-xs font-medium leading-tight">
                                                        {{ $jabatanPimpinan }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="relative w-64 h-[550px] mx-auto overflow-hidden shadow-md rounded-lg bg-gray-100 flex items-center justify-center">
                                        <div class="text-center p-6">
                                            <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-gray-200 mb-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <p class="text-gray-500 text-sm">Tidak ada gambar</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            Data sambutan pimpinan belum tersedia. Silakan hubungi administrator untuk mengisi data ini.
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
