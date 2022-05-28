<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $category = $request->validate([
            'name' => ['required','min:3','max:255','unique:categories,name']
        ]);

        Category::create($category);

        return to_route('categories_list')->with(
            ['success' => 'Category added successfully.']
        );
    }

    public function index()
    {
        $categories = Category::all();

        return view('admin.categories.index', compact('categories'));
    }

    public function delete($categoryId)
    {
        Category::findOrFail($categoryId)->delete();

        return back()->with([
            'success' => 'Category deleted successfully.'
        ]);
    }

    public function edit($categoryId)
    {
        $category = Category::findOrFail($categoryId)->first();

        return view('admin.categories.add', compact('category'));
    }

    public function update($categoryId, Request $request)
    {
        $category = $request->validate([
            'name' => ['required','min:3','max:255']
        ]);

        Category::findOrFail($categoryId)->update($category);

        return to_route('categories_list')->with([
            'success' => 'Category Updated successfully'
        ]);
    }
}
