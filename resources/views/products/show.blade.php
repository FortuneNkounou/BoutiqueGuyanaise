@extends('layouts.app')

@section('title', $product->name . ' — Boutique Guyanaise')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produits</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        {{-- Image --}}
        <div class="col-md-5">
            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center" style="height:350px;">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded-3" style="max-height:350px;">
                @else
                    <span style="font-size:6rem;">🛍️</span>
                @endif
            </div>
        </div>

        {{-- Détails --}}
        <div class="col-md-7">
            <h1 class="fw-bold mb-2">{{ $product->name }}</h1>

            {{-- Catégories --}}
            <div class="mb-3">
                @foreach($product->categories as $cat)
                    <a href="{{ route('categories.show', $cat->slug) }}" class="badge bg-success text-decoration-none me-1">{{ $cat->name }}</a>
                @endforeach
            </div>

            <p class="fs-2 fw-bold text-primary mb-3">{{ number_format($product->price, 2, ',', ' ') }} €</p>

            @if($product->stock > 0)
                <p class="text-success mb-3"><i class="bi bi-check-circle me-1"></i>En stock ({{ $product->stock }} disponible(s))</p>
            @else
                <p class="text-danger mb-3"><i class="bi bi-x-circle me-1"></i>Rupture de stock</p>
            @endif

            <p class="text-muted mb-4">{{ $product->description }}</p>

            @if($product->stock > 0)
            <form method="POST" action="{{ route('cart.add', $product->id) }}" class="d-flex gap-3 align-items-center">
                @csrf
                <div style="width:90px;">
                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                           class="form-control text-center fw-bold">
                </div>
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-cart-plus me-2"></i>Ajouter au panier
                </button>
            </form>
            @endif
        </div>
    </div>

    {{-- Produits similaires --}}
    @if($related->isNotEmpty())
    <section class="mt-5">
        <h4 class="fw-bold mb-4">Produits similaires</h4>
        <div class="row g-4">
            @foreach($related as $rel)
            <div class="col-sm-6 col-md-3">
                <div class="card h-100 border-0 shadow-sm product-card">
                    <div class="product-img d-flex align-items-center justify-content-center bg-light rounded-top">
                        <span style="font-size:2.5rem;">🛍️</span>
                    </div>
                    <div class="card-body">
                        <h6 class="fw-semibold">{{ $rel->name }}</h6>
                        <p class="fw-bold text-primary mb-2">{{ number_format($rel->price, 2, ',', ' ') }} €</p>
                        <a href="{{ route('products.show', $rel->slug) }}" class="btn btn-outline-primary btn-sm w-100">Voir</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif
</div>
@endsection
