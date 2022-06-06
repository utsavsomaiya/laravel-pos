<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => [
                'required',
                'min:3',
                'max:255',
                'unique:categories,name'
            ]
        ]);

        Category::create($validatedData);

        return to_route('categories')->with([
            'success' => 'Category added successfully.'
        ]);
    }

    public function edit(Category $category)
    {
        return view('admin.categories.form', compact('category'));
    }

    public function update(Category $category, Request $request)
    {
        $validatedData = $request->validate([
            'name' => [
                'required',
                'min:3',
                'max:255',
                Rule::unique('categories', 'name')->ignore($category->id),
            ]
        ]);

        $category->update($validatedData);

        return to_route('categories')->with([
            'success' => 'Category Updated successfully'
        ]);
    }

    public function delete(Category $category)
    {
        $productCategory = Product::where('category_id', $category->id)->first();

        if ($productCategory) {
            return back()->with([
                'error' => 'This category depends on some of the products'
            ]);
        }

        $category->delete();

        return back()->with([
            'success' => 'Category deleted successfully.'
        ]);
    }
}
