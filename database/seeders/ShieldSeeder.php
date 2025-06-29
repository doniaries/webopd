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

        $rolesWithPermissions = '[{"name":"super_admin","guard_name":"web","permissions":["view_agenda::kegiatan","view_any_agenda::kegiatan","create_agenda::kegiatan","update_agenda::kegiatan","restore_agenda::kegiatan","restore_any_agenda::kegiatan","replicate_agenda::kegiatan","reorder_agenda::kegiatan","delete_agenda::kegiatan","delete_any_agenda::kegiatan","force_delete_agenda::kegiatan","force_delete_any_agenda::kegiatan","view_banner","view_any_banner","create_banner","update_banner","restore_banner","restore_any_banner","replicate_banner","reorder_banner","delete_banner","delete_any_banner","force_delete_banner","force_delete_any_banner","view_dokumen","view_any_dokumen","create_dokumen","update_dokumen","restore_dokumen","restore_any_dokumen","replicate_dokumen","reorder_dokumen","delete_dokumen","delete_any_dokumen","force_delete_dokumen","force_delete_any_dokumen","view_external::link","view_any_external::link","create_external::link","update_external::link","restore_external::link","restore_any_external::link","replicate_external::link","reorder_external::link","delete_external::link","delete_any_external::link","force_delete_external::link","force_delete_any_external::link","view_infografis","view_any_infografis","create_infografis","update_infografis","restore_infografis","restore_any_infografis","replicate_infografis","reorder_infografis","delete_infografis","delete_any_infografis","force_delete_infografis","force_delete_any_infografis","view_informasi","view_any_informasi","create_informasi","update_informasi","restore_informasi","restore_any_informasi","replicate_informasi","reorder_informasi","delete_informasi","delete_any_informasi","force_delete_informasi","force_delete_any_informasi","view_pengaturan","view_any_pengaturan","create_pengaturan","update_pengaturan","restore_pengaturan","restore_any_pengaturan","replicate_pengaturan","reorder_pengaturan","delete_pengaturan","delete_any_pengaturan","force_delete_pengaturan","force_delete_any_pengaturan","view_post","view_any_post","create_post","update_post","restore_post","restore_any_post","replicate_post","reorder_post","delete_post","delete_any_post","force_delete_post","force_delete_any_post","view_produk::hukum","view_any_produk::hukum","create_produk::hukum","update_produk::hukum","restore_produk::hukum","restore_any_produk::hukum","replicate_produk::hukum","reorder_produk::hukum","delete_produk::hukum","delete_any_produk::hukum","force_delete_produk::hukum","force_delete_any_produk::hukum","view_role","view_any_role","create_role","update_role","delete_role","delete_any_role","view_sambutan::pimpinan","view_any_sambutan::pimpinan","create_sambutan::pimpinan","update_sambutan::pimpinan","restore_sambutan::pimpinan","restore_any_sambutan::pimpinan","replicate_sambutan::pimpinan","reorder_sambutan::pimpinan","delete_sambutan::pimpinan","delete_any_sambutan::pimpinan","force_delete_sambutan::pimpinan","force_delete_any_sambutan::pimpinan","view_slider","view_any_slider","create_slider","update_slider","restore_slider","restore_any_slider","replicate_slider","reorder_slider","delete_slider","delete_any_slider","force_delete_slider","force_delete_any_slider","view_tag","view_any_tag","create_tag","update_tag","restore_tag","restore_any_tag","replicate_tag","reorder_tag","delete_tag","delete_any_tag","force_delete_tag","force_delete_any_tag","view_unit::kerja","view_any_unit::kerja","create_unit::kerja","update_unit::kerja","restore_unit::kerja","restore_any_unit::kerja","replicate_unit::kerja","reorder_unit::kerja","delete_unit::kerja","delete_any_unit::kerja","force_delete_unit::kerja","force_delete_any_unit::kerja","view_user","view_any_user","create_user","update_user","restore_user","restore_any_user","replicate_user","reorder_user","delete_user","delete_any_user","force_delete_user","force_delete_any_user","view_visi::misi","view_any_visi::misi","create_visi::misi","update_visi::misi","restore_visi::misi","restore_any_visi::misi","replicate_visi::misi","reorder_visi::misi","delete_visi::misi","delete_any_visi::misi","force_delete_visi::misi","force_delete_any_visi::misi","page_Themes"]}]';
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
                        ->map(fn ($permission) => $permissionModel::firstOrCreate([
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
