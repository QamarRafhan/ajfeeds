<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Clean up old dummy permissions
        Permission::query()->delete();

        // 2. Create proper System Permissions
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
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // 3. Sync permissions to Admin Role
        $adminRole = Role::where('name', 'Admin')->first();
        if ($adminRole) {
            $adminRole->syncPermissions(Permission::all());
        }

        // 4. Seed Categories (AJ-Feeds focus)
        $categories = [
            ['name' => 'Poultry Feed', 'description' => 'Specialized feed for chickens, ducks, and turkeys.'],
            ['name' => 'Cattle Nutrition', 'description' => 'High-protein supplements for dairy and beef cattle.'],
            ['name' => 'Sheep & Goat Mix', 'description' => 'Balanced nutrients for small ruminants.'],
            ['name' => 'Agricultural Equipment', 'description' => 'Feeders, drinkers, and storage solutions.'],
            ['name' => 'Vitamins & Minerals', 'description' => 'Concentrated additives for herd health.'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['name' => $cat['name']], $cat);
        }

        // 5. Seed Suppliers
        $suppliers = [
            ['name' => 'Global Grain Corp', 'email' => 'sales@globalgrain.com', 'phone' => '0300-1112223', 'address' => 'Grain District, Karachi'],
            ['name' => 'Nutra-Mix Feed Additives', 'email' => 'info@nutra-mix.com', 'phone' => '0312-4445556', 'address' => 'Industrial Area, Faisalabad'],
            ['name' => 'Agri-Tech Solutions', 'email' => 'support@agritech.pk', 'phone' => '0333-7778889', 'address' => 'Model Town, Lahore'],
            ['name' => 'National Feed Mills', 'email' => 'contact@nationalfeed.com', 'phone' => '0345-9990001', 'address' => 'Sargodha Road, Sheikhupura'],
        ];

        foreach ($suppliers as $sup) {
            Supplier::firstOrCreate(['name' => $sup['name']], $sup);
        }

        // 6. Seed Products
        $poultryCat = Category::where('name', 'Poultry Feed')->first();
        $cattleCat = Category::where('name', 'Cattle Nutrition')->first();
        $vitCat = Category::where('name', 'Vitamins & Minerals')->first();

        $products = [
            [
                'name' => 'Layer Starter 2.0',
                'category_id' => $poultryCat->id,
                'sku' => 'AJ-PL-001',
                'description' => 'Premium starter feed for high-yielding layers.',
                'purchase_price' => 2100.00,
                'sale_price' => 2450.00,
                'stock_quantity' => 500,
                'min_stock_alert' => 50
            ],
            [
                'name' => 'Broiler Finisher XP',
                'category_id' => $poultryCat->id,
                'sku' => 'AJ-PL-002',
                'description' => 'High-energy finisher for rapid growth.',
                'purchase_price' => 2400.00,
                'sale_price' => 2800.00,
                'stock_quantity' => 1200,
                'min_stock_alert' => 100
            ],
            [
                'name' => 'Dairy Max Pro',
                'category_id' => $cattleCat->id,
                'sku' => 'AJ-CT-001',
                'description' => 'Milk boosting concentrate for dairy cows.',
                'purchase_price' => 2800.00,
                'sale_price' => 3200.00,
                'stock_quantity' => 300,
                'min_stock_alert' => 30
            ],
            [
                'name' => 'Gold-Vit Multivitamin (1kg)',
                'category_id' => $vitCat->id,
                'sku' => 'AJ-VT-001',
                'description' => 'Broad-spectrum vitamin supplement for all livestock.',
                'purchase_price' => 650.00,
                'sale_price' => 850.00,
                'stock_quantity' => 150,
                'min_stock_alert' => 20
            ],
            [
                'name' => 'Maize Crushed Blend',
                'category_id' => $poultryCat->id,
                'sku' => 'AJ-GR-001',
                'description' => 'High-quality crushed yellow maize.',
                'purchase_price' => 1600.00,
                'sale_price' => 1900.00,
                'stock_quantity' => 2000,
                'min_stock_alert' => 200
            ],
        ];

        foreach ($products as $prod) {
            Product::firstOrCreate(['name' => $prod['name']], $prod);
        }
    }
}
