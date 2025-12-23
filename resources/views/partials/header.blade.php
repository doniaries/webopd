<header id="header" class="header sticky-top" style="margin-bottom: 0 !important; padding-bottom: 0 !important;">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        /* Base Header Styles */
        .header {
            background-color: #fff;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            width: 100%;
            top: 0;
            z-index: 1020;
        }

        /* Top Bar */
        .header-main {
            border-bottom: 1px solid #f0f0f0;
            padding: 5px 0;
            /* Reduced padding */
            background: #fff;
            width: 100%;
        }

        /* Logo Area */
        .logo-group {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .main-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #333;
            border-right: 1px solid #eee;
            padding-right: 20px;
            margin-right: 10px;
        }

        .logo-img {
            height: 48px;
            width: auto;
            object-fit: contain;
        }

        .site-identity {
            display: flex;
            flex-direction: column;
            line-height: 1.1;
        }

        .site-name {
            font-size: 1rem;
            font-weight: 700;
            color: #111;
            margin: 0;
            text-transform: uppercase;
        }

        .site-tagline {
            font-size: 0.75rem;
            color: #666;
            text-transform: uppercase;
        }

        .partner-logos {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .partner-img {
            height: 32px;
            width: auto;
            filter: grayscale(0%);
            transition: filter 0.3s;
        }



        /* Navigation Menu */
        .nav-container {
            background: #fff;
            border-bottom: none;
            /* No border to prevent gap */
            padding: 0;
            margin: 0;
        }

        .main-nav {
            display: flex;
            justify-content: center;
            list-style: none;
            margin: 0;
            padding: 0;
            flex-wrap: wrap;
        }

        .main-nav>li>a {
            display: block;
            padding: 14px 20px;
            color: #333;
            font-weight: 600;
            text-decoration: none;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.2s;
            border-bottom: 3px solid transparent;
            height: 100%;
            /* Ensure full height */
            display: flex;
            align-items: center;
            /* Center content vertical */
            gap: 8px;
            /* Gap for icon + text */
        }

        .main-nav>li>a:hover,
        .main-nav>li>a.active {
            color: #0d6efd;
            /* Blue Color */
            border-bottom-color: #0d6efd;
        }

        .main-nav>li>a i.icon-only {
            font-size: 1.2rem;
            margin: 0;
            line-height: 1;
        }

        /* Dropdown */
        .dropdown {
            position: relative;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            /* Centered dropdown */
            background: #fff;
            border: 1px solid #eee;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            min-width: 220px;
            z-index: 9999;
            /* High Z-Index */
            list-style: none;
            padding: 8px 0;
            border-radius: 0 0 8px 8px;
            text-transform: none;
            margin-top: 0;
            /* consistent positioning */
        }

        /* Bridge to prevent closing */
        .dropdown-menu::before {
            content: '';
            position: absolute;
            top: -10px;
            left: 0;
            width: 100%;
            height: 10px;
            background: transparent;
        }

        /* Desktop Hover */
        @media (min-width: 992px) {
            .dropdown:hover .dropdown-menu {
                display: block !important;
                /* Force display */
            }
        }

        .dropdown-menu li a {
            display: block;
            padding: 10px 20px;
            color: #555;
            text-decoration: none;
            font-size: 0.9rem;
            text-transform: none;
            /* Normal case for submenu */
            transition: all 0.2s;
            border-bottom: none;
        }

        .dropdown-menu li a:hover {
            background: #eff6ff;
            color: #0d6efd;
        }

        /* Mobile Responsive */
        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            padding: 5px;
            font-size: 1.8rem;
            color: #333;
            cursor: pointer;
        }

        @media (max-width: 991px) {
            .header-main {
                padding: 10px 0;
            }

            .logo-group {
                gap: 10px;
            }

            .partner-logos,
            .search-container {
                display: none;
                /* Hide partners and search on minimal mobile header (can be moved deeper if needed) */
            }

            .mobile-toggle {
                display: block;
            }

            .nav-container {
                display: none;
                /* Hidden by default */
            }

            .nav-container.active {
                display: block;
            }

            .main-nav {
                flex-direction: column;
                justify-content: flex-start;
                padding: 10px 0;
            }

            .main-nav>li>a {
                padding: 12px 20px;
                border-bottom: 1px solid #f5f5f5;
                width: 100%;
                text-align: left;
            }

            /* Mobile Search in Nav */
            .mobile-search {
                padding: 15px 20px;
                background: #f9fafb;
                border-bottom: 1px solid #eee;
            }

            .mobile-search .search-input {
                padding: 8px 15px 8px 40px;
            }

            /* Dropdown Mobile */
            .dropdown:hover .dropdown-menu {
                display: none;
            }

            .dropdown-menu {
                position: relative;
                top: 0;
                left: 0;
                transform: none;
                width: 100%;
                box-shadow: none;
                border: none;
                background: #f9fafb;
                padding-left: 0;
            }

            .dropdown-menu.show {
                display: block;
            }

            .dropdown-menu li a {
                padding-left: 40px;
            }
        }
    </style>

    @php
    use App\Models\Pengaturan;
    $pengaturan = Pengaturan::first();
    $siteName = $pengaturan->name ?? 'Web OPD';
    $logoUrl = $pengaturan->logo ? asset('storage/' . $pengaturan->logo) : asset('assets/img/logo.png');
    @endphp

    <div class="header-main w-100">
        <div class="container-fluid px-lg-5 px-3 d-flex align-items-center justify-content-between">
            <!-- Left: Logo Group -->
            <div class="logo-group">
                <a href="{{ url('/') }}" class="main-logo">
                    <img src="{{ $logoUrl }}" alt="Logo" class="logo-img" onerror="this.src='{{ asset('assets/img/logo.png') }}'">
                    <div class="site-identity d-none d-sm-flex">
                        <h1 class="site-name">{{ $siteName }}</h1>
                        <span class="site-tagline">Pemerintah {{ $pengaturan->kabupaten ?? 'Sijunjung' }}</span>
                    </div>
                </a>

                <!-- Partner Logos (Desktop) -->
                <div class="partner-logos d-none d-lg-flex">
                    <img src="{{ asset('images/bangga.png') }}" alt="Bangga" class="partner-img">
                    <img src="{{ asset('images/berakhlak.png') }}" alt="Berakhlak" class="partner-img">
                </div>
            </div>



            <!-- Mobile Toggle -->
            <button class="mobile-toggle d-lg-none" onclick="document.querySelector('.nav-container').classList.toggle('active')">
                <i class="bi bi-list"></i>
            </button>
        </div>
    </div>

    <!-- Nav Container -->
    <div class="nav-container w-100">
        <div class="container-fluid px-lg-5 px-3">


            <nav>
                <ul class="main-nav">
                    <!-- Home Icon -->
                    <li>
                        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                            <i class="bi bi-house-door-fill icon-only"></i>
                        </a>
                    </li>

                    <li><a href="{{ request()->is('berita*') ? '#' : route('berita.index') }}" class="{{ request()->is('berita*') ? 'active' : '' }}">
                            Berita
                        </a></li>

                    <li class="dropdown">
                        <a href="#">Profil <i class="bi bi-chevron-down ms-1" style="font-size: 0.8em;"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Sejarah</a></li>
                            <li><a href="{{ route('profil.visi-misi') }}">Visi & Misi</a></li>
                            <li><a href="{{ route('struktur-organisasi') }}">Struktur Organisasi</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#">Informasi <i class="bi bi-chevron-down ms-1" style="font-size: 0.8em;"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('agenda.index') }}">Agenda Kegiatan</a></li>
                            <li><a href="{{ route('dokumen.index') }}">Dokumen & Download</a></li>
                        </ul>
                    </li>

                    <li><a href="{{ route('pengumuman.index') }}" class="{{ request()->routeIs('pengumuman.*') ? 'active' : '' }}">
                            Pengumuman
                        </a></li>

                    <li><a href="{{ route('kontak') }}" class="{{ request()->routeIs('kontak') ? 'active' : '' }}">
                            Layanan
                        </a></li>
                </ul>
            </nav>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Dropdown Logic
            const dropdownLinks = document.querySelectorAll('.dropdown > a');

            function closeAllDropdowns() {
                document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                    menu.classList.remove('show');
                    menu.previousElementSibling.classList.remove('active');
                    const icon = menu.previousElementSibling.querySelector('.bi-chevron-down');
                    if (icon) icon.style.transform = 'rotate(0deg)';
                });
            }

            dropdownLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    if (this.getAttribute('href') === '#') e.preventDefault();

                    // Mobile interaction logic
                    if (window.matchMedia('(max-width: 991px)').matches) {
                        e.preventDefault();
                        e.stopPropagation();

                        const menu = this.nextElementSibling;
                        const isAlreadyOpen = menu && menu.classList.contains('show');

                        closeAllDropdowns();

                        if (menu && !isAlreadyOpen) {
                            menu.classList.add('show');
                            this.classList.add('active');
                            const icon = this.querySelector('.bi-chevron-down');
                            if (icon) icon.style.transform = 'rotate(180deg)';
                        }
                    }
                });
            });

            // Close on outside click
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.dropdown')) closeAllDropdowns();
            });
        });
    </script>
</header>