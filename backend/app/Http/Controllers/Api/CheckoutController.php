<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $data = $request->validate([
            'shipping_address' => ['required', 'string', 'max:1000'],
            'payment_method' => ['nullable', 'string', 'max:80'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $cartItems = $request->user()
            ->cartItems()
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            throw ValidationException::withMessages([
                'cart' => ['Your cart is empty.'],
            ]);
        }

        $order = DB::transaction(function () use ($request, $data, $cartItems): Order {
            $subtotal = 0;

            foreach ($cartItems as $item) {
                $product = Product::whereKey($item->product_id)->lockForUpdate()->firstOrFail();

                if (! $product->is_active || $product->stock < $item->quantity) {
                    throw ValidationException::withMessages([
                        'cart' => ["{$product->name} does not have enough stock."],
                    ]);
                }

                $subtotal += (float) $product->price * $item->quantity;
            }

            $order = Order::create([
                'user_id' => $request->user()->id,
                'status' => 'pending',
                'subtotal' => round($subtotal, 2),
                'total' => round($subtotal, 2),
                'shipping_address' => $data['shipping_address'],
                'payment_method' => $data['payment_method'] ?? 'cash_on_delivery',
                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($cartItems as $item) {
                $product = Product::whereKey($item->product_id)->firstOrFail();
                $lineTotal = (float) $product->price * $item->quantity;

                $order->items()->create([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'unit_price' => $product->price,
                    'quantity' => $item->quantity,
                    'total' => round($lineTotal, 2),
                ]);

                $product->decrement('stock', $item->quantity);
                $item->delete();
            }

            return $order->load('items.product');
        });

        return response()->json($order, 201);
    }
}
