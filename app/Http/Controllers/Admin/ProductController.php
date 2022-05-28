<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
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

        return to_route('products_list')->with([
            'success' => 'Products added successfully.'
        ]);
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id)->get()->first();

        Storage::delete('public/image'.'/'.$product->image);

        Product::findOrFail($id)->delete();

        return back()->with([
            'success' => 'Product deleted successfully.'
        ]);
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);

        $categories = Category::findOrFail($product->category_id)->get();

        return view('admin.products.add', compact('product', 'categories'));
    }

    public function update($id, Request $request)
    {
        $product = $request->validate([
            'name' => ['required','min:3','max:255'],
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

        Product::find($id)->update($product);

        return to_route('products_list')->with([
            'success' => 'Product updated successfully.'
        ]);
    }
}
