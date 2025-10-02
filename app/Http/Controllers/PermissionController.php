<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,nama',
        ]);

        Permission::create([
            'nama' => $request->name,
            'slug' => Str::slug($request->name, '_'),
        ]);

        return back()->with('success', 'Permission berhasil dibuat.');
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|unique:permissions,nama,' . $permission->id,
        ]);

        $permission->update([
            'nama' => $request->name,
            'slug' => Str::slug($request->name, '_'),
        ]);

        return back()->with('success', 'Permission berhasil diperbarui.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return back()->with('success', 'Permission berhasil dihapus.');
    }
}
