<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                'categories' => Category::count(),
                'products' => Product::count(),
                'orders' => Order::count(),
                'users' => User::where('is_admin', false)->count(),
                'revenue' => Order::where('status', 'completed')->sum('total'),
            ],
            'recentOrders' => Order::with('user')->latest()->limit(8)->get(),
            'lowStockProducts' => Product::with('category')->where('stock', '<=', 5)->orderBy('stock')->limit(8)->get(),
        ]);
    }
}
