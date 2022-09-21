<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ProductExport;
use App\Http\Controllers\Controller;
use App\Imports\ProductImport;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

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

        $taxes = Product::TAXES;

        return view('admin.products.form', compact('categories', 'taxes'));
    }

    public function store(ProductRequest $request)
    {
        $validatedData = $request->validated();

        $product = Product::create($validatedData);

        $product
            ->addMediaFromRequest('image')
            ->toMediaCollection('product-images');

        return to_route('products.index')->with([
            'success' => 'Product added successfully.'
        ]);
    }

    public function edit(Product $product)
    {
        $categories = Category::all();

        $taxes = Product::TAXES;

        return view('admin.products.form', compact('product', 'categories', 'taxes'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $validatedData = $request->validated();

        $product->update($validatedData);

        if (request()->hasFile('image')) {
            $product
                ->addMediaFromRequest('image')
                ->toMediaCollection('product-images');
        }

        return to_route('products.index')->with([
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

    public function fileExport()
    {
        return Excel::download(new ProductExport, 'products.xlsx');
    }

    public function fileImport()
    {
        request()->validate([
            'import_file' => ['required','mimes:xlsx'],
        ]);

        Excel::import(new ProductImport, request()->file('import_file')->store('temp'));

        return back()->with('success', 'File imported successfully!!');
    }
}
