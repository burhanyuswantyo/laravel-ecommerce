@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="mb-2 d-flex">
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary ms-auto">Tambah Produk</a>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Data Produk</h5>
                            <div>
                                <form action="{{ route('admin.products.index') }}">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control"
                                            value="{{ request('search') }}">
                                        <button class="btn btn-outline-secondary" type="submit">Cari</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col" colspan="">Nama Produk</th>
                                        <th scope="col">Kategori</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Dibuat Pada</th>
                                        <th scope="col">Terakhir Diubah</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($products as $product)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <img src="{{ productImage($product) }}" class="rounded-2"
                                                        style="width: 50px;height:50px;object-fit: cover"
                                                        alt="{{ $product->name }}">
                                                    <span>{{ $product->name }}</span>
                                                </div>
                                            </td>
                                            <td>{{ $product->category->name }}</td>
                                            <td>{{ rupiah($product->price) }}</td>
                                            <td>{{ formatDate($product->created_at, 'd F Y H:m') }}</td>
                                            <td>{{ formatHumanDate($product->updated_at) }}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('admin.products.edit', $product) }}"
                                                        class="btn btn-sm btn-warning">Edit</a>
                                                    <form action="{{ route('admin.products.destroy', $product) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Apakah anda yakin ingin menghapus produk ini?')">Hapus</button>
                                                    </form>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{-- {{ $products->links() }} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
