# Boutique Guyanaise

Site e-commerce de produits locaux authentiques de Guyane française. Développé avec Laravel 13 dans le cadre du cours de développement web L3 2026/2027.

## Fonctionnalités

- Catalogue de produits avec filtrage par catégorie et recherche
- Panier (sans connexion requise)
- Inscription, connexion, déconnexion
- Réinitialisation de mot de passe par email
- Gestion du profil et suppression de compte
- Passage et suivi de commandes
- Espace d'administration complet (CRUD produits, catégories, utilisateurs, commandes)
- Relation Many-to-Many entre produits et catégories
- Upload de photos pour les produits
- Interface responsive avec Bootstrap 5

## Stack technique

- **Backend** : PHP 8.5 / Laravel 13
- **Base de données** : MySQL
- **Frontend** : Bootstrap 5, Bootstrap Icons, Blade
- **Build** : Vite + npm

## Installation

### Prérequis
- PHP >= 8.4
- Composer
- MySQL
- Node.js + npm

### Étapes

**1. Cloner le projet**
```bash
git clone https://github.com/ton-pseudo/BoutiqueGuyanaise.git
cd BoutiqueGuyanaise
```

**2. Installer les dépendances PHP**
```bash
composer install
```

**3. Installer les dépendances JS et compiler les assets**
```bash
npm install
npm run build
```

**4. Configurer l'environnement**
```bash
cp .env.example .env
php artisan key:generate
```

Modifier le fichier `.env` avec vos paramètres de base de données :
```
DB_DATABASE=boutiqueguyanaise
DB_USERNAME=root
DB_PASSWORD=
```

**5. Créer la base de données et insérer les données de test**
```bash
php artisan migrate:fresh --seed
```

**6. Créer le lien symbolique pour les images**
```bash
php artisan storage:link
```

**7. Lancer le serveur**
```bash
php artisan serve
```

Le site est accessible sur `http://127.0.0.1:8000`

---

## Comptes de test

| Rôle | Email | Mot de passe |
|------|-------|-------------|
| Administrateur | admin@boutiqueguyanaise.fr | admin1234 |
| Utilisateur | jean@example.com | password |
| Utilisateur | marie@example.com | password |

L'espace d'administration est accessible sur `/admin` avec le compte administrateur.

---

## Structure du projet

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/        # Connexion, inscription, mot de passe oublié
│   │   ├── Admin/       # Espace administration
│   │   ├── CartController.php
│   │   ├── OrderController.php
│   │   ├── ProductController.php
│   │   └── ...
│   └── Middleware/
│       └── AdminMiddleware.php
└── Models/
    ├── User.php
    ├── Product.php
    ├── Category.php
    ├── Order.php
    └── OrderItem.php

database/
├── migrations/   # Structure des tables
└── seeders/      # Données de test

resources/views/
├── layouts/      # Templates principaux (app.blade.php, admin.blade.php)
├── admin/        # Vues de l'espace admin
├── auth/         # Connexion, inscription
└── ...
```

## Configuration email

Le projet utilise un service SMTP pour l'envoi des emails de réinitialisation de mot de passe. Configurer les variables `MAIL_*` dans le fichier `.env`.

Pour les tests en local, [Mailtrap](https://mailtrap.io) est recommandé.
