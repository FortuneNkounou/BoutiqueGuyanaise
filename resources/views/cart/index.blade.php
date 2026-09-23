@extends('layouts.app')

@section('title', 'Mon panier — Boutique Guyanaise')

@section('content')
<div class="container">
    <h1 class="fw-bold mb-4"><i class="bi bi-cart3 me-2"></i>Mon panier</h1>

    @if(empty($products))
        <div class="text-center py-5">
            <div style="font-size:5rem;">🛒</div>
            <h4 class="mt-3 text-muted">Votre panier est vide</h4>
            <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">Découvrir nos produits</a>
        </div>
    @else
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <table class="table mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Produit</th>
                                    <th class="text-center">Prix unitaire</th>
                                    <th class="text-center" style="width:130px;">Quantité</th>
                                    <th class="text-end">Sous-total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $item)
                                <tr>
                                    <td>
                                        <a href="{{ route('products.show', $item['product']->slug) }}" class="fw-semibold text-decoration-none text-dark">
                                            {{ $item['product']->name }}
                                        </a>
                                    </td>
                                    <td class="text-center">{{ number_format($item['product']->price, 2, ',', ' ') }} €</td>
                                    <td>
                                        <form method="POST" action="{{ route('cart.update', $item['product']->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <div class="input-group input-group-sm">
                                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="99"
                                                       class="form-control text-center">
                                                <button type="submit" class="btn btn-outline-secondary" title="Mettre à jour">
                                                    <i class="bi bi-arrow-repeat"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </td>
                                    <td class="text-end fw-bold">{{ number_format($item['subtotal'], 2, ',', ' ') }} €</td>
                                    <td class="text-end">
                                        <form method="POST" action="{{ route('cart.remove', $item['product']->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Supprimer">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-3 d-flex justify-content-between">
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i>Continuer mes achats
                    </a>
                    <form method="POST" action="{{ route('cart.clear') }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="bi bi-trash me-1"></i>Vider le panier
                        </button>
                    </form>
                </div>
            </div>

            {{-- Résumé --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white fw-bold">
                        <i class="bi bi-receipt me-2"></i>Résumé de la commande
                    </div>
                    <div class="card-body">
                        @foreach($products as $item)
                        <div class="d-flex justify-content-between small mb-1">
                            <span class="text-muted">{{ $item['product']->name }} × {{ $item['quantity'] }}</span>
                            <span>{{ number_format($item['subtotal'], 2, ',', ' ') }} €</span>
                        </div>
                        @endforeach
                        <hr>
                        <div class="d-flex justify-content-between fw-bold fs-5">
                            <span>Total</span>
                            <span class="text-primary">{{ number_format($total, 2, ',', ' ') }} €</span>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        @auth
                            <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#checkoutModal">
                                <i class="bi bi-bag-check me-2"></i>Valider la commande
                            </button>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary w-100">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Connexion pour commander
                            </a>
                            <p class="text-muted text-center small mt-2 mb-0">
                                Pas encore de compte ? <a href="{{ route('register') }}">S'inscrire</a>
                            </p>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal validation commande --}}
        @auth
        <div class="modal fade" id="checkoutModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title"><i class="bi bi-bag-check me-2"></i>Valider la commande</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" action="{{ route('orders.store') }}">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Adresse de livraison</label>
                                <textarea name="shipping_address" class="form-control @error('shipping_address') is-invalid @enderror"
                                          rows="3" placeholder="Votre adresse complète..." required>{{ Auth::user()->address }}</textarea>
                                @error('shipping_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="alert alert-info small mb-0">
                                <i class="bi bi-info-circle me-1"></i>
                                Total : <strong>{{ number_format($total, 2, ',', ' ') }} €</strong>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i>Confirmer la commande
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endauth
    @endif
</div>
@endsection
