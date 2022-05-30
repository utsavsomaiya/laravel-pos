<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();

        return view('admin.products.index', compact('products'));
    }
    public function add()
    {
        $categories = Category::all();

        return view('admin.products.add', compact('categories'));
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required','min:3','max:255','unique:products,name'],
            'price' => ['required'],
            'category_id' => ['required'],
            'tax' => ['required'],
            'stock' => ['required'],
            'image' => ['required','image'],
        ]);

        $name = $request->file('image')->getClientOriginalName();

        $request->file('image')->storeAs('public/image', $name);

        $validatedData['image'] = $name;

        $validatedData['path'] = asset('storage/image').'/'.$name;

        Product::create($validatedData);

        return to_route('products')->with([
            'success' => 'Products added successfully.'
        ]);
    }


    public function edit(Product $product)
    {
        $categories = Category::findOrFail($product->category_id)->get();

        return view('admin.products.add', compact('product', 'categories'));
    }

    public function update(Product $product, Request $request)
    {
        $validatedData = $request->validate([
            'name' => [
                'required',
                'min:3',
                'max:255',
                Rule::unique('products', 'name')->ignore($product->id),
            ],
            'price' => ['required'],
            'category_id' => ['required'],
            'tax' => ['required'],
            'stock' => ['required'],
            'image' => ['image'],
        ]);

        if ($request->file('image') != null) {
            Storage::delete('public/image'.'/'.$product->image);

            $name = $request->file('image')->getClientOriginalName();

            $request->file('image')->storeAs('public/image', $name);

            $validatedData['image'] = $name;

            $validatedData['path'] = asset('storage/image').'/'.$name;
        }

        $product->update($validatedData);

        return to_route('products')->with([
            'success' => 'Product updated successfully.'
        ]);
    }

    public function delete(Product $product)
    {
        Storage::delete('public/image'.'/'.$product->image);

        $product->delete();

        return back()->with([
            'success' => 'Product deleted successfully.'
        ]);
    }
}
