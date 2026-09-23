# Documentation — Boutique Guyanaise

## Sommaire
1. [Structure du projet](#1-structure-du-projet)
2. [Base de données](#2-base-de-données)
3. [Comment fonctionne Laravel (MVC)](#3-comment-fonctionne-laravel-mvc)
4. [Authentification](#4-authentification)
5. [Gestion des rôles et accès admin](#5-gestion-des-rôles-et-accès-admin)
6. [Le panier](#6-le-panier)
7. [Les commandes](#7-les-commandes)
8. [L'espace admin](#8-lespace-admin)
9. [Les routes](#9-les-routes)
10. [Les Seeders](#10-les-seeders)
11. [Comptes de test](#11-comptes-de-test)

---

## 1. Structure du projet

```
BoutiqueGuyanaise/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/               ← connexion, inscription, mot de passe oublié
│   │   │   ├── Admin/              ← tout ce qui concerne l'espace admin
│   │   │   ├── CartController.php  ← gestion du panier (session)
│   │   │   ├── OrderController.php ← passer et voir ses commandes
│   │   │   ├── ProfileController.php
│   │   │   ├── ProductController.php
│   │   │   ├── CategoryController.php
│   │   │   └── HomeController.php
│   │   └── Middleware/
│   │       └── AdminMiddleware.php ← bloque l'accès si pas admin
│   └── Models/
│       ├── User.php
│       ├── Product.php
│       ├── Category.php
│       ├── Order.php
│       └── OrderItem.php
├── database/
│   ├── migrations/     ← création des tables SQL
│   └── seeders/        ← données de test
├── resources/
│   └── views/
│       ├── layouts/    ← app.blade.php (site) et admin.blade.php (admin)
│       ├── partials/   ← navbar, footer
│       ├── auth/       ← login, register, forgot-password, reset-password
│       ├── admin/      ← toutes les pages d'administration
│       ├── products/
│       ├── categories/
│       ├── cart/
│       ├── orders/
│       └── profile/
└── routes/
    └── web.php         ← toutes les URLs du site
```

---

## 2. Base de données

### Tables et leurs colonnes principales

**users**
| colonne | type | description |
|---------|------|-------------|
| id | int | identifiant unique |
| name | string | nom de l'utilisateur |
| email | string | unique |
| password | string | hashé (bcrypt) |
| role | string | `user` ou `admin` |
| phone | string | téléphone (optionnel) |
| address | string | adresse de livraison (optionnel) |

**categories**
| colonne | type | description |
|---------|------|-------------|
| id | int | |
| name | string | |
| slug | string | version URL du nom (ex: `epices-condiments`) |
| description | text | |

**products**
| colonne | type | description |
|---------|------|-------------|
| id | int | |
| name | string | |
| slug | string | version URL du nom |
| description | text | |
| price | decimal | prix |
| stock | int | quantité disponible |
| image | string | chemin vers le fichier (storage/) |
| active | boolean | visible sur le site ou non |

**category_product** — table pivot (relation Many-to-Many)
| colonne | description |
|---------|-------------|
| category_id | référence une catégorie |
| product_id | référence un produit |

> Un produit peut être dans plusieurs catégories, une catégorie peut avoir plusieurs produits.
> C'est la relation **Many-to-Many**. Cette table fait le lien entre les deux.

**orders**
| colonne | type | description |
|---------|------|-------------|
| id | int | |
| user_id | int | qui a passé la commande |
| total | decimal | montant total |
| status | string | `en_attente`, `confirmée`, `expédiée`, `annulée` |
| shipping_address | text | adresse de livraison |

**order_items** — les lignes d'une commande
| colonne | type | description |
|---------|------|-------------|
| id | int | |
| order_id | int | à quelle commande appartient cette ligne |
| product_id | int | quel produit |
| quantity | int | combien |
| unit_price | decimal | prix au moment de la commande (figé) |

---

## 3. Comment fonctionne Laravel (MVC)

Laravel suit le pattern **MVC : Model - View - Controller**.

```
Navigateur  →  routes/web.php  →  Controller  →  Model  →  BDD
                                       ↓
                                      View (Blade)  →  Navigateur
```

**Exemple concret : l'utilisateur visite `/produits`**

1. Le navigateur envoie une requête GET vers `/produits`
2. `routes/web.php` voit cette URL et appelle `ProductController@index`
3. `ProductController` demande à `Product` (le Model) de récupérer les produits en BDD
4. Le Model fait la requête SQL via Eloquent et renvoie les données
5. Le Controller passe ces données à la vue `products/index.blade.php`
6. La vue génère le HTML et l'envoie au navigateur

### C'est quoi Eloquent ?
C'est l'ORM de Laravel. Au lieu d'écrire du SQL brut, on écrit du PHP :
```php
// Équivaut à : SELECT * FROM products WHERE active = 1 ORDER BY name
Product::where('active', true)->orderBy('name')->get();
```

### C'est quoi Blade ?
C'est le moteur de templates de Laravel. Les fichiers `.blade.php` mélangent HTML et PHP avec une syntaxe simplifiée :
```blade
@foreach($products as $product)
    <p>{{ $product->name }}</p>
@endforeach
```

---

## 4. Authentification

### Inscription — `RegisterController`

```
POST /inscription
      ↓
validate (name, email, password)
      ↓
User::create(...) — crée l'utilisateur en BDD avec role = 'user'
      ↓
Auth::login($user) — connecte directement après l'inscription
      ↓
redirect → accueil
```

Le mot de passe est **jamais stocké en clair**. `Hash::make($password)` le transforme en une chaîne illisible (ex: `$2y$12$...`). Quand on vérifie le mot de passe plus tard, on utilise `Hash::check()` qui compare sans jamais décoder.

---

### Connexion — `LoginController`

```
POST /connexion
      ↓
validate (email, password)
      ↓
Auth::attempt(['email' => ..., 'password' => ...])
      ↓
Laravel cherche l'utilisateur par email, puis compare
le mot de passe soumis avec le hash en BDD via Hash::check()
      ↓
Si OK → session créée, redirect vers la page voulue
Si NON → retour au formulaire avec erreur
```

`Auth::attempt()` fait tout : cherche l'utilisateur, vérifie le mot de passe, et crée la session si c'est bon.

`$request->session()->regenerate()` change l'ID de session après la connexion — c'est une protection contre les attaques de type "session fixation".

---

### Déconnexion — `LoginController@logout`

```php
Auth::logout();                    // efface l'utilisateur de la session
$request->session()->invalidate(); // détruit toute la session
$request->session()->regenerateToken(); // nouveau token CSRF
```

---

### Mot de passe oublié — `ForgotPasswordController`

C'est le flux le plus complexe de l'auth. Voici les étapes :

**Étape 1 — L'utilisateur demande un lien**
```
POST /mot-de-passe-oublie
      ↓
Vérifie que l'email existe en BDD
      ↓
Génère un token aléatoire de 64 caractères (Str::random(64))
      ↓
Stocke Hash::make($token) dans la table password_reset_tokens
(on stocke le hash, pas le token lui-même — même logique que les mots de passe)
      ↓
Envoie un email avec l'URL : /reinitialiser-mot-de-passe/{token}?email=...
```

**Étape 2 — L'utilisateur clique sur le lien**
```
GET /reinitialiser-mot-de-passe/{token}?email=jean@example.com
      ↓
Affiche le formulaire avec le token et l'email pré-remplis (champs cachés)
```

**Étape 3 — L'utilisateur soumet son nouveau mot de passe**
```
POST /reinitialiser-mot-de-passe
      ↓
Récupère l'entrée dans password_reset_tokens pour cet email
      ↓
Hash::check($token_soumis, $token_en_bdd) — vérifie que c'est le bon token
      ↓
Vérifie que le token a moins de 60 minutes (expiration)
      ↓
Met à jour le mot de passe de l'utilisateur
      ↓
Supprime le token (ne peut être utilisé qu'une seule fois)
      ↓
Redirect vers /connexion
```

---

### Protection CSRF

Tous les formulaires POST/PUT/DELETE ont `@csrf` dans le Blade. Ça génère un token caché dans le formulaire. Laravel vérifie que ce token correspond à celui de la session — ça empêche un site tiers de faire des requêtes à la place de l'utilisateur.

---

## 5. Gestion des rôles et accès admin

### Où est stocké le rôle ?
Dans la colonne `role` de la table `users`. Valeur : `user` ou `admin`.

### Comment on vérifie si quelqu'un est admin ?
Dans `app/Models/User.php` :
```php
public function isAdmin(): bool
{
    return $this->role === 'admin';
}
```

### Comment les routes admin sont protégées ?

**Dans `routes/web.php`**, toutes les routes `/admin/*` ont deux middlewares :
```php
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    ...
});
```

- `auth` → vérifie que l'utilisateur est connecté (middleware natif Laravel)
- `admin` → notre middleware personnalisé

**Dans `app/Http/Middleware/AdminMiddleware.php`** :
```php
public function handle(Request $request, Closure $next): Response
{
    if (!Auth::check() || !Auth::user()->isAdmin()) {
        abort(403);
    }
    return $next($request);
}
```

Si l'utilisateur n'est pas connecté ou n'est pas admin → erreur 403 (accès refusé).
Sinon → `$next($request)` laisse passer la requête vers le controller.

**Ce middleware est enregistré** dans `bootstrap/app.php` avec l'alias `admin` :
```php
$middleware->alias([
    'admin' => \App\Http\Middleware\AdminMiddleware::class,
]);
```

C'est pour ça qu'on peut écrire `->middleware('admin')` dans les routes.

---

## 6. Le panier

Le panier fonctionne avec les **sessions Laravel**, pas avec la BDD. Ça veut dire qu'il fonctionne même sans être connecté.

### Structure du panier en session
```php
session('cart') = [
    '3' => ['quantity' => 2],  // product_id => données
    '7' => ['quantity' => 1],
]
```

La clé du tableau est l'ID du produit.

### Ajouter un produit (`CartController@add`)
```php
$cart = session('cart', []);

if (isset($cart[$id])) {
    $cart[$id]['quantity'] += $qte;  // déjà dans le panier → on ajoute
} else {
    $cart[$id] = ['quantity' => $qte];  // nouveau produit
}

session(['cart' => $cart]);
```

### Afficher le panier (`CartController@index`)
La session ne stocke que les IDs et quantités. Pour afficher les prix et noms, on va chercher chaque produit en BDD :
```php
foreach ($cart as $id => $ligne) {
    $produit = Product::find($id);
    // on calcule le sous-total ici
}
```

### Vider le panier
Après validation d'une commande, `session()->forget('cart')` supprime le panier de la session.

---

## 7. Les commandes

### Passer une commande (`OrderController@store`)

```
POST /commandes (depuis le modal du panier)
      ↓
Vérifie que le panier n'est pas vide
      ↓
Pour chaque produit du panier :
  - récupère le produit en BDD
  - vérifie qu'il est actif (active = true)
  - calcule le sous-total
      ↓
Crée la commande en BDD (table orders)
      ↓
Crée une ligne par produit (table order_items)
avec le prix FIGÉ au moment de la commande
      ↓
Vide le panier
      ↓
Redirect vers la page de confirmation
```

**Pourquoi stocker `unit_price` dans `order_items` ?**
Si le prix d'un produit change demain, les anciennes commandes doivent garder le prix d'origine. On copie donc le prix au moment de la commande.

### Voir ses commandes (`OrderController@show`)
```php
if ($order->user_id !== Auth::id()) {
    abort(403);
}
```
Cette vérification empêche un utilisateur de voir la commande d'un autre en changeant l'ID dans l'URL.

---

## 8. L'espace admin

### Accès
URL : `/admin` — accessible uniquement avec un compte `role = admin`.

### Ce qu'on peut faire

**Produits (`AdminProductController`)**
- Lister tous les produits avec leurs catégories
- Créer un produit avec upload de photo
- Modifier : nom, prix, stock, catégories, photo, actif/inactif
- Supprimer (l'image est supprimée du disque en même temps)

**Catégories (`AdminCategoryController`)**
- Créer/modifier/supprimer des catégories
- Dans la page d'édition d'une catégorie : choisir quels produits lui appartiennent
- `$category->products()->sync(...)` met à jour la table pivot `category_product`

**Utilisateurs (`AdminUserController`)**
- Voir tous les comptes
- Modifier le rôle (passer un user en admin ou l'inverse)
- Supprimer un compte (impossible de supprimer le sien)

**Commandes (`AdminOrderController`)**
- Voir toutes les commandes de tous les utilisateurs
- Changer le statut : `en_attente` → `confirmée` → `expédiée` → `annulée`
- Supprimer une commande

### La relation Many-to-Many en pratique
Quand on modifie les catégories d'un produit dans le formulaire admin, les cases cochées sont envoyées comme un tableau `categories[]`. La méthode `sync()` s'occupe de tout :

```php
$product->categories()->sync($request->categories);
// sync() ajoute les nouvelles lignes dans category_product
// et supprime celles qui ne sont plus cochées
// sans toucher au reste
```

---

## 9. Les routes

### Organisation
Les routes sont divisées en 4 groupes dans `routes/web.php` :

| Groupe | Middleware | Exemple d'URL |
|--------|-----------|---------------|
| Public | aucun | `/`, `/produits`, `/categories` |
| Visiteurs seulement | `guest` | `/connexion`, `/inscription` |
| Connectés | `auth` | `/profil`, `/commandes` |
| Admin | `auth` + `admin` | `/admin/*` |

Le middleware `guest` redirige vers l'accueil si l'utilisateur est déjà connecté — inutile de voir le formulaire de connexion si on l'est déjà.

### Route Model Binding
```php
Route::get('/produits/{product:slug}', [ProductController::class, 'show']);
```
Le `:slug` dit à Laravel de chercher le produit par son slug au lieu de son ID. Laravel fait la requête SQL automatiquement et injecte le Model directement dans le controller. Si rien n'est trouvé → 404 automatique.

---

## 10. Les Seeders

Les seeders permettent de remplir la BDD avec des données de test.

Pour tout réinitialiser et relancer les seeders :
```bash
php artisan migrate:fresh --seed
```

### Ordre d'exécution (`DatabaseSeeder`)
```
UserSeeder    → crée les utilisateurs (admin + users de test)
CategorySeeder → crée les catégories
ProductSeeder  → crée les produits et les attache aux catégories
```

L'ordre est important : `ProductSeeder` a besoin que les catégories existent déjà.

---

## 11. Comptes de test

| Rôle | Email | Mot de passe | Accès |
|------|-------|-------------|-------|
| Admin | `admin@boutiqueguyanaise.fr` | `admin1234` | Tout le site + `/admin` |
| Utilisateur | `jean@example.com` | `password` | Site + commandes |
| Utilisateur | `marie@example.com` | `password` | Site + commandes |

---

## Questions fréquentes

**Q : Où sont stockées les images uploadées ?**
Dans `storage/app/public/products/`. Le lien symbolique `public/storage` → `storage/app/public` permet d'y accéder depuis le navigateur via `asset('storage/products/...')`.

**Q : Comment ajouter une nouvelle page ?**
1. Créer une méthode dans un Controller existant (ou nouveau)
2. Créer la vue Blade dans `resources/views/`
3. Ajouter la route dans `routes/web.php`

**Q : Comment créer un nouveau compte admin ?**
Soit via le seeder, soit en modifiant le rôle depuis `/admin/users`.

**Q : Pourquoi certaines routes utilisent `PUT` et d'autres `PATCH` ?**
`PUT` = remplace toutes les données (ex: modifier un profil complet).
`PATCH` = mise à jour partielle (ex: changer juste le statut d'une commande).
Les formulaires HTML ne supportent que GET et POST, donc on ajoute `@method('PUT')` ou `@method('PATCH')` dans le Blade — Laravel intercepte ce champ caché et traite la requête correctement.
