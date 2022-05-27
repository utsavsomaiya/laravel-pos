<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiscountController extends Controller
{
    public function show()
    {
        $discounts = Discount::all();

        return view('admin.discounts.show', compact('discounts'));
    }

    public function add()
    {
        $products = Product::all();

        return view('admin.discounts.add', compact('products'));
    }

    public function store(Request $request)
    {
        $a = 1;

        echo $a++;
        $request->validate([
            'name' => ['required','unique:discounts,name'],
            'category' => ['required'],
            'type' => ['required_if:category,in:"0"'],
            'minimum_spend_amount' => ['required','array'],
            'minimum_spend_amount.*' => ['required','distinct'],
            'digit' => ['required_if:category,in:"0"','array'],
            'digit.*' => ['required','distinct'],
            'product' => ['required_if:category,in:"1"','array'],
            'product.*' => ['required','distinct'],
            'status' => ['required'],
        ]);
    }
}
