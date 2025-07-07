@if($links->count() > 0)
<div class="py-8 bg-gray-100 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-center mb-8 text-gray-800">Tautan Eksternal</h2>
        
        <div x-data="{
            speed: 1,
            pause: false,
            scroller: null,
            
            init() {
                this.$nextTick(() => {
                    this.scroller = this.$refs.scroller;
                    this.duplicateItems();
                    this.startScroll();
                });
            },
            
            duplicateItems() {
                // Duplicate items for seamless infinite scroll
                const container = this.$refs.scroller;
                const items = Array.from(container.children);
                items.forEach(item => {
                    const clone = item.cloneNode(true);
                    container.appendChild(clone);
                });
            },
            
            startScroll() {
                const scroll = () => {
                    if (!this.pause) {
                        if (this.scroller.scrollLeft >= this.scroller.scrollWidth / 2) {
                            this.scroller.scrollLeft = 0;
                        } else {
                            this.scroller.scrollLeft += this.speed;
                        }
                    }
                    requestAnimationFrame(scroll);
                };
                scroll();
            }
        }"
        class="relative">
            <div class="absolute inset-y-0 left-0 w-16 bg-gradient-to-r from-gray-100 to-transparent z-10"></div>
            <div class="absolute inset-y-0 right-0 w-16 bg-gradient-to-l from-gray-100 to-transparent z-10"></div>
            
            <div class="flex space-x-6 py-4 overflow-x-hidden"
                x-ref="scroller"
                @mouseenter="pause = true"
                @mouseleave="pause = false">
                
                @foreach($links as $link)
                <a href="{{ $link->url }}" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="group flex-shrink-0 w-48 h-48 bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 flex flex-col items-center justify-center p-6">
                    
                    <div class="w-20 h-20 mb-4 rounded-full bg-gray-50 flex items-center justify-center overflow-hidden">
                        @if($link->logo)
                            <img src="{{ asset('storage/' . $link->logo) }}" 
                                 alt="{{ $link->nama_link }}"
                                 class="h-16 w-16 object-contain">
                        @else
                            <span class="text-2xl font-bold text-blue-600">
                                {{ strtoupper(substr($link->nama_link, 0, 2)) }}
                            </span>
                        @endif
                    </div>
                    
                    <h3 class="text-center font-medium text-gray-800 group-hover:text-blue-600 transition-colors">
                        {{ $link->nama_link }}
                    </h3>
                    
                    <div class="mt-3 text-xs text-gray-500 group-hover:text-blue-500 transition-colors">
                        Kunjungi Situs <i class="fas fa-external-link-alt ml-1"></i>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif

@push('styles')
<style>
    /* Hide scrollbar but keep functionality */
    .overflow-x-hidden {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .overflow-x-hidden::-webkit-scrollbar {
        display: none;
    }
    
    /* Smooth scrolling */
    .overflow-x-hidden {
        scroll-behavior: smooth;
    }
    
    /* Animation for hover effect */
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    .group:hover .group-hover\:animate-pulse {
        animation: pulse 2s infinite;
    }
</style>
@endpush
