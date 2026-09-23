@extends('layouts.admin')
@section('title', 'Modifier ' . $user->name . ' — Administration')
@section('page-title', 'Modifier un utilisateur')

@section('content')
<div class="card border-0 shadow-sm" style="max-width:600px;">
    <div class="card-header fw-bold">Modifier : {{ $user->name }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nom <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $user->name) }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email', $user->email) }}" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Téléphone</label>
                    <input type="tel" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Rôle <span class="text-danger">*</span></label>
                    <select name="role" class="form-select">
                        <option value="user" @selected(old('role', $user->role) === 'user')>Utilisateur</option>
                        <option value="admin" @selected(old('role', $user->role) === 'admin')>Administrateur</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Adresse</label>
                    <input type="text" name="address" class="form-control" value="{{ old('address', $user->address) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nouveau mot de passe <span class="text-muted">(facultatif)</span></label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                           placeholder="Laisser vide pour ne pas changer">
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Confirmer</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••">
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Enregistrer</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
