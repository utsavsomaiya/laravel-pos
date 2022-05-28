<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
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
            'name' => ['required','min:3','max:255','unique:categories,name']
        ]);

        Category::create($category);

        return to_route('categories')->with(
            ['success' => 'Category added successfully.']
        );
    }

    public function edit($categoryId)
    {
        $category = Category::findOrFail($categoryId);

        return view('admin.categories.add', compact('category'));
    }

    public function update($categoryId, Request $request)
    {
        $category = $request->validate([
            'name' => [Rule::unique('categories', 'name')->ignore($categoryId),'required','min:3','max:255']
        ]);

        Category::findOrFail($categoryId)->update($category);

        return to_route('categories')->with([
            'success' => 'Category Updated successfully'
        ]);
    }

    public function delete($categoryId)
    {
        Category::findOrFail($categoryId)->delete();

        return back()->with([
            'success' => 'Category deleted successfully.'
        ]);
    }
}
