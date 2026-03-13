<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RolePermission;
use App\Models\Role;
use App\Models\User;

class RolePermissionController extends BaseController
{
    // Show Role Permission Form
    public function index(Request $request)
    {
        $role = Role::findOrFail($request->r_id);
        $rolePermissions = RolePermission::where('role_id', $request->r_id)->get();

        return view('add_permission', [
            'rolePermissions' => $rolePermissions,
            'roleId' => $request->r_id,
            'roleName' => $role->role_name ?? '' // Make sure your roles table has 'name'
        ]);
    }

    // Save/Update Role Permissions
    public function permission(Request $request, $id)
    {
        $pages = $request->page ?? [];

        foreach ($pages as $page) {
            $permissionField = $page.'_permission';
            $permissionValue = implode(',', $request->$permissionField ?? []);

            $rolePermission = RolePermission::firstOrNew([
                'role_id' => $id,
                'page' => $page
            ]);

            $rolePermission->permission = $permissionValue;
            $rolePermission->status = 0;
            $rolePermission->updated_by = Auth::id();

            if (!$rolePermission->exists) {
                $rolePermission->created_by = Auth::id();
            }

            $rolePermission->save();
        }

        return response()->json([
            'status' => 200,
            'message' => 'Role permissions saved successfully',
        ]);
    }

    // Get Page Permission for Current User
    public function pagePermission($name)
    {
        $page = $name;
        $user = Auth::user();
        $result = RolePermission::where('role_id', $user->role_id)
                    ->where('page', $page)
                    ->first();

        return response()->json([
            'status' => 200,
            'message' => 'Role Permission',
            'data' => $result,
        ]);
    }
}