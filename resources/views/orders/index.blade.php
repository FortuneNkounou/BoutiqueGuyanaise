@extends('layouts.app')

@section('title', 'Mes commandes — Boutique Guyanaise')

@section('content')
<div class="container">
    <h1 class="fw-bold mb-4"><i class="bi bi-bag me-2"></i>Mes commandes</h1>

    @if($orders->isEmpty())
        <div class="text-center py-5">
            <div style="font-size:5rem;">📦</div>
            <h4 class="mt-3 text-muted">Vous n'avez pas encore de commandes</h4>
            <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">Commencer mes achats</a>
        </div>
    @else
        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Articles</th>
                            <th class="text-end">Total</th>
                            <th class="text-center">Statut</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td class="fw-bold">#{{ $order->id }}</td>
                            <td>{{ $order->created_at->format('d/m/Y') }}</td>
                            <td>{{ $order->items->count() }} article(s)</td>
                            <td class="text-end fw-bold">{{ number_format($order->total, 2, ',', ' ') }} €</td>
                            <td class="text-center">
                                @php
                                    $badges = [
                                        'en_attente' => 'warning',
                                        'confirmée'  => 'info',
                                        'expédiée'   => 'primary',
                                        'annulée'    => 'danger',
                                    ];
                                    $badge = $badges[$order->status] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $badge }}">{{ ucfirst($order->status) }}</span>
                            </td>
                            <td>
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye me-1"></i>Détails
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
