<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category:id,name')->get();

        $discounts = Discount::with('priceDiscounts', 'giftDiscounts', 'giftDiscounts.products')->get();

        return view('index', compact('products', 'discounts'));
    }
}
