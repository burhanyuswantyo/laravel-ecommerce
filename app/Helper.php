<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\File;

if (!function_exists('productImage')) {
    function productImage($product)
    {
        $image = $product->productImages->first()->image_path ?? null;

        if (File::exists('storage/' . $image)) {
            return asset('storage/' . $image);
        } else {
            return asset('images/blank-image.jpg');
        }
    }
}

if (!function_exists('rupiah')) {
    function rupiah($value)
    {
        return $value ? 'Rp ' . number_format($value, 0, ',', '.') : 'Rp 0';
    }
}

if (!function_exists('formatDate')) {
    function formatDate($date, $format = 'd F Y')
    {
        return $date ? Carbon::parse($date)->translatedFormat($format) : null;
    }
}

if (!function_exists('formatHumanDate')) {
    function formatHumanDate($date)
    {
        return $date ? Carbon::parse($date)->diffForHumans() : null;
    }
}
