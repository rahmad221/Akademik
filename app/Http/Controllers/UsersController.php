<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

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

    public function storeAjax(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'role_id' => 'required|exists:roles,id',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    $user->roles()->attach($request->role_id);

    return response()->json([
        'success' => true,
        'message' => 'User berhasil ditambahkan!',
        'data' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->roles->first()->name
        ]
    ]);
}
}
