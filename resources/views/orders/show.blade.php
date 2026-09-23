@extends('layouts.app')

@section('title', 'Commande #' . $order->id . ' — Boutique Guyanaise')

@section('content')
<div class="container">
    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary btn-sm mb-4">
        <i class="bi bi-arrow-left me-1"></i>Retour à mes commandes
    </a>

    <div class="row g-4">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Commande #{{ $order->id }}</h5>
                    @php
                        $badges = ['en_attente'=>'warning','confirmée'=>'info','expédiée'=>'primary','annulée'=>'danger'];
                        $badge = $badges[$order->status] ?? 'secondary';
                    @endphp
                    <span class="badge bg-{{ $badge }} fs-6">{{ ucfirst($order->status) }}</span>
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Produit</th>
                                <th class="text-center">Qté</th>
                                <th class="text-end">Prix unit.</th>
                                <th class="text-end">Sous-total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>{{ $item->product->name ?? 'Produit supprimé' }}</td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-end">{{ number_format($item->unit_price, 2, ',', ' ') }} €</td>
                                <td class="text-end fw-bold">{{ number_format($item->quantity * $item->unit_price, 2, ',', ' ') }} €</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Total</td>
                                <td class="text-end fw-bold text-primary fs-5">{{ number_format($order->total, 2, ',', ' ') }} €</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header fw-bold">Informations</div>
                <div class="card-body small">
                    <p class="mb-1"><strong>Date :</strong> {{ $order->created_at->format('d/m/Y à H:i') }}</p>
                    <p class="mb-1"><strong>Client :</strong> {{ $order->user->name }}</p>
                    <p class="mb-0"><strong>Adresse de livraison :</strong><br>{{ $order->shipping_address }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
