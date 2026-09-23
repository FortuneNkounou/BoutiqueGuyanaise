<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.product', 'user');
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:en_attente,confirmée,expédiée,annulée',
        ]);

        $order->update(['status' => $request->status]);
        return back()->with('success', 'Statut mis à jour.');
    }

    public function destroy(Order $order)
    {
        $id = $order->id;
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Commande #' . $id . ' supprimée.');
    }
}
