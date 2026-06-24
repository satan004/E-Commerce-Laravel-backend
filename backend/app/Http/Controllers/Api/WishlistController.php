<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\WishlistItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $items = $request->user()
            ->wishlistItems()
            ->with('product.category')
            ->latest()
            ->get();

        return response()->json($items);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
        ]);

        $product = Product::active()->findOrFail($data['product_id']);

        $item = WishlistItem::firstOrCreate([
            'user_id' => $request->user()->id,
            'product_id' => $product->id,
        ]);

        return response()->json($item->load('product.category'), 201);
    }

    public function destroy(Request $request, Product $product): JsonResponse
    {
        $deleted = WishlistItem::where('user_id', $request->user()->id)
            ->where('product_id', $product->id)
            ->delete();

        return response()->json([
            'deleted' => (bool) $deleted,
        ]);
    }
}
