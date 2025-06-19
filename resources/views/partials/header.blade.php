<header id="header" class="header d-flex align-items-center sticky-top">
    <style>
        .sticky-top {
            position: sticky;
            top: 0;
            z-index: 1020;
            background-color: white;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .sticky-top .header-container {
            padding: 5px 0;
            transition: all 0.3s ease;
        }

        /* Tambahkan margin kiri untuk logo dan judul */
        .logo {
            margin-left: 20px;
        }
    </style>
    <div
        class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

        <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto me-xl-0">
            @php
                $logoUrl = '';
                $siteName = 'WebOPD'; // Default value

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
            <img src="{{ $logoUrl }}" alt="Logo" class="img-fluid" style="max-height: 50px;">
            <div class="ms-2 d-flex flex-column">
                <span class="text-uppercase"
                    style="font-size: 0.8rem; letter-spacing: 1px; color: #6c757d;">WEBSITE</span>
                <h1 class="sitename m-0" style="font-size: 1.2rem; line-height: 1.2;">{{ $siteName }}</h1>
            </div>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Beranda</a></li>
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
                                class="{{ request()->routeIs('produk-hukum') ? 'active' : '' }}">Produk Hukum</a></li>
                        <li><a href="{{ route('agenda-kegiatan.index') }}"
                                class="{{ request()->routeIs('agenda-kegiatan.index') || request()->routeIs('agenda.show') ? 'active' : '' }}">Agenda
                                Kegiatan</a></li>
                        <li><a href="{{ route('pengumuman.index') }}"
                                class="{{ request()->routeIs('pengumuman.index') || request()->routeIs('pengumuman.show') ? 'active' : '' }}">Pengumuman</a>
                        </li>
                    </ul>
                </li>

                <li><a href="{{ route('kontak') }}"
                        class="{{ request()->routeIs('kontak') ? 'active' : '' }}">Kontak</a></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <div class="d-flex align-items-center">
            {{-- <div id="darkModeToggle" class="dark-mode-toggle me-2">
                <i class="bi bi-sun-fill" id="lightIcon"></i>
                <i class="bi bi-moon-fill d-none" id="darkIcon"></i>
            </div> --}}
            <a class="btn-getstarted" href="{{ route('login') }}">Login</a>
        </div>

    </div>
</header>
