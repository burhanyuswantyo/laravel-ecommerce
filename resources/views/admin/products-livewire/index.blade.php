@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="mb-2 d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.products-livewire.create') }}" class="btn btn-primary ms-auto">Tambah Produk</a>
                </div>
                <div class="card">
                    @livewire('product-page')
                </div>
            </div>
        </div>
    </div>
@endsection
