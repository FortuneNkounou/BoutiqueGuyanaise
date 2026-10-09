@extends('layouts.app')

@section('title', 'Boutique Guyanaise — Produits locaux authentiques')

@section('content')

{{-- Hero --}}
<div class="hero-section mb-5">
    <div class="hero-overlay"></div>
    <div class="container text-center hero-content">
        <h1 class="display-3 fw-bold mb-3">🌿 Kréyol Market</h1>
        <p class="lead fs-4 mb-4">Découvrez les saveurs et l'artisanat authentiques de Guyane française directement chez vous.</p>
        <a href="{{ route('products.index') }}" class="btn btn-warning btn-lg me-2">
            <i class="bi bi-bag me-2"></i>Découvrir nos produits
        </a>
        @guest
            <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">
                <i class="bi bi-person-plus me-2"></i>Créer un compte
            </a>
        @endguest
    </div>
</div>

<div class="container">

    {{-- Catégories --}}
    @if($categories->isNotEmpty())
    <section class="mb-5">
        <h2 class="fw-bold mb-4">Nos catégories</h2>
        <div class="row g-3">
            @foreach($categories as $category)
            <div class="col-6 col-md-4 col-lg-2">
                <a href="{{ route('categories.show', $category->slug) }}" class="text-decoration-none">
                    <div class="card text-center h-100 border-0 shadow-sm product-card">
                        <div class="card-body py-4">
                            <div class="fs-1 mb-2"></div>
                            <p class="fw-semibold mb-1 small">{{ $category->name }}</p>
                            <p class="text-muted" style="font-size:.75rem;">{{ $category->products_count }} produit(s)</p>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Produits en vedette --}}
    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Produits en vedette</h2>
            <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-sm">Voir tout</a>
        </div>

        @if($featured_products->isEmpty())
            <div class="alert alert-info">Aucun produit disponible pour le moment.</div>
        @else
        <div class="row g-4">
            @foreach($featured_products as $product)
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
                        <p class="text-muted small flex-grow-1">{{ Str::limit($product->description, 60) }}</p>
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
                        <a href="{{ route('products.show', $product->slug) }}" class="btn btn-outline-secondary btn-sm mt-2">Voir le produit</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </section>

    {{-- Bannière avantages --}}
    <section class="bg-light rounded-3 p-5 mb-5">
        <div class="row text-center g-4">
            <div class="col-md-4">
                <div class="fs-1">🚚</div>
                <h5 class="fw-bold mt-2">Livraison rapide</h5>
                <p class="text-muted small">Expédition sous 48h depuis la Guyane.</p>
            </div>
            <div class="col-md-4">
                <div class="fs-1">🌿</div>
                <h5 class="fw-bold mt-2">100% local</h5>
                <p class="text-muted small">Produits authentiques directement des producteurs guyanais.</p>
            </div>
            <div class="col-md-4">
                <div class="fs-1">🔒</div>
                <h5 class="fw-bold mt-2">Paiement sécurisé</h5>
                <p class="text-muted small">Vos données sont protégées à chaque transaction.</p>
            </div>
        </div>
    </section>

</div>
@endsection
