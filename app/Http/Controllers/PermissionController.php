<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Permission;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
class PermissionController extends Controller 
// implements HasMiddleware
{
    // public static function middleware(): array
    // {
    //     return [
    //         new Middleware('permission:Permission view', only: ['index', 'show']),
    //         new Middleware('permission:Permission create', only: ['create', 'store']),
    //         new Middleware('permission:Permission edit', only: ['edit', 'update']),
    //         new Middleware('permission:Permission delete', only: ['destroy']),
    //         new Middleware('permission:Assign user permission', only: ['assignPermissionsToUser']),
    //     ];
    // }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::get(['id', 'name']);
        return response()->json(['permissions' => $permissions]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:permissions,name']
        ]);
        $permission = Permission::create([
            'name' => $validate['name'],
            'guard_name' => 'web',
        ]);
        return response()->json(['message' => "$permission->name Permission Create Successfully."]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $validate = $request->validate([
            'name' => ['required', 'string', 'max:255']
        ]);
        $permission->update([
            'name' => $validate['name'],
            'guard_name' => 'web',
        ]);
        return response()->json(['message' => "$permission->name Permission Updated Successfully."]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return response()->json([
            'message' => $permission->name . ' Permission Deleted Successfully.'
        ]);
    }

    public function assignPermissionsToUser(User $user, Request $request)
    {
        $permissions = Permission::whereIn('id', $request->permissions)->get();
        $user->givePermissionTo($permissions);
        return response()->json(['message' => 'Permission Assigned User Successfully.']);
    }
}
