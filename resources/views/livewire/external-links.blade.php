@if ($links->count() > 0)
    <div class="py-8 bg-gray-100 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-1xl font-bold text-center mb-8 text-gray-800">Tautan Eksternal</h2>

            <div x-data="{
                // pixels per second
                speed: 60,
                pause: false,
                scroller: null,
                track: null,
                offset: 0,
                lastTime: 0,
                trackWidth: 0,

                init() {
                    this.$nextTick(() => {
                        this.scroller = this.$refs.scroller;
                        this.track = this.$refs.track;
                        this.buildTrack();
                        this.cacheWidth();
                        this.startLoop();
                        this.initTooltips();

                        // Pause when tab not visible
                        document.addEventListener('visibilitychange', () => {
                            this.pause = document.hidden;
                            // reset timer to avoid jumps
                            this.lastTime = 0;
                        });
                    });
                },

                initTooltips() {
                    if (typeof tippy !== 'undefined') {
                        tippy('[data-tippy-content]', {
                            theme: 'custom',
                            animation: 'scale',
                            arrow: true,
                            placement: 'top',
                            delay: [100, 0],
                            duration: [200, 150],
                            content: (reference) => reference.getAttribute('data-tippy-content'),
                        });
                    }
                },

                buildTrack() {
                    // Duplicate the original set once to create a seamless loop
                    const items = Array.from(this.track.children);
                    items.forEach((item) => {
                        const clone = item.cloneNode(true);
                        this.track.appendChild(clone);
                    });
                },

                cacheWidth() {
                    // Half of the total width equals one full set
                    this.trackWidth = this.track.scrollWidth / 2;
                },

                startLoop() {
                    const step = (ts) => {
                        if (!this.lastTime) this.lastTime = ts;
                        const dt = (ts - this.lastTime) / 1000; // seconds
                        this.lastTime = ts;

                        if (!this.pause) {
                            this.offset += this.speed * dt;
                            if (this.offset >= this.trackWidth) this.offset -= this.trackWidth;
                            this.track.style.transform = `translate3d(${-this.offset}px, 0, 0)`;
                        }
                        requestAnimationFrame(step);
                    };
                    requestAnimationFrame(step);
                }
            }" class="relative">
                <div class="absolute inset-y-0 left-0 w-16 bg-gradient-to-r from-gray-100 to-transparent z-10"></div>
                <div class="absolute inset-y-0 right-0 w-16 bg-gradient-to-l from-gray-100 to-transparent z-10"></div>

                <div class="overflow-x-hidden" x-ref="scroller" @mouseenter="pause = true" @mouseleave="pause = false">
                    <div class="flex space-x-6 py-4 will-change-transform" x-ref="track">
                        @foreach ($links as $link)
                            <a href="{{ $link->url }}" target="_blank" rel="noopener noreferrer"
                                class="group flex-shrink-0 w-48 h-48 bg-white rounded-lg shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 flex flex-col items-center justify-center p-4">

                                <div
                                    class="w-20 h-20 mb-3 rounded-full bg-gray-50 flex items-center justify-center overflow-hidden p-2">
                                    @if (Str::startsWith($link->logo, 'fa-'))
                                        <i class="{{ $link->logo }} text-4xl text-blue-600"></i>
                                    @elseif ($link->logo)
                                        <img src="{{ asset('storage/' . $link->logo) }}" alt="{{ $link->nama_link }}"
                                            class="h-full w-full object-contain"
                                            onerror="this.onerror=null; this.src='{{ asset('assets/img/placeholder2.jpg') }}';">
                                    @else
                                        <span class="text-sm font-bold text-blue-600 text-center">
                                            Logo Tidak Tersedia
                                        </span>
                                    @endif
                                </div>

                                <div class="w-full text-center mt-2 px-2">
                                    <div class="text-xs font-normal text-gray-600 group-hover:text-blue-600 transition-colors break-words"
                                        data-tippy-content="{{ $link->nama_link }}">
                                        {{ $link->nama_link }}
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <!-- Tippy.js for tooltips -->
        <script src="https://unpkg.com/@popperjs/core@2"></script>
        <script src="https://unpkg.com/tippy.js@6"></script>
    @endpush
@endif

@push('styles')
        <!-- FontAwesome for icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <!-- Custom tooltip theme -->
        <style>
            /* Custom tooltip theme */
            .tippy-box[data-theme~='custom'] {
                background-color: #6b7280;
                color: white;
                font-size: 0.75rem;
                padding: 4px 8px;
                border-radius: 4px;
            }

            .tippy-box[data-theme~='custom'] .tippy-arrow {
                color: #6b7280;
            }

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
                0% {
                    transform: scale(1);
                }

                50% {
                    transform: scale(1.05);
                }

                100% {
                    transform: scale(1);
                }
            }

            .group:hover .group-hover\:animate-pulse {
                animation: pulse 2s infinite;
            }
        </style>
    @endpush
