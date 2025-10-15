<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index() {
        $users = Role::all();
        return response()->json(['data' => $users]);
    }

    public function updateUserRole($id, Request $request) {
        $request->validate( [
            'role_id' => 'required|integer'
        ]);

        $role = User::findOrFail($id);
        $role->role_id = $request->role_id;
        $role->save();

        return response()->json(new UserResource($role));
    }

    public function createRole(Request $request) {
        $request->validate([
            'name' => 'required|string'
        ]);

        $role = Role::create($request->all());

        return response()->json(['data' => $role]);
    }

    public function updateRole($id, Request $request) {
        $role = Role::findOrFail($id);

        $validate = $request->validate([
            'name' => 'required|string'
        ]);

        $role->update( $validate);

        return response()->json([
            'message' => 'Berhasil update role',
            'data' => $role
        ]);
    }

    public function deleteRole($id) {
        $role = Role::findOrFail($id);
        $role->delete(); // soft delete, tidak benar-benar hilang dari DB

        return response()->json([
            'message' => 'Delete role successfully'
        ]);
    }
}
