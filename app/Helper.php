<?php

use Illuminate\Support\Facades\File;

if (!function_exists('productImage')) {
    function productImage($product)
    {
        $image = $product->productImages->first()->image_path ?? null;

        if (File::exists('storage/' . $image)) {
            return asset('storage/' . $image);
        } else {
            return 'https://placehold.co/600x400/EEE/31343C';
        }
    }
}
