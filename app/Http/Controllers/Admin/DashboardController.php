<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'productCount' => Product::count(),
            'lowStockCount' => Product::where('stock', '<', 5)->count(),
            'pendingOrderCount' => Order::where('status', 'pending')->count(),
            'todaySales' => Order::whereDate('ordered_at', today())
                ->whereNotIn('status', ['cancelled'])
                ->sum('grand_total'),
            'latestOrders' => Order::with('user')->latest('ordered_at')->take(5)->get(),
        ]);
    }
}
