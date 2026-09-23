<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminOrderController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// pages publiques
Route::get('/produits', [ProductController::class, 'index'])->name('products.index');
Route::get('/produits/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

// panier (pas besoin d'être connecté)
Route::get('/panier', [CartController::class, 'index'])->name('cart.index');
Route::post('/panier/ajouter/{id}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/panier/modifier/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/panier/supprimer/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/panier/vider', [CartController::class, 'clear'])->name('cart.clear');

// auth (visiteurs uniquement)
Route::middleware('guest')->group(function () {
    Route::get('/connexion', [LoginController::class, 'showForm'])->name('login');
    Route::post('/connexion', [LoginController::class, 'login']);

    Route::get('/inscription', [RegisterController::class, 'showForm'])->name('register');
    Route::post('/inscription', [RegisterController::class, 'register']);

    Route::get('/mot-de-passe-oublie', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/mot-de-passe-oublie', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reinitialiser-mot-de-passe/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reinitialiser-mot-de-passe', [ForgotPasswordController::class, 'reset'])->name('password.update');
});

Route::post('/deconnexion', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// espace connecté
Route::middleware('auth')->group(function () {
    Route::get('/profil', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profil', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/commandes', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/commandes/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/commandes', [OrderController::class, 'store'])->name('orders.store');
});

// admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('products', AdminProductController::class)->except(['show']);
    Route::resource('categories', AdminCategoryController::class)->except(['show']);

    Route::get('users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}', [AdminOrderController::class, 'update'])->name('orders.update');
    Route::delete('orders/{order}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');
});
