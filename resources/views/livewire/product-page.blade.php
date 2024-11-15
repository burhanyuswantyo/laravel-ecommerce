<div>
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">Data Produk</h5>

            <div>
                <input type="text" name="search" placeholder="Cari" class="form-control"
                    wire:model.live.debounce.500ms='filter.search'>
            </div>
        </div>
        <div class="d-flex justify-content-end align-items-end gap-2 mt-3">
            <div class="d-flex align-items-center gap-1 me-auto">
                <span>Menampilkan</span>
                <select wire:model.live='filter.paginate' class="form-select form-select-sm">
                    @foreach ($perPageOptions as $option)
                        <option value="{{ $option }}" @if ($option == $filter['paginate']) selected @endif>
                            {{ $option }}</option>
                    @endforeach
                </select>
                <span>produk</span>
            </div>
            <div>
                <span>Kategori:</span>
                <select wire:model.live='filter.category' class="form-select form-select-sm">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @if ($category->id == $filter['category']) selected @endif>
                            {{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <span>Status:</span>
                <select wire:model.live='filter.is_active' class="form-select form-select-sm">
                    <option value="" @if ($filter['is_active'] == '') selected @endif>
                        Semua Status</option>
                    <option value="active" @if ($filter['is_active'] == 'active') selected @endif>
                        Aktif</option>
                    <option value="inactive" @if ($filter['is_active'] == 'inactive') selected @endif>
                        Nonaktif</option>
                </select>
            </div>
            <div>
                <span>Kategori:</span>
                <select wire:model.live='sort' class="form-select form-select-sm">
                    @foreach ($sortTypes as $sortType)
                        <option value="{{ $sortType['field'] }}" @if ($sort == $sortType['field']) selected @endif>
                            {{ $sortType['label'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @if (!empty($selectedProducts))
            <div class="d-flex justify-content-between align-items-center gap-2 mt-3">
                <div>
                    <span>Terpilih: {{ count($selectedProducts) }} produk</span>
                </div>
                <div>
                    <button type="button" wire:click='activateSelectedProducts'
                        class="btn btn-sm btn-outline-success">Aktifkan</button>
                    <button type="button" wire:click='deactivateSelectedProducts'
                        class="btn btn-sm btn-outline-danger">Nonaktifkan</button>
                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                        data-bs-target="#deleteBulkModal">Hapus</button>
                </div>
            </div>
        @endif
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
                        <th scope="col">Status</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $key => $product)
                        <tr>
                            <td class="align-middle">
                                <input class="form-check-input" type="checkbox" value="{{ $product->id }}"
                                    wire:model.change='selectedProducts' id="{{ $product->id }}">
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ productImage($product) }}" class="rounded-2"
                                        style="width: 50px;height:50px;object-fit: cover" alt="{{ $product->name }}">
                                    <span>{{ $product->name }}</span>
                                </div>
                            </td>
                            <td>{{ $product->category->name }}</td>
                            <td>{{ rupiah($product->price) }}</td>
                            <td>{{ formatDate($product->created_at, 'd F Y H:m') }}</td>
                            <td>{{ formatHumanDate($product->updated_at) }}</td>
                            <td class="text-center">
                                @if ($product->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-danger">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2 justify-content-end">
                                    @if ($product->is_active)
                                        <button type="button" wire:loading.attr='disabled'
                                            wire:click='deactivateProduct("{{ $product->id }}")'
                                            class="btn btn-sm btn-outline-danger">
                                            Nonaktifkan</button>
                                    @else
                                        <button type="button" wire:loading.attr='disabled'
                                            wire:click='activateProduct("{{ $product->id }}")'
                                            class="btn btn-sm btn-outline-success">
                                            Aktifkan</button>
                                    @endif
                                    <a href="{{ route('admin.products-livewire.edit', $product) }}"
                                        class="btn btn-sm btn-warning">Edit</a>
                                    <button type="button" wire:click='addDeleteId("{{ $product->id }}")'
                                        class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal">Hapus</button>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $products->links() }}
    </div>
    <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <p class="fs-5">
                        Apakah Anda yakin ingin menghapus produk ini?
                    </p>
                    <div class="d-flex justify-content-center gap-2">
                        <button wire:loading.attr='disabled' type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button wire:loading.attr='disabled' type="button" wire:click='deleteProduct'
                            class="btn btn-danger btn-load" data-bs-dismiss="modal">
                            <div wire:loading wire:target='deleteProduct'>
                                <output class="spinner-border spinner-border-sm" aria-hidden="true"></output>
                            </div>
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="deleteBulkModal" tabindex="-1"
        aria-labelledby="deleteBulkModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <p class="fs-5">
                        Apakah Anda yakin ingin menghapus {{ count($selectedProducts) }} produk ini?
                    </p>
                    <div class="d-flex justify-content-center gap-2">
                        <button wire:loading.attr='disabled' type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button wire:loading.attr='disabled' type="button" wire:click='deleteSelectedProducts'
                            class="btn btn-danger btn-load" data-bs-dismiss="modal">
                            <div wire:loading wire:target='deleteSelectedProducts'>
                                <output class="spinner-border spinner-border-sm" aria-hidden="true"></output>
                            </div>
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
