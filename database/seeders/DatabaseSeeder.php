<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Admin']);
        $managerRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Manager']);
        $staffRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Staff']);

        // Create Admin User
        $adminUser = User::firstOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Admin User',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
        ]);

        $adminUser->assignRole($adminRole);
    }
}
