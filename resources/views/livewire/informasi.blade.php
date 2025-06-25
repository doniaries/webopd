<div class="mb-6">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-4 py-3">
            <h3 class="text-white text-sm font-semibold flex items-center">
                <i class="fas fa-info-circle mr-2"></i>
                INFORMASI TERBARU
            </h3>
        </div>
        <div class="p-4">
            @if ($informasi->count() > 0)
                <div class="space-y-4">
                    @foreach ($informasi as $item)
                        <div class="border-b border-gray-100 pb-3 last:border-0 last:pb-0">
                            <a href="{{ route('informasi.detail', $item->slug) }}" 
                               class="block group">
                                <h4 class="text-sm font-medium text-gray-800 group-hover:text-blue-600 transition-colors line-clamp-2">
                                    {{ $item->judul }}
                                </h4>
                                <div class="flex items-center justify-between mt-1">
                                    <span class="text-xs text-gray-500">
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        {{ $item->created_at->translatedFormat('d M Y') }}
                                    </span>
                                    @if($item->dokumen->count() > 0)
                                        <span class="text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded">
                                            <i class="far fa-file-alt mr-1"></i>
                                            {{ $item->dokumen->count() }}
                                        </span>
                                    @endif
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-4 text-center">
                    <a href="{{ route('informasi') }}" 
                       class="inline-flex items-center text-xs font-medium text-blue-600 hover:text-blue-800">
                        Lihat Semua Informasi
                        <i class="fas fa-chevron-right ml-1 text-xs"></i>
                    </a>
                </div>
                                                    <div class="text-sm text-gray-900 line-clamp-2">
                                                        {!! Str::limit(strip_tags($item->isi), 100) !!}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @php
                                                        $files = is_array($item->file) ? $item->file : [$item->file];
                                                        $hasFiles = !empty(array_filter($files));
                                                    @endphp
                                                    @if ($hasFiles)
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                            {{ count($files) }} Dokumen
                                                        </span>
                                                    @else
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                            Tidak ada dokumen
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border-r border-gray-200">
                                                    {{ indonesia_date($item->published_at) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <div class="flex space-x-2">
                                                        <a href="{{ route('informasi.detail', $item->slug) }}" 
                                                           class="group relative inline-flex items-center px-3 py-1.5 text-sm font-medium text-blue-600 border border-blue-200 rounded-md hover:bg-blue-50 hover:text-blue-700 transition-all duration-200">
                                                            <i class="fas fa-eye mr-1"></i> Detail
                                                            <span class="absolute -bottom-7 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">
                                                                Lihat detail informasi
                                                            </span>
                                                        </a>
                                                        @if ($hasFiles)
                                                            <button type="button"
                                                               class="group relative inline-flex items-center px-3 py-1.5 text-sm font-medium text-green-600 border border-green-200 rounded-md hover:bg-green-50 hover:text-green-700 transition-all duration-200"
                                                               data-bs-toggle="modal" 
                                                               data-bs-target="#dokumenModal{{ $item->id }}">
                                                                <i class="fas fa-download mr-1"></i> Unduh
                                                                <span class="absolute -bottom-7 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">
                                                                    Unduh dokumen
                                                                </span>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Modal Dokumen -->
                                            @if ($hasFiles)
                                                <div class="modal fade" id="dokumenModal{{ $item->id }}" tabindex="-1" aria-labelledby="dokumenModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="dokumenModalLabel">Dokumen Lampiran</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="space-y-4">
                                                                    @foreach ($files as $file)
                                                                        @if ($file)
                                                                            @php
                                                                                $filePath = str_starts_with($file, 'public/') ? $file : 'public/' . $file;
                                                                                $fileName = basename($filePath);
                                                                                $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
                                                                                $fileIcon = 'fa-file';
                                                                                
                                                                                if (in_array($fileExt, ['pdf'])) {
                                                                                    $fileIcon = 'fa-file-pdf text-red-500';
                                                                                } elseif (in_array($fileExt, ['doc', 'docx'])) {
                                                                                    $fileIcon = 'fa-file-word text-blue-500';
                                                                                } elseif (in_array($fileExt, ['xls', 'xlsx'])) {
                                                                                    $fileIcon = 'fa-file-excel text-green-500';
                                                                                } elseif (in_array($fileExt, ['jpg', 'jpeg', 'png', 'gif'])) {
                                                                                    $fileIcon = 'fa-file-image text-yellow-500';
                                                                                }
                                                                            @endphp
                                                                            <div class="flex items-center justify-between p-3 border rounded-lg">
                                                                                <div class="flex items-center">
                                                                                    <i class="fas {{ $fileIcon }} text-lg mr-3"></i>
                                                                                    <div>
                                                                                        <p class="text-sm font-medium text-gray-900">{{ $fileName }}</p>
                                                                                        <p class="text-xs text-gray-500">{{ Str::upper($fileExt) }} • 
                                                                                        @php
                                                                                            $fileSize = Storage::exists($filePath) ? Storage::size($filePath) : 0;
                                                                                            if ($fileSize >= 1048576) {
                                                                                                echo round($fileSize / 1048576, 1) . ' MB';
                                                                                            } else {
                                                                                                echo round($fileSize / 1024, 1) . ' KB';
                                                                                            }
                                                                                        @endphp
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                                <a href="{{ route('file.download', $file) }}" 
                                                                                   class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                                                                   target="_blank">
                                                                                    <i class="fas fa-download mr-1"></i> Unduh
                                                                                </a>
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="mt-4">
                                {{ $informasi->links() }}
                            </div>
                        @else
                            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-md">
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-blue-400 mr-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-blue-700">Tidak ada informasi yang tersedia saat ini.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .card-article {
                transition: all 0.3s ease;
                border: 1px solid rgba(0, 0, 0, 0.1);
            }

            .card-article:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            }

            .article-title {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
                min-height: 3em;
            }

            .article-excerpt {
                display: -webkit-box;
                -webkit-line-clamp: 3;
                -webkit-box-orient: vertical;
                overflow: hidden;
                min-height: 4.5em;
            }
        </style>
    @endpush
</div>

@push('scripts')
    <script>
        // Inisialisasi tabel shadow setelah Livewire selesai memuat
        document.addEventListener('livewire:load', function() {
            document.querySelectorAll('table').forEach(function(tbl) {
                tbl.classList.add('shadow-table');
            });
        });
    </script>
@endpush
</div>
