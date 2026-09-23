<div class="row g-3">
    <div class="col-12">
        <label class="form-label fw-semibold">Nom du produit <span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $product?->name) }}" required>
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Description</label>
        <textarea name="description" class="form-control" rows="3">{{ old('description', $product?->description) }}</textarea>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Prix (€) <span class="text-danger">*</span></label>
        <input type="number" name="price" step="0.01" min="0"
               class="form-control @error('price') is-invalid @enderror"
               value="{{ old('price', $product?->price) }}" required>
        @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Stock <span class="text-danger">*</span></label>
        <input type="number" name="stock" min="0"
               class="form-control @error('stock') is-invalid @enderror"
               value="{{ old('stock', $product?->stock ?? 0) }}" required>
        @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- Image du produit --}}
    <div class="col-12">
        <label class="form-label fw-semibold">Photo du produit</label>

        {{-- Prévisualisation de l'image actuelle (mode édition) --}}
        @if($product?->image)
            <div class="mb-2" id="current-image-block">
                <img src="{{ asset('storage/' . $product->image) }}"
                     alt="{{ $product->name }}"
                     id="current-img-preview"
                     class="rounded border"
                     style="height:120px; object-fit:cover;">
                <div class="form-check mt-2">
                    <input type="checkbox" name="remove_image" id="remove_image" value="1"
                           class="form-check-input" onchange="toggleRemoveImage(this)">
                    <label for="remove_image" class="form-check-label text-danger small">
                        Supprimer l'image actuelle
                    </label>
                </div>
            </div>
        @endif

        {{-- Input upload --}}
        <input type="file" name="image" id="image-input"
               class="form-control @error('image') is-invalid @enderror"
               accept="image/jpeg,image/png,image/jpg,image/webp"
               onchange="previewImage(this)">
        <div class="form-text">Formats acceptés : JPG, PNG, WEBP — max 2 Mo</div>
        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror

        {{-- Prévisualisation de la nouvelle image --}}
        <div id="new-image-preview" class="mt-2" style="display:none;">
            <p class="small text-muted mb-1">Aperçu :</p>
            <img id="preview-img" src="#" alt="Aperçu"
                 class="rounded border"
                 style="height:120px; object-fit:cover;">
        </div>
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Catégories <span class="text-danger">*</span></label>
        <div class="row g-2">
            @foreach($categories as $cat)
            <div class="col-md-4">
                <div class="form-check">
                    <input type="checkbox" name="categories[]" value="{{ $cat->id }}"
                           id="cat_{{ $cat->id }}" class="form-check-input"
                           @if(in_array($cat->id, old('categories', $selected_cats ?? []))) checked @endif>
                    <label for="cat_{{ $cat->id }}" class="form-check-label">{{ $cat->name }}</label>
                </div>
            </div>
            @endforeach
        </div>
        @error('categories') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
    </div>

    <div class="col-12">
        <div class="form-check form-switch">
            <input type="checkbox" name="active" id="active" value="1" class="form-check-input"
                   @if(old('active', $product?->active ?? true)) checked @endif>
            <label for="active" class="form-check-label">Produit actif (visible sur le site)</label>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Prévisualise la nouvelle image sélectionnée
function previewImage(input) {
    const preview = document.getElementById('new-image-preview');
    const img     = document.getElementById('preview-img');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { img.src = e.target.result; preview.style.display = 'block'; };
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.style.display = 'none';
    }
}

// Grise l'image actuelle si "supprimer" est coché
function toggleRemoveImage(checkbox) {
    const currentImg = document.getElementById('current-img-preview');
    if (currentImg) {
        currentImg.style.opacity = checkbox.checked ? '0.3' : '1';
    }
}
</script>
@endpush
