<?php

namespace Database\Seeders;

use BezhanSalleh\FilamentShield\Support\Utils;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Get or create roles
        $superAdminRole = Role::firstOrCreate([
            'name' => 'super_admin',
            'guard_name' => 'web'
        ]);

        $adminOpdRole = Role::firstOrCreate([
            'name' => 'admin_opd',
            'guard_name' => 'web'
        ]);

        $editorRole = Role::firstOrCreate([
            'name' => 'editor',
            'guard_name' => 'web'
        ]);

        // Define all resources that need permissions
        $resources = [
            'user',
            'role',
            'permission',
            'agenda_kegiatan',
            'banner',
            'slider',
            'informasi',
            'produk_hukum',
            'infografis',
            'dokumen',
            'sambutan_pimpinan',
            'unit_kerja',
            'visi_misi',
            'pengaturan',
            'post',
            'tag',
            'team',
            'comment',
            'theme',
            'satuan',
            'ukuran',
            'tentang',
        ];

        // Define all permissions for each resource
        $permissions = [];
        $permissionTypes = [
            'view_any_',
            'view_',
            'create_',
            'update_',
            'delete_',
            'delete_any_',
            'restore_',
            'restore_any_',
            'force_delete_',
            'force_delete_any_',
            'replicate_',
            'reorder_',
        ];

        // Generate permissions for each resource
        foreach ($resources as $resource) {
            foreach ($permissionTypes as $type) {
                // Skip invalid permission combinations
                if (in_array($type, ['restore_', 'restore_any_', 'force_delete_', 'force_delete_any_', 'replicate_']) && 
                    in_array($resource, ['role', 'permission'])) {
                    continue;
                }
                
                $permissions[] = $type . $resource;
            }
        }

        // Add special page permissions
        $pagePermissions = [
            'page_Themes',
        ];

        $permissions = array_merge($permissions, $pagePermissions);
        $permissions = array_unique($permissions);

        // Create all permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        // Define admin_opd permissions first
        $adminOpdPermissions = [];
        $allowedAdminResources = [
            'agenda_kegiatan',
            'banner',
            'slider',
            'informasi',
            'produk_hukum',
            'infografis',
            'dokumen',
            'sambutan_pimpinan',
            'post',
            'tag',
            'comment',
        ];

        foreach ($allowedAdminResources as $resource) {
            $adminOpdPermissions = array_merge($adminOpdPermissions, array_filter($permissions, function($permission) use ($resource) {
                return (str_starts_with($permission, 'view_') || 
                       str_starts_with($permission, 'create_') || 
                       str_starts_with($permission, 'update_') ||
                       str_starts_with($permission, 'delete_') ||
                       str_starts_with($permission, 'restore_') ||
                       str_starts_with($permission, 'force_delete_') ||
                       str_starts_with($permission, 'replicate_') ||
                       str_starts_with($permission, 'reorder_')) && 
                       str_contains($permission, $resource);
            }));
        }
        
        // Assign all permissions to super admin (must be done last)
        $superAdminRole->syncPermissions(Permission::all());

        // Define editor permissions (more restricted than admin_opd)
        $editorPermissions = [];
        $allowedEditorResources = [
            'post',
            'comment',
        ];

        foreach ($allowedEditorResources as $resource) {
            $editorPermissions = array_merge($editorPermissions, array_filter($permissions, function($permission) use ($resource) {
                return (str_starts_with($permission, 'view_') || 
                        str_starts_with($permission, 'create_') || 
                        str_starts_with($permission, 'update_')) && 
                       str_contains($permission, $resource);
            }));
        }

        // Assign permissions to roles
        $adminOpdRole->syncPermissions($adminOpdPermissions);
        $editorRole->syncPermissions($editorPermissions);

        $this->command->info('Shield Seeding Completed.');
    }
}
