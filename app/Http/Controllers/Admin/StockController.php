<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStockInRequest;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StockController extends Controller
{
    public function index(Request $request): View
    {
        $movements = StockMovement::with(['product', 'user'])
            ->when($request->filled('product_id'), fn ($q) => $q->where('product_id', $request->integer('product_id')))
            ->when($request->filled('type'), fn ($q) => $q->where('type', $request->input('type')))
            ->latest('movement_at')
            ->paginate(20)
            ->withQueryString();

        return view('admin.stock.index', [
            'movements' => $movements,
            'products' => Product::orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.stock.create', [
            'products' => Product::orderBy('name')->get(),
        ]);
    }

    public function store(StoreStockInRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $product = Product::whereKey($request->integer('product_id'))->lockForUpdate()->firstOrFail();
            $quantity = $request->integer('quantity');

            $product->increment('stock', $quantity);

            StockMovement::create([
                'product_id' => $product->id,
                'user_id' => $request->user()->id,
                'type' => 'IN',
                'quantity' => $quantity,
                'unit_cost' => $request->input('unit_cost'),
                'reference' => $request->input('reference'),
                'note' => $request->input('note'),
                'movement_at' => $request->date('movement_at') ?? now(),
            ]);
        });

        return redirect()->route('admin.stock.index')->with('success', 'Barang masuk dicatat dan stok bertambah.');
    }
}
