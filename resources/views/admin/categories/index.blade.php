@extends('layouts.admin')
@section('title', 'Catégories — Administration')
@section('page-title', 'Gestion des catégories')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Catégories</h4>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Nouvelle catégorie
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Nom</th>
                    <th>Description</th>
                    <th class="text-center">Produits</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td class="fw-semibold">{{ $category->name }}</td>
                    <td class="text-muted small">{{ Str::limit($category->description, 60) }}</td>
                    <td class="text-center">{{ $category->products_count }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="d-inline"
                              onsubmit="return confirm('Supprimer cette catégorie ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">Aucune catégorie.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($categories->hasPages())
        <div class="card-footer bg-white">{{ $categories->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
