<div>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Form Edit Produk
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" wire:model="forms.name" class="form-control"
                            value="{{ old('name', $product->name ?? null) }}">
                        @error('forms.name')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea wire:model="forms.description" class="form-control">{{ old('description', $product->description ?? null) }}</textarea>
                        @error('forms.description')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select class="form-select" wire:model="forms.category_id">
                            <option hidden>Pilih kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @if ($category->id == old('category_id', $product->category_id ?? null)) selected @endif>
                                    {{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('forms.category_id')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">Harga</label>
                            <input type="number" wire:model="forms.price" class="form-control"
                                value="{{ old('price', $product->price ?? null) }}">
                            @error('forms.price')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label class="form-label">Stok</label>
                            <input type="number" wire:model="forms.stock" class="form-control"
                                value="{{ old('stock', $product->stock ?? null) }}">
                            @error('forms.stock')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    {{-- <div class="mb-3">
                        <label class="form-label">Gambar</label>
                        <input type="file" multiple wire:model="forms.images" class="form-control">
                        @error('forms.images')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    @if (!empty($forms['images']))
                        <div class="d-flex flex-wrap gap-2">
                            @foreach ($forms['images'] as $image)
                                <img style="width: 80px;height: 80px;object-fit: cover"
                                    src="{{ $image->temporaryUrl() }}">
                            @endforeach
                        </div>
                    @endif --}}
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('admin.products-livewire.index') }}" class="btn btn-secondary">Kembali</a>
        <button class="btn btn-primary" wire:click='submit'>Simpan</button>
    </div>
</div>
