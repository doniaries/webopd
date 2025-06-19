<footer id="footer" class="footer">

    <div class="container footer-top">
        <div class="row gy-4">
            <div class="col-lg-4 col-md-6 footer-about">
                <a href="{{ url('/') }}" class="logo d-flex align-items-center">
                    <span class="sitename">WebOPD</span>
                </a>
                <div class="footer-contact pt-3">
                    <p>{{ $pengaturan->alamat_instansi ?? 'Jl. Contoh No. 123' }}</p>
                    <p>{{ $pengaturan->kota_instansi ?? 'Kota' }}, {{ $pengaturan->kode_pos_instansi ?? '12345' }}</p>
                    <p class="mt-3"><strong>Telepon:</strong>
                        <span>{{ $pengaturan->no_telp_instansi ?? '+62 123 4567 890' }}</span>
                    </p>
                    <p><strong>Email:</strong> <span>{{ $pengaturan->email_instansi ?? 'info@webopd.com' }}</span></p>
                </div>
                <div class="social-links d-flex mt-4">
                    <a href="{{ $pengaturan->twitter_url ?? '#' }}" target="_blank"><i class="bi bi-twitter-x"></i></a>
                    <a href="{{ $pengaturan->facebook_url ?? '#' }}" target="_blank"><i class="bi bi-facebook"></i></a>
                    <a href="{{ $pengaturan->instagram_url ?? '#' }}" target="_blank"><i
                            class="bi bi-instagram"></i></a>
                    <a href="{{ $pengaturan->youtube_url ?? '#' }}" target="_blank"><i class="bi bi-youtube"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-md-3 footer-links">
                <h4>Tautan Cepat</h4>
                <ul>
                    <li><a href="{{ url('/') }}">Beranda</a></li>
                    <li><a href="{{ route('visi-misi') }}">Visi & Misi</a></li>
                    <li><a href="{{ route('sambutan-pimpinan') }}">Sambutan Pimpinan</a></li>
                    <li><a href="{{ route('berita.index') }}">Berita</a></li>
                    <li><a href="{{ route('kontak') }}">Kontak</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-3 footer-links">
                <h4>Informasi</h4>
                <ul>
                    <li><a href="{{ route('infografis') }}">Infografis</a></li>
                    <li><a href="{{ route('dokumen') }}">Dokumen</a></li>
                    <li><a href="{{ route('produk-hukum') }}">Produk Hukum</a></li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-6 footer-newsletter">
                <h4>Peta Lokasi</h4>
                <div class="map-container" style="height: 200px; width: 100%;">
                    <!-- Ganti dengan iframe Google Maps lokasi instansi -->
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.2904357236226!2d106.82687551476908!3d-6.175387395533356!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5d2e764b12d%3A0x3d2ad6e1e0e9bcc8!2sMonumen%20Nasional!5e0!3m2!1sid!2sid!4v1651234567890!5m2!1sid!2sid"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>

        </div>
    </div>

    <div class="container copyright text-center mt-4">
        <p>© <span>Copyright</span> <strong class="px-1 sitename">{{ $siteName }}</strong>
            <span>{{ date('Y') }}. All Rights
                Reserved</span>
        </p>
        <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you've purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
            Designed by <a href="https://doniaries.com/">Don Borland</a>
        </div>
    </div>

</footer>
