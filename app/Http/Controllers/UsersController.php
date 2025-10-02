<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class UsersController extends Controller
{
    function index() 
    {
        $user = User::with('roles')->get(); // eager load biar hemat query
        $roles = Role::all();
        return view('master.users.index', compact('user','roles'));
    }

    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id'
        ]);

        $user = User::findOrFail($id);
        $user->roles()->sync([$request->role_id]);

        return redirect()->back()->with('success', 'Role berhasil diupdate!');
    }

}
