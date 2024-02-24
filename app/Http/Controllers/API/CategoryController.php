<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with(['products.owner' => function ($query) {
            $query->where('name', 'like', '%a%');
        }])
        ->get();

        // Apply the global filtering for products priced greater than or equal to 150 for each category
        $categories->each(function ($category) {
            $category->products = $category->products()->priceGreaterThan()->get();
        });

        return response()->json($categories);
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->all());
        return response()->json(['category' => $category], 201);
    }

    public function show($id)
    {
        $category = Category::with(['products.owner' => function ($query) {
            $query->where('name', 'like', '%a%');
        }])
        ->findOrFail($id);
        // Apply the global filtering for products priced greater than or equal to 150
        $category->products = $category->products()->priceGreaterThan()->get();
        return response()->json($category);
    }

    public function update(StoreCategoryRequest $request, Category $category)
    {
        $category->update($request->all());
        return response()->json(['category' => $category]);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(null, 204);
    }
}
