@php
    $isEdit = isset($product);
@endphp

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Form Tambah Produk
                    </div>
                    <div class="card-body">
                        <form
                            action="{{ $isEdit ? route('admin.products.update', $product->id) : route('admin.products.store') }}"
                            method="post" enctype="multipart/form-data">
                            @csrf
                            @method($isEdit ? 'PUT' : 'POST')
                            <div class="mb-3">
                                <label class="form-label">Nama Produk</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', $product->name ?? null) }}">
                                @error('name')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="description" class="form-control">{{ old('description', $product->description ?? null) }}</textarea>
                                @error('description')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <select class="form-select" name="category_id">
                                    <option hidden>Pilih kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            @if ($category->id == old('category_id', $product->category_id ?? null)) selected @endif>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <label class="form-label">Harga</label>
                                    <input type="number" name="price" class="form-control"
                                        value="{{ old('price', $product->price ?? null) }}">
                                    @error('price')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Stok</label>
                                    <input type="number" name="stock" class="form-control"
                                        value="{{ old('stock', $product->stock ?? null) }}">
                                    @error('stock')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            @unless ($isEdit)
                                <div class="mb-3">
                                    <label class="form-label">Gambar</label>
                                    <input type="file" multiple name="images[]" class="form-control"
                                        value="{{ old('images[,$product->name??null]') }}">
                                    @error('images.*')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endunless
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
