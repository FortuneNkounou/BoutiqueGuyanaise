<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Administration — Boutique Guyanaise')</title>
    <!-- Bootstrap + Icons via Vite (local) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root { --sidebar-width: 240px; --bg-primary: #2d6a4f; }
        body { background: #f1f3f5; }
        #sidebar { width: var(--sidebar-width); min-height: 100vh; background: #1b4332; position: fixed; top: 0; left: 0; z-index: 100; }
        #sidebar .nav-link { color: #ccc; border-radius: 6px; margin: 2px 8px; }
        #sidebar .nav-link:hover, #sidebar .nav-link.active { background: var(--bg-primary); color: #fff; }
        #main { margin-left: var(--sidebar-width); }
        .topbar { background: #fff; border-bottom: 1px solid #dee2e6; }
        @media(max-width:768px) { #sidebar { position: static; width: 100%; min-height: auto; } #main { margin-left: 0; } }
    </style>
    @yield('styles')
</head>
<body>
    <div id="sidebar" class="d-flex flex-column py-3">
        <a href="{{ route('admin.dashboard') }}" class="text-white text-decoration-none px-3 mb-4">
            <h5 class="fw-bold mb-0">🌿 Admin</h5>
            <small class="text-secondary">Boutique Guyanaise</small>
        </a>
        <nav class="flex-grow-1">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link @if(request()->routeIs('admin.dashboard')) active @endif" href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-speedometer2 me-2"></i>Tableau de bord
                    </a>
                </li>
                <li class="nav-item mt-2"><small class="text-secondary px-3 text-uppercase" style="font-size:.7rem;">Catalogue</small></li>
                <li class="nav-item">
                    <a class="nav-link @if(request()->routeIs('admin.products.*')) active @endif" href="{{ route('admin.products.index') }}">
                        <i class="bi bi-box-seam me-2"></i>Produits
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(request()->routeIs('admin.categories.*')) active @endif" href="{{ route('admin.categories.index') }}">
                        <i class="bi bi-tags me-2"></i>Catégories
                    </a>
                </li>
                <li class="nav-item mt-2"><small class="text-secondary px-3 text-uppercase" style="font-size:.7rem;">Gestion</small></li>
                <li class="nav-item">
                    <a class="nav-link @if(request()->routeIs('admin.orders.*')) active @endif" href="{{ route('admin.orders.index') }}">
                        <i class="bi bi-bag me-2"></i>Commandes
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(request()->routeIs('admin.users.*')) active @endif" href="{{ route('admin.users.index') }}">
                        <i class="bi bi-people me-2"></i>Utilisateurs
                    </a>
                </li>
            </ul>
        </nav>
        <div class="px-3 pb-2">
            <a href="{{ route('home') }}" class="btn btn-outline-light btn-sm w-100 mb-2">
                <i class="bi bi-house me-1"></i>Voir le site
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm w-100">
                    <i class="bi bi-box-arrow-right me-1"></i>Déconnexion
                </button>
            </form>
        </div>
    </div>

    <div id="main">
        <div class="topbar px-4 py-2 d-flex justify-content-between align-items-center">
            <h6 class="mb-0 text-muted">@yield('page-title', 'Administration')</h6>
            <span class="small text-muted"><i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}</span>
        </div>

        <div class="p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    @yield('scripts')
    @stack('scripts')
</body>
</html>
