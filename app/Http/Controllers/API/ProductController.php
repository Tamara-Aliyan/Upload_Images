<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return response()->json(['products' => $products]);
    }

    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->all());
        return response()->json(['product' => $product], 201);
    }

    public function show(Product $product)
    {
        return response()->json(['product' => $product]);
    }

    public function update(StoreProductRequest $request, Product $product)
    {
        $product->update($request->all());
        return response()->json(['product' => $product]);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(null, 204);
    }
}
