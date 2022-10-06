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
        $usuario = Role::create(['name' => 'usuario']);
        $inventario = Role::create(['name' => 'admin_tienda']);

        // Permission::create(['name'=>'home'])->syncRoles([$admin],[$usuario]);

        //autores de los productos
        Permission::create(['name' => 'admin.authors.index', 'description' => 'Ver listado de autores'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.authors.create', 'description' => 'Crear Autor'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.authors.edit', 'description' => 'Editar Autor'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.authors.destroy', 'description' => 'Eliminar Autor'])->syncRoles([$admin]);

        //categorias
        Permission::create(['name' => 'admin.categories.index', 'description' => 'Ver Listado de Categorias'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.categories.create', 'description' => 'Crear Categorias'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.categories.edit', 'description' => 'Editar Categorias'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.categories.destroy', 'description' => 'Eliminar Categorias'])->syncRoles([$admin]);

        //repositorios
        Permission::create(['name' => 'admin.repositories.index', 'description' => 'Ver Listado de Repositorios'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.repositories.create', 'description' => 'Crear Repositorio'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.repositories.edit', 'description' => 'Editar Repositorio'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.repositories.destroy', 'description' => 'Eliminar Repositorio'])->syncRoles([$admin]);

        //Productos
        Permission::create(['name' => 'admin.products.index', 'description' => 'Ver Listado de Productos'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.products.create', 'description' => 'Crear Producto'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.products.edit', 'description' => 'Editar Producto'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.products.destroy', 'description' => 'Eliminar Producto'])->syncRoles([$admin]);

        //barras de navegación
        Permission::create(['name' => 'nav.admin'])->assignRole('admin');
        Permission::create(['name' => 'nav.users'])->assignRole('usuario');
    }
}
