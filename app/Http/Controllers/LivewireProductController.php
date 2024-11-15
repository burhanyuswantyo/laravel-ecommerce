<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class LivewireProductController extends Controller
{

    public function index()
    {
        return view('admin.products-livewire.index');
    }

    public function create()
    {
        return view('admin.products-livewire.form');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return view('admin.products-livewire.edit', compact('product'));
    }
}
