@extends('layouts.app')

@section('title', 'Nouveau mot de passe — Boutique Guyanaise')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h4 class="mb-0"><i class="bi bi-lock me-2"></i>Nouveau mot de passe</h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="email" value="{{ $email }}">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Adresse email</label>
                            <input type="email" class="form-control bg-light" value="{{ $email }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Nouveau mot de passe</label>
                            <input type="password" name="password" id="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Minimum 8 caractères" required autofocus>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label fw-semibold">Confirmer le mot de passe</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="form-control" placeholder="••••••••" required>
                        </div>

                        @error('token')
                            <div class="alert alert-danger small">{{ $message }}</div>
                        @enderror

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-2"></i>Réinitialiser mon mot de passe
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
