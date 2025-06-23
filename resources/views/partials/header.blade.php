<header id="header" class="header sticky-top">
    <style>
        /* Transisi untuk efek smooth */
        .header-container,
        .menu-container {
            transition: all 0.3s ease-in-out;
        }

        /* State default (ketika di-scroll) */
        .header-container {
            padding: 0;
        }

        .menu-container {
            padding: 5px 0;
        }

        /* State ketika di atas (belum di-scroll) */
        .at-top .header-container {
            padding: 10px 0;
        }

        .at-top .menu-container {
            padding: 15px 0;
        }

        /* Style untuk menu item saat di atas */
        .at-top #navmenu>ul>li>a {
            padding: 10px 15px;
            font-size: 1rem;
        }

        .at-top #navmenu>ul>li>a svg {
            width: 1.25rem;
            height: 1.25rem;
            margin-right: 6px;
        }

        /* Style default untuk menu item (saat di-scroll) */
        #navmenu>ul>li>a {
            padding: 8px 12px;
            font-size: 0.95rem;
            transition: all 0.3s ease-in-out;
        }

        #navmenu>ul>li>a svg {
            width: 1.1rem;
            height: 1.1rem;
            margin-right: 5px;
            transition: all 0.3s ease-in-out;
        }

        /* Menyesuaikan tinggi menu container */
        .menu-container {
            display: flex;
            align-items: center;
            height: auto;
            padding: 0;
        }
        
        .menu-wrapper {
            width: 100%;
        }
        
        #navmenu ul {
            margin: 0;
            padding: 0;
        }

        /* Reset border radius untuk header dan semua elemen di dalamnya */
        header#header,
        header#header *,
        header#header *:before,
        header#header *:after {
            border-radius: 0 !important;
            -webkit-border-radius: 0 !important;
            -moz-border-radius: 0 !important;
        }

        /* Container utama untuk header dan menu */
        .sticky-top {
            position: sticky;
            top: 0;
            z-index: 1020;
            background-color: transparent;
            width: 100%;
            padding: 0;
        }

        /* Container untuk konten header dan menu */
        .header-wrapper,
        .menu-wrapper {
            max-width: 1320px;
            margin: 0 auto;
            padding: 0 20px;
            width: 100%;
        }

        /* Header utama */
        .header-container {
            width: 100%;
            background-color: white;
            border-bottom: 1px solid #e0e0e0;
            padding: 2px 0;
        }

        .header-content {
            display: flex;
            width: 100%;
            justify-content: space-between;
            align-items: center;
            padding: 0;
        }

        /* Logo */
        .logo {
            display: flex;
            align-items: center;
            text-decoration: none;
            padding: 2px 0;
        }

        /* Menu container */
        .menu-container {
            background-color: white;
            border-bottom: 1px solid #e0e0e0;
            padding: 0;
        }

        .menu-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0px 0;
        }

        /* Navigasi Menu */
        .navmenu {
            width: 100%;
            padding: 0;
            margin: 0;
        }

        .navmenu>ul {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .navmenu>ul>li {
            position: relative;
            padding: 2px 8px;
            margin: 0;
        }

        .navmenu>ul>li>a {
            color: #333;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.8rem;
            transition: color 0.3s;
            padding: 5px 0;
            display: block;
        }

        .navmenu>ul>li>a:hover,
        .navmenu>ul>li>a.active {
            color: #0d6efd;
        }

        /* Mobile Menu Styles */
        .mobile-menu-container {
            display: none;
            position: fixed;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1030;
        }

        .mobile-menu {
            position: fixed;
            top: 0;
            right: -320px;
            /* Start off-screen */
            width: 320px;
            height: 100%;
            background-color: white;
            overflow-y: auto;
            transition: right 0.3s ease;
            z-index: 1031;
            box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .mobile-menu.open {
            right: 0;
        }

        .mobile-menu-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1025;
            display: none;
        }

        .mobile-menu-overlay.open {
            display: block;
        }

        .mobile-menu-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
        }

        .mobile-menu-header h3 {
            margin: 0;
        }

        /* Menghilangkan tanda X tambahan yang muncul di sebelah teks Menu */
        .mobile-menu-header h3::after {
            display: none;
        }

        .close-button {
            background: none;
            border: none;
            cursor: pointer;
            padding: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease;
        }

        .close-button:hover {
            transform: rotate(90deg);
        }

        .mobile-menu-content {
            padding: 15px;
        }

        .mobile-menu-content ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .mobile-menu-content ul li {
            margin-bottom: 10px;
        }

        .mobile-menu-content ul li a {
            display: flex;
            align-items: center;
            color: #333;
            text-decoration: none;
            font-weight: 500;
            padding: 8px 0;
            transition: color 0.3s;
        }

        .mobile-menu-content ul li a:hover,
        .mobile-menu-content ul li a.active {
            color: #0d6efd;
        }

        .mobile-menu-content ul li a svg,
        .mobile-menu-content ul li a i {
            margin-right: 10px;
            width: 20px;
            height: 20px;
        }

        .mobile-dropdown {
            margin-bottom: 10px;
        }

        .mobile-dropdown button {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            background: none;
            border: none;
            color: #333;
            font-weight: 500;
            padding: 8px 0;
            text-align: left;
            cursor: pointer;
        }

        .mobile-dropdown button:focus {
            outline: none;
        }

        .mobile-dropdown-menu {
            padding-left: 20px;
            margin-top: 5px;
            display: none;
            animation: fadeIn 0.3s ease-in-out;
        }

        .mobile-dropdown-menu.open {
            display: block;
        }

        /* Memastikan class hidden dan open bekerja dengan benar */
        .mobile-dropdown-menu {
            display: none;
        }

        .mobile-dropdown-menu.open {
            display: block;
        }

        .mobile-dropdown-menu.hidden {
            display: none !important;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .mobile-dropdown-icon {
            transition: transform 0.3s;
        }

        .mobile-dropdown-icon.rotate {
            transform: rotate(180deg);
        }

        .hamburger-menu {
            display: none;
            cursor: pointer;
            padding: 10px;
            z-index: 1040;
            background-color: transparent;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .hamburger-menu:hover {
            background-color: #f8f9fa;
            transform: scale(1.05);
        }

        .hamburger-icon {
            width: 24px;
            height: 18px;
            position: relative;
            transform: rotate(0deg);
            transition: .5s ease-in-out;
        }

        .hamburger-icon span {
            display: block;
            position: absolute;
            height: 2px;
            width: 100%;
            background: #333;
            border-radius: 9px;
            opacity: 1;
            left: 0;
            transform: rotate(0deg);
            transition: .25s ease-in-out;
        }

        .hamburger-icon span:nth-child(1) {
            top: 0px;
        }

        .hamburger-icon span:nth-child(2) {
            top: 8px;
        }

        .hamburger-icon span:nth-child(3) {
            top: 16px;
        }

        .hamburger-icon.open span:nth-child(1) {
            top: 8px;
            transform: rotate(135deg);
        }

        .hamburger-icon.open span:nth-child(2) {
            opacity: 0;
            left: -60px;
        }

        .hamburger-icon.open span:nth-child(3) {
            top: 8px;
            transform: rotate(-135deg);
        }

        .hamburger-menu:hover .hamburger-icon span {
            background-color: #0a58ca;
        }

        /* Sembunyikan hamburger menu pada tampilan desktop */
        .hamburger-menu {
            display: none;
        }

        @media (max-width: 1199px) {
            .hamburger-menu {
                display: flex;
            }

            .navmenu {
                display: none;
            }
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .header-content {
                padding: 10px 0;
            }

            .logo img {
                max-height: 35px !important;
            }

            .sitename {
                font-size: 0.9rem !important;
            }

            .logo .d-flex:last-child img {
                max-height: 28px !important;
            }
        }

        @media (max-width: 576px) {
            .header-wrapper {
                padding: 0 10px;
            }

            .logo img {
                max-height: 30px !important;
            }

            .sitename {
                font-size: 0.8rem !important;
            }

            .logo .d-flex:last-child {
                display: none !important;
            }
        }

        .login-button {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            background-color: #0d6efd;
            color: white;
            text-align: center;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.3s;
        }

        .login-button:hover {
            background-color: #0b5ed7;
        }
    </style>
    <div class="header-container">
        <div class="header-wrapper">
            <div class="header-content">
                <a href="{{ url('/') }}" class="logo d-flex align-items-center">
                    @php
                        $logoUrl = '';
                        $siteName = 'Web OPD'; // Default value

                        if (class_exists('App\\Models\\Pengaturan') && \App\Models\Pengaturan::exists()) {
                            $pengaturan = \App\Models\Pengaturan::first();

                            // Get logo URL
                            if ($pengaturan && $pengaturan->logo_instansi) {
                                if (str_starts_with($pengaturan->logo_instansi, 'http')) {
                                    $logoUrl = $pengaturan->logo_instansi;
                                } else {
                                    $logoUrl = asset('storage/' . $pengaturan->logo_instansi);
                                }
                            }

                            // Get site name
                            if (!empty($pengaturan->nama_website)) {
                                $siteName = $pengaturan->nama_website;
                            }
                        }

                        if (empty($logoUrl) || $logoUrl === asset('storage/')) {
                            $logoUrl = asset('kabupaten-sijunjung.png');
                        }

                    @endphp
                    <div class="d-flex align-items-center">
                        <img src="{{ $logoUrl }}" alt="Logo" class="img-fluid" style="max-height: 40px;">
                        <div class="ms-2 d-flex flex-column">
                            <span class="text-uppercase"
                                style="font-size: 0.7rem; letter-spacing: 0.5px; color: #6c757d;">WEBSITE</span>
                            <h1 class="sitename m-0" style="font-size: 1rem; line-height: 1.1;">{{ $siteName }}
                            </h1>
                        </div>
                        <div class="d-flex align-items-center ms-3"
                            style="border-left: 1px solid #dee2e6; padding-left: 15px;">
                            <img src="{{ asset('images/bangga.png') }}" alt="Bangga" class="img-fluid me-1"
                                style="max-height: 32px;">
                            <img src="{{ asset('images/berakhlak.png') }}" alt="Berakhlak" class="img-fluid"
                                style="max-height: 32px;">
                        </div>
                    </div>
                </a>

                <!-- Right side elements -->
                <div class="d-flex align-items-center">
                    <div id="current-time" class="d-flex align-items-center me-3">
                        <div class="text-end me-3" style="line-height: 1.1;">
                            <div id="date" class="fw-medium" style="font-size: 0.8rem; color: #6c757d;">Selasa, 24 Juni 2025</div>
                            <div id="time" class="fw-bold" style="font-size: 0.9rem; color: #495057;">00:00:00 WIB</div>
                        </div>
                        <i class="bi bi-calendar3" style="font-size: 1.5rem; color: #6c757d;"></i>
                    </div>
                    <a href="{{ route('login') }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Login
                    </a>
                </div>

                <!-- Hamburger Menu Button inside header content -->
                <div class="hamburger-menu ms-3" id="mobile-menu-toggle">
                    <div class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="mobile-menu-container" id="mobile-menu-container" style="right: 0;">
        <!-- Mobile Menu Overlay -->
        <div class="mobile-menu-overlay" id="mobile-menu-overlay"></div>

        <div class="mobile-menu" id="mobile-menu">
            <div class="mobile-menu-header">
                <h3 class="m-0">Menu</h3>
                <button id="close-mobile-menu" class="close-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <div class="mobile-menu-content">
                <ul>
                    <li>
                        <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('berita.index') }}"
                            class="{{ request()->routeIs('berita.index') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                            Berita
                        </a>
                    </li>
                    <li class="mobile-dropdown">
                        <button>
                            <div class="d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <span class="ms-2">Profil</span>
                            </div>
                            <i class="bi bi-chevron-down mobile-dropdown-icon"></i>
                        </button>
                        <ul class="mobile-dropdown-menu hidden">
                            <li><a href="{{ route('visi-misi') }}"
                                    class="{{ request()->routeIs('visi-misi') ? 'active' : '' }}">Visi & Misi</a></li>
                            <li><a href="{{ route('sambutan-pimpinan') }}"
                                    class="{{ request()->routeIs('sambutan-pimpinan') ? 'active' : '' }}">Sambutan
                                    Pimpinan</a></li>
                            <li><a href="{{ route('struktur-organisasi') }}"
                                    class="{{ request()->routeIs('struktur-organisasi') ? 'active' : '' }}">Struktur
                                    Organisasi</a></li>
                        </ul>
                    </li>
                    <li class="mobile-dropdown">
                        <button>
                            <div class="d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="16" x2="12" y2="12"></line>
                                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                                </svg>
                                <span class="ms-2">Informasi</span>
                            </div>
                            <i class="bi bi-chevron-down mobile-dropdown-icon"></i>
                        </button>
                        <ul class="mobile-dropdown-menu hidden">
                            <li><a href="{{ route('infografis') }}"
                                    class="{{ request()->routeIs('infografis') ? 'active' : '' }}">Infografis</a></li>
                            <li><a href="{{ route('dokumen') }}"
                                    class="{{ request()->routeIs('dokumen') ? 'active' : '' }}">Dokumen</a></li>
                            <li><a href="{{ route('produk-hukum') }}"
                                    class="{{ request()->routeIs('produk-hukum') ? 'active' : '' }}">Produk Hukum</a>
                            </li>
                            <li><a href="{{ route('agenda.index') }}"
                                    class="{{ request()->routeIs('agenda.index') || request()->routeIs('agenda.show') ? 'active' : '' }}">Agenda
                                    Kegiatan</a></li>
                            <li><a href="{{ route('informasi.index') }}"
                                    class="{{ request()->routeIs('informasi.index') || request()->routeIs('informasi.show') ? 'active' : '' }}">Informasi</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('kontak') }}" class="{{ request()->routeIs('kontak') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                </path>
                            </svg>
                            Kontak
                        </a>
                    </li>
                </ul>
                <a href="{{ route('login') }}" class="login-button">Login</a>
            </div>
        </div>
    </div>

    <div class="menu-container">
        <div class="menu-wrapper">
            <nav id="navmenu" class="navmenu">
                <ul class="flex justify-center items-center">
                    <li class="flex items-center">
                        <a href="{{ url('/') }}"
                            class="{{ request()->is('/') ? 'active' : '' }} flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </a>
                    </li>
                    <li><a href="{{ route('berita.index') }}"
                            class="{{ request()->routeIs('berita.index') ? 'active' : '' }}">Berita</a></li>
                    <li class="dropdown"><a href="#"><span>Profil</span> <i
                                class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="{{ route('visi-misi') }}"
                                    class="{{ request()->routeIs('visi-misi') ? 'active' : '' }}">Visi & Misi</a></li>
                            <li><a href="{{ route('sambutan-pimpinan') }}"
                                    class="{{ request()->routeIs('sambutan-pimpinan') ? 'active' : '' }}">Sambutan
                                    Pimpinan</a></li>
                            <li><a href="{{ route('struktur-organisasi') }}"
                                    class="{{ request()->routeIs('struktur-organisasi') ? 'active' : '' }}">Struktur
                                    Organisasi</a></li>
                        </ul>
                    </li>
                    <li class="dropdown"><a href="#"><span>Informasi</span> <i
                                class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="{{ route('infografis') }}"
                                    class="{{ request()->routeIs('infografis') ? 'active' : '' }}">Infografis</a></li>
                            <li><a href="{{ route('dokumen') }}"
                                    class="{{ request()->routeIs('dokumen') ? 'active' : '' }}">Dokumen</a></li>
                            <li><a href="{{ route('produk-hukum') }}"
                                    class="{{ request()->routeIs('produk-hukum') ? 'active' : '' }}">Produk Hukum</a>
                            </li>
                            <li><a href="{{ route('agenda.index') }}"
                                    class="{{ request()->routeIs('agenda.index') || request()->routeIs('agenda.show') ? 'active' : '' }}">Agenda
                                    Kegiatan</a></li>
                            <li><a href="{{ route('informasi.index') }}"
                                    class="{{ request()->routeIs('informasi.index') || request()->routeIs('informasi.show') ? 'active' : '' }}">Informasi</a>
                            </li>
                        </ul>
                    </li>
                    <li><a href="{{ route('kontak') }}"
                            class="{{ request()->routeIs('kontak') ? 'active' : '' }}">Kontak</a></li>
                </ul>
            </nav>
        </div>
    </div>

    <script>
        // Handle scroll untuk mengubah ukuran header
        function updateHeader() {
            const header = document.getElementById('header');
            if (window.scrollY > 50) {
                header.classList.remove('at-top');
            } else {
                header.classList.add('at-top');
            }
        }

        // Add at-top class by default
        document.getElementById('header').classList.add('at-top');

        // Update on scroll
        window.addEventListener('scroll', updateHeader);

        // Check initial scroll position
        updateHeader();

        // Update waktu dan tanggal secara real-time
        function updateTime() {
            const now = new Date();
            
            // Format waktu
            const timeString = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            });
            
            // Format tanggal
            const options = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            };
            const dateString = now.toLocaleDateString('id-ID', options);
            
            document.getElementById('time').textContent = timeString + ' WIB';
            document.getElementById('date').textContent = dateString;
        }
        
        // Update waktu setiap detik
        setInterval(updateTime, 1000);
        updateTime(); // Panggil sekali saat pertama kali load

        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
            const mobileMenuContainer = document.getElementById('mobile-menu-container');
            const mobileMenu = document.getElementById('mobile-menu');
            const closeMobileMenuBtn = document.getElementById('close-mobile-menu');
            const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');
            const hamburgerIcon = document.querySelector('.hamburger-icon');

            // Toggle mobile dropdowns
            const mobileDropdowns = document.querySelectorAll('.mobile-dropdown');

            // Function to close mobile menu
            function closeMobileMenuFunc() {
                mobileMenu.classList.remove('open');
                hamburgerIcon.classList.remove('open');
                mobileMenuOverlay.classList.remove('open');
                document.body.style.overflow = ''; // Restore scrolling

                // Reset all dropdowns when menu closes
                mobileDropdowns.forEach(dropdown => {
                    const menu = dropdown.querySelector('.mobile-dropdown-menu');
                    const icon = dropdown.querySelector('.mobile-dropdown-icon');

                    menu.classList.add('hidden');
                    menu.classList.remove('open');
                    if (icon) {
                        icon.style.transform = 'rotate(0deg)';
                    }
                });

                setTimeout(function() {
                    mobileMenuContainer.style.display = 'none';
                }, 300);
            }

            if (mobileMenuToggle && mobileMenuContainer && mobileMenu && closeMobileMenuBtn && mobileMenuOverlay) {
                // Open mobile menu
                mobileMenuToggle.addEventListener('click', function() {
                    mobileMenuContainer.style.display = 'block';
                    mobileMenuOverlay.classList.add('open');
                    document.body.style.overflow = 'hidden'; // Prevent scrolling when menu is open
                    setTimeout(function() {
                        mobileMenu.classList.add('open');
                        hamburgerIcon.classList.add('open');

                        // Tidak perlu auto-open dropdown saat menu dibuka
                        // Pastikan semua dropdown tertutup saat menu dibuka
                        mobileDropdowns.forEach(dropdown => {
                            const menu = dropdown.querySelector('.mobile-dropdown-menu');
                            const icon = dropdown.querySelector('.mobile-dropdown-icon');

                            menu.classList.add('hidden');
                            menu.classList.remove('open');
                            if (icon) {
                                icon.style.transform = 'rotate(0deg)';
                            }
                        });
                    }, 10);
                });

                // Close mobile menu
                closeMobileMenuBtn.addEventListener('click', closeMobileMenuFunc);

                // Close menu when clicking on overlay
                mobileMenuOverlay.addEventListener('click', closeMobileMenuFunc);

                // Close menu when clicking outside
                mobileMenuContainer.addEventListener('click', function(e) {
                    if (e.target === mobileMenuContainer) {
                        closeMobileMenuFunc();
                    }
                });
            }

            // Toggle mobile dropdowns
            mobileDropdowns.forEach(dropdown => {
                const button = dropdown.querySelector('button');
                const menu = dropdown.querySelector('.mobile-dropdown-menu');
                const icon = dropdown.querySelector('.mobile-dropdown-icon');

                if (button && menu && icon) {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();

                        // Toggle classes for dropdown menu
                        menu.classList.toggle('hidden');
                        menu.classList.toggle('open');

                        // Rotate icon based on menu state
                        if (menu.classList.contains('open')) {
                            icon.style.transform = 'rotate(180deg)';
                        } else {
                            icon.style.transform = 'rotate(0deg)';
                        }
                    });
                }
            });

        });
    </script>
</header>
