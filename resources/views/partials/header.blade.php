<header id="header" class="header sticky-top">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        /* Base Header Styles */
        .header {
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            width: 100%;
            /* Sticky behavior handled by Bootstrap .sticky-top, but fallback here */
            top: 0;
            z-index: 1020;
        }

        /* Top Bar / Brand Bar */
        .header-main {
            border-bottom: 1px solid #eee;
            padding: 10px 0;
            background: #fff;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 15px;
            text-decoration: none;
            color: #333;
        }

        .logo-img {
            height: 45px;
            width: auto;
            object-fit: contain;
        }

        .site-identity {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .site-name {
            font-size: 1.1rem;
            font-weight: 700;
            line-height: 1.2;
            color: #1a1a1a;
            margin: 0;
            font-family: 'Roboto', sans-serif;
        }

        .site-tagline {
            font-size: 0.75rem;
            color: #666;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Navigation Menu */
        .nav-container {
            background: #fff;
        }

        .main-nav {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            flex-wrap: wrap;
        }

        .main-nav>li>a {
            display: block;
            padding: 12px 16px;
            color: #444;
            font-weight: 500;
            text-decoration: none;
            font-size: 0.95rem;
            transition: all 0.2s;
            border-bottom: 2px solid transparent;
            white-space: nowrap;
        }

        .main-nav>li>a:hover,
        .main-nav>li>a.active {
            color: #10b981;
            /* Modern Emerald */
            background-color: #f0fdf4;
            border-bottom-color: #10b981;
        }

        .main-nav>li>a i {
            margin-right: 5px;
        }

        /* Mobile Menu Toggle */
        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 1.5rem;
            color: #333;
        }

        /* Dropdown Support (Basic Hover) */
        .dropdown {
            position: relative;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background: #fff;
            border: 1px solid #eee;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            min-width: 200px;
            z-index: 1000;
            list-style: none;
            padding: 5px 0;
        }

        .dropdown:hover .dropdown-menu {
            display: block;
        }

        .dropdown-menu li a {
            display: block;
            padding: 8px 16px;
            color: #333;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .dropdown-menu li a:hover {
            background: #f9f9f9;
            color: #10b981;
        }

        /* Mobile Responsive */
        @media (max-width: 991px) {
            .mobile-toggle {
                display: block;
            }

            .main-nav {
                display: none;
                /* Hidden by default on mobile */
                flex-direction: column;
                width: 100%;
                border-top: 1px solid #eee;
            }

            .nav-container.active .main-nav {
                display: flex;
            }

            .main-nav>li>a {
                padding: 12px 20px;
                border-bottom: 1px solid #f5f5f5;
                width: 100%;
            }

            .dropdown:hover .dropdown-menu {
                display: none;
                /* Disable hover on mobile */
            }
        }

        @media (max-width: 576px) {
            .site-name {
                font-size: 0.95rem;
            }

            .logo-img {
                height: 35px;
            }

            .header-main {
                padding: 5px 0;
            }
        }
    </style>

    @php
    use App\Models\Pengaturan;
    $pengaturan = Pengaturan::first();
    $siteName = $pengaturan->name ?? 'Web OPD';
    $logoUrl = $pengaturan->logo ? asset('storage/' . $pengaturan->logo) : asset('assets/img/logo.png');
    @endphp

    <div class="header-main">
        <div class="container d-flex align-items-center justify-content-between">
            <!-- Logo & Identity -->
            <a href="{{ url('/') }}" class="logo-section">
                <img src="{{ $logoUrl }}" alt="Logo" class="logo-img" onerror="this.src='{{ asset('assets/img/logo.png') }}'">
                <div class="site-identity">
                    <h1 class="site-name">{{ $siteName }}</h1>
                    <span class="site-tagline">Pemerintah {{ $pengaturan->kabupaten ?? 'Sijunjung' }}</span>
                </div>
            </a>

            <!-- Additional Logos (Hidden on Mobile) -->
            <div class="d-none d-md-flex align-items-center gap-3">
                <img src="{{ asset('images/bangga.png') }}" alt="Bangga" style="height: 30px;">
                <img src="{{ asset('images/berakhlak.png') }}" alt="Berakhlak" style="height: 30px;">
            </div>

            <!-- Mobile Toggle -->
            <button class="mobile-toggle" onclick="this.parentElement.parentElement.nextElementSibling.classList.toggle('active')">
                <i class="bi bi-list"></i>
            </button>
        </div>
    </div>

    <!-- Nav Container -->
    <div class="nav-container border-bottom">
        <div class="container">
            <nav>
                <ul class="main-nav">
                    <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                            <i class="bi bi-house-door"></i> Beranda
                        </a></li>

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
                            Kontak
                        </a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>