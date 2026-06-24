<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return response()->json($this->cartPayload($request));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        $product = Product::active()->findOrFail($data['product_id']);
        $quantity = (int) ($data['quantity'] ?? 1);

        if ($product->stock < $quantity) {
            throw ValidationException::withMessages([
                'quantity' => ['The requested quantity is not available.'],
            ]);
        }

        $item = CartItem::firstOrNew([
            'user_id' => $request->user()->id,
            'product_id' => $product->id,
        ]);

        $item->quantity = ($item->exists ? $item->quantity : 0) + $quantity;

        if ($item->quantity > $product->stock) {
            throw ValidationException::withMessages([
                'quantity' => ['The cart quantity is higher than available stock.'],
            ]);
        }

        $item->save();

        return response()->json($this->cartPayload($request), 201);
    }

    public function update(Request $request, CartItem $cartItem): JsonResponse
    {
        abort_if($cartItem->user_id !== $request->user()->id, 404);

        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cartItem->load('product');

        if (! $cartItem->product->is_active || $data['quantity'] > $cartItem->product->stock) {
            throw ValidationException::withMessages([
                'quantity' => ['The requested quantity is not available.'],
            ]);
        }

        $cartItem->update(['quantity' => $data['quantity']]);

        return response()->json($this->cartPayload($request));
    }

    public function destroy(Request $request, CartItem $cartItem): JsonResponse
    {
        abort_if($cartItem->user_id !== $request->user()->id, 404);

        $cartItem->delete();

        return response()->json($this->cartPayload($request));
    }

    private function cartPayload(Request $request): array
    {
        $items = $request->user()
            ->cartItems()
            ->with('product.category')
            ->latest()
            ->get();

        $mapped = $items->map(function (CartItem $item): array {
            $lineTotal = (float) $item->product->price * $item->quantity;

            return [
                'id' => $item->id,
                'quantity' => $item->quantity,
                'line_total' => round($lineTotal, 2),
                'product' => $item->product,
            ];
        });

        return [
            'items' => $mapped,
            'count' => $items->sum('quantity'),
            'subtotal' => round($mapped->sum('line_total'), 2),
        ];
    }
}
