@extends('layouts.admin')
@section('title', 'Nouveau produit — Administration')
@section('page-title', 'Créer un produit')

@section('content')
<div class="card border-0 shadow-sm" style="max-width:700px;">
    <div class="card-header fw-bold">Nouveau produit</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
            @csrf
            @include('admin.products._form', ['product' => null, 'selected_cats' => []])
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Créer</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
