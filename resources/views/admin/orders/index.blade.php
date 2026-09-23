@extends('layouts.admin')
@section('title', 'Commandes — Administration')
@section('page-title', 'Gestion des commandes')

@section('content')
<h4 class="fw-bold mb-4">Commandes</h4>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Client</th>
                    <th>Date</th>
                    <th class="text-end">Total</th>
                    <th class="text-center">Statut</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                    <td class="text-end">{{ number_format($order->total, 2, ',', ' ') }} €</td>
                    <td class="text-center">
                        @php $badges=['en_attente'=>'warning','confirmée'=>'info','expédiée'=>'primary','annulée'=>'danger']; @endphp
                        <span class="badge bg-{{ $badges[$order->status] ?? 'secondary' }}">{{ $order->status }}</span>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-eye"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" class="d-inline"
                              onsubmit="return confirm('Supprimer cette commande ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Aucune commande.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($orders->hasPages())
        <div class="card-footer bg-white">{{ $orders->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
