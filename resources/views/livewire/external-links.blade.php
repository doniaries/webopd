{{-- <div x-data="{ test: 'Alpine is working!' }" x-text="test"></div> --}}

@if ($links->count() > 0)
    <div x-data="{
        scrollContainer: null,
        scrollInterval: null,
        init() {
            this.$nextTick(() => {
                this.scrollContainer = this.$refs.scrollContainer;
                if (this.scrollContainer) {
                    this.startAutoScroll();
                }
            });
        },
        startAutoScroll() {
            if (!this.scrollContainer) return;
            
            // Clear any existing interval to prevent duplicates
            if (this.scrollInterval) {
                clearInterval(this.scrollInterval);
            }

            this.scrollInterval = setInterval(() => {
                try {
                    if (!this.scrollContainer) {
                        clearInterval(this.scrollInterval);
                        return;
                    }
                    
                    if (this.scrollContainer.scrollLeft + this.scrollContainer.offsetWidth >=
                        this.scrollContainer.scrollWidth - 50) {
                        this.scrollContainer.scrollTo({
                            left: 0,
                            behavior: 'smooth'
                        });
                    } else {
                        this.scrollContainer.scrollBy({
                            left: 1,
                            behavior: 'smooth'
                        });
                    }
                } catch (error) {
                    console.error('Auto-scroll error:', error);
                    clearInterval(this.scrollInterval);
                }
            }, 30);
        },
        stopAutoScroll() {
            if (this.scrollInterval) {
                clearInterval(this.scrollInterval);
                this.scrollInterval = null;
            }
        }
    }" x-init="init()" class="py-8 bg-gray-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative group">
                <div x-ref="scrollContainer" @mouseenter="stopAutoScroll()" @mouseleave="startAutoScroll()"
                    class="flex space-x-6 pb-6 overflow-x-auto scrollbar-hide snap-x snap-mandatory scroll-smooth">
                    @foreach ($links as $link)
                        <a href="{{ $link->url }}" target="_blank" rel="noopener noreferrer"
                            class="hover-lift group flex-shrink-0 w-40 h-40 bg-white rounded-lg shadow-sm hover:shadow-md transition-all duration-300 p-4 flex flex-col snap-center">
                            <div class="icon-wrapper mb-3">
                                @if ($link->logo)
                                    <img src="{{ asset('storage/' . $link->logo) }}" alt="{{ $link->nama_link }}"
                                        class="h-full w-full object-cover rounded-full">
                                @else
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
                </div>
            </div>
        </div>
    </div>

    @push('styles')
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

            .scrollbar-hide {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }

            .scrollbar-hide::-webkit-scrollbar {
                display: none;
            }
        </style>
    @endpush
@endif
