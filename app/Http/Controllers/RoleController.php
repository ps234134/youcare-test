<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return view('roles.index', ['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('roles.create', compact('roles', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles',
            'permissions' => 'array',
        ]);

        // Maak een nieuwe rol aan
        $role = Role::create([
            'name' => $request->name,
        ]);
    

        if ($request->has('permissions')) {
            foreach ($request->permissions as $permissionId) {
                $permission = Permission::find($permissionId);
                if ($permission) {
                    $role->givePermissionTo($permission);
                }
            }
        }


        // // selecteer permissies aan de nieuwe rol
        // if ($request->has('permissions')) {
        //     foreach ($request->input('permissions') as $permissionName) {
        //         $permission = Permission::where('name', $permissionName)->first();
        //         if ($permission) {
        //             $role->givePermissionTo($permission);
        //         }
        //     }
        // }
    
        return redirect()->route('roles.index')->with('success', 'Rol is succesvol aangemaakt.');
    }


    /**
     * Display the specified resource.
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
    
        // Haal alle permissie ID's op die aan de rol zijn toegewezen
        $rolePermissions = $role->permissions->pluck('id')->toArray();
    
        return view('roles.edit', ['role' => $role, 'permissions' => $permissions, 'rolePermissions' => $rolePermissions]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
{
    $role = Role::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
        'permissions' => 'array',
    ]);

    $role->update([
        'name' => $request->name,
    ]);

    // Filter geldige machtigingen
    $validPermissionIds = Permission::whereIn('id', $request->permissions)->pluck('id')->toArray();

    // Synchroniseer de permissies met de rol
    $role->syncPermissions($validPermissionIds);

    return redirect()->route('roles.index')->with('success', 'Rol is succesvol bijgewerkt.');
}
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Rol is succesvol verwijderd.');
    }
}
