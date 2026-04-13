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
        // // Create roles
        // $adminRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Admin']);
        // // Create Admin User
        // $adminUser = User::firstOrCreate([
        //     'email' => 'admin@gmail.com',
        // ], [
        //     'name' => 'Admin User',
        //     'password' => \Illuminate\Support\Facades\Hash::make('password'),
        // ]);
        // $adminUser->assignRole($adminRole);

        // Call full inventory seeder
        $this->call(InventorySeeder::class);
        $this->call(CustomerSeeder::class);
    }
}
