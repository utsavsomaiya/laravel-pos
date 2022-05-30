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
        $product = $request->validate([
            'name' => ['required','min:3','max:255','unique:products,name'],
            'price' => ['required'],
            'category_id' => ['required'],
            'tax' => ['required'],
            'stock' => ['required'],
            'image' => ['required','image'],
        ]);

        $name = $request->file('image')->getClientOriginalName();

        $request->file('image')->storeAs('public/image', $name);

        $product['image'] = $name;

        Product::create($product);

        return to_route('products')->with([
            'success' => 'Products added successfully.'
        ]);
    }

    public function delete($productId)
    {
        $product = Product::findOrFail($productId)->get()->first();

        Storage::delete('public/image'.'/'.$product->image);

        Product::findOrFail($productId)->delete();

        return back()->with([
            'success' => 'Product deleted successfully.'
        ]);
    }

    public function edit($productId)
    {
        $product = Product::findOrFail($productId);

        $categories = Category::findOrFail($product->category_id)->get();

        return view('admin.products.add', compact('product', 'categories'));
    }

    public function update($productId, Request $request)
    {
        $product = $request->validate([
            'name' => [
                'required',
                'min:3',
                'max:255',
                Rule::unique('products', 'name')->ignore($productId),
            ],
            'price' => ['required'],
            'category_id' => ['required'],
            'tax' => ['required'],
            'stock' => ['required'],
            'image' => ['image'],
        ]);

        if ($request->file('image') != null) {
            $name = $request->file('image')->getClientOriginalName();

            $request->file('image')->storeAs('public/image', $name);

            $product['image'] = $name;
        }

        Product::findOrFail($productId)->update($product);

        return to_route('products')->with([
            'success' => 'Product updated successfully.'
        ]);
    }
}
