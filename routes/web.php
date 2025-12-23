<?php

use \App\Livewire\Layanan;
use App\Http\Controllers\InformasiController;
use App\Livewire\AgendaKegiatan;
use App\Livewire\Dokumen;
use App\Livewire\Home;
use App\Livewire\Infografis;
use App\Livewire\Informasi;
use App\Livewire\InformasiDetail;
use App\Livewire\Kontak;
use App\Livewire\Post;
use App\Livewire\ProdukHukum;
use App\Livewire\SambutanPimpinan;
use App\Livewire\Slider;
use App\Livewire\UnitKerja;
use App\Livewire\VisiMisi;
use App\Livewire\Pengumuman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;








// Home/Landing Page
Route::get('/', Home::class)->name('home');


// Post Routes (Legacy)
Route::get('/post', [Post::class, 'index'])->name('post.index');
// Route::get('/post/kategori/{slug}', Post::class)->name('post.kategori');
Route::get('/post/tag/{tag:slug}', [Post::class, 'tag'])->name('post.tag');
Route::get('/post/{slug}', Post::class)->name('post.show');

// Pengumuman Routes
Route::get('/pengumuman', Pengumuman::class)->name('pengumuman.index');
Route::get('/pengumuman/{pengumuman:slug}', \App\Livewire\PengumumanDetail::class)->name('pengumuman.show');


// Document Routes
// Route::get('/dokumen', \App\Livewire\Dokumen::class)->name('dokumen');
Route::get('/dokumen/{slug}', \App\Livewire\DokumenDetail::class)->name('dokumen.detail');
Route::get('/dokumen/{slug}/download', [\App\Livewire\DokumenDetail::class, 'download'])->name('dokumen.download');

// Profil Instansi Routes
Route::get('/profil/sambutan', SambutanPimpinan::class)->name('profil.sambutan');
Route::get('/sambutan-pimpinan', SambutanPimpinan::class)->name('sambutan-pimpinan'); // Alias untuk kompatibilitas dengan template
Route::get('/profil/visi-misi', VisiMisi::class)->name('profil.visi-misi');
Route::get('/visi-misi', VisiMisi::class)->name('visi-misi'); // Alias untuk kompatibilitas dengan template
Route::get('/profil/unit-kerja', UnitKerja::class)->name('profil.unit-kerja');
Route::get('/struktur-organisasi', UnitKerja::class)->name('struktur-organisasi'); // Alias untuk kompatibilitas dengan template
Route::get('/profil/unit-kerja/{unitKerja:slug}', [\App\Http\Controllers\UnitKerjaController::class, 'show'])->name('unit-kerja.detail');

// Produk Hukum
// Route::get('/produk-hukum', ProdukHukum::class)->name('produk-hukum.index');
// Alias untuk kompatibilitas dengan template
// Route::get('/produk-hukum', ProdukHukum::class)->name('produk-hukum');

// Layanan
Route::get('/layanan', \App\Livewire\Layanan::class)->name('layanan.index');
Route::get('/layanan/{layanan:slug}', \App\Livewire\LayananDetail::class)->name('layanan.show');


// Infografis
Route::get('/infografis', Infografis::class)->name('infografis.index');
// Alias untuk kompatibilitas dengan template
Route::get('/infografis', Infografis::class)->name('infografis');

// Agenda Kegiatan
Route::get('/agenda', AgendaKegiatan::class)->name('agenda.index');
Route::get('/agenda/{agenda:slug}', \App\Livewire\AgendaDetail::class)
    ->name('agenda.show')
    ->middleware('web');

// Dokumen
Route::get('/dokumen', Dokumen::class)->name('dokumen.index');

// Kontak
Route::get('/kontak', Kontak::class)->name('kontak');

// Legacy routes for backward compatibility
Route::get('/posts', Post::class)->name('posts.index');
Route::get('/posts/{slug}', Post::class)->name('posts.show');
Route::get('/agenda', AgendaKegiatan::class)->name('agenda.index');

// Berita routes (alias for Post)
Route::get('/berita', Post::class)->name('berita.index');
Route::get('/berita/kategori/{slug}', Post::class)->name('berita.kategori');
Route::get('/berita/{slug}', Post::class)->name('berita.show');

Route::get('/tag/{tag}', Slider::class)->name('slider.tag');



// Authentication Routes
Route::get('/login', function () {
    return redirect('/admin/login');
})->name('login');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Route untuk mengunduh file
Route::get('/download/{file}', function ($file) {
    // Hapus awalan 'public/' jika ada
    $filePath = str_starts_with($file, 'public/') ? $file : 'public/' . $file;

    if (Storage::exists($filePath)) {
        // Dapatkan nama file asli
        $originalName = basename($filePath);

        // Unduh file dengan nama asli
        return Storage::download($filePath, $originalName, [
            'Content-Type' => Storage::mimeType($filePath),
            'Content-Length' => Storage::size($filePath),
            'Content-Disposition' => 'attachment; filename="' . $originalName . '"',
        ]);
    }

    return back()->with('error', 'File tidak ditemukan');
})->name('file.download')->middleware('web');
