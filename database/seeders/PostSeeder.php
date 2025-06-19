<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostSeeder extends Seeder
{
    /**
     * The Faker instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * Create a new seeder instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->faker = \Faker\Factory::create('id_ID');
    }
    public function run(): void
    {
        try {
            // Hapus data lama dari database
            $this->command->info('Menghapus data post lama...');

            // Ambil semua post untuk menghapus gambar terkait
            $oldPosts = Post::all();
            foreach ($oldPosts as $oldPost) {
                // Hapus file gambar jika ada
                if ($oldPost->foto_utama) {
                    $imagePath = 'foto-utama/' . $oldPost->foto_utama;
                    if (Storage::disk('public')->exists($imagePath)) {
                        Storage::disk('public')->delete($imagePath);
                        $this->command->info("Menghapus gambar: {$imagePath}");
                    }
                }
            }

            // Hapus semua post dari database
            $deletedCount = Post::query()->delete();
            $this->command->info("Berhasil menghapus {$deletedCount} post lama.");

            // Hapus semua file di folder public/foto-utama
            $this->command->info('Menghapus semua file di folder public/foto-utama...');
            $publicFotoUtamaPath = public_path('foto-utama');
            $deletedFilesCount = 0;

            // Pastikan folder public/foto-utama ada
            if (!file_exists($publicFotoUtamaPath)) {
                mkdir($publicFotoUtamaPath, 0777, true);
                $this->command->info("Folder public/foto-utama dibuat karena belum ada.");
            }

            // Hapus semua file di folder
            $files = glob($publicFotoUtamaPath . '/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                    $deletedFilesCount++;
                }
            }

            $this->command->info("Berhasil menghapus {$deletedFilesCount} file dari folder public/foto-utama.");

            // Pastikan direktori penyimpanan ada
            if (!Storage::disk('public')->exists('posts')) {
                Storage::disk('public')->makeDirectory('posts');
            }

            // Pastikan direktori images ada di public
            if (!file_exists(public_path('images'))) {
                mkdir(public_path('images'), 0777, true);
            }
            // Get or create a team
            $team = Team::first();
            if (!$team) {
                $team = Team::create(['name' => 'Tim Default']);
            }

            // Get or create admin user
            $user = User::firstOrCreate(
                ['email' => 'admin@example.com'],
                [
                    'name' => 'Admin',
                    'password' => bcrypt('password'),
                    'email_verified_at' => now(),
                ]
            );

            // Ensure user is attached to the team
            if (!$user->teams->contains($team->id)) {
                $user->teams()->attach($team);
            }

            // Get categories from database that were seeded by CategorySeeder
            $categories = Category::where('team_id', $team->id)
                ->where('is_active', true)
                ->get();

            if ($categories->isEmpty()) {
                $this->command->warn('No active categories found. Please run CategorySeeder first!');
                return;
            }

            $categoryIds = $categories->pluck('id')->toArray();

            // Pastikan direktori foto-utama ada di storage
            if (!Storage::disk('public')->exists('foto-utama')) {
                Storage::disk('public')->makeDirectory('foto-utama');
            }

            // Pastikan direktori foto-tambahan ada di storage
            if (!Storage::disk('public')->exists('foto-tambahan')) {
                Storage::disk('public')->makeDirectory('foto-tambahan');
            }

            // Daftar gambar default dari Pexels (hanya landscape)
            $pexelsImages = [
                'https://images.pexels.com/photos/3183150/pexels-photo-3183150.jpeg?auto=compress&cs=tinysrgb&w=1600', // Office team (landscape)
                'https://images.pexels.com/photos/3184418/pexels-photo-3184418.jpeg?auto=compress&cs=tinysrgb&w=1600', // Meeting (landscape)
                'https://images.pexels.com/photos/3184296/pexels-photo-3184296.jpeg?auto=compress&cs=tinysrgb&w=1600', // Team discussion (landscape)
                'https://images.pexels.com/photos/3184339/pexels-photo-3184339.jpeg?auto=compress&cs=tinysrgb&w=1600', // Office workspace (landscape)
                'https://images.pexels.com/photos/3183197/pexels-photo-3183197.jpeg?auto=compress&cs=tinysrgb&w=1600', // Team meeting (landscape)
                'https://images.pexels.com/photos/3183153/pexels-photo-3183153.jpeg?auto=compress&cs=tinysrgb&w=1600', // Office team meeting (landscape)
                'https://images.pexels.com/photos/3183171/pexels-photo-3183171.jpeg?auto=compress&cs=tinysrgb&w=1600', // Office team (landscape)
                'https://images.pexels.com/photos/3184287/pexels-photo-3184287.jpeg?auto=compress&cs=tinysrgb&w=1600', // Office workspace (landscape)
                'https://images.pexels.com/photos/3183159/pexels-photo-3183159.jpeg?auto=compress&cs=tinysrgb&w=1600', // Office meeting (landscape)
                'https://images.pexels.com/photos/3183157/pexels-photo-3183157.jpeg?auto=compress&cs=tinysrgb&w=1600'  // Team discussion (landscape)
            ];

            // Unduh gambar default jika folder kosong
            $availableImages = [];
            foreach ($pexelsImages as $index => $imageUrl) {
                $imageName = 'default_' . ($index + 1) . '.jpg';
                $imagePath = 'foto-utama/' . $imageName;

                if (!Storage::disk('public')->exists($imagePath)) {
                    try {
                        $imageContent = file_get_contents($imageUrl);
                        if ($imageContent !== false) {
                            Storage::disk('public')->put($imagePath, $imageContent);
                            $this->command->info('Downloaded default image: ' . $imageName);
                        }
                    } catch (\Exception $e) {
                        $this->command->error('Failed to download image: ' . $e->getMessage());
                        continue;
                    }
                }

                $availableImages[] = $imagePath;
            }

            // Judul berita Indonesia
            $indonesianTitles = [
                'Pemerintah Daerah Luncurkan Program Pemberdayaan UMKM',
                'Dinas Kesehatan Gelar Vaksinasi Massal di Pusat Kota',
                'Bupati Resmikan Pembangunan Jalan Baru di Kecamatan',
                'Dinas Pendidikan Adakan Pelatihan Guru di Era Digital',
                'Pemkab Gelar Festival Budaya Daerah',
                'Dinas Pertanian Sosialisasikan Program Ketahanan Pangan',
                'Bupati Tinjau Lokasi Banjir di Desa Terdampak',
                'Dinas Sosial Salurkan Bantuan untuk Warga Kurang Mampu',
                'Pemkab Gelar Musrenbang Tingkat Kecamatan',
                'Dinas Pariwisata Promosikan Destinasi Wisata Lokal',
                'Bupati Hadiri Peresmian Gedung Sekolah Baru',
                'Dinas Lingkungan Hidup Lakukan Penghijauan di Kawasan Kritis',
                'Pemkab Gelar Pelatihan Kewirausahaan untuk Pemuda',
                'Dinas PUPR Perbaiki Infrastruktur Jalan Rusak',
                'Bupati Buka Turnamen Olahraga Antar Kecamatan',
                'Dinas Kominfo Sosialisasikan Layanan Publik Digital',
                'Pemkab Gelar Rapat Koordinasi Penanggulangan Bencana',
                'Dinas Koperasi Adakan Bazar UMKM',
                'Bupati Kunjungi Sentra Industri Kerajinan Lokal',
                'Dinas Perhubungan Tata Ulang Rute Angkutan Umum'
            ];

            // Konten berita Indonesia
            $indonesianContents = [
                '<p>Pemerintah Kabupaten telah meluncurkan program pemberdayaan UMKM yang bertujuan untuk meningkatkan daya saing usaha mikro, kecil, dan menengah di wilayah ini. Program ini mencakup pelatihan manajemen usaha, bantuan permodalan, dan pendampingan pemasaran produk.</p><p>Menurut Kepala Dinas Koperasi dan UMKM, program ini diharapkan dapat membantu pelaku UMKM untuk bangkit dari dampak pandemi COVID-19. "Kami berharap dengan adanya program ini, UMKM di daerah kami dapat berkembang dan bersaing di pasar yang lebih luas," ujarnya.</p><p>Program ini akan dilaksanakan secara bertahap di seluruh kecamatan dan diharapkan dapat menjangkau setidaknya 1.000 pelaku UMKM dalam tahun ini.</p>',
                '<p>Dinas Kesehatan Kabupaten menggelar vaksinasi massal COVID-19 di pusat kota. Kegiatan ini merupakan bagian dari upaya pemerintah untuk mempercepat cakupan vaksinasi di wilayah tersebut.</p><p>Vaksinasi dilaksanakan di Gedung Serbaguna dan ditargetkan dapat melayani hingga 1.000 orang per hari. Masyarakat yang hadir tampak antusias dan tertib mengikuti prosedur yang telah ditetapkan.</p><p>Kepala Dinas Kesehatan mengatakan bahwa kegiatan ini akan terus dilakukan hingga target cakupan vaksinasi tercapai. "Kami mengajak seluruh masyarakat untuk berpartisipasi dalam program vaksinasi ini demi kesehatan bersama," ujarnya.</p>',
                '<p>Bupati meresmikan pembangunan jalan baru sepanjang 5 kilometer yang menghubungkan beberapa desa di Kecamatan. Pembangunan jalan ini diharapkan dapat meningkatkan aksesibilitas dan mobilitas warga serta mendorong pertumbuhan ekonomi di wilayah tersebut.</p><p>Dalam sambutannya, Bupati menyampaikan bahwa pembangunan infrastruktur merupakan salah satu prioritas pemerintah daerah. "Kami berkomitmen untuk terus meningkatkan kualitas infrastruktur di seluruh wilayah kabupaten," ujarnya.</p><p>Pembangunan jalan ini menggunakan anggaran dari APBD dan ditargetkan selesai dalam waktu enam bulan.</p>',
                '<p>Dinas Pendidikan Kabupaten mengadakan pelatihan bagi guru-guru sekolah dasar dan menengah tentang metode pembelajaran di era digital. Pelatihan ini diikuti oleh 200 guru dari berbagai sekolah di kabupaten tersebut.</p><p>Materi pelatihan mencakup penggunaan teknologi informasi dalam pembelajaran, pengembangan konten digital, dan strategi pembelajaran jarak jauh. Para peserta juga dibekali dengan keterampilan untuk menggunakan berbagai platform pembelajaran online.</p><p>Kepala Dinas Pendidikan berharap pelatihan ini dapat meningkatkan kompetensi guru dalam menghadapi tantangan pendidikan di era digital. "Guru harus mampu beradaptasi dengan perkembangan teknologi agar dapat memberikan pembelajaran yang berkualitas kepada siswa," ujarnya.</p>',
                '<p>Pemerintah Kabupaten menggelar Festival Budaya Daerah yang menampilkan berbagai kesenian dan tradisi lokal. Festival ini diselenggarakan di alun-alun kota dan berlangsung selama tiga hari.</p><p>Berbagai pertunjukan seni tradisional seperti tari, musik, dan teater rakyat ditampilkan oleh kelompok kesenian dari berbagai kecamatan. Selain itu, festival ini juga menampilkan pameran kerajinan tangan dan kuliner khas daerah.</p><p>Bupati dalam sambutannya menekankan pentingnya melestarikan budaya lokal di tengah arus globalisasi. "Festival ini merupakan upaya kami untuk menjaga dan mempromosikan kekayaan budaya daerah kita," ujarnya.</p>'
            ];

            // Create 10 posts per month for the last 2 months
            $this->command->info('Creating 10 posts per month for the last 2 months...');

            $currentMonth = now()->startOfMonth();
            $lastMonth = now()->subMonth()->startOfMonth();

            $months = [$lastMonth, $currentMonth];

            foreach ($months as $monthStart) {
                $this->command->info("Creating posts for " . $monthStart->format('F Y') . "...");

                // Create 10 posts for this month
                for ($i = 1; $i <= 10; $i++) {
                    // Random day in the month
                    $postDate = $monthStart->copy()->addDays(rand(0, $monthStart->daysInMonth - 1))
                        ->setHour(rand(8, 16))
                        ->setMinute(rand(0, 59));

                    // Random category
                    $categoryId = $this->faker->randomElement($categoryIds);

                    // Create post
                    $post = Post::create([
                        'title' => $this->faker->sentence(8),
                        'slug' => Str::slug($this->faker->sentence(5)),
                        // 'excerpt' => $this->faker->paragraph(2),
                        'content' => $this->faker->randomElement($indonesianContents),
                        'published_at' => $postDate,
                        'status' => 'published',
                        'category_id' => $categoryId,
                        'user_id' => $user->id,
                        'team_id' => $team->id,
                        'views' => $this->faker->numberBetween(10, 1000),
                        'foto_utama' => $this->faker->randomElement($availableImages),
                        'created_at' => $postDate,
                        'updated_at' => $postDate,
                    ]);

                    // Assign tags (optional)
                    if ($i % 3 === 0) {
                        $tags = [];
                        for ($j = 0; $j < rand(1, 3); $j++) {
                            $tag = Tag::firstOrCreate(
                                ['name' => $this->faker->word],
                                [
                                    'slug' => Str::slug($this->faker->word),
                                    'team_id' => $team->id
                                ]
                            );
                            $tags[$tag->id] = ['team_id' => $team->id];
                        }
                        $post->tags()->sync($tags);
                    }
                }
            }

            $this->command->info('Successfully created 10 posts per month for the last 2 months.');

            // Get total post count
            $totalPosts = Post::count();
            $this->command->info("Total posts in database: {$totalPosts}");
        } catch (\Exception $e) {
            $this->command->error('Error creating posts: ' . $e->getMessage());
            $this->command->error($e->getTraceAsString());
            throw $e;
        }
    }
}
