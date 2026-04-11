<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // 1. Buat Role (Peran)
        $roleManager = Role::create(['name' => 'Manager']);
        $roleStaff   = Role::create(['name' => 'Staff Gudang']);

        // 2. Buat Akun Super Admin PERTAMA
        $admin = User::create([
            'name'      => 'Ahmad Manager',
            'email'     => 'admin@ulaqua.local',
            'password'  => Hash::make('password123') // Sesuaikan password defaultnya
        ]);

        // 3. Masukkan Role ke User
        $admin->assignRole('Manager');
    }
}
