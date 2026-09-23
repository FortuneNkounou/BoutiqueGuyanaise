@extends('layouts.admin')
@section('title', 'Produits — Administration')
@section('page-title', 'Gestion des produits')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Produits</h4>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Nouveau produit
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Nom</th>
                    <th>Catégories</th>
                    <th class="text-end">Prix</th>
                    <th class="text-center">Stock</th>
                    <th class="text-center">Actif</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td class="fw-semibold">{{ $product->name }}</td>
                    <td>
                        @foreach($product->categories as $cat)
                            <span class="badge bg-success bg-opacity-10 text-success">{{ $cat->name }}</span>
                        @endforeach
                    </td>
                    <td class="text-end">{{ number_format($product->price, 2, ',', ' ') }} €</td>
                    <td class="text-center">{{ $product->stock }}</td>
                    <td class="text-center">
                        @if($product->active)
                            <span class="badge bg-success">Oui</span>
                        @else
                            <span class="badge bg-secondary">Non</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="d-inline"
                              onsubmit="return confirm('Supprimer ce produit ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Aucun produit.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($products->hasPages())
        <div class="card-footer bg-white">{{ $products->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
