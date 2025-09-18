<?php

namespace App\Http\Controllers;

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
        Validator::make($request->all(), [
            'role_id' => 'required|integer'
        ],
        [
            'role_id.required' => 'Harap isi role',
            'role_id.integer' => 'role_id harus berupa angka'
        ]);

        $role = User::findOrFail($id);
        $role->role_id = $request->role_id;
        $role->save();

        return response()->json(['data' => $role]);
    }

    public function createRole(Request $request) {
        Validator::make($request->all(), [
            'name' => 'required|string'
        ],[
            'name.required' => 'Nama role harus diisi',
            'name.string' => 'Nama role harus berupa string',
        ]);

        $role = Role::create($request->all());

        return response()->json(['data' => $role]);
    }
}
