<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create(['name' => 'admin']);
        $guru = Role::create(['name' => 'guru']);
        $siswa = Role::create(['name' => 'siswa']);
    
        // Permissions
        $manageUsers = Permission::create(['name' => 'manage_users']);
        $viewMateri  = Permission::create(['name' => 'view_materi']);
        $createMateri = Permission::create(['name' => 'create_materi']);
    
        // Assign permissions to roles
        $admin->permissions()->attach([$manageUsers->id, $viewMateri->id, $createMateri->id]);
        $guru->permissions()->attach([$viewMateri->id, $createMateri->id]);
        $siswa->permissions()->attach([$viewMateri->id]);
    
        // Buat user
        $u1 = User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password')
        ]);
        $u1->roles()->attach($admin->id);
    
        $u2 = User::create([
            'name' => 'Guru',
            'email' => 'guru@mail.com',
            'password' => Hash::make('password')
        ]);
        $u2->roles()->attach($guru->id);
    
        $u3 = User::create([
            'name' => 'Siswa',
            'email' => 'siswa@mail.com',
            'password' => Hash::make('password')
        ]);
        $u3->roles()->attach($siswa->id);
    }
}
