<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Flasher\Prime\Notification\Type;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::query()->where('name', 'like', '%' . request('search') . '%')->get();

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin.products.form', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required',
            'images' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [], [
            'images.*' => 'Gambar',
        ]);

        try {
            $product = Product::query()->create($request->all());
            foreach ($request->images as $image) {
                $fileName = $image->store('products', 'public');
                $product->productImages()->create(['image_path' => $fileName]);
            }

            flash('Produk berhasil ditambahkan.', Type::SUCCESS);
        } catch (\Exception $e) {
            flash('Produk gagal ditambahkan.', Type::ERROR);
        }


        return redirect()->route('admin.products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::query()->findOrFail($id);
        $categories = Category::all();

        return view('admin.products.form', compact('categories', 'product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::query()->findOrFail($id);
        $categories = Category::all();

        return view('admin.products.form', compact('categories', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required',
        ]);

        try {
            $product = Product::query()->findOrFail($id);
            $product->update($request->all());
            flash('Produk berhasil diperbarui.', Type::SUCCESS);
        } catch (\Exception $e) {
            flash('Produk gagal diperbarui.', Type::ERROR);
        }

        return redirect()->route('admin.products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $product = Product::query()->findOrFail($id);
            $product->productImages()->delete();
            $product->delete();

            flash('Produk berhasil dihapus.', Type::SUCCESS);
            return redirect()->back();
        } catch (\Exception $e) {
            flash('Produk gagal dihapus.', Type::ERROR);
            return redirect()->back();
        }
    }
}
