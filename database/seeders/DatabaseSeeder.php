<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Hash; 

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        DB::table('tbl_user')->insert([
            [
                'name' => 'Super Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('superadmin'),
                'role' => 'admin',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Staff',
                'email' => 'staff@gmail.com',
                'password' => Hash::make('staff'),
                'role' => 'staff',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Technician',
                'email' => 'technician@gmail.com',
                'password' => Hash::make('technician'),
                'role' => 'technician',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Chew Jia Wei',
                'email' => 'chewjiawei123@gmail.com',
                'password' => Hash::make('chewjiawei'),
                'role' => 'customer',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('tbl_category')->insert([
            ['name' => 'Computers', 'created_at' => now()],
            ['name' => 'Accessories', 'created_at' => now()],
            ['name' => 'Monitors', 'created_at' => now()],
            ['name' => 'Printers', 'created_at' => now()],
        ]);

        DB::table('tbl_product')->insert([
            ['name' => 'Gaming Mouse', 'price' => 89.00, 'description' => 'High performance gaming mouse with RGB lighting', 'stock_quantity' => 15, 'category_id' => 2, 'created_at' => now()],
            ['name' => 'Mechanical Keyboard', 'price' => 150.00, 'description' => 'RGB mechanical keyboard with blue switches', 'stock_quantity' => 10, 'category_id' => 2, 'created_at' => now()],
            ['name' => '24 Inch Monitor', 'price' => 450.00, 'description' => 'Full HD IPS monitor', 'stock_quantity' => 5, 'category_id' => 3, 'created_at' => now()],
            ['name' => 'Laptop', 'price' => 1500.00, 'description' => 'High performance ROG laptop', 'stock_quantity' => 20, 'category_id' => 2, 'created_at' => now()],
        ]);
    }
}
