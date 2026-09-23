@extends('layouts.admin')
@section('title', 'Modifier ' . $category->name . ' — Administration')
@section('page-title', 'Modifier une catégorie')

@section('content')
<div class="card border-0 shadow-sm" style="max-width:700px;">
    <div class="card-header fw-bold">Modifier : {{ $category->name }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.categories.update', $category) }}">
            @csrf @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold">Nom <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $category->name) }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
            </div>

            {{-- Gestion des produits liés à cette catégorie --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Produits associés</label>
                <div class="row g-2" style="max-height:220px; overflow-y:auto; border:1px solid #dee2e6; border-radius:6px; padding:10px;">
                    @foreach($all_products as $product)
                    <div class="col-md-6">
                        <div class="form-check">
                            <input type="checkbox" name="products[]" value="{{ $product->id }}"
                                   id="prod_{{ $product->id }}" class="form-check-input"
                                   @if(in_array($product->id, old('products', $selected_products))) checked @endif>
                            <label for="prod_{{ $product->id }}" class="form-check-label small">{{ $product->name }}</label>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Enregistrer</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
