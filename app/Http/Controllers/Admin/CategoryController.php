<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $category = $request->validate([
            'name' => ['required','min:3','max:255','unique:categories,name']
        ]);

        Category::create($category);

        return redirect('/admin/categories')->with(
            ['success' => 'Category added successfully.']
        );
    }

    public function show()
    {
        $categories = Category::all();

        return view('admin.categories.show', compact('categories'));
    }

    public function delete($id)
    {
        $category = Product::where('category_id', $id)->first();
        if ($category == null) {
            Category::find($id)->delete();
            return back()->with([
                'success' => 'Category deleted successfully.'
            ]);
        }
        return back()->with([
            'error' => 'This category is used in product.'
        ]);
    }

    public function edit($id)
    {
        $category = Category::find($id)->first();
        return view('admin.categories.add', compact('category'));
    }

    public function update($id, Request $request)
    {
        $category = $request->validate([
            'name' => ['required','min:3','max:255']
        ]);

        Category::find($id)->update($category);

        return redirect('/admin/categories')->with([
            'success' => 'Category Updated successfully'
        ]);
    }
}
