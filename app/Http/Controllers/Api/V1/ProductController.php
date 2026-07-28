<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ProductResource;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Product::with(['category', 'images']);

        if ($request->filled('category')) {
            $category = ProductCategory::where('slug', $request->category)->first();
            if ($category) {
                $query->where('product_category_id', $category->id);
            }
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->boolean('promo')) {
            $query->where('is_promo', true);
        }

        $perPage = max(1, min((int) $request->get('per_page', 12), 50));
        $products = $query->latest()->paginate($perPage);

        return ProductResource::collection($products);
    }

    public function show(string $slug): ProductResource|JsonResponse
    {
        $product = Product::with(['category', 'images', 'type'])
            ->where('slug', $slug)
            ->first();

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return new ProductResource($product);
    }

    public function categories(): AnonymousResourceCollection
    {
        $categories = ProductCategory::withCount('products')->orderBy('name')->get();

        return \App\Http\Resources\V1\CategoryResource::collection($categories);
    }
}
