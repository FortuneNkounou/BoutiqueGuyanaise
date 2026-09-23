@extends('layouts.admin')
@section('title', 'Utilisateurs — Administration')
@section('page-title', 'Gestion des utilisateurs')

@section('content')
<h4 class="fw-bold mb-4">Utilisateurs</h4>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th class="text-center">Rôle</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td class="fw-semibold">{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone ?? '—' }}</td>
                    <td class="text-center">
                        @if($user->role === 'admin')
                            <span class="badge bg-danger">Admin</span>
                        @else
                            <span class="badge bg-secondary">Utilisateur</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        @if($user->id !== Auth::id())
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="d-inline"
                              onsubmit="return confirm('Supprimer cet utilisateur ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Aucun utilisateur.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
        <div class="card-footer bg-white">{{ $users->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
