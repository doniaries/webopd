<?php

use App\Livewire\Home;
use App\Livewire\Post;
use App\Livewire\Kontak;
use App\Livewire\Dokumen;
use App\Livewire\VisiMisi;
use App\Livewire\Infografis;
use App\Livewire\Informasi;
use App\Livewire\ProdukHukum;
use App\Livewire\AgendaKegiatan;
use App\Livewire\SambutanPimpinan;
use Illuminate\Support\Facades\Route;
use App\Livewire\Unitkerja as UnitKerja;

// Home/Landing Page
Route::get('/', Home::class)->name('home');

// Berita Routes
Route::get('/berita', [Post::class, 'index'])->name('berita.index');
Route::get('/berita/tag/{tag:slug}', [Post::class, 'tag'])->name('posts.tag');

// Post Routes (Legacy)
Route::get('/post', [Post::class, 'index'])->name('post.index');
Route::get('/post/kategori/{slug}', Post::class)->name('post.kategori');
Route::get('/post/tag/{tag:slug}', [Post::class, 'tag'])->name('post.tag');
Route::get('/post/{slug}', Post::class)->name('post.show');

// Informasi Routes
Route::get('/informasi', Informasi::class)->name('informasi.index');
Route::get('/informasi/kategori/{slug}', Informasi::class)->name('informasi.kategori');
Route::get('/informasi/{slug}', \App\Livewire\InformasiDetail::class)->name('informasi.show');

// Profil Instansi Routes
Route::get('/profil/sambutan', SambutanPimpinan::class)->name('profil.sambutan');
Route::get('/sambutan-pimpinan', SambutanPimpinan::class)->name('sambutan-pimpinan'); // Alias untuk kompatibilitas dengan template
Route::get('/profil/visi-misi', VisiMisi::class)->name('profil.visi-misi');
Route::get('/visi-misi', VisiMisi::class)->name('visi-misi'); // Alias untuk kompatibilitas dengan template
Route::get('/profil/unit-kerja', UnitKerja::class)->name('profil.unit-kerja');
Route::get('/struktur-organisasi', UnitKerja::class)->name('struktur-organisasi'); // Alias untuk kompatibilitas dengan template


// Produk Hukum
Route::get('/produk-hukum', ProdukHukum::class)->name('produk-hukum.index');
// Alias untuk kompatibilitas dengan template
Route::get('/produk-hukum', ProdukHukum::class)->name('produk-hukum');


// Infografis
Route::get('/infografis', Infografis::class)->name('infografis.index');
// Alias untuk kompatibilitas dengan template
Route::get('/infografis', Infografis::class)->name('infografis');

// Agenda Kegiatan
Route::get('/agenda-kegiatan', AgendaKegiatan::class)->name('agenda-kegiatan.index');
Route::get('/agenda/{slug}', AgendaKegiatan::class)->name('agenda.show');

// Dokumen
Route::get('/dokumen', Dokumen::class)->name('dokumen.index');
Route::get('/dokumen', Dokumen::class)->name('dokumen'); // Alias untuk kompatibilitas dengan template

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

// Authentication Routes
Route::get('/login', function () {
    return redirect('/admin/login');
})->name('login');

Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');
