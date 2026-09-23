@extends('layouts.app')

@section('title', $category->name . ' — Boutique Guyanaise')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Catégories</a></li>
            <li class="breadcrumb-item active">{{ $category->name }}</li>
        </ol>
    </nav>

    <h1 class="fw-bold mb-2">{{ $category->name }}</h1>
    @if($category->description)
        <p class="text-muted mb-4">{{ $category->description }}</p>
    @endif

    @if($products->isEmpty())
        <div class="alert alert-info">Aucun produit dans cette catégorie.</div>
    @else
        <div class="row g-4">
            @foreach($products as $product)
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 border-0 shadow-sm product-card">
                    <div class="product-img d-flex align-items-center justify-content-center bg-light rounded-top">
                        <span style="font-size:3rem;">🛍️</span>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h6 class="fw-semibold">{{ $product->name }}</h6>
                        <p class="text-muted small flex-grow-1">{{ Str::limit($product->description, 70) }}</p>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <span class="fw-bold text-primary">{{ number_format($product->price, 2, ',', ' ') }} €</span>
                            <form method="POST" action="{{ route('cart.add', $product->id) }}">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button class="btn btn-primary btn-sm"><i class="bi bi-cart-plus"></i></button>
                            </form>
                        </div>
                        <a href="{{ route('products.show', $product->slug) }}" class="btn btn-outline-secondary btn-sm mt-2">Voir le détail</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-4">{{ $products->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
