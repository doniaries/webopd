<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Tag;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Set locale to Indonesia
        $faker = \Faker\Factory::create('id_ID');

        // Daftar kata kunci untuk berita
        $topics = ['Pemerintahan', 'Ekonomi', 'Pendidikan', 'Kesehatan', 'Teknologi', 'Politik', 'Olahraga', 'Budaya', 'Lingkungan', 'Sosial'];
        $locations = ['Jakarta', 'Bandung', 'Surabaya', 'Medan', 'Makassar', 'Yogyakarta', 'Bali', 'Lombok', 'Palembang', 'Balikpapan'];
        $organizations = ['Kementerian', 'Dinas', 'Pemerintah Daerah', 'Dewan Perwakilan', 'Badan', 'Lembaga', 'Dinas Kesehatan', 'Dinas Pendidikan', 'Dinas Sosial', 'Dinas Perhubungan'];

        // Generate judul berita
        $title = $faker->randomElement([
            'Pemerintah ' . $faker->randomElement($locations) . ' ' . $faker->randomElement(['Luncurkan', 'Tandatangani', 'Sosialisasikan', 'Canangkan', 'Resmikan']) . ' ' . $faker->randomElement(['Program', 'Kegiatan', 'Kebijakan', 'Fasilitas', 'Infrastruktur']) . ' ' . $faker->randomElement($topics),
            $faker->randomElement($organizations) . ' ' . $faker->randomElement($locations) . ' ' . $faker->randomElement(['Gelar', 'Laksanakan', 'Selenggarakan', 'Adakan']) . ' ' . $faker->randomElement(['Rapat', 'Pelatihan', 'Lomba', 'Pameran', 'Workshop', 'Seminar']) . ' ' . $faker->randomElement($topics),
            $faker->randomElement(['Inovasi', 'Gagasan', 'Program', 'Kebijakan']) . ' Baru di Bidang ' . $faker->randomElement($topics) . ' ' . $faker->randomElement(['Diluncurkan', 'Diresmikan', 'Dikembangkan', 'Diperkenalkan']) . ' di ' . $faker->randomElement($locations),
            'Peningkatan ' . $faker->randomElement(['Kualitas', 'Pelayanan', 'Akses']) . ' di Sektor ' . $faker->randomElement($topics) . ' ' . $faker->randomElement($locations) . ' ' . $faker->randomElement(['Membuahkan Hasil', 'Diapresiasi Masyarakat', 'Dukung Pembangunan'])
        ]);

        // Generate isi berita
        $intro = "<p>" . $faker->randomElement([
            "<strong>" . $faker->randomElement($locations) . "</strong> - " . $faker->randomElement($organizations) . " " . $faker->randomElement($locations) . " " . $faker->randomElement(['mengadakan', 'menyelenggarakan', 'melaksanakan', 'menggelar']) . " " . $faker->randomElement(['kegiatan', 'program', 'kebijakan', 'pelatihan']) . " dalam rangka " . $faker->randomElement(['meningkatkan kualitas', 'mengembangkan potensi', 'memperkuat kapasitas', 'mengoptimalkan pelayanan']) . " " . $faker->randomElement($topics) . " di wilayah setempat.",
            "<strong>" . $faker->randomElement($locations) . "</strong> - " . "Baru-baru ini, " . $faker->randomElement($organizations) . " " . $faker->randomElement($locations) . " " . $faker->randomElement(['mengumumkan', 'meluncurkan', 'meresmikan', 'memperkenalkan']) . " " . $faker->randomElement(['program', 'kebijakan', 'inovasi', 'terobosan']) . " terbaru di bidang " . $faker->randomElement($topics) . " yang diharapkan dapat " . $faker->randomElement(['meningkatkan kesejahteraan', 'memberikan manfaat', 'menjadi solusi', 'memperbaiki kualitas']) . " " . $faker->randomElement(['masyarakat', 'dunia usaha', 'dunia pendidikan', 'lingkungan sekitar']) . "."
        ]) . "</p>";

        // Generate isi utama
        $mainContent = "";
        $paragraphs = [];

        // Paragraf 1: Latar belakang
        $paragraphs[] = "<p>" . $faker->randomElement([
            "Kegiatan ini dilaksanakan sebagai wujud nyata " . $faker->randomElement(['komitmen', 'tanggung jawab', 'upaya nyata']) . " " . $faker->randomElement($organizations) . " " . $faker->randomElement($locations) . " dalam " . $faker->randomElement(['meningkatkan', 'mengembangkan', 'memajukan', 'mengoptimalkan']) . " " . $faker->randomElement(['pelayanan publik', 'kualitas hidup masyarakat', 'pembangunan daerah', 'sektor ' . $faker->randomElement($topics)]) . " di wilayah setempat. " . $faker->randomElement(['Hal ini sejalan dengan', 'Ini merupakan implementasi dari', 'Program ini merupakan bagian dari']) . " " . $faker->randomElement(['rencana strategis', 'program kerja', 'kebijakan pembangunan', 'visi misi pembangunan']) . " yang telah ditetapkan sebelumnya.",
            "Program ini merupakan bagian integral dari " . $faker->randomElement(['rencana strategis', 'program kerja', 'kebijakan pembangunan', 'agenda prioritas']) . " yang telah disusun oleh " . $faker->randomElement($organizations) . " " . $faker->randomElement($locations) . " untuk " . $faker->randomElement(['mempercepat', 'mendorong', 'mengakselerasi']) . " " . $faker->randomElement(['pembangunan di berbagai sektor', 'pertumbuhan ekonomi daerah', 'peningkatan kualitas sumber daya manusia', 'pembangunan infrastruktur']) . ". " . $faker->randomElement(['Melalui program ini, diharapkan dapat', 'Inisiatif ini diharapkan mampu', 'Program ini bertujuan untuk']) . " " . $faker->randomElement(['memberikan dampak positif', 'menciptakan perubahan signifikan', 'memberikan manfaat nyata']) . " bagi " . $faker->randomElement(['seluruh lapisan masyarakat', 'dunia usaha dan industri', 'dunia pendidikan', 'lingkungan sekitar']) . " di " . $faker->randomElement($locations) . "."
        ]) . "</p>";

        // Paragraf 2: Detail kegiatan
        $paragraphs[] = "<p>" . $faker->randomElement([
            "Dalam pelaksanaannya, " . $faker->randomElement($organizations) . " " . $faker->randomElement($locations) . " menjelaskan bahwa " . $faker->randomElement(['kegiatan', 'program', 'inisiatif']) . " ini akan berlangsung selama " . $faker->numberBetween(1, 12) . " bulan ke depan dengan melibatkan berbagai " . $faker->randomElement(['pemangku kepentingan', 'stakeholder terkait', 'elemen masyarakat', 'instansi pemerintah']) . " setempat. " . $faker->randomElement(['Tidak hanya itu,', 'Selain itu,', 'Lebih lanjut,']) . " program ini juga akan menjangkau " . $faker->numberBetween(5, 20) . " " . $faker->randomElement(['desa/kelurahan', 'kecamatan', 'wilayah binaan']) . " di seluruh " . $faker->randomElement($locations) . " dengan total anggaran mencapai Rp " . number_format($faker->numberBetween(100000000, 1000000000), 0, ',', '.') . ".",
            "Menurut penjelasan dari " . $faker->randomElement(['Kepala', 'Perwakilan', 'Plt. Kepala']) . " " . $faker->randomElement($organizations) . " " . $faker->randomElement($locations) . ", program ini diharapkan dapat memberikan " . $faker->randomElement(['dampak positif', 'manfaat nyata', 'perubahan signifikan']) . " bagi " . $faker->randomElement(['masyarakat', 'dunia usaha', 'dunia pendidikan', 'lingkungan']) . " di wilayah tersebut. " . $faker->randomElement(['"Kami berkomitmen untuk', '"Melalui program ini, kami berupaya', '"Ini merupakan wujud nyata komitmen kami dalam']) . " " . $faker->randomElement(['meningkatkan kualitas pelayanan publik', 'memberikan yang terbaik bagi masyarakat', 'mewujudkan pembangunan yang berkelanjutan']) . "," . $faker->randomElement(['" ujarnya.', '" tegasnya.', '" jelasnya.']) . " " . $faker->randomElement(['Lebih lanjut dijelaskan bahwa', 'Dia juga menambahkan bahwa', 'Tidak hanya itu, disebutkan pula bahwa']) . " program ini akan terus dipantau dan dievaluasi secara " . $faker->randomElement(['berkala', 'rutin', 'berkelanjutan']) . " untuk memastikan " . $faker->randomElement(['tujuan yang telah ditetapkan dapat tercapai', 'manfaatnya dapat dirasakan secara merata', 'pelaksanaannya berjalan sesuai rencana']) . "."
        ]) . "</p>";

        // Paragraf 3: Dampak/harapan
        $paragraphs[] = "<p>" . $faker->randomElement([
            $faker->randomElement(['Kepala', 'Sekretaris', 'Kepala Bidang']) . " " . $faker->randomElement($organizations) . " " . $faker->randomElement($locations) . ", " . $faker->name() . ", dalam sambutannya menyampaikan " . $faker->randomElement(['harapan besar', 'optimisme', 'dukungan penuh']) . " terhadap " . $faker->randomElement(['program', 'kegiatan', 'inisiatif']) . " ini. \"" . $faker->randomElement(['Kami berharap', 'Kami yakin', 'Kami percaya']) . " bahwa " . $faker->randomElement(['program ini dapat menjadi solusi', 'inisiatif ini akan memberikan dampak positif', 'kegiatan ini mampu menciptakan perubahan']) . " bagi " . $faker->randomElement(['masyarakat', 'dunia usaha', 'dunia pendidikan', 'lingkungan']) . " di " . $faker->randomElement($locations) . "," . $faker->randomElement(['" ujarnya dengan penuh semangat.', '" tuturnya dengan penuh keyakinan.', '" ungkapnya dengan penuh harap.']) . " " . $faker->randomElement(['Menurutnya,', 'Dia menambahkan,', 'Lebih lanjut disampaikannya,']) . " " . $faker->randomElement(['program ini merupakan bagian dari', 'inisiatif ini sejalan dengan', 'kegiatan ini merupakan wujud nyata dari']) . " " . $faker->randomElement(['komitmen pemerintah', 'strategi pembangunan berkelanjutan', 'visi pembangunan jangka menengah']) . " dalam " . $faker->randomElement(['meningkatkan kesejahteraan masyarakat', 'mempercepat pembangunan di berbagai sektor', 'mewujudkan tata kelola pemerintahan yang baik']) . ".",
            "Sementara itu, " . $faker->name() . " selaku " . $faker->jobTitle() . " menyatakan bahwa " . $faker->randomElement($organizations) . " " . $faker->randomElement($locations) . " akan terus berkomitmen untuk " . $faker->randomElement(['mengawal', 'mendukung', 'mengoptimalkan', 'mengawasi']) . " pelaksanaan program ini. \"" . $faker->randomElement(['Kami akan memastikan', 'Kami berkomitmen untuk', 'Tugas kami adalah memastikan']) . " bahwa " . $faker->randomElement(['setiap tahapan pelaksanaan', 'seluruh rangkaian kegiatan', 'setiap program yang dijalankan']) . " dapat " . $faker->randomElement(['berjalan dengan baik', 'mencapai target yang ditetapkan', 'memberikan manfaat optimal']) . " bagi " . $faker->randomElement(['seluruh pemangku kepentingan', 'masyarakat luas', 'dunia usaha dan industri']) . "," . $faker->randomElement(['" tegasnya.', '" ujarnya dengan tegas.', '" paparnya dengan serius.']) . " " . $faker->randomElement(['Dia juga menekankan pentingnya', 'Tidak lupa disampaikannya mengenai', 'Hal yang tak kalah penting adalah']) . " " . $faker->randomElement(['peran serta aktif masyarakat', 'dukungan dari berbagai pihak', 'sinergi antar instansi terkait']) . " dalam " . $faker->randomElement(['mendukung kesuksesan program ini', 'mewujudkan tujuan pembangunan', 'mengoptimalkan hasil yang ingin dicapai']) . "."
        ]) . "</p>";

        // Gabungkan semua paragraf
        $content = $intro . "\n" . implode("\n", $paragraphs);

        // Tambahkan 1-2 paragraf tambahan secara acak
        $additionalParagraphs = [];
        $additionalCount = $faker->numberBetween(1, 2);

        for ($i = 0; $i < $additionalCount; $i++) {
            $additionalParagraphs[] = "<p>" . $faker->randomElement([
                "Tidak hanya itu, " . $faker->randomElement($organizations) . " " . $faker->randomElement($locations) . " juga akan " . $faker->randomElement(['melakukan', 'melaksanakan', 'mengadakan']) . " " . $faker->randomElement(['pendampingan', 'evaluasi', 'monitoring']) . " secara " . $faker->randomElement(['berkala', 'rutin', 'terus-menerus']) . " untuk memastikan " . $faker->randomElement(['keberlanjutan', 'keberhasilan', 'efektivitas']) . " program ini.",
                "Di tempat terpisah, " . $faker->name() . " selaku " . $faker->jobTitle() . " mengapresiasi inisiatif ini. \"" . $faker->sentence(10, 15) . "\", ujarnya.",
                $faker->randomElement(['Sebagai informasi', 'Perlu diketahui', 'Diketahui']) . ", program serupa sebelumnya telah berhasil " . $faker->randomElement(['dilaksanakan', 'diimplementasikan', 'diterapkan']) . " di " . $faker->randomElement($locations) . " dengan hasil yang " . $faker->randomElement(['sangat memuaskan', 'cukup menggembirakan', 'melebihi ekspektasi']) . "."
            ]) . "</p>";
        }

        // Gabungkan dengan paragraf tambahan
        if (!empty($additionalParagraphs)) {
            $content .= "\n" . implode("\n", $additionalParagraphs);
        }

        // Tambahkan penutup
        $content .= "\n<p>" . $faker->randomElement([
            "Kegiatan ini diharapkan dapat menjadi " . $faker->randomElement(['pemicu', 'penggerak', 'pemantik']) . " bagi " . $faker->randomElement(['pemangku kepentingan terkait', 'masyarakat', 'dunia usaha']) . " untuk bersama-sama " . $faker->randomElement(['berkontribusi', 'berpartisipasi aktif', 'bersinergi']) . " dalam mewujudkan " . $faker->randomElement(['pembangunan yang berkelanjutan', 'kesejahteraan masyarakat', 'kemajuan daerah']) . ".",
            "" . $faker->randomElement($organizations) . " " . $faker->randomElement($locations) . " mengajak seluruh lapisan masyarakat untuk turut serta mendukung dan mengawal pelaksanaan program ini agar dapat " . $faker->randomElement(['berjalan dengan baik', 'mencapai sasaran yang ditetapkan', 'memberikan manfaat optimal']) . " bagi " . $faker->randomElement(['seluruh masyarakat', 'seluruh pemangku kepentingan', 'pembangunan daerah']) . "."
        ]) . "</p>";

        // Gunakan gambar default dari storage
        $featuredImage = null;

        // Coba gunakan gambar default dari storage
        $defaultImages = Storage::disk('public')->files('post-images');
        if (!empty($defaultImages)) {
            $randomImage = $defaultImages[array_rand($defaultImages)];
            $featuredImage = basename($randomImage);
        }

        return [
            'team_id' => Team::inRandomOrder()->first()?->id ?? Team::factory(),
            'title' => $title,
            'slug' => Str::slug($title) . '-' . Str::random(6),
            'content' => $content,
            'featured_image' => $featuredImage,
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'status' => $faker->randomElement(['published', 'draft', 'archived']),
            'published_at' => $faker->dateTimeBetween('-1 year', '+1 month'),
            'views' => $faker->numberBetween(0, 10000),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Post $post) {
            // Attach 1-3 random tags to the post
            $tags = Tag::inRandomOrder()
                ->take(rand(1, 3))
                ->pluck('id')
                ->toArray();
            
            $post->tags()->sync($tags);
        });
    }

    /**
     * Indicate that the post is published.
     */
    /**
     * Indicate that the post is published.
     */
    public function published()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'published',
                'published_at' => now(),
            ];
        });
    }

    /**
     * Indicate that the post is a draft.
     */
    /**
     * Indicate that the post is a draft.
     */
    public function draft()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'draft',
                'published_at' => null,
            ];
        });
    }

    /**
     * Indicate that the post is featured.
     */
    public function featured()
    {
        return $this->state([
            'is_featured' => true,
        ]);
    }
}
