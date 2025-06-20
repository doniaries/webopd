<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use BezhanSalleh\FilamentShield\Support\Utils;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Super Admin role if not exists
        $superAdminRole = \Spatie\Permission\Models\Role::firstOrCreate([
            'name' => 'super_admin',
            'guard_name' => 'web'
        ]);

        // Create Admin OPD role if not exists
        $adminOpdRole = \Spatie\Permission\Models\Role::firstOrCreate([
            'name' => 'admin_opd',
            'guard_name' => 'web'
        ]);

        // // Create Editor role if not exists
        // $editorRole = \Spatie\Permission\Models\Role::firstOrCreate([
        //     'name' => 'editor',
        //     'guard_name' => 'web'
        // ]);


        $allPermissions = [
            // User permissions
            "view_user",
            "view_any_user",
            "create_user",
            "update_user",
            "delete_user",
            "delete_any_user",
            "restore_user",
            "restore_any_user",
            "force_delete_user",
            "force_delete_any_user",
            "replicate_user",
            "reorder_user",

            // Role permissions
            "view_role",
            "view_any_role",
            "create_role",
            "update_role",
            "delete_role",
            "delete_any_role",

            // Post permissions
            "view_post",
            "view_any_post",
            "create_post",
            "update_post",
            "delete_post",
            "delete_any_post",
            "restore_post",
            "restore_any_post",
            "force_delete_post",
            "force_delete_any_post",
            "replicate_post",
            "reorder_post",

            // Tag permissions
            "view_tag",
            "view_any_tag",
            "create_tag",
            "update_tag",
            "delete_tag",
            "delete_any_tag",
            "restore_tag",
            "restore_any_tag",
            "force_delete_tag",
            "force_delete_any_tag",
            "replicate_tag",
            "reorder_tag",

            // Team permissions
            "view_team",
            "view_any_team",
            "create_team",
            "update_team",
            "delete_team",
            "delete_any_team",
            "restore_team",
            "restore_any_team",
            "force_delete_team",
            "force_delete_any_team",
            "replicate_team",
            "reorder_team",

            // Comment permissions
            "view_comment",
            "view_any_comment",
            "create_comment",
            "update_comment",
            "delete_comment",
            "delete_any_comment",
            "restore_comment",
            "restore_any_comment",
            "force_delete_comment",
            "force_delete_any_comment",
            "replicate_comment",
            "reorder_comment",

            // Theme permissions
            "view_theme",
            "view_any_theme",
            "create_theme",
            "update_theme",
            "delete_theme",
            "delete_any_theme",
            "restore_theme",
            "restore_any_theme",
            "force_delete_theme",
            "force_delete_any_theme",
            "replicate_theme",
            "reorder_theme",

            // Pengaturan permissions
            "view_pengaturan",
            "view_any_pengaturan",
            "create_pengaturan",
            "update_pengaturan",
            "delete_pengaturan",
            "delete_any_pengaturan",
            "restore_pengaturan",
            "restore_any_pengaturan",
            "force_delete_pengaturan",
            "force_delete_any_pengaturan",
            "replicate_pengaturan",
            "reorder_pengaturan",
            // user
            "view_user",
            "view_any_user",
            "create_user",
            "update_user",
            "restore_user",
            "restore_any_user",
            "replicate_user",
            "reorder_user",
            "delete_user",
            "delete_any_user",
            "force_delete_user",
            "force_delete_any_user",
            // satuan
            "view_satuan",
            "view_any_satuan",
            "create_satuan",
            "update_satuan",
            "restore_satuan",
            "restore_any_satuan",
            "replicate_satuan",
            "reorder_satuan",
            "delete_satuan",
            "delete_any_satuan",
            "force_delete_satuan",
            "force_delete_any_satuan",
            // ukuran
            "view_ukuran",
            "view_any_ukuran",
            "create_ukuran",
            "update_ukuran",
            "restore_ukuran",
            "restore_any_ukuran",
            "replicate_ukuran",
            "reorder_ukuran",
            "delete_ukuran",
            "delete_any_ukuran",
            "force_delete_ukuran",
            "force_delete_any_ukuran",
            // tentang
            "view_tentang",
            "view_any_tentang",
            "create_tentang",
            "update_tentang",
            "restore_tentang",
            "restore_any_tentang",
            "replicate_tentang",
            "reorder_tentang",
            "delete_tentang",
            "delete_any_tentang",
            "force_delete_tentang",
            "force_delete_any_tentang",
            // agenda
            "view_agenda",
            "view_any_agenda",
            "create_agenda",
            "update_agenda",
            "restore_agenda",
            "restore_any_agenda",
            "replicate_agenda",
            "reorder_agenda",
            "delete_agenda",
            "delete_any_agenda",
            "force_delete_agenda",
            "force_delete_any_agenda",
            // informasi
            "view_informasi",
            "view_any_informasi",
            "create_informasi",
            "update_informasi",
            "restore_informasi",
            "restore_any_informasi",
            "replicate_informasi",
            "reorder_informasi",
            "delete_informasi",
            "delete_any_informasi",
            "force_delete_pengumuman",
            "force_delete_any_pengumuman",
            // banner
            "view_banner",
            "view_any_banner",
            "create_banner",
            "update_banner",
            "restore_banner",
            "restore_any_banner",
            "replicate_banner",
            "reorder_banner",
            "delete_banner",
            "delete_any_banner",
            "force_delete_banner",
            "force_delete_any_banner",
            // slider
            "view_slider",
            "view_any_slider",
            "create_slider",
            "update_slider",
            "restore_slider",
            "restore_any_slider",
            "replicate_slider",
            "reorder_slider",
            "delete_slider",
            "delete_any_slider",
            "force_delete_slider",
            "force_delete_any_slider",

            // dokumen
            "view_dokumen",
            "view_any_dokumen",
            "create_dokumen",
            "update_dokumen",
            "restore_dokumen",
            "restore_any_dokumen",
            "replicate_dokumen",
            "reorder_dokumen",
            "delete_dokumen",
            "delete_any_dokumen",
            "force_delete_dokumen",
            "force_delete_any_dokumen",
            // sambutan
            "view_sambutan",
            "view_any_sambutan",
            "create_sambutan",
            "update_sambutan",
            "restore_sambutan",
            "restore_any_sambutan",
            "replicate_sambutan",
            "reorder_sambutan",
            "delete_sambutan",
            "delete_any_sambutan",
            "force_delete_sambutan",
            "force_delete_any_sambutan",
            // visi misi
            "view_visimisi",
            "view_any_visimisi",
            "create_visimisi",
            "update_visimisi",
            "restore_visimisi",
            "restore_any_visimisi",
            "replicate_visimisi",
            "reorder_visimisi",
            "delete_visimisi",
            "delete_any_visimisi",
            "force_delete_visimisi",
            "force_delete_any_visimisi",
            // produk hukum
            "view_produkhukum",
            "view_any_produkhukum",
            "create_produkhukum",
            "update_produkhukum",
            "restore_produkhukum",
            "restore_any_produkhukum",
            "replicate_produkhukum",
            "reorder_produkhukum",
            "delete_produkhukum",
            "delete_any_produkhukum",
            "force_delete_produkhukum",
            "force_delete_any_produkhukum",
            // infografis
            "view_infografis",
            "view_any_infografis",
            "create_infografis",
            "update_infografis",
            "restore_infografis",
            "restore_any_infografis",
            "replicate_infografis",
            "reorder_infografis",
            "delete_infografis",
            "delete_any_infografis",
            "force_delete_infografis",
            "force_delete_any_infografis",



            // themes
            "delete_user",
            "delete_any_user",
            "force_delete_user",
            "force_delete_any_user",
            "page_Themes"

        ];
        // Define permissions for admin_opd role
        $adminOpdPermissions = array_filter($allPermissions, function ($permission) {
            // Allow access to content management
            $allowedPrefixes = [
                'view_', 'view_any_', 'create_', 'update_', 'restore_', 'restore_any_',
                'replicate_', 'reorder_', 'delete_', 'delete_any_', 'force_delete_', 'force_delete_any_'
            ];

            // Allowed resources for admin_opd
            $allowedResources = [
                'post', 'tag', 'comment', 'pengaturan', 'user', 'satuan', 'ukuran',
                'tentang', 'agenda', 'informasi', 'banner', 'slider', 'dokumen',
                'sambutan', 'visimisi', 'produkhukum', 'infografis'
            ];

            // Check if permission is for an allowed resource
            foreach ($allowedResources as $resource) {
                if (strpos($permission, $resource) !== false) {
                    // Deny access to user and role management
                    if (in_array($resource, ['user', 'role'])) {
                        return false;
                    }
                    return true;
                }
            }


            return false;
        });

        // Define permissions for editor role
        $editorPermissions = array_filter($allPermissions, function ($permission) {
            // Allow viewing and managing content
            $allowedPrefixes = ['view_', 'view_any_', 'create_', 'update_'];
            $allowedResources = ['post', 'tag', 'comment', 'informasi', 'agenda'];

            // Check if permission is for an allowed resource
            foreach ($allowedResources as $resource) {
                if (strpos($permission, $resource) !== false) {
                    // Only allow view, create, and update actions
                    foreach ($allowedPrefixes as $prefix) {
                        if (str_starts_with($permission, $prefix)) {
                            return true;
                        }
                    }
                    return false;
                }
            }


            return false;
        });

        // Define roles and their permissions
        $roles = [
            [
                'name' => 'super_admin',
                'guard_name' => 'web',
                'permissions' => $allPermissions
            ],
            [
                'name' => 'admin_opd',
                'guard_name' => 'web',
                'permissions' => array_values($adminOpdPermissions) // array_values to reindex the array
            ],
            [
                'name' => 'editor',
                'guard_name' => 'web',
                'permissions' => array_values($editorPermissions) // array_values to reindex the array
            ]
        ];

        // Konversi ke JSON
        $rolesWithPermissions = json_encode($roles);

        $directPermissions = '[]';

        static::makeRolesWithPermissions($rolesWithPermissions);
        static::makeDirectPermissions($directPermissions);

        $this->command->info('Shield Seeding Completed.');
    }

    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (! blank($rolePlusPermissions = json_decode($rolesWithPermissions, true))) {
            /** @var Model $roleModel */
            $roleModel = Utils::getRoleModel();
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($rolePlusPermissions as $rolePlusPermission) {
                $role = $roleModel::firstOrCreate([
                    'name' => $rolePlusPermission['name'],
                    'guard_name' => $rolePlusPermission['guard_name'],
                ]);

                if (! blank($rolePlusPermission['permissions'])) {
                    $permissionModels = collect($rolePlusPermission['permissions'])
                        ->map(fn($permission) => $permissionModel::firstOrCreate([
                            'name' => $permission,
                            'guard_name' => $rolePlusPermission['guard_name'],
                        ]))
                        ->all();

                    $role->syncPermissions($permissionModels);
                }
            }
        }
    }

    public static function makeDirectPermissions(string $directPermissions): void
    {
        if (! blank($permissions = json_decode($directPermissions, true))) {
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($permissions as $permission) {
                if ($permissionModel::whereName($permission)->doesntExist()) {
                    $permissionModel::create([
                        'name' => $permission['name'],
                        'guard_name' => $permission['guard_name'],
                    ]);
                }
            }
        }
    }
}
