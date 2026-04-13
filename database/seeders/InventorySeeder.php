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
use App\Enums\ThemeMode;

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
            ['name' => 'view.dashboard', 'group_name' => 'dashboard'],

            ['name' => 'view.categories', 'group_name' => 'categories'],
            ['name' => 'create.categories', 'group_name' => 'categories'],
            ['name' => 'update.categories', 'group_name' => 'categories'],
            ['name' => 'delete.categories', 'group_name' => 'categories'],

            ['name' => 'view.products', 'group_name' => 'products'],
            ['name' => 'create.products', 'group_name' => 'products'],
            ['name' => 'update.products', 'group_name' => 'products'],
            ['name' => 'delete.products', 'group_name' => 'products'],

            ['name' => 'view.suppliers', 'group_name' => 'suppliers'],
            ['name' => 'create.suppliers', 'group_name' => 'suppliers'],
            ['name' => 'update.suppliers', 'group_name' => 'suppliers'],
            ['name' => 'delete.suppliers', 'group_name' => 'suppliers'],

            ['name' => 'view.purchases', 'group_name' => 'purchases'],
            ['name' => 'create.purchases', 'group_name' => 'purchases'],
            ['name' => 'update.purchases', 'group_name' => 'purchases'],
            ['name' => 'delete.purchases', 'group_name' => 'purchases'],

            ['name' => 'view.orders', 'group_name' => 'orders'],
            ['name' => 'create.orders', 'group_name' => 'orders'],
            ['name' => 'update.orders', 'group_name' => 'orders'],
            ['name' => 'delete.orders', 'group_name' => 'orders'],

            ['name' => 'view.staff', 'group_name' => 'staff'],
            ['name' => 'create.staff', 'group_name' => 'staff'],
            ['name' => 'update.staff', 'group_name' => 'staff'],
            ['name' => 'delete.staff', 'group_name' => 'staff'],

            ['name' => 'view.customers', 'group_name' => 'customers'],
            ['name' => 'create.customers', 'group_name' => 'customers'],
            ['name' => 'update.customers', 'group_name' => 'customers'],
            ['name' => 'delete.customers', 'group_name' => 'customers'],

            ['name' => 'view.roles', 'group_name' => 'roles'],
            ['name' => 'create.roles', 'group_name' => 'roles'],
            ['name' => 'update.roles', 'group_name' => 'roles'],
            ['name' => 'delete.roles', 'group_name' => 'roles'],

            ['name' => 'view.reports', 'group_name' => 'reports'],

        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission['name'],
                'group_name' => $permission['group_name'],
                'guard_name' => 'web',
            ]);
        }

        // 3. Create Roles & Assign Permissions
        $adminRole = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $adminRole->syncPermissions(Permission::all());

        $managerRole = Role::firstOrCreate(['name' => 'Manager', 'guard_name' => 'web']);
        $staffRole = Role::firstOrCreate(['name' => 'Staff', 'guard_name' => 'web']);
        // $staffRole->syncPermissions(['view.dashboard', 'view.products']);


        // 4. Create Users (Total 5)
        $users = [
            [
                'name' => 'Qamar Rafhan',
                'email' => 'admin@gmail.com',
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
                'theme_mode' => ThemeMode::LIGHT_BLUE->value,
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
