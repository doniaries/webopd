<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Define all permissions that should exist
        $permissions = [
            // Core permissions
            'view_post', 'view_any_post', 'create_post', 'update_post', 'delete_post',
            'publish_post', 'unpublish_post', 'edit_published_posts', 'edit_others_posts',
            'delete_published_posts', 'delete_others_posts', 'read_private_posts',
            'restore_post', 'restore_any_post', 'replicate_post', 'reorder_post', 
            'force_delete_post', 'force_delete_any_post',
            
            // Tag permissions
            'view_tag', 'view_any_tag', 'create_tag', 'update_tag', 'delete_tag',
            'delete_any_tag', 'restore_tag', 'restore_any_tag', 'replicate_tag',
            'reorder_tag', 'force_delete_tag', 'force_delete_any_tag',
            
            // User management
            'view_user', 'view_any_user', 'create_user', 'update_user', 'delete_user',
            'restore_user', 'restore_any_user', 'replicate_user', 'reorder_user',
            'force_delete_user', 'force_delete_any_user',
            
            // Role management
            'view_role', 'view_any_role', 'create_role', 'update_role', 'delete_role',
            'delete_any_role',
            
            // Settings
            'view_setting', 'view_any_setting', 'create_setting', 'update_setting', 'delete_setting',
            
            // External Links
            'view_external::link', 'view_any_external::link', 'create_external::link',
            'update_external::link', 'delete_external::link', 'delete_any_external::link',
            'restore_external::link', 'restore_any_external::link', 'replicate_external::link',
            'reorder_external::link', 'force_delete_external::link', 'force_delete_any_external::link',
            
            // Sambutan Pimpinan
            'view_sambutan::pimpinan', 'view_any_sambutan::pimpinan', 'create_sambutan::pimpinan',
            'update_sambutan::pimpinan', 'delete_sambutan::pimpinan', 'delete_any_sambutan::pimpinan',
            'restore_sambutan::pimpinan', 'restore_any_sambutan::pimpinan', 'replicate_sambutan::pimpinan',
            'reorder_sambutan::pimpinan', 'force_delete_sambutan::pimpinan', 'force_delete_any_sambutan::pimpinan',
            
            // Gallery
            'view_gallery', 'view_any_gallery', 'create_gallery', 'update_gallery', 'delete_gallery',
            'delete_any_gallery', 'restore_gallery', 'restore_any_gallery', 'replicate_gallery',
            'reorder_gallery', 'force_delete_gallery', 'force_delete_any_gallery',
            
            // Pengumuman
            'view_pengumuman', 'view_any_pengumuman', 'create_pengumuman', 'update_pengumuman', 'delete_pengumuman',
            'delete_any_pengumuman', 'restore_pengumuman', 'restore_any_pengumuman', 'replicate_pengumuman',
            'reorder_pengumuman', 'force_delete_pengumuman', 'force_delete_any_pengumuman',
            
            // Layanan
            'view_layanan', 'view_any_layanan', 'create_layanan', 'update_layanan', 'delete_layanan',
            'delete_any_layanan', 'restore_layanan', 'restore_any_layanan', 'replicate_layanan',
            'reorder_layanan', 'force_delete_layanan', 'force_delete_any_layanan',
            
            // Other common permissions
            'view_any_*', 'view_*', 'create_*', 'update_*', 'delete_*', 'delete_any_*',
            'restore_*', 'restore_any_*', 'replicate_*', 'reorder_*', 'force_delete_*', 'force_delete_any_*',
            'publish_*', 'unpublish_*',
            
            // Filament pages
            'page_*',
        ];

        // Create all permissions
        $createdPermissions = [];
        foreach ($permissions as $permission) {
            // Ensure permission is a string and trim any whitespace
            $permission = is_string($permission) ? trim($permission) : $permission;
            if (is_string($permission) && !empty($permission)) {
                $createdPermissions[] = Permission::firstOrCreate(
                    ['name' => $permission],
                )->name; // Store the permission name as a string
            }
        }

        // Create roles with their permissions
        // Define role permissions
        $roles = [
            [
                'name' => 'super_admin',
                'guard_name' => 'web',
                'permissions' => $permissions, // All permissions
                'description' => 'Super Administrator dengan akses penuh ke semua fitur'
            ],
            [
                'name' => 'administrator',
                'guard_name' => 'web',
                'permissions' => array_filter($permissions, function($permission) {
                    // Admin bisa semua kecuali beberapa hal sensitif
                    return !in_array($permission, [
                        'delete_user', 'force_delete_user', 'force_delete_any_user',
                        'delete_role', 'delete_any_role',
                        'delete_setting', 'force_delete_setting', 'force_delete_any_setting'
                    ]);
                }),
                'description' => 'Administrator dengan kendali penuh atas situs'
            ],
            [
                'name' => 'editor',
                'guard_name' => 'web',
                'permissions' => array_filter($permissions, function($permission) {
                    // Editor bisa mengelola konten termasuk mempublikasikan
                    $allowed = [
                        'view_post', 'view_any_post', 'create_post', 'update_post', 'delete_post',
                        'publish_post', 'unpublish_post', 'edit_published_posts', 'edit_others_posts',
                        'delete_published_posts', 'delete_others_posts', 'read_private_posts',
                        'view_tag', 'view_any_tag', 'create_tag', 'update_tag', 'delete_tag',
                        'view_sambutan::pimpinan', 'view_any_sambutan::pimpinan', 'update_sambutan::pimpinan'
                    ];
                    return in_array($permission, $allowed);
                }),
                'description' => 'Dapat mengelola dan mempublikasikan konten'
            ],
            [
                'name' => 'author',
                'guard_name' => 'web',
                'permissions' => array_filter($permissions, function($permission) {
                    // Author hanya bisa membuat dan mengedit draft
                    $allowed = [
                        'view_post', 'view_any_post', 'create_post', 'update_post', 'delete_post',
                        'view_tag', 'view_any_tag', 'create_tag', 'update_tag'
                    ];
                    return in_array($permission, $allowed);
                }),
                'description' => 'Dapat membuat dan mengelola postingan mereka sendiri, tapi tidak bisa mempublikasikan'
            ],
            [
                'name' => 'contributor',
                'guard_name' => 'web',
                'permissions' => [
                    'view_post', 'view_any_post', 'create_post', 'update_post',
                    'view_tag', 'view_any_tag'
                ],
                'description' => 'Can write and edit their own posts but cannot publish'
            ]
        ];

        // Create roles and assign permissions
        foreach ($roles as $roleData) {
            // Ensure role name is a string
            $roleName = is_string($roleData['name']) ? trim($roleData['name']) : '';
            if (empty($roleName)) continue;

            $role = Role::firstOrCreate(
                ['name' => $roleName],
                [
                    'name' => $roleName,
                    'guard_name' => is_string($roleData['guard_name'] ?? 'web') ? $roleData['guard_name'] : 'web'
                ]
            );

            // Handle permissions
            $permissionsToSync = [];
            
            // Handle wildcard permission (super_admin case)
            if (in_array('*', $roleData['permissions'] ?? [])) {
                $permissionsToSync = Permission::all()->pluck('name')->toArray();
            } 
            // Handle array of permissions
            elseif (is_array($roleData['permissions'] ?? null)) {
                $permissionsToSync = array_filter(
                    $roleData['permissions'],
                    fn($p) => is_string($p) && !empty(trim($p))
                );
            }
            
            // Only sync if we have permissions to sync
            if (!empty($permissionsToSync)) {
                $role->syncPermissions($permissionsToSync);
            }

            // Update description if provided
            if (isset($roleData['description'])) {
                $role->update(['description' => $roleData['description']]);
            }
        }

        $this->command->info('Shield Seeding Completed.');
    }
}
