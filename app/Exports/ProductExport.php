<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $product = Product::with('category')->get();

        $product =  collect(
            $product->map(function ($product) {
                return [
                    $product->name,
                    $product->category->name,
                    $product->price,
                    $product->tax,
                    $product->stock
                ];
            })
        );

        $product = $product->prepend(['Name', 'Category', 'Price', 'Tax', 'Stock']);

        return $product;
    }
}
