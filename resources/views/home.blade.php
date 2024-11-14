@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="row g-3">
          @foreach ($products as $key => $product)
            <div class="col-sm-4">
              <div class="card">
                <img src="{{ productImage($product) }}" class="card-img-top" alt="product-{{ $key }}">
                <div class="card-body">
                  <h5 class="card-title">{{ Str::limit($product->name, 20) }}</h5>
                  <p class="card-text">{{ Str::limit($product->description, 50) }}</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
@endsection
