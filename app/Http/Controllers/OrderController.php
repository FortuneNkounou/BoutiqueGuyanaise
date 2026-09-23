<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()->orders()->with('items.product')->latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('items.product');
        return view('orders.show', compact('order'));
    }

    public function store(Request $request)
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        $request->validate([
            'shipping_address' => 'required|string|max:255',
        ]);

        $total = 0;
        $lignes = [];

        foreach ($cart as $produit_id => $ligne) {
            $produit = Product::find($produit_id);
            if (!$produit || !$produit->active) continue;

            $total += $produit->price * $ligne['quantity'];
            $lignes[] = [
                'product_id' => $produit->id,
                'quantity' => $ligne['quantity'],
                'unit_price' => $produit->price,
            ];
        }

        if (empty($lignes)) {
            return redirect()->route('cart.index')->with('error', 'Aucun produit valide dans le panier.');
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'total' => $total,
            'status' => 'en_attente',
            'shipping_address' => $request->shipping_address,
        ]);

        foreach ($lignes as $ligne) {
            $order->items()->create($ligne);
        }

        session()->forget('cart');

        return redirect()->route('orders.show', $order)->with('success', 'Commande #' . $order->id . ' enregistrée !');
    }
}
