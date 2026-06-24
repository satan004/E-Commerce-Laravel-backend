<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        return view('admin.orders.index', [
            'orders' => Order::with('user', 'items')->latest()->paginate(12),
        ]);
    }

    public function show(Order $order): View
    {
        return view('admin.orders.show', [
            'order' => $order->load('user', 'items.product'),
        ]);
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(Order::STATUSES)],
        ]);

        $order->update(['status' => $data['status']]);

        return back()->with('status', 'Order status updated.');
    }
}
