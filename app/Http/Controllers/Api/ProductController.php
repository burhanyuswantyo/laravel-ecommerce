<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::query()->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Data produk berhasil diambil.',
            'data' => $products,
        ]);
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
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [], [
            'images.*' => 'Gambar',
        ]);

        try {
            $product = Product::query()->create($request->except('images'));
            foreach ($request->images as $image) {
                $fileName = $image->store('products', 'public');
                $product->productImages()->create(['image_path' => $fileName]);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Data produk berhasil ditambahkan.',
                'data' => $product->load('productImages'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::query()->find($id);

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data produk tidak ditemukan.',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data produk berhasil diambil.',
            'data' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::query()->find($id);

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data produk tidak ditemukan.',
                'data' => null,
            ], 404);
        }

        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required',
        ]);

        try {
            $product->update($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Data produk berhasil diupdate.',
                'data' => $product->load('productImages'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data produk gagal diupdate.',
                'data' => null,
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::query()->find($id);

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data produk tidak ditemukan.',
                'data' => null,
            ], 404);
        }

        try {
            $product->productImages()->delete();
            $product->delete();
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data produk gagal dihapus.',
                'data' => null,
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data produk berhasil dihapus.',
            'data' => null,
        ]);
    }
}
