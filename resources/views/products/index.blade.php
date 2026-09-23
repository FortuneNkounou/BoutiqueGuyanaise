@extends('layouts.app')

@section('title', 'Produits — Boutique Guyanaise')

@section('content')
<div class="container">
    <h1 class="fw-bold mb-4">Nos produits</h1>

    {{-- Filtres --}}
    <form method="GET" action="{{ route('products.index') }}" class="row g-2 mb-4">
        <div class="col-md-5">
            <input type="text" name="search" class="form-control" placeholder="Rechercher un produit..."
                   value="{{ request('search') }}">
        </div>
        <div class="col-md-4">
            <select name="category" class="form-select">
                <option value="">Toutes les catégories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->slug }}" @selected(request('category') === $cat->slug)>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-search me-1"></i>Filtrer
            </button>
        </div>
        @if(request('search') || request('category'))
        <div class="col-md-1">
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary w-100" title="Réinitialiser">
                <i class="bi bi-x-lg"></i>
            </a>
        </div>
        @endif
    </form>

    @if($products->isEmpty())
        <div class="alert alert-info">Aucun produit trouvé.</div>
    @else
        <p class="text-muted small mb-3">{{ $products->total() }} produit(s) trouvé(s)</p>
        <div class="row g-4">
            @foreach($products as $product)
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 border-0 shadow-sm product-card">
                    <div class="product-img d-flex align-items-center justify-content-center bg-light rounded-top">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid h-100 w-100 object-fit-cover">
                        @else
                            <span style="font-size:3rem;">🛍️</span>
                        @endif
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title fw-semibold">{{ $product->name }}</h6>
                        <div class="mb-2">
                            @foreach($product->categories as $cat)
                                <span class="badge bg-success bg-opacity-10 text-success" style="font-size:.7rem;">{{ $cat->name }}</span>
                            @endforeach
                        </div>
                        <p class="text-muted small flex-grow-1">{{ Str::limit($product->description, 70) }}</p>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <span class="fw-bold text-primary fs-5">{{ number_format($product->price, 2, ',', ' ') }} €</span>
                            <form method="POST" action="{{ route('cart.add', $product->id) }}">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="bi bi-cart-plus"></i>
                                </button>
                            </form>
                        </div>
                        <a href="{{ route('products.show', $product->slug) }}" class="btn btn-outline-secondary btn-sm mt-2">Voir le détail</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
