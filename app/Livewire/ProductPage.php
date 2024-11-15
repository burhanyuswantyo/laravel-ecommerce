<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Flasher\Prime\Notification\Type;
use Livewire\Component;
use Livewire\WithPagination;

class ProductPage extends Component
{
    use WithPagination;

    public $deleteId;
    public $selectedProducts = [];
    public $categories;

    public $filter = [
        'search' => '',
        'category' => '',
        'price' => '',
        'is_active' => '',
        'paginate' => 10,
    ];

    public $sort = 'created_at|desc';

    public $sortTypes = [
        ['field' => 'created_at|desc', 'label' => 'Produk terbaru'],
        ['field' => 'created_at|asc', 'label' => 'Produk terlama'],
        ['field' => 'price|desc', 'label' => 'Harga tertinggi'],
        ['field' => 'price|asc', 'label' => 'Harga terendah'],
    ];

    public $perPageOptions = [10, 25, 50, 100];

    public function mount()
    {
        $this->categories = Category::query()->orderBy('name')->get();
    }

    public function render()
    {
        $products = Product::query()
            ->filter($this->filter)
            ->sort($this->sort)
            ->paginate($this->filter['paginate']);

        return view('livewire.product-page', compact('products'));
    }

    public function addDeleteId($id)
    {
        $this->deleteId = $id;
    }

    public function deleteProduct()
    {
        try {
            $product = Product::query()->find($this->deleteId);
            $product->productImages()->delete();
            $product->delete();
            flash('Produk berhasil dihapus', Type::SUCCESS);
        } catch (\Exception $e) {
            flash('Produk gagal dihapus', Type::ERROR);
        }
    }

    public function deactivateProduct($id)
    {
        $product = Product::query()->find($id);
        $product->update(['is_active' => false]);
        flash('Produk berhasil dinonaktifkan', Type::SUCCESS);
    }

    public function activateProduct($id)
    {
        $product = Product::query()->find($id);
        $product->update(['is_active' => true]);
        flash('Produk berhasil diaktifkan', Type::SUCCESS);
    }

    public function deactivateSelectedProducts()
    {
        Product::query()->whereIn('id', $this->selectedProducts)->update(['is_active' => false]);
        flash('Produk terpilih berhasil dinonaktifkan', Type::SUCCESS);
        $this->selectedProducts = [];
    }

    public function activateSelectedProducts()
    {
        Product::query()->whereIn('id', $this->selectedProducts)->update(['is_active' => true]);
        flash('Produk terpilih berhasil diaktifkan', Type::SUCCESS);
        $this->reset('selectedProducts');
    }

    public function deleteSelectedProducts()
    {
        $products = Product::query()->whereIn('id', $this->selectedProducts);
        $products->each(function ($product) {
            $product->productImages()->delete();
            $product->delete();
        });
        flash('Produk terpilih berhasil dihapus', Type::SUCCESS);
        $this->reset('selectedProducts');
    }
}
