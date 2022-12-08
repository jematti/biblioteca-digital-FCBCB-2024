<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct() {
        $this->middleware('can:admin.roles.index')->only('index','show');
        $this->middleware('can:admin.roles.create')->only('create');
        $this->middleware('can:admin.roles.edit')->only('edit','update');
        $this->middleware('can:admin.roles.destroy')->only('destroy');
    }


    public function index()
    {
        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }


    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create',compact('permissions'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);
        //Creacion de rol
        $role = Role::create($request->all());
        //sincronizar permisos con el rol
        $role->permissions()->sync($request->permissions);

        return redirect()->route('admin.roles.index')->with('info','el rol se creó con exito');
    }


    public function show(Role $role)
    {
        return view('admin.roles.show', compact('role'));
    }


    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('admin.roles.edit', compact('role','permissions'));

    }


    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required'
        ]);
        //update rol
        $role->update($request->all());
        //sincronizar permisos
        $role->permissions()->sync($request->permissions);

        return redirect()->route('admin.roles.edit', $role)->with('info','el rol se actualizó con exito');


    }


    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('admin.roles.index', $role)->with('info','el rol se eliminó con exito');

    }
}
