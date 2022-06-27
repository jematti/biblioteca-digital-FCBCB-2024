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
        $role1 = Role::create(['name' => 'admin']);
        $role2 = Role::create(['name'=>'delegado']);

        Permission::create(['name'=>'admin.muro'])->syncRoles([$role1],[$role2]);

        Permission::create(['name' => 'admin.books.index'])->syncRoles([$role1],[$role2]);
        Permission::create(['name' => 'admin.books.create'])->syncRoles([$role1],[$role2]);
        Permission::create(['name' => 'admin.books.edit'])->syncRoles([$role1],[$role2]);
        Permission::create(['name' => 'admin.books.destroy'])->syncRoles([$role1],[$role2]);
    }
}
