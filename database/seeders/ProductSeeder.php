<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::upsert([
            ['id' => 1, 'title' => '固定資料', 'content' => '固定內容', 'price' => rand(0,300), 'quantity' => 20],
            ['id' => 12, 'title' => '固定資料', 'content' => '固定內容', 'price' => rand(0,300), 'quantity' => 20]
        ],['id'], ['price', 'quantity']);
    }
}
