<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $users = User::with(['roles:id,name', 'roles.permissions:id,name', 'permissions:id,name'])
                ->cursorPaginate(2, ['id', 'name', 'email']);
            $roles = Role::get(['id', 'name']);
            $permissions = Permission::get(['id', 'name']);
            return response()->json(['user' => $users, 'roles' => $roles, 'permissions' => $permissions]);
        }catch(Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validate = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'max:255', 'unique:users,email'],
                'password' => ['required', 'string', 'max:255'],
                'password_confirmation' => ['required', 'string', 'max:255', 'same:password'],
            ]);
            $user = User::create($validate);
            return response()->json(['message' => "$user->name User Create Successfully."]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validate = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'unique:users,email,'.$user->id],
        ]);
        $user->update($validate);
        return response()->json(['message' => "$user->name User Updated Successfully."]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => "$user->name User Deleted Successfully."]);
    }
    public function changePassword(Request $request,User $user){
        $validate = $request->validate([
            'password' => ['required','string','max:255'],
            'confirmPassword' => ['required','string','same:password'],
        ]);
        $user->update($validate);
        return response()->json(['message' => "$user->name User Password Change Successfully."]);
    }
}
