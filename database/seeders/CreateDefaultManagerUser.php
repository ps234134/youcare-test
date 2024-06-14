<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateDefaultManagerUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Maak de standaard gebruiker aan
        $user = User::create([
            'name' => 'Admin',
            'email' => 'Admin@admin.com',
            'password' => bcrypt('Admin'),
        ]);

        $managerRole = Role::where('name', 'manager')->first();
        $user->assignRole($managerRole);
        $user->givePermissionTo(Permission::all());

    }
}
