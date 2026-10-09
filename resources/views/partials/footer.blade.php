<footer class="mt-5 py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-3">
                <h5 class="text-white">🌿 Kréyol Market</h5>
                <p class="small">Produits locaux authentiques de Guyane française. Épices, artisanat, boissons et bien plus encore.</p>
            </div>
            <div class="col-md-4 mb-3">
                <h6 class="text-white">Navigation</h6>
                <ul class="list-unstyled small">
                    <li><a href="{{ route('home') }}" class="text-secondary text-decoration-none">Accueil</a></li>
                    <li><a href="{{ route('products.index') }}" class="text-secondary text-decoration-none">Produits</a></li>
                    <li><a href="{{ route('categories.index') }}" class="text-secondary text-decoration-none">Catégories</a></li>
                    <li><a href="{{ route('cart.index') }}" class="text-secondary text-decoration-none">Panier</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-3">
                <h6 class="text-white">Contact</h6>
                <p class="small">
                    <i class="bi bi-geo-alt me-1"></i>Cayenne, Guyane française<br>
                    <i class="bi bi-envelope me-1"></i>
                </p>
            </div>
        </div>
        <hr class="border-secondary">
        <p class="text-center small mb-0">© {{ date('Y') }} Boutique Guyanaise — Tous droits réservés</p>
    </div>
</footer>
