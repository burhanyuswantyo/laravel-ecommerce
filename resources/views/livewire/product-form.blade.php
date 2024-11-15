<div>
    <div class="d-flex justify-content-end">
        <button class="btn btn-primary" wire:click='addForm'>Tambah Form</button>
    </div>
    <div class="row">
        @foreach ($forms as $key => $form)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Form Tambah Produk {{ $loop->iteration }}</span>
                            @if (count($forms) > 1)
                                <button class="btn btn-sm btn-danger"
                                    wire:click='removeForm({{ $key }})'>Hapus</button>
                            @endif
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Produk</label>
                            <input type="text" wire:model="forms.{{ $key }}.name" class="form-control"
                                value="{{ old('name', $product->name ?? null) }}">
                            @error("forms.$key.name")
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea wire:model="forms.{{ $key }}.description" class="form-control">{{ old('description', $product->description ?? null) }}</textarea>
                            @error("forms.$key.description")
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select class="form-select" wire:model="forms.{{ $key }}.category_id">
                                <option hidden>Pilih kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        @if ($category->id == old('category_id', $product->category_id ?? null)) selected @endif>
                                        {{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error("forms.$key.category_id")
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="form-label">Harga</label>
                                <input type="number" wire:model="forms.{{ $key }}.price" class="form-control"
                                    value="{{ old('price', $product->price ?? null) }}">
                                @error("forms.$key.price")
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label class="form-label">Stok</label>
                                <input type="number" wire:model="forms.{{ $key }}.stock" class="form-control"
                                    value="{{ old('stock', $product->stock ?? null) }}">
                                @error("forms.$key.stock")
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Gambar</label>
                            <input type="file" multiple wire:model="forms.{{ $key }}.images"
                                class="form-control">
                            @error("forms.$key.images")
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        @if (!empty($forms[$key]['images']))
                            <div class="d-flex flex-wrap gap-2">
                                @foreach ($forms[$key]['images'] as $image)
                                    <img style="width: 80px;height: 80px;object-fit: cover"
                                        src="{{ $image->temporaryUrl() }}">
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('admin.products-livewire.index') }}" class="btn btn-secondary">Kembali</a>
        <button class="btn btn-primary" wire:click='submit'>Simpan</button>
    </div>
</div>
