<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostImage;
use App\Models\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostImageSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure we have teams and posts
        if (Team::count() === 0) {
            $this->call(TeamSeeder::class);
        }
        
        if (Post::count() === 0) {
            $this->call(PostSeeder::class);
        }

        // Create images directory in public if not exists
        $publicPath = public_path('images');
        if (!file_exists($publicPath)) {
            mkdir($publicPath, 0777, true);
        }
        
        // Daftar URL gambar landscape dari Pexels (gratis untuk digunakan)
        $pexelsImages = [
            'https://images.pexels.com/photos/3183150/pexels-photo-3183150.jpeg?auto=compress&cs=tinysrgb&w=1600', // Team discussion
            'https://images.pexels.com/photos/3184418/pexels-photo-3184418.jpeg?auto=compress&cs=tinysrgb&w=1600', // Office meeting
            'https://images.pexels.com/photos/3184291/pexels-photo-3184291.jpeg?auto=compress&cs=tinysrgb&w=1600', // Business meeting
            'https://images.pexels.com/photos/3184296/pexels-photo-3184296.jpeg?auto=compress&cs=tinysrgb&w=1600', // Office team
            'https://images.pexels.com/photos/3184339/pexels-photo-3184339.jpeg?auto=compress&cs=tinysrgb&w=1600', // Team work
            'https://images.pexels.com/photos/3184352/pexels-photo-3184352.jpeg?auto=compress&cs=tinysrgb&w=1600', // Office space
            'https://images.pexels.com/photos/3184465/pexels-photo-3184465.jpeg?auto=compress&cs=tinysrgb&w=1600', // Team work 2
            'https://images.pexels.com/photos/3184338/pexels-photo-3184338.jpeg?auto=compress&cs=tinysrgb&w=1600', // Team meeting
            'https://images.pexels.com/photos/3184332/pexels-photo-3184332.jpeg?auto=compress&cs=tinysrgb&w=1600', // Business presentation
            'https://images.pexels.com/photos/3183153/pexels-photo-3183153.jpeg?auto=compress&cs=tinysrgb&w=1600', // Business conference
            'https://images.pexels.com/photos/3183151/pexels-photo-3183151.jpeg?auto=compress&cs=tinysrgb&w=1600', // Office workspace
            'https://images.pexels.com/photos/3183152/pexels-photo-3183152.jpeg?auto=compress&cs=tinysrgb&w=1600', // Team collaboration
            'https://images.pexels.com/photos/3183154/pexels-photo-3183154.jpeg?auto=compress&cs=tinysrgb&w=1600', // Business people
            'https://images.pexels.com/photos/3183155/pexels-photo-3183155.jpeg?auto=compress&cs=tinysrgb&w=1600', // Office discussion
            'https://images.pexels.com/photos/3183156/pexels-photo-3183156.jpeg?auto=compress&cs=tinysrgb&w=1600', // Team meeting 2
            'https://images.pexels.com/photos/3183157/pexels-photo-3183157.jpeg?auto=compress&cs=tinysrgb&w=1600', // Business presentation 2
            'https://images.pexels.com/photos/3183158/pexels-photo-3183158.jpeg?auto=compress&cs=tinysrgb&w=1600', // Office team 2
            'https://images.pexels.com/photos/3183159/pexels-photo-3183159.jpeg?auto=compress&cs=tinysrgb&w=1600', // Team work 3
            'https://images.pexels.com/photos/3183160/pexels-photo-3183160.jpeg?auto=compress&cs=tinysrgb&w=1600', // Business meeting 3
            'https://images.pexels.com/photos/3183161/pexels-photo-3183161.jpeg?auto=compress&cs=tinysrgb&w=1600', // Office workspace 2
        ];
        
        $sampleImages = [];
        
        // Download images from Pexels if not exists
        foreach ($pexelsImages as $index => $imageUrl) {
            $imageName = 'berita' . ($index + 1) . '.jpg';
            $imagePath = $publicPath . '/' . $imageName;
            
            if (!file_exists($imagePath)) {
                try {
                    $imageContent = file_get_contents($imageUrl);
                    if ($imageContent !== false) {
                        file_put_contents($imagePath, $imageContent);
                        $this->command->info('Downloaded image: ' . $imageName);
                    }
                } catch (\Exception $e) {
                    $this->command->error('Failed to download image: ' . $e->getMessage());
                    continue;
                }
            }
            
            $sampleImages[] = 'images/' . $imageName;
        }
        
        $this->command->info('Using ' . count($sampleImages) . ' sample images from public directory');

        // Get all teams
        $teams = Team::all();
        
        // Create foto-tambahan directory if not exists
        if (!Storage::exists('public/foto-tambahan')) {
            Storage::makeDirectory('public/foto-tambahan');
        }
        
        // Process each team
        foreach ($teams as $team) {
            $this->command->info("Processing team: " . $team->name);
            
            // Get published posts for this team
            $teamPosts = Post::where('team_id', $team->id)
                ->where('status', 'published')
                ->where('published_at', '<=', now())
                ->get();
            
            if ($teamPosts->isEmpty()) {
                $this->command->warn("No published posts found for team: " . $team->name);
                continue;
            }
            
            foreach ($teamPosts as $post) {
                // Create 1-3 images per post (at least 1 featured image)
                $imageCount = rand(1, 3);
                $hasFeatured = false;
                
                for ($i = 0; $i < $imageCount; $i++) {
                    $isFeatured = !$hasFeatured && ($i === $imageCount - 1 || rand(0, 1));
                    if ($isFeatured) {
                        $hasFeatured = true;
                    }
                    
                    // Select a random image from public directory
                    $randomImage = $sampleImages[array_rand($sampleImages)];
                    $imageName = 'post_' . $post->id . '_' . Str::random(10) . '.jpg';
                    $imagePath = 'foto-tambahan/' . $imageName;
                    
                    try {
                        // Copy the image from public to storage
                        $sourcePath = public_path($randomImage);
                        $imageContent = file_get_contents($sourcePath);
                        
                        if ($imageContent !== false) {
                            Storage::disk('public')->put($imagePath, $imageContent);
                            $this->command->info('Copied and saved image: ' . $imagePath);
                        } else {
                            $this->command->error('Failed to read image from: ' . $sourcePath);
                            continue;
                        }
                        
                        // Create the image record
                        $image = PostImage::firstOrCreate(
                            [
                                'team_id' => $team->id,
                                'post_id' => $post->id,
                                'image_path' => $imagePath,
                            ],
                            [
                                'caption' => 'Gambar ilustrasi untuk ' . $post->title,
                                'description' => 'Deskripsi untuk gambar ' . ($i + 1) . ' dari postingan ' . $post->title,
                                'order' => $i + 1,
                                'is_featured' => $isFeatured,
                            ]
                        );
                        
                        $this->command->info("Created image: " . $imagePath . " for post: " . $post->title);
                        
                        // Set the first image as featured image for the post
                        if ($isFeatured) {
                            // Kita sudah memiliki foto_utama di tabel posts, ini hanya untuk gambar tambahan
                            $this->command->info("Set featured image in post_images for post: " . $post->title);
                        }
                    } catch (\Exception $e) {
                        $this->command->error("Error processing image: " . $e->getMessage());
                        // Skip if image processing fails
                        continue;
                    }
                }
                
                // Ensure at least one featured image exists in post_images table
                if (!$hasFeatured) {
                    $firstImage = $post->images()->first();
                    if ($firstImage) {
                        $firstImage->update(['is_featured' => true]);
                        // Kita sudah memiliki foto_utama di tabel posts, ini hanya untuk gambar tambahan
                    }
                }
            }
        }
    }
}
