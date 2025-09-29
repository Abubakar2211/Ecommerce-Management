<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
class RoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:Role view', only: ['index', 'show']),
            new Middleware('permission:Role create', only: ['create', 'store']),
            new Middleware('permission:Role edit', only: ['edit', 'update']),
            new Middleware('permission:Role delete', only: ['destroy']),
            new Middleware('permission:Assign permission', only: ['addPermissionToRole']),
            new Middleware('permission:Assign role', only: ['assignRolesToUser']),
        ];
    }
    public function index()
    {
        $roles = Role::get(['id', 'name']);
        return response()->json(['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name']
        ]);
        $role = Role::create([
            'name' => $validate['name'],
            'guard_name' => 'api',
        ]);
        return response()->json(['message' => "$role->name Role Created Successfully."]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $validate = $request->validate([
            'name' => ['required', 'string', 'max:255']
        ]);
        $role->update([
            'name' => $validate['name'],
            'guard_name' => 'api',
        ]);
        return response()->json(['message' => "$role->name Role Updated Successfully."]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return response()->json(['message' => "$role->name Role Deleted Successfully."]);
    }
    public function addPermissionToRole(Request $request, Role $role)
    {
        $permissions = Permission::whereIn('id', $request->permissions ?? [])->get();
        $role->syncPermissions($permissions);
        return response()->json(['message' => 'Permissions assigned successfully!']);
    }
    public function assignRolesToUser(User $user, Request $request)
    {
        $roles = Role::whereIn('id', $request->roles ?? [])->get();
        $user->syncRoles($roles);
        return response()->json(['message' => 'Role Assigned User Successfully.']);
    }
}
