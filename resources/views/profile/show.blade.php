@extends('layouts.app')

@section('title', 'Mon profil — Boutique Guyanaise')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="fw-bold mb-4"><i class="bi bi-person-circle me-2"></i>Mon profil</h1>

            {{-- Modifier les informations --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header fw-bold bg-primary text-white">Mes informations</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nom complet</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $user->name) }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email', $user->email) }}" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Téléphone</label>
                                <input type="tel" name="phone" class="form-control"
                                       value="{{ old('phone', $user->phone) }}" placeholder="0594...">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Adresse</label>
                                <input type="text" name="address" class="form-control"
                                       value="{{ old('address', $user->address) }}" placeholder="Votre adresse de livraison">
                            </div>
                        </div>

                        <hr class="my-4">
                        <h6 class="fw-bold mb-3">Changer le mot de passe <span class="text-muted fw-normal">(facultatif)</span></h6>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Mot de passe actuel</label>
                                <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror"
                                       placeholder="••••••••">
                                @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Nouveau mot de passe</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Min. 8 caractères">
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Confirmer</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••">
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- suppression du compte --}}
            <div class="card border-danger border-0 shadow-sm">
                <div class="card-header fw-bold bg-danger text-white">Zone de danger</div>
                <div class="card-body">
                    <p class="text-muted small">La suppression de votre compte est définitive. Toutes vos données seront effacées.</p>
                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="bi bi-trash me-2"></i>Supprimer mon compte
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal suppression compte --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="bi bi-exclamation-triangle me-2"></i>Supprimer mon compte</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Êtes-vous sûr(e) de vouloir supprimer définitivement votre compte ?</p>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Confirmez avec votre mot de passe</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                               placeholder="Votre mot de passe" required>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Supprimer définitivement</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
