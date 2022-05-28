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
        $category = $request->validate([
            'name' => [
                'required',
                'min:3',
                'max:255',
                'unique:categories,name'
            ]
        ]);

        Category::create($category);

        return to_route('categories')->with([
            'success' => 'Category added successfully.'
        ]);
    }

    public function edit($categoryId)
    {
        $category = Product::where('category_id', $categoryId)->first();

        if ($category == null) {
            Category::findOrFail($categoryId)->delete();
            return back()->with([
                'success' => 'Category deleted successfully.'
            ]);
        }

        return back()->with([
            'error' => 'This category is used in product.'
        ]);
    }

    public function update($categoryId, Request $request)
    {
        $category = $request->validate([
            'name' => [
                'required',
                'min:3',
                'max:255',
                Rule::unique('categories', 'name')->ignore($categoryId),
            ]
        ]);

        Category::findOrFail($categoryId)->update($category);

        return to_route('categories')->with([
            'success' => 'Category Updated successfully'
        ]);
    }

    public function delete($categoryId)
    {
        $category = Product::where('category_id', $categoryId)->first();

        if ($category == null) {
            Category::findOrFail($categoryId)->delete();
            return back()->with([
                'success' => 'Category deleted successfully.'
            ]);
        }

        return back()->with([
            'error' => 'This category is used in product.'
        ]);
    }
}
