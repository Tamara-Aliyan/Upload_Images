<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;

class CategoryController extends Controller
{
    public function index()
{
    $categories = Category::with([
            'subcategories.products',
            'products' => function ($query) {
                $query->userNameContainsA();
            }
        ])
        ->whereNull('parent_id')
        ->get();

    $categories->each(function ($category) {
        $category->products = $category->products->merge(
            $category->subcategories->flatMap->products
        );
    });

    return response()->json(['categories' => $categories]);
}

    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->all());
        return response()->json(['category' => $category], 201);
    }

    public function show($categoryId)
{
    $category = Category::with([
            'subcategories.products',
            'products' => function ($query) {
                $query->userNameContainsA();
            }
        ])
        ->find($categoryId);

    return response()->json(['category' => $category]);
}

    public function update(UpdateCategoryRequest $request, Category $category)
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
