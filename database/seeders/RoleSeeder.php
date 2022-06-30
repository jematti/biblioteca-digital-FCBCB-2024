<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create(['name' => 'admin']);
        $usuario = Role::create(['name'=>'usuario']);

        // Permission::create(['name'=>'home'])->syncRoles([$admin],[$usuario]);

        // Permission::create(['name' => 'admin.books.index'])->syncRoles([$admin]);
        // Permission::create(['name' => 'admin.books.create'])->syncRoles([$admin]);
        // Permission::create(['name' => 'admin.books.edit'])->syncRoles([$admin]);
        // Permission::create(['name' => 'admin.books.destroy'])->syncRoles([$admin]);

        Permission::create(['name' => 'nav.users'])->assignRole('usuario');
        Permission::create(['name' => 'nav.admin'])->assignRole('admin');
    }
}
