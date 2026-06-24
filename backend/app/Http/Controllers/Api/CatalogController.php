<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function categories(): JsonResponse
    {
        $categories = Category::withCount([
            'products' => fn ($query) => $query->active(),
        ])
            ->orderBy('name')
            ->get();

        return response()->json($categories);
    }

    public function products(Request $request): JsonResponse
    {
        $query = Product::query()
            ->active()
            ->with('category')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews');

        if ($search = $request->string('search')->trim()->toString()) {
            $query->where(function ($query) use ($search): void {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($category = $request->string('category')->trim()->toString()) {
            $query->whereHas('category', fn ($query) => $query->where('slug', $category));
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->float('min_price'));
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->float('max_price'));
        }

        match ($request->string('sort')->toString()) {
            'price_low' => $query->orderBy('price'),
            'price_high' => $query->orderByDesc('price'),
            'name' => $query->orderBy('name'),
            default => $query->latest(),
        };

        $products = $query->paginate(
            perPage: min($request->integer('per_page', 12), 48),
        )->withQueryString();

        return response()->json($products);
    }

    public function show(Product $product): JsonResponse
    {
        abort_if(! $product->is_active, 404);

        $product->load([
            'category',
            'reviews' => fn ($query) => $query->with('user:id,name')->latest(),
        ])->loadCount('reviews')
            ->loadAvg('reviews', 'rating');

        return response()->json($product);
    }
}
