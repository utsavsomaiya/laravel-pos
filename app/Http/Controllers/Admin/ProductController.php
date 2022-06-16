<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ProductExport;
use App\Exports\SampleExport;
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

        $validatedData = $this->storeImage($validatedData);

        Product::create($validatedData);

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

        $oldImage = $product->image;

        if (request()->hasFile('image')) {
            $validatedData = $this->storeImage($validatedData);
        }

        $product->update($validatedData);

        if (request()->hasFile('image')) {
            Storage::delete('public/image'.'/'.$oldImage);
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

    private function storeImage($validatedData)
    {
        $name = request()->file('image')->getClientOriginalName();

        request()->file('image')->storeAs('public/image', $name);

        $validatedData['image'] = $name;

        $validatedData['path'] = asset('storage/image').'/'.$name;

        return $validatedData;
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

    public function importFileSampleDownload()
    {
        return Excel::download(new SampleExport, 'products.xlsx');
    }
}
