<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use App\Models\Product;
use App\Http\Requests\Admin\StoreProductImageRequest;
use App\Http\Requests\Admin\UpdateProductImageRequest;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    public function index()
    {
        $images = ProductImage::with('product')->latest()->paginate(10);

        return view('admin.product-images.index', compact('images'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();

        return view('admin.product-images.create', compact('products'));
    }

    public function store(StoreProductImageRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('filename')) {
            $data['filename'] = $request->file('filename')->store('products', 'public');
        }

        ProductImage::create($data);

        return redirect()->route('admin.product-images.index')
            ->with('success', 'Product image created successfully.');
    }

    public function show(ProductImage $productImage)
    {
        $productImage->load('product');

        return view('admin.product-images.show', compact('productImage'));
    }

    public function edit(ProductImage $productImage)
    {
        $products = Product::orderBy('name')->get();

        return view('admin.product-images.edit', compact('productImage', 'products'));
    }

    public function update(UpdateProductImageRequest $request, ProductImage $productImage)
    {
        $data = $request->validated();

        if ($request->hasFile('filename')) {
            $oldFilename = $productImage->filename;

            $data['filename'] = $request->file('filename')->store('products', 'public');

            if ($oldFilename && Storage::disk('public')->exists($oldFilename)) {
                Storage::disk('public')->delete($oldFilename);
            }
        }

        $productImage->update($data);

        return redirect()->route('admin.product-images.index')
            ->with('success', 'Product image updated successfully.');
    }

    public function destroy(ProductImage $productImage)
    {
        if ($productImage->filename && Storage::disk('public')->exists($productImage->filename)) {
            Storage::disk('public')->delete($productImage->filename);
        }

        $productImage->delete();

        return redirect()->route('admin.product-images.index')
            ->with('success', 'Product image deleted successfully.');
    }
}
