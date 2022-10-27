<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UsersTableSeeder');

        DB::table('users')->insert([
            'username' => 'dudu',
            'password' => Hash::make('12345'),
            'first_name' => 'dudu',
            'last_name' => 'dos Montes',
            'email' => 'duduzinho@dudao.com',
            // 'address_1' => 'Monte amarelo',
            // 'address_2' => '',
            // 'city' => 'Faro',
            // 'postal_code' => '8000',
            // 'country' => 'Espanha',
            // 'mobile' => '913512512',
            // 'telephone' => '289804829',
            'high_permission' => false
        ]);

        DB::table('users')->insert([
            'username' => 'fefe',
            'password' => Hash::make('12345'),
            'first_name' => 'fefe',
            'last_name' => 'oculinhos',
            'email' => 'fefe_glass@hotmail.com',
            // 'address_1' => 'Num Prédio',
            // 'address_2' => '',
            // 'city' => 'Faro',
            // 'postal_code' => '8005',
            // 'country' => 'Portugal',
            // 'mobile' => '913512777',
            // 'telephone' => '289804345',
            'high_permission' => true
        ]);

        DB::table('categories')->insert([
            'name' => 'Computers and Software'
        ]);

        DB::table('sub_categories')->insert([
            'name' => 'Laptops',
            'categories_id' => 1
        ]);

        DB::table('products')->insert([
            'name'=> 'Apple MacBook Pro 2021',
            'desc' => 'Apple M1 Pro CPU-8 core, GPU-14 core e Neural Engine 16-core macOS 16-GB',
            'price' => 2099,
            'stock_quantity' => 8,
            'sub_categories_id' => 1

        ]);

    }
}
