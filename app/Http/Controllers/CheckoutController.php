<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\ShippingService;
use App\Models\StockMovement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        $cart = $request->session()->get('cart', []);

        if ($cart === []) {
            return redirect()->route('cart.index')->with('error', 'Keranjang masih kosong.');
        }

        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');
        $items = collect();
        $subtotal = 0;

        foreach ($cart as $productId => $quantity) {
            $product = $products->get($productId);
            if (! $product) {
                continue;
            }
            $lineTotal = (float) $product->price * $quantity;
            $subtotal += $lineTotal;
            $items->push(compact('product', 'quantity', 'lineTotal'));
        }

        return view('checkout.index', [
            'items' => $items,
            'subtotal' => $subtotal,
            'shippingServices' => ShippingService::where('is_active', true)->orderBy('courier')->get(),
        ]);
    }

    public function store(CheckoutRequest $request): RedirectResponse
    {
        $cart = $request->session()->get('cart', []);

        if ($cart === []) {
            return redirect()->route('cart.index')->with('error', 'Keranjang masih kosong.');
        }

        $order = DB::transaction(function () use ($request, $cart) {
            $shipping = ShippingService::whereKey($request->integer('shipping_service_id'))
                ->where('is_active', true)
                ->firstOrFail();

            $lockedProducts = Product::whereIn('id', array_keys($cart))
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $subtotal = 0;

            foreach ($cart as $productId => $quantity) {
                $product = $lockedProducts->get($productId);
                if (! $product || ! $product->is_active || $quantity > $product->stock) {
                    throw ValidationException::withMessages([
                        'cart' => 'Stok berubah. Periksa kembali keranjang Anda.',
                    ]);
                }
                $subtotal += (float) $product->price * $quantity;
            }

            $code = 'ORD-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));

            $order = Order::create([
                'code' => $code,
                'user_id' => $request->user()->id,
                'shipping_service_id' => $shipping->id,
                'recipient_name' => $request->string('recipient_name')->toString(),
                'phone' => $request->string('phone')->toString(),
                'address' => $request->string('address')->toString(),
                'shipping_courier' => $shipping->courier,
                'shipping_service' => $shipping->service,
                'shipping_eta' => $shipping->eta,
                'subtotal' => $subtotal,
                'shipping_cost' => $shipping->cost,
                'grand_total' => $subtotal + (float) $shipping->cost,
                'status' => 'pending',
                'ordered_at' => now(),
            ]);

            foreach ($cart as $productId => $quantity) {
                $product = $lockedProducts->get($productId);
                $lineTotal = (float) $product->price * $quantity;

                $order->items()->create([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $quantity,
                    'subtotal' => $lineTotal,
                ]);

                $product->decrement('stock', $quantity);

                StockMovement::create([
                    'product_id' => $product->id,
                    'user_id' => $request->user()->id,
                    'type' => 'OUT',
                    'quantity' => $quantity,
                    'reference' => $code,
                    'note' => 'Checkout pelanggan',
                    'movement_at' => now(),
                ]);
            }

            return $order;
        });

        $request->session()->forget('cart');

        return redirect()->route('orders.show', $order)->with('success', 'Checkout berhasil. Pesanan menunggu validasi admin.');
    }
}
