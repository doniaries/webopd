<header id="header" class="header sticky-top">
    <style>
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
        }

        .header-content {
            display: flex;
            width: 100%;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
        }

        /* Logo */
        .logo {
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        /* Menu container */
        .menu-container {
            background-color: white;
            border-bottom: 1px solid #e0e0e0;
        }

        .menu-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
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
            padding: 15px 20px;
        }

        .navmenu>ul>li>a {
            color: #333;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .navmenu>ul>li>a:hover,
        .navmenu>ul>li>a.active {
            color: #0d6efd;
        }

        /* Waktu dan Tanggal */
        .datetime-container {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .time,
        .date {
            line-height: 1.2;
            white-space: nowrap;
        }
    </style>
    <div class="header-container">
        <div class="header-wrapper">
            <div class="header-content">
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
                    <div class="d-flex align-items-center">
                        <img src="{{ $logoUrl }}" alt="Logo" class="img-fluid" style="max-height: 50px;">
                        <div class="ms-2 d-flex flex-column">
                            <span class="text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px; color: #6c757d;">WEBSITE</span>
                            <h1 class="sitename m-0" style="font-size: 1.2rem; line-height: 1.2;">{{ $siteName }}</h1>
                        </div>
                        <div class="d-flex align-items-center ms-3" style="border-left: 1px solid #dee2e6; padding-left: 15px;">
                            <img src="{{ asset('images/bangga.png') }}" alt="Bangga" class="img-fluid me-2" style="max-height: 40px;">
                            <img src="{{ asset('images/berakhlak.png') }}" alt="Berakhlak" class="img-fluid" style="max-height: 40px;">
                        </div>
                    </div>
                </a>

                <div class="text-center my-2">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="bi bi-clock me-2"></i>
                        <span id="jam" style="font-size: 1.2rem;"></span>
                    </div>
                    <span id="tanggal" style="font-size: 1.2rem;"></span>
                </div>

                <script>
                    const dateElement = document.getElementById('tanggal');
                    const timeElement = document.getElementById('jam');

                    // Indonesian month names
                    const monthNames = [
                        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                    ];

                    // Indonesian day names
                    const dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

                    function refreshTime() {
                        const now = new Date();

                        // Format date: Hari, DD MMMM YYYY (e.g., Senin, 23 Juni 2025)
                        const dayName = dayNames[now.getDay()];
                        const dateNum = now.getDate();
                        const monthName = monthNames[now.getMonth()];
                        const year = now.getFullYear();

                        // Format time: HH:MM:SS
                        const hours = String(now.getHours()).padStart(2, '0');
                        const minutes = String(now.getMinutes()).padStart(2, '0');
                        const seconds = String(now.getSeconds()).padStart(2, '0');

                        dateElement.textContent = `${dayName}, ${dateNum} ${monthName} ${year}`;
                        timeElement.textContent = `${hours}:${minutes}:${seconds} WIB`; // WIB for Western Indonesian Time

                        // Update the time every second
                        setTimeout(refreshTime, 1000);
                    }

                    // Initial call
                    refreshTime();
                </script>

                <div class="d-flex align-items-center">
                    {{-- <div id="darkModeToggle" class="dark-mode-toggle me-2">
                        <i class="bi bi-sun-fill" id="lightIcon"></i>
                        <i class="bi bi-moon-fill d-none" id="darkIcon"></i>
                    </div> --}}
                    <a class="btn-getstarted" href="{{ route('login') }}">Login</a>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="menu-container">
        <div class="menu-wrapper">
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
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
</header>
