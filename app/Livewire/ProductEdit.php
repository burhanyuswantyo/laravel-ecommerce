<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;

class ProductEdit extends Component
{
    public $product;
    public $categories;
    public $forms;

    public function mount()
    {
        $this->categories = Category::all();
        $this->forms = [
            'name' => $this->product->name,
            'description' => $this->product->description,
            'price' => $this->product->price,
            'stock' => $this->product->stock,
            'category_id' => $this->product->category_id,
        ];
    }

    public function render()
    {
        return view('livewire.product-edit');
    }

    public function submit()
    {
        $this->validate([
            'forms.name' => ['required'],
            'forms.description' => ['required'],
            'forms.price' => ['required', 'numeric'],
            'forms.stock' => ['required', 'numeric'],
            'forms.category_id' => ['required'],
        ], attributes: [
            'forms.name' => 'Nama',
            'forms.description' => 'Deskripsi',
            'forms.price' => 'Harga',
            'forms.stock' => 'Stok',
            'forms.category_id' => 'Kategori',
        ]);

        $product = Product::find($this->product->id);
        $product->update($this->forms);


        flash('Produk berhasil ditambahkan!');
        return to_route('admin.products-livewire.index');
    }
}
