<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use App\Models\User;
use App\Models\UserSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Reset Data (Careful with order of deletion)
        OrderItem::query()->delete();
        Order::query()->delete();
        PurchaseItem::query()->delete();
        Purchase::query()->delete();
        Product::query()->delete();
        Category::query()->delete();
        Supplier::query()->delete();
        
        // Roles & Permissions are handled by resetting permissions to ensure latest list
        Permission::query()->delete();

        // 2. Define Permissions
        $permissions = [
            'view dashboard',
            'manage inventory',
            'manage categories',
            'manage products',
            'manage suppliers',
            'manage purchases',
            'manage orders',
            'manage staff',
            'manage roles',
            'view reports',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        // 3. Create Roles & Assign Permissions
        $adminRole = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $adminRole->syncPermissions(Permission::all());

        $managerRole = Role::firstOrCreate(['name' => 'Manager', 'guard_name' => 'web']);
        $managerRole->syncPermissions(['view dashboard', 'manage inventory', 'manage products', 'manage suppliers', 'view reports']);

        $staffRole = Role::firstOrCreate(['name' => 'Staff', 'guard_name' => 'web']);
        $staffRole->syncPermissions(['view dashboard', 'manage orders']);

        // 4. Create Users (Total 5)
        $users = [
            [
                'name' => 'Qamar Rafhan',
                'email' => 'admin@ajfeeds.com',
                'password' => Hash::make('password'),
                'role' => 'Admin'
            ],
            [
                'name' => 'Manager User',
                'email' => 'manager@ajfeeds.com',
                'password' => Hash::make('password'),
                'role' => 'Manager'
            ],
            [
                'name' => 'Staff Alice',
                'email' => 'alice@ajfeeds.com',
                'password' => Hash::make('password'),
                'role' => 'Staff'
            ],
            [
                'name' => 'Staff Bob',
                'email' => 'bob@ajfeeds.com',
                'password' => Hash::make('password'),
                'role' => 'Staff'
            ],
            [
                'name' => 'Staff Charlie',
                'email' => 'charlie@ajfeeds.com',
                'password' => Hash::make('password'),
                'role' => 'Staff'
            ]
        ];

        foreach ($users as $u) {
            $user = User::create([
                'name' => $u['name'],
                'email' => $u['email'],
                'password' => $u['password'],
            ]);
            $user->assignRole($u['role']);
            
            // Create default settings
            UserSetting::create([
                'user_id' => $user->id,
                'theme_mode' => 'light_blue',
                'sidebar_type' => 'full'
            ]);
        }

        // 5. Seed Suppliers (20)
        $suppliers = Supplier::factory(20)->create();

        // 6. Seed Categories (5)
        $categories = Category::factory(8)->create();

        // 7. Seed Products (100)
        $products = Product::factory(100)->recycle($categories)->create();

        // 8. Seed Sales Orders (30)
        $staffUsers = User::role(['Staff', 'Admin', 'Manager'])->get();
        
        Order::factory(30)->recycle($staffUsers)->create()->each(function ($order) use ($products) {
            $itemsCount = rand(1, 4);
            $randomProducts = $products->random($itemsCount);
            $totalAmount = 0;

            foreach ($randomProducts as $product) {
                $qty = rand(1, 10);
                $price = $product->sale_price;
                $subtotal = $price * $qty;
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'unit_price' => $price,
                    'subtotal' => $subtotal
                ]);
                
                $totalAmount += $subtotal;
            }

            $order->update(['total_amount' => $totalAmount]);
        });

        // 9. Seed Purchases (15)
        Purchase::factory(15)->recycle($suppliers)->create()->each(function ($purchase) use ($products) {
            $itemsCount = rand(2, 5);
            $randomProducts = $products->random($itemsCount);
            $totalAmount = 0;

            foreach ($randomProducts as $product) {
                $qty = rand(10, 50);
                $price = $product->purchase_price;
                $subtotal = $price * $qty;
                
                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'unit_price' => $price,
                    'subtotal' => $subtotal
                ]);
                
                $totalAmount += $subtotal;
            }

            $purchase->update(['total_amount' => $totalAmount]);
        });
    }
}
