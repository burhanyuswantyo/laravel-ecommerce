<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Product::query()->truncate();
        Category::query()->truncate();
        ProductImage::query()->truncate();
        // Delete all files in the products directory
        Storage::deleteDirectory(storage_path('app/public/products'));

        Category::factory(5)->has(
            Product::factory()->count(10)->has(
                ProductImage::factory()->count(3)
            )
        )->create();
    }
}
