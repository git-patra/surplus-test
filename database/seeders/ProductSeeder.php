<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $product = Product::query()->create([
            'id' => 1,
            'name' => 'Ayam Krispi',
            'description' => 'Makanan cepat saji yang benar sangat cepat.',
            'enable' => true,
            'created_at' => now(),
        ]);

        $product->categories()->attach([1]);
        $product->images()->attach([1]);
        $product->save();
    }
}
