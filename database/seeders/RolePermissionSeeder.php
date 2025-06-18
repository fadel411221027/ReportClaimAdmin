<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        // $permissions = [
        //     'tambah-user',
        //     'lihat-user',
        //     'edit-user',
        //     'hapus-user',
        //     'tambah-tulisan',
        //     'lihat-tulisan',
        //     'edit-tulisan',
        //     'hapus-tulisan',
        //     'bolehchat'
        // ];
        // foreach ($permissions as $permission) {
        //     Permission::create(['name' => $permission]);
        // }

        // Create roles
        $roles = [
            'TeamAdmin','PIC','Leader','dev'
        ];
        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }

        // Assign permissions to roles
        // $rolepic = Role::findByName('pic');
        // // $rolepic->givePermissionTo(['tambah-user', 'lihat-user', 'edit-user', 'hapus-user', 'bolehchat']);

        // $roleTeamAdmin = Role::findByName('TeamAdmin');
        // $roleTeamAdmin->givePermissionTo(['tambah-tulisan', 'lihat-tulisan', 'edit-tulisan', 'hapus-tulisan', 'bolehchat']);
    }

}
