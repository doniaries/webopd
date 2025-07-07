<header id="header" class="header sticky-top">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* Reset and Base Styles */
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');

        header#header,
        header#header *,
        header#header *:before,
        header#header *:after {
            border-radius: 0 !important;
            -webkit-border-radius: 0 !important;
            -moz-border-radius: 0 !important;
            box-sizing: border-box;
        }

        /* Layout Containers */
        .sticky-top {
            position: sticky;
            top: 0;
            z-index: 1020;
            background-color: transparent;
            width: 100%;
            padding: 0;
        }

        .header-container {
            width: 100%;
            background-color: #ffffff;
            border-bottom: 1px solid #d8d7d7;
            min-height: 50px;
            display: flex;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: none !important;
        }

        .menu-container {
            padding: 0;
            background-color: #ffffff;
            box-shadow: none !important;
            display: flex;
            align-items: center;
            height: auto;
        }

        .header-wrapper,
        .menu-wrapper {
            max-width: 1320px;
            margin: 0 auto;
            padding: 0 20px;
            width: 100%;
            display: flex;
            align-items: center;
        }

        .header-content {
            display: flex;
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 10px;
            justify-content: space-between;
            align-items: center;
            position: relative;
        }

        /* Logo Styles */
        .logo {
            display: flex !important;
            align-items: center;
            text-decoration: none;
            color: inherit;
            padding: 2px 0;
            min-width: 40px;
            margin-right: auto;
        }

        .logo-wrapper {
            display: flex;
            align-items: center;
            height: 35px;
            margin-right: 10px;
        }

        .logo-image {
            height: 100%;
            width: auto;
            max-width: 150px;
            object-fit: contain;
        }

        /* Nama Aplikasi */
        .sitename {
            font-size: 1.1rem !important;
            line-height: 1.2 !important;
            font-weight: 700 !important;
            color: #333 !important;
            margin: 0 !important;
            padding: 0 !important;
            white-space: nowrap !important;
            overflow: visible !important;
            text-overflow: unset !important;
            display: block !important;
            opacity: 1 !important;
            visibility: visible !important;
            position: relative !important;
            z-index: 100 !important;
        }

        .text-uppercase {
            font-size: 0.7rem !important;
            letter-spacing: 0.5px !important;
            color: #6c757d !important;
            font-weight: 600 !important;
            display: block !important;
            opacity: 1 !important;
            visibility: visible !important;
            margin: 0 !important;
            padding: 0 !important;
            line-height: 1.2 !important;
        }

        /* Fallback for logo */
        .logo-image[src*='kabupaten-sijunjung.png'] {
            height: 35px;
            width: auto;
        }

        /* Mobile Styles */
        @media (max-width: 767px) {
            .logo {
                min-width: 35px !important;
                width: 35px !important;
                height: 35px !important;
                margin: 0 5px 0 0 !important;
                padding: 0 !important;
                overflow: visible !important;
            }

            .logo img,
            .logo-image,
            .logo-container img,
            .d-flex.align-items-center img {
                min-width: 35px !important;
                width: 35px !important;
                height: 35px !important;
                max-width: 100% !important;
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
                position: relative !important;
            }
        }

        /* CSS untuk logo container */
        .logo-container {
            flex-shrink: 0;
            display: block;
            min-width: 40px;
            width: 40px;
            height: 40px;
            position: relative;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: visible;
        }

        /* Tambahan untuk memastikan logo terlihat pada mobile */
        @media (max-width: 576px) {
            .logo a {
                display: flex !important;
                align-items: center !important;
            }

            /* Pastikan container logo memiliki dimensi tetap */
            .logo a>div:first-child,
            .logo-container {
                min-width: 35px !important;
                width: 35px !important;
                height: 35px !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                overflow: visible !important;
                position: relative !important;
                z-index: 10 !important;
            }

            /* Pastikan gambar logo terlihat */
            .logo a>div:first-child img,
            .logo-image {
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
                min-width: 35px !important;
                min-height: 35px !important;
                object-fit: contain !important;
                position: relative !important;
                z-index: 10 !important;
                max-width: none !important;
            }

            /* CSS khusus untuk logo-container dan logo-image */
            .logo-container {
                min-width: 35px !important;
                width: 35px !important;
                height: 35px !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                overflow: visible !important;
                position: relative !important;
                z-index: 10 !important;
            }

            .logo-image {
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
                min-width: 35px !important;
                min-height: 35px !important;
                max-height: 35px !important;
                width: auto !important;
                object-fit: contain !important;
                position: relative !important;
                z-index: 10 !important;
                max-width: none !important;
            }
        }

        /* Menu container */
        .menu-container {
            background-color: white;
            /* border-bottom: 1px solid #e0e0e0; */
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
            opacity: 0;
            transition: opacity 0.3s ease;
            <div class="position-absolute bottom-0 start-0 w-100 p-4 mb-5" style="background: linear-gradient(to top, rgba(0, 0, 255, 0.8), transparent); z-index: 11; transform: translateY(20px);">
        }

        .mobile-menu-container.visible {
            opacity: 1;
        }

        .mobile-menu {
            position: fixed;
            top: 0;
            right: -280px;
            /* Lebih kecil untuk tampilan mobile */
            width: 280px;
            /* Lebih kecil untuk tampilan mobile */
            height: 100%;
            background-color: white;
            overflow-y: auto;
            transition: right 0.3s ease;
            z-index: 1031;
            box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .mobile-menu.open {
            right: 0;
            box-shadow: -5px 0 15px rgba(0, 0, 0, 0.2);
        }

        .mobile-menu-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 1025;
            display: none;
            backdrop-filter: blur(2px);
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
            background-color: #f8f9fa;
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
            transition: color 0.3s, background-color 0.2s ease;
        }

        .mobile-menu-content ul li a:active {
            background-color: #f5f5f5;
        }

        .mobile-menu-content ul li a:hover,
        .mobile-menu-content ul li a.active {
            color: #0d6efd;
        }

        /* Active menu item styles */
        .navmenu>ul>li>a.active {
            background-color: #3490dc;
            color: white !important;
            border-radius: 4px;
            padding: 8px 16px !important;
            transition: all 0.3s ease;
        }

        .navmenu>ul>li>a:hover {
            background-color: #3490dc;
            color: white !important;
            border-radius: 4px;
        }

        .navmenu>ul>li>a {
            padding: 8px 16px;
            transition: all 0.3s ease;
            display: inline-block;
            font-size: 1rem;
            /* Match submenu font size */
        }

        /* Dropdown menu items styling */
        .navmenu ul ul {
            background: white;
            border-radius: 4px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 5px 0;
            min-width: 200px;
        }

        .navmenu ul ul li a {
            font-size: 1rem;
            text-decoration: none !important;
            display: block;
            padding: 8px 16px;
            color: #333;
            transition: all 0.3s ease;
        }

        .navmenu ul ul li a:hover {
            background-color: #3490dc;
            color: white !important;
        }

        /* Ensure dropdown menu items have consistent font size */
        .navmenu ul ul li a {
            font-size: 1rem;
        }

        .mobile-menu-content ul li a i {
            margin-right: 10px;
            width: 20px;
            height: 20px;
        }

        .mobile-dropdown {
            margin-bottom: 10px;
        }

        .mobile-dropdown button {
            outline: none;
        }

        .mobile-dropdown-menu {
            padding-left: 20px;
            margin-top: 5px;
            display: none;
            animation: fadeIn 0.3s ease-in-out;
            background-color: #f9f9f9;
            overflow: hidden;
        }

        .mobile-dropdown-menu.open {
            display: block;
            max-height: 1000px;
            /* Nilai yang cukup besar untuk menampung semua item */
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
            margin-left: auto;
            font-size: 1.1rem;
        }

        .mobile-dropdown-icon.rotate {
            transform: rotate(180deg);
        }

        /* Hamburger Menu - Flowbite Style */
        .hamburger-button {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem;
            width: 2.5rem;
            height: 2.5rem;
            justify-content: center;
            font-size: 0.875rem;
            color: #6B7280;
            background-color: transparent;
            border-radius: 0.375rem;
            border: none;
            cursor: pointer;
        }

        .hamburger-button:hover {
            background-color: #F3F4F6;
        }

        .hamburger-button:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
        }

        /* Hamburger Menu */
        #mobile-menu-toggle {
            display: none;
            background: transparent;
            border: none;
            padding: 8px;
            cursor: pointer;
            z-index: 1001;
        }

        #mobile-menu-toggle svg {
            width: 24px;
            height: 24px;
            color: #333;
        }

        /* Mobile Menu Styles */
        @media (max-width: 991.98px) {
            .navmenu {
                display: none !important;
            }

            #mobile-menu-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .header-wrapper {
                padding: 0 15px;
                height: 100%;
            }
        }

        /* Mobile Specific Styles */
        @media (max-width: 576px) {
            .header-container {
                height: 60px;
                padding: 0 !important;
                margin: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
            }

            .header-wrapper {
                padding: 0 10px !important;
                width: 100% !important;
                max-width: 100% !important;
                margin: 0 !important;
            }

            .header-content {
                padding: 0 5px !important;
                margin: 0 !important;
            }

            .logo {
                display: flex !important;
                min-width: 35px !important;
                flex-shrink: 0 !important;
            }

            .logo img {
                max-height: 35px !important;
                min-height: 35px !important;
                min-width: 35px !important;
                width: auto !important;
                margin-right: 5px;
                display: block !important;
                flex-shrink: 0 !important;
                object-fit: contain !important;
            }

            .sitename {
                font-size: 0.85rem !important;
                max-width: 180px !important;
                white-space: nowrap !important;
                overflow: visible !important;
                text-overflow: unset !important;
                font-weight: 700 !important;
                color: #333 !important;
                display: block !important;
                opacity: 1 !important;
                visibility: visible !important;
            }

            #current-time {
                display: none !important;
            }
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .header-content {
                padding: 0 10px !important;
                min-height: 50px;
                justify-content: space-between;
            }

            .logo {
                flex: 0 0 auto !important;
                max-width: 180px !important;
                display: flex !important;
                align-items: center !important;
                margin-right: 0 !important;
            }

            .logo-wrapper {
                width: 35px !important;
                min-width: 35px !important;
                height: 35px !important;
                margin-right: 8px !important;
                flex-shrink: 0 !important;
            }

            .logo-image {
                width: 100% !important;
                height: 100% !important;
                object-fit: contain !important;
            }

            .sitename {
                font-size: 0.9rem !important;
                max-width: 120px !important;
                white-space: nowrap !important;
                overflow: visible !important;
                text-overflow: unset !important;
                color: #333 !important;
                display: block !important;
                opacity: 1 !important;
                visibility: visible !important;
                position: relative !important;
                z-index: 100 !important;
                line-height: 1.2 !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            padding: 10px 0;
        }

        .logo img {
            max-height: 35px !important;
        }

        .sitename {
            font-family: 'Roboto', sans-serif !important;
            font-size: 1.1rem !important;
            font-weight: 700 !important;
            color: #2c3e50 !important;
            letter-spacing: 0.3px;
            line-height: 1.2;
            text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        }

        .logo .d-flex:last-child img {
            max-height: 28px !important;
        }

        #current-time {
            display: none !important;
        }
        }

        @media (max-width: 576px) {
            .header-wrapper {
                padding: 0 10px;
                height: 100%;
            }

            .logo {
                display: flex !important;
                min-width: 35px !important;
                max-width: none !important;
                flex-shrink: 0 !important;
            }

            .logo img {
                max-height: 35px !important;
                min-height: 35px !important;
                min-width: 35px !important;
                width: auto !important;
                margin-right: 5px;
                display: block !important;
                flex-shrink: 0 !important;
                object-fit: contain !important;
                visibility: visible !important;
                opacity: 1 !important;
            }

            .sitename {
                font-size: 0.85rem !important;
                max-width: 180px;
                /* Perluas lebar teks karena tidak ada jam */
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                font-weight: 700 !important;
            }

            .logo .d-flex:last-child {
                display: none !important;
            }

            /* Mengurangi padding pada header untuk memberi ruang lebih pada logo */
            .header-container {
                padding: 0;
                height: 60px;
                display: flex;
                align-items: center;
            }

            /* Sembunyikan elemen yang tidak penting pada mobile */
            .d-flex.align-items-center.ms-3 {
                display: none !important;
                /* Sembunyikan gambar bangga dan berakhlak pada mobile */
            }

            /* Pastikan header content memiliki ruang yang cukup */
            .header-content {
                padding: 0 5px;
                justify-content: space-between;
                align-items: center;
            }

            /* Kurangi margin pada waktu */
            #current-time {
                margin-right: 5px !important;
            }

            .hamburger-button {
                margin-left: auto !important;
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

        @media (max-width: 576px) {
            .login-button {
                padding: 6px 10px;
                font-size: 0.9rem;
            }

            .login-button i {
                margin-right: 4px;
            }
        }

        .login-button:hover {
            background-color: #0b5ed7;
        }
    </style>
    <div class="header-container">
        <div class="header-wrapper">
            <div class="header-content">
                <!-- Logo dan nama website di kiri -->
                <div class="d-flex align-items-center">
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
                                if (!empty($pengaturan->name)) {
                                    $siteName = $pengaturan->name;
                                }
                            }

                            if (empty($logoUrl) || $logoUrl === asset('storage/')) {
                                $logoUrl = asset('kabupaten-sijunjung.png');
                            }

                        @endphp
                        <div class="logo-wrapper">
                            <img src="{{ $logoUrl }}" alt="Logo" class="logo-image"
                                onerror="this.onerror=null; this.src='{{ asset('kabupaten-sijunjung.png') }}';">
                        </div>
                        <div class="ms-2 d-flex flex-column" style="position: relative; z-index: 1000;">
                            <span class="text-uppercase d-none d-sm-block">WEBSITE</span>
                            <div class="sitename" style="color: #000 !important;">{{ $siteName }}</div>
                        </div>
                </div>
                </a>
                <div class="d-flex align-items-center ms-3 d-none d-md-flex"
                    style="border-left: 1px solid #dee2e6; padding-left: 15px;">
                    <img src="{{ asset('images/bangga.png') }}" alt="Bangga" class="img-fluid me-1"
                        style="max-height: 24px;">
                    <img src="{{ asset('images/berakhlak.png') }}" alt="Berakhlak" class="img-fluid"
                        style="max-height: 24px;">
                </div>
            </div>



            <!-- Elemen di kanan: hanya tombol hamburger -->
            <div class="d-flex align-items-center">
                <!-- Hamburger Menu Button dengan style Flowbite -->
                <button id="mobile-menu-toggle" type="button"
                    class="hamburger-button inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 1h15M1 7h15M1 13h15" />
                    </svg>
                </button>
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
                            <li><a href="{{ route('agenda.index') }}"
                                    class="{{ request()->routeIs('agenda.index') || request()->routeIs('agenda.show') ? 'active' : '' }}">Agenda
                                    Kegiatan</a></li>

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
                <ul class="flex justify-center items-center" style="gap: 20px;">
                    <li class="flex items-center" style="margin-right: 20px;">
                        <a href="{{ url('/') }}"
                            class="{{ request()->is('/') ? 'active' : '' }} flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </a>
                    </li>
                    <li style="margin: 0 20px;"><a href="{{ route('berita.index') }}"
                            class="{{ request()->routeIs('berita.index') ? 'active' : '' }}">Berita</a></li>

                    <li class="dropdown" style="margin: 0 20px;"><a href="#"><span>Profil</span> <i
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
                    <li class="dropdown" style="margin: 0 20px;"><a href="#"><span>Informasi</span> <i
                                class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="{{ route('layanan.index') }}"
                                    class="{{ request()->routeIs('layanan.index') || request()->routeIs('layanan.show') ? 'active' : '' }}">Layanan</a>
                            </li>
                            <li><a href="{{ route('infografis') }}"
                                    class="{{ request()->routeIs('infografis') ? 'active' : '' }}">Infografis</a></li>
                            <li><a href="{{ route('dokumen') }}"
                                    class="{{ request()->routeIs('dokumen') ? 'active' : '' }}">Dokumen</a></li>
                            <li><a href="{{ route('agenda.index') }}"
                                    class="{{ request()->routeIs('agenda.index') || request()->routeIs('agenda.show') ? 'active' : '' }}">Agenda
                                    Kegiatan</a></li>
                            {{-- <li><a href="{{ route('informasi.index') }}"
                                    class="{{ request()->routeIs('informasi.index') || request()->routeIs('informasi.show') ? 'active' : '' }}">Informasi</a>
                            </li> --}}
                        </ul>
                    </li>
                    <li style="margin: 0 20px;"><a href="{{ route('pengumuman.index') }}"
                            class="{{ request()->routeIs('pengumuman.*') ? 'active' : '' }}">Pengumuman</a></li>
                    <li style="margin-left: 20px;"><a href="{{ route('kontak') }}"
                            class="{{ request()->routeIs('kontak') ? 'active' : '' }}">Kontak</a></li>

                </ul>
            </nav>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle scroll untuk mengubah ukuran header
            function updateHeader() {
                const header = document.getElementById('header');
                if (window.scrollY > 50) {
                    header.classList.remove('at-top');
                } else {
                    header.classList.add('at-top');
                }
            }

            // Initialize header state
            updateHeader();
            window.addEventListener('scroll', updateHeader);
            // Mobile menu toggle
            const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
            const mobileMenuContainer = document.getElementById('mobile-menu-container');
            const mobileMenu = document.getElementById('mobile-menu');
            const closeMobileMenuBtn = document.getElementById('close-mobile-menu');
            const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');
            // Tidak lagi menggunakan hamburgerIcon karena kita menggunakan SVG

            // Toggle mobile dropdowns
            const mobileDropdowns = document.querySelectorAll('.mobile-dropdown');

            // Function to close mobile menu
            function closeMobileMenuFunc() {
                mobileMenu.classList.remove('open');
                // Tidak lagi menggunakan hamburgerIcon
                mobileMenuOverlay.classList.remove('open');
                mobileMenuContainer.classList.remove('visible');
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
                    // Tambahkan delay kecil untuk memastikan transisi berjalan dengan baik
                    setTimeout(function() {
                        mobileMenuContainer.classList.add('visible');
                        mobileMenuOverlay.classList.add('open');
                        document.body.style.overflow =
                            'hidden'; // Prevent scrolling when menu is open

                        setTimeout(function() {
                            mobileMenu.classList.add('open');
                            // Tidak perlu lagi mengubah kelas hamburger icon karena menggunakan SVG

                            // Pastikan semua dropdown tertutup saat menu dibuka
                            mobileDropdowns.forEach(dropdown => {
                                const menu = dropdown.querySelector(
                                    '.mobile-dropdown-menu');
                                const icon = dropdown.querySelector(
                                    '.mobile-dropdown-icon');

                                menu.classList.add('hidden');
                                menu.classList.remove('open');
                                if (icon) {
                                    icon.style.transform = 'rotate(0deg)';
                                }
                            });
                        }, 50);
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
                        if (menu.classList.contains('hidden')) {
                            // Buka dropdown
                            menu.classList.remove('hidden');
                            setTimeout(() => {
                                menu.classList.add('open');
                            }, 10); // Delay kecil untuk animasi yang lebih halus
                            if (icon) {
                                icon.style.transform = 'rotate(180deg)';
                            }
                        } else {
                            // Tutup dropdown
                            menu.classList.remove('open');
                            setTimeout(() => {
                                menu.classList.add('hidden');
                            }, 300); // Sesuaikan dengan durasi transisi
                            if (icon) {
                                icon.style.transform = 'rotate(0deg)';
                            }
                        }
                    });
                }
            });

        });
    </script>
</header>
