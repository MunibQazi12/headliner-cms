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
        $products = [
            ['name' => "Airline Cut Dry Ice"],
            ['name' => "Dry Ice Pellets"],
            ['name' => "High-Density Dry Ice Pellets"],
            ['name' => "5 lb. Dry Ice Blocks"],
        ];
        foreach ($products as $key => $product) {
            Product::create($product);
        }
    }
}
