<?php

namespace App\Observers;

use App\Models\Post;

class PostObserver
{
    /**
     * Handle the Post "creating" event.
     */
    public function creating(Post $post): void
    {
        // Mengubah status menjadi 'published' secara otomatis saat post dibuat
        $post->status = 'published';
        
        // Jika published_at belum diatur, atur ke waktu saat ini
        if (!$post->published_at) {
            $post->published_at = now();
        }
    }

    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "deleted" event.
     */
    public function deleted(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "restored" event.
     */
    public function restored(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "force deleted" event.
     */
    public function forceDeleted(Post $post): void
    {
        //
    }
}