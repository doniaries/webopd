<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $this->checkPermission($user, 'view_any_post');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Post $post): bool
    {
        // Admin dan editor bisa melihat semua post
        if ($user->hasRole(['administrator', 'editor'])) {
            return true;
        }
        
        // Author hanya bisa melihat post miliknya sendiri
        if ($user->hasRole('author')) {
            return $post->user_id === $user->id;
        }
        
        return $this->checkPermission($user, 'view_post');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->checkPermission($user, 'create_post');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): bool
    {
        // Admin dan editor bisa mengupdate semua post
        if ($user->hasRole(['administrator', 'editor'])) {
            return true;
        }
        
        // Author hanya bisa mengupdate post miliknya sendiri
        if ($user->hasRole('author') && $post->user_id === $user->id) {
            // Cek apakah post sudah dipublikasikan
            if ($post->status === 'published') {
                // Author tidak bisa mengubah post yang sudah dipublikasikan
                return false;
            }
            return true;
        }
        
        return $this->checkPermission($user, 'update_post');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        // Admin bisa menghapus semua post
        if ($user->hasRole('administrator')) {
            return true;
        }
        
        // Editor tidak bisa menghapus post yang sudah dipublikasikan
        if ($user->hasRole('editor') && $post->status === 'published') {
            return false;
        }
        
        // Author hanya bisa menghapus post miliknya sendiri yang belum dipublikasikan
        if ($user->hasRole('author')) {
            return $post->user_id === $user->id && $post->status !== 'published';
        }
        
        return $this->checkPermission($user, 'delete_post');
    }

    /**
     * Determine whether the user can publish posts.
     */
    public function publish(User $user, Post $post = null): bool
    {
        // Admin dan editor bisa mempublikasikan post
        if ($user->hasRole(['administrator', 'editor'])) {
            return true;
        }
        
        // Author tidak bisa mempublikasikan post
        return false;
    }

    /**
     * Determine whether the user can update the published status.
     */
    public function updateStatus(User $user, Post $post, string $newStatus): bool
    {
        // Jika mengubah ke published, butuh permission publish_post
        if ($newStatus === 'published') {
            return $user->can('publish_post');
        }
        
        // Untuk status lain, cukup punya update_post
        return $user->can('update_post');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_post');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, Post $post): bool
    {
        return $user->can('force_delete_post');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_post');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Post $post): bool
    {
        return $user->can('restore_post');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_post');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Post $post): bool
    {
        return $user->can('replicate_post');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_post');
    }
    
    /**
     * Helper method untuk mengecek permission dengan fallback
     */
    protected function checkPermission(User $user, string $permission): bool
    {
        // Cek apakah user memiliki permission langsung
        if (method_exists($user, 'hasPermissionTo')) {
            return $user->hasPermissionTo($permission);
        }
        
        // Fallback ke can() jika hasPermissionTo tidak tersedia
        if (method_exists($user, 'can')) {
            return $user->can($permission);
        }
        
        // Default ke false
        return false;
    }
}
