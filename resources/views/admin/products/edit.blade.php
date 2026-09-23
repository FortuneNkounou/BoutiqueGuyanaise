@extends('layouts.admin')
@section('title', 'Modifier ' . $product->name . ' — Administration')
@section('page-title', 'Modifier un produit')

@section('content')
<div class="card border-0 shadow-sm" style="max-width:700px;">
    <div class="card-header fw-bold">Modifier : {{ $product->name }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            @include('admin.products._form', ['product' => $product, 'selected_cats' => $selected_cats])
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Enregistrer</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
