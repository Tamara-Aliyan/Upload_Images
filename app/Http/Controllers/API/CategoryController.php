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
        $categories = Category::with(['products' => function ($query) {
            $query->userNameContainsA();
        }])
        ->get();

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

    public function show($categoryId)
    {
        $category = Category::with(['products' => function ($query) {
            $query->userNameContainsA();
        }])
        ->findOrFail($categoryId);

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
