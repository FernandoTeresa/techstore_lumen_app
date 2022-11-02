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
            'admin' => false
        ]);

        DB::table('users')->insert([
            'username' => 'fefe',
            'password' => Hash::make('12345'),
            'first_name' => 'fefe',
            'last_name' => 'oculinhos',
            'email' => 'fefe_glass@hotmail.com',
            'admin' => true
        ]);

        DB::table('userinfo')->insert([
            'address_1' => 'Monte amarelo',
            'address_2' => '',
            'city' => 'Faro',
            'postal_code' => '8000',
            'country' => 'Espanha',
            'mobile' => 913512512,
            'telephone' => 289804829,
            'user_id' => 1
        ]);

        DB::table('userinfo')->insert([
            'address_1' => 'Num Prédio',
            'address_2' => '',
            'city' => 'Faro',
            'postal_code' => '8005',
            'country' => 'Portugal',
            'mobile' => 913512777,
            'telephone' => 289804345,
            'user_id' => 2
        ]);

        DB::table('categories')->insert([
            'name' => 'Computers and Software'
        ]);

        DB::table('categories')->insert([
            'name' => 'Printers'
        ]);

        DB::table('sub_categories')->insert([
            'name' => 'Laptops',
            'categories_id' => 1
        ]);

        DB::table('sub_categories')->insert([
            'name' => '3D',
            'categories_id' => 2
        ]);

        DB::table('products')->insert([
            'name'=> 'Apple MacBook Pro 2021',
            'desc' => 'Apple M1 Pro CPU-8 core, GPU-14 core e Neural Engine 16-core macOS 16-GB',
            'price' => 2099,
            'stock' => 8,
            'sub_categories_id' => 1
        ]);

        DB::table('products')->insert([
            'name'=> 'printer Hp',
            'desc' => 'muita nice',
            'price' => 856.93,
            'stock' => 2,
            'sub_categories_id' => 2
        ]);

        DB::table('products_images')->insert([
            'images' => '/var/www/html/app/public/img/AppleMacBookPro2021/391.jpg',
            'product_id' => 1
        ]);

        DB::table('products_images')->insert([
            'images' => '/var/www/html/app/public/img/AppleMacBookPro2021/680.jpg',
            'product_id' => 1
        ]);

        DB::table('products_images')->insert([
            'images' => '/var/www/html/app/public/img/printerHp/852.jpg',
            'product_id' => 2
        ]);

        DB::table('products_images')->insert([
            'images' => '/var/www/html/app/public/img/printerHp/995.jpg',
            'product_id' => 2
        ]);



        

    }
}
