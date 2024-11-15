<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductForm extends Component
{
    use WithFileUploads;

    public $categories;
    public $forms = [
        [
            'name' => '',
            'description' => '',
            'price' => '',
            'stock' => '',
            'category_id' => '',
            'images' => []
        ]
    ];

    public function mount()
    {
        $this->categories = Category::all();
    }

    public function render()
    {
        return view('livewire.product-form');
    }

    public function addForm()
    {
        $this->forms[] = [
            'name' => '',
            'description' => '',
            'price' => '',
            'stock' => '',
            'category_id' => '',
        ];
    }

    public function removeForm($index)
    {
        unset($this->forms[$index]);
        $this->forms = array_values($this->forms);
    }

    public function submit()
    {
        $this->validate([
            'forms.*.name' => ['required'],
            'forms.*.description' => ['required'],
            'forms.*.price' => ['required', 'numeric'],
            'forms.*.stock' => ['required', 'numeric'],
            'forms.*.category_id' => ['required'],
        ], attributes: [
            'forms.*.name' => 'Nama',
            'forms.*.description' => 'Deskripsi',
            'forms.*.price' => 'Harga',
            'forms.*.stock' => 'Stok',
            'forms.*.category_id' => 'Kategori',
        ]);

        foreach ($this->forms as $form) {
            $products = Product::create($form);
            foreach ($form['images'] as $image) {
                $products->productImages()->create([
                    'image_path' => $image->store('products', 'public')
                ]);
            }
        }

        flash('Produk berhasil ditambahkan!');
        return to_route('admin.products-livewire.index');
    }
}
