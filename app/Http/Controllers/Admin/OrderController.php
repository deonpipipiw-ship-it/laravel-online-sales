<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = Order::with('user')
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->input('status')))
            ->when($request->filled('q'), function ($q) use ($request) {
                $keyword = $request->string('q')->toString();
                $q->where(fn ($sub) => $sub->where('code', 'like', "%{$keyword}%")
                    ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$keyword}%")));
            })
            ->latest('ordered_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load(['user', 'items', 'validator']);

        return view('admin.orders.show', compact('order'));
    }

    public function confirm(Request $request, Order $order): RedirectResponse
    {
        if ($order->status !== 'pending') {
            return back()->with('error', 'Hanya pesanan pending yang dapat divalidasi.');
        }

        $order->update([
            'status' => 'confirmed',
            'validated_by' => $request->user()->id,
            'validated_at' => now(),
        ]);

        return back()->with('success', 'Pesanan telah divalidasi.');
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['processed', 'shipped', 'completed'])],
        ]);

        $allowed = [
            'confirmed' => ['processed'],
            'processed' => ['shipped'],
            'shipped' => ['completed'],
        ];

        if (! in_array($data['status'], $allowed[$order->status] ?? [], true)) {
            return back()->with('error', 'Perubahan status tidak sesuai alur transaksi.');
        }

        $order->update(['status' => $data['status']]);

        return back()->with('success', 'Status pesanan diperbarui.');
    }

    public function cancel(Request $request, Order $order): RedirectResponse
    {
        if (! in_array($order->status, ['pending', 'confirmed'], true)) {
            return back()->with('error', 'Pesanan pada status ini tidak dapat dibatalkan.');
        }

        DB::transaction(function () use ($request, $order) {
            $order->load('items');

            foreach ($order->items as $item) {
                if (! $item->product_id) {
                    continue;
                }

                $product = Product::whereKey($item->product_id)->lockForUpdate()->first();

                if (! $product) {
                    continue;
                }

                $product->increment('stock', $item->quantity);

                StockMovement::create([
                    'product_id' => $product->id,
                    'user_id' => $request->user()->id,
                    'type' => 'IN',
                    'quantity' => $item->quantity,
                    'reference' => 'CANCEL-' . $order->code,
                    'note' => 'Pengembalian stok karena pesanan dibatalkan admin',
                    'movement_at' => now(),
                ]);
            }

            $order->update([
                'status' => 'cancelled',
                'validated_by' => $request->user()->id,
                'validated_at' => now(),
            ]);
        });

        return back()->with('success', 'Pesanan dibatalkan dan stok dikembalikan.');
    }
}
