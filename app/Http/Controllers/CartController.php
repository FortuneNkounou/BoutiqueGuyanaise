<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $items = [];
        $total = 0;

        foreach ($cart as $id => $ligne) {
            $produit = Product::find($id);
            if (!$produit) continue;

            $sous_total = $produit->price * $ligne['quantity'];
            $total += $sous_total;
            $items[] = [
                'product' => $produit,
                'quantity' => $ligne['quantity'],
                'subtotal' => $sous_total,
            ];
        }

        return view('cart.index', ['products' => $items, 'total' => $total]);
    }

    public function add(Request $request, int $id)
    {
        $produit = Product::findOrFail($id);
        $qte = (int) $request->input('quantity', 1);
        $cart = session('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $qte;
        } else {
            $cart[$id] = ['quantity' => $qte];
        }

        session(['cart' => $cart]);

        return back()->with('success', '"' . $produit->name . '" ajouté au panier.');
    }

    public function update(Request $request, int $id)
    {
        $request->validate(['quantity' => 'required|integer|min:1|max:99']);

        $cart = session('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = (int) $request->quantity;
            session(['cart' => $cart]);
        }

        return back()->with('success', 'Quantité mise à jour.');
    }

    public function remove(int $id)
    {
        $cart = session('cart', []);
        unset($cart[$id]);
        session(['cart' => $cart]);

        return back()->with('success', 'Article retiré.');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Panier vidé.');
    }
}
