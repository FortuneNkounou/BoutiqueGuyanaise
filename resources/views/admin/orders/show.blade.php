@extends('layouts.admin')
@section('title', 'Commande #' . $order->id . ' — Administration')
@section('page-title', 'Détail commande #' . $order->id)

@section('content')
<div class="row g-4">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header fw-bold">Articles commandés</div>
            <div class="table-responsive">
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
            <div class="card-header fw-bold">Informations client</div>
            <div class="card-body small">
                <p class="mb-1"><strong>Nom :</strong> {{ $order->user->name }}</p>
                <p class="mb-1"><strong>Email :</strong> {{ $order->user->email }}</p>
                <p class="mb-1"><strong>Date :</strong> {{ $order->created_at->format('d/m/Y à H:i') }}</p>
                <p class="mb-0"><strong>Adresse :</strong><br>{{ $order->shipping_address }}</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header fw-bold">Modifier le statut</div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.orders.update', $order) }}">
                    @csrf @method('PATCH')
                    <select name="status" class="form-select mb-3">
                        @foreach(['en_attente', 'confirmée', 'expédiée', 'annulée'] as $status)
                            <option value="{{ $status }}" @selected($order->status === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-save me-1"></i>Mettre à jour
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary mt-4">
    <i class="bi bi-arrow-left me-1"></i>Retour aux commandes
</a>
@endsection
