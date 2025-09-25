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
        // Default status ke draft jika belum diatur
        if (empty($post->status)) {
            $post->status = 'draft';
        }
        
        // Jika status published, pastikan ada published_at
        if ($post->status === 'published' && !$post->published_at) {
            $post->published_at = now();
        }
    }
    
    public function updating(Post $post): void
    {
        // Jika status diubah menjadi published, set published_at jika belum ada
        if ($post->isDirty('status') && $post->status === 'published' && !$post->published_at) {
            $post->published_at = now();
        }
        
        // Jika status diubah dari published, hapus published_at
        if ($post->isDirty('status') && $post->getOriginal('status') === 'published' && $post->status !== 'published') {
            $post->published_at = null;
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