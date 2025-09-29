<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::resource('user', UserController::class)->names('api.user');
    Route::resource('role', RoleController::class)->names('api.role');
    Route::resource('permission', PermissionController::class)->names('api.permission');
    Route::post('assignPermission/{role}', [RoleController::class, 'addPermissionToRole'])->name('api.assignPermission');
    Route::post('assignRoleToUser/{user}', [RoleController::class, 'assignRolesToUser'])->name('api.assignRoleToUser');
    Route::post('assignPermissionsToUser/{user}', [PermissionController::class, 'assignPermissionsToUser'])->name('api.assignPermissionsToUser');
    Route::resource('order', OrderController::class)->names('api.order');
});
