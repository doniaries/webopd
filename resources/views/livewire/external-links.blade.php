@if ($links->count() > 0)
    {{-- Container utama untuk komponen slider --}}
    <div x-data="externalLinksScroll" class="py-8 bg-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative group">
                {{-- Kontainer yang akan di-scroll. Interaksi mouse akan menjeda/melanjutkan scroll --}}
                <div x-ref="scrollContainer" @mouseenter="isScrolling = false" @mouseleave="isScrolling = true"
                    class="flex space-x-6 pb-6 overflow-x-auto scrollbar-hide">

                    {{-- Loop untuk menampilkan link asli dari Livewire/Laravel --}}
                    @foreach ($links as $link)
                        <a href="{{ $link->url }}" target="_blank" rel="noopener noreferrer"
                            wire:key="link-{{ $link->id }}"
                            class="hover-lift group flex-shrink-0 w-40 h-40 bg-white rounded-lg shadow-sm hover:shadow-md transition-all duration-300 p-4 flex flex-col items-center justify-center snap-center">

                            <div class="icon-wrapper mb-3">
                                @if ($link->logo)
                                    <img src="{{ asset('storage/' . $link->logo) }}" alt="{{ $link->nama_link }}"
                                        class="h-full w-full object-contain rounded-full">
                                @else
                                    {{-- Fallback jika tidak ada logo --}}
                                    <div class="h-full w-full flex items-center justify-center bg-blue-50 rounded-full">
                                        <span class="text-xl font-bold text-blue-700">
                                            {{ strtoupper(substr($link->nama_link, 0, 2)) }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <h3 class="card-title">
                                {{ $link->nama_link }}
                            </h3>
                        </a>
                    @endforeach

                    {{-- Elemen kloning akan ditambahkan di sini oleh Alpine.js --}}
                </div>
            </div>
        </div>
    </div>

    {{-- Script untuk Alpine.js dan hook Livewire --}}
    <script>
        // Hook untuk Livewire: Saat Livewire selesai memperbarui DOM, kirim event global.
        document.addEventListener('livewire:init', () => {
            Livewire.hook('morph.updated', ({
                el,
                component
            }) => {
                window.dispatchEvent(new CustomEvent('content-updated'));
            });
        });

        document.addEventListener('alpine:init', () => {
            Alpine.data('externalLinksScroll', () => ({
                isScrolling: true,
                scrollContainer: null,

                init() {
                    // Inisialisasi saat komponen dimuat pertama kali
                    // $nextTick memastikan DOM siap sebelum skrip berjalan
                    this.$nextTick(() => this.setupSlider());

                    // Dengarkan event dari Livewire untuk re-inisialisasi jika konten berubah
                    window.addEventListener('content-updated', () => {
                        this.$nextTick(() => this.setupSlider());
                    });
                },

                setupSlider() {
                    this.scrollContainer = this.$refs.scrollContainer;
                    if (!this.scrollContainer) return;

                    // Hapus kloning lama jika ada (untuk re-inisialisasi)
                    this.scrollContainer.querySelectorAll('[data-clone]').forEach(clone => clone
                    .remove());

                    // Cek apakah konten cukup lebar untuk di-scroll
                    const isOverflowing = this.scrollContainer.scrollWidth > this.scrollContainer
                        .clientWidth;
                    if (!isOverflowing) {
                        this.isScrolling = false;
                        return; // Tidak perlu scroll jika konten pas
                    }

                    // Duplikasi item untuk loop yang mulus
                    const originalItems = Array.from(this.scrollContainer.children);
                    originalItems.forEach(item => {
                        const clone = item.cloneNode(true);
                        clone.setAttribute('data-clone', 'true'); // Tandai sebagai klon
                        clone.setAttribute('aria-hidden', 'true');
                        this.scrollContainer.appendChild(clone);
                    });

                    this.startAnimation();
                },

                startAnimation() {
                    let speed = 0.8; // Atur kecepatan scroll di sini

                    const animate = () => {
                        if (this.isScrolling && this.scrollContainer) {
                            // Gerakkan kontainer ke kiri
                            this.scrollContainer.scrollLeft += speed;

                            // Jika scroll sudah mencapai akhir dari konten asli, reset ke awal
                            // `scrollWidth / 2` adalah titik di mana set kloning dimulai
                            if (this.scrollContainer.scrollLeft >= this.scrollContainer
                                .scrollWidth / 2) {
                                this.scrollContainer.scrollLeft = 0;
                            }
                        }
                        // Terus panggil frame animasi berikutnya
                        requestAnimationFrame(animate);
                    };

                    // Mulai animasi
                    animate();
                }
            }));
        });
    </script>
@endif

@push('styles')
    {{-- CSS tidak perlu diubah, sudah bagus --}}
    <style>
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 10px;
            overflow: hidden;
            background: white;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2) !important;
        }

        .icon-wrapper {
            width: 70px;
            height: 70px;
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(13, 110, 253, 0.1);
            border-radius: 50%;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .hover-lift:hover .icon-wrapper {
            background: rgba(13, 110, 253, 0.2);
            transform: scale(1.05);
        }

        .card-title {
            font-size: 0.875rem;
            font-weight: 600;
            margin-top: auto;
            color: #1a202c;
            line-height: 1.4;
            text-align: center;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Class untuk menyembunyikan scrollbar */
        .scrollbar-hide {
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
            /* Chrome, Safari, and Opera */
        }
    </style>
@endpush
