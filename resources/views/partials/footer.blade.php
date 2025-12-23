<!-- Pre-Footer Section -->
<div class="bg-gray-100 border-t border-gray-200 py-8">
    <div class="container">
        <div class="text-center">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Tetap Terhubung</h3>
            <div class="flex justify-center space-x-6">
                @if (!empty($pengaturan->facebook))
                <a href="{{ $pengaturan->facebook }}" target="_blank"
                    class="text-gray-600 hover:text-blue-600 transition-colors duration-300">
                    <i class="bi bi-facebook text-2xl"></i>
                </a>
                @endif
                @if (!empty($pengaturan->twitter))
                <a href="{{ $pengaturan->twitter }}" target="_blank"
                    class="text-gray-600 hover:text-blue-400 transition-colors duration-300">
                    <i class="bi bi-twitter-x text-2xl"></i>
                </a>
                @endif
                @if (!empty($pengaturan->instagram))
                <a href="{{ $pengaturan->instagram }}" target="_blank"
                    class="text-gray-600 hover:text-pink-500 transition-colors duration-300">
                    <i class="bi bi-instagram text-2xl"></i>
                </a>
                @endif
                @if (!empty($pengaturan->youtube))
                <a href="{{ $pengaturan->youtube }}" target="_blank"
                    class="text-gray-600 hover:text-red-600 transition-colors duration-300">
                    <i class="bi bi-youtube text-2xl"></i>
                </a>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Main Footer -->
<footer id="footer" class="footer" style="border-top: 1px solid #e1e1e1; background-color: #f8f9fa;">
    <div class="container footer-top">
        <div class="row gy-4">
            <div class="col-lg-4 col-md-6 footer-about">
                <a href="{{ url('/') }}" class="logo d-flex align-items-center">
                    <span class="sitename">{{ $pengaturan->name ?? config('app.name') }}</span>
                </a>
                <div class="footer-contact pt-3">
                    @if (!empty($pengaturan->alamat_instansi))
                    <p>{{ $pengaturan->alamat_instansi }}</p>
                    @else
                    <p>Jl. Contoh No. 123</p>
                    @endif

                    @if (!empty($pengaturan->no_telp_instansi))
                    <p class="mt-3"><strong>Telepon:</strong> <span>{{ $pengaturan->no_telp_instansi }}</span></p>
                    @else
                    <p class="mt-3"><strong>Telepon:</strong> <span>+62 123 4567 890</span></p>
                    @endif

                    @if (!empty($pengaturan->email_instansi))
                    <p><strong>Email:</strong> <span>{{ $pengaturan->email_instansi }}</span></p>
                    @else
                    <p><strong>Email:</strong> <span>info@webopd.com</span></p>
                    @endif
                </div>
                {{-- <div class="social-links d-flex mt-4">
                    <a href="{{ $pengaturan->twitter_url ?? '#' }}" target="_blank"><i class="bi bi-twitter-x"></i></a>
                <a href="{{ $pengaturan->facebook_url ?? '#' }}" target="_blank"><i class="bi bi-facebook"></i></a>
                <a href="{{ $pengaturan->instagram_url ?? '#' }}" target="_blank"><i
                        class="bi bi-instagram"></i></a>
                <a href="{{ $pengaturan->youtube_url ?? '#' }}" target="_blank"><i class="bi bi-youtube"></i></a>
            </div> --}}
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
                <li><a href="{{ route('dokumen.index') }}">Dokumen</a></li>
            </ul>
        </div>

        {{-- <div class="col-lg-4 col-md-6 footer-newsletter">
                <h4>Peta Lokasi</h4>
                <div class="map-container" style="height: 200px; width: 100%;">
                    <!-- Ganti dengan iframe Google Maps lokasi instansi -->
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.2904357236226!2d106.82687551476908!3d-6.175387395533356!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5d2e764b12d%3A0x3d2ad6e1e0e9bcc8!2sMonumen%20Nasional!5e0!3m2!1sid!2sid!4v1651234567890!5m2!1sid!2sid"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div> --}}

    </div>
    </div>

    <div class="container copyright text-center mt-4">
        <p>© <span>Copyright</span> <strong
                class="px-1 sitename">{{ $pengaturan->name ?? config('app.name') }}</strong>
            <span>{{ date('Y') }}. All Rights Reserved</span>
        </p>
        <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you've purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
            {{-- Designed by <a href="https://doniaries.com/">Don Borland</a> --}}
        </div>
    </div>

</footer>