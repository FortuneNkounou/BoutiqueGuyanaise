@extends('layouts.admin')

@section('title', 'Tableau de bord — Administration')
@section('page-title', 'Tableau de bord')

@section('content')

<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm text-center p-3">
            <div class="fs-1 text-primary">{{ $stats['users'] }}</div>
            <div class="text-muted small">Utilisateurs</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm text-center p-3">
            <div class="fs-1 text-success">{{ $stats['products'] }}</div>
            <div class="text-muted small">Produits</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm text-center p-3">
            <div class="fs-1 text-warning">{{ $stats['orders'] }}</div>
            <div class="text-muted small">Commandes</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm text-center p-3">
            <div class="fs-1 text-danger">{{ number_format($stats['revenue'], 2, ',', ' ') }} €</div>
            <div class="text-muted small">Chiffre d'affaires</div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header fw-bold">Dernières commandes</div>
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Client</th>
                    <th>Date</th>
                    <th class="text-end">Total</th>
                    <th class="text-center">Statut</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($recent_orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                    <td class="text-end">{{ number_format($order->total, 2, ',', ' ') }} €</td>
                    <td class="text-center">
                        @php $badges=['en_attente'=>'warning','confirmée'=>'info','expédiée'=>'primary','annulée'=>'danger']; @endphp
                        <span class="badge bg-{{ $badges[$order->status] ?? 'secondary' }}">{{ $order->status }}</span>
                    </td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Aucune commande.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
