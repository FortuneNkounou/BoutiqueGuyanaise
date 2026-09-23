@extends('layouts.app')

@section('title', 'Catégories — Boutique Guyanaise')

@section('content')
<div class="container">
    <h1 class="fw-bold mb-4">Toutes les catégories</h1>
    <div class="row g-4">
        @foreach($categories as $category)
        <div class="col-sm-6 col-md-4">
            <a href="{{ route('categories.show', $category->slug) }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm product-card h-100">
                    <div class="card-body p-4">
                        <h4 class="fw-bold mb-1">{{ $category->name }}</h4>
                        <p class="text-muted small mb-3">{{ $category->description }}</p>
                        <span class="badge bg-primary">{{ $category->products_count }} produit(s)</span>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection
