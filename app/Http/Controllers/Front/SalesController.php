<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Product;
use App\Models\Sales;
use App\Models\SalesDetails;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id' => ['required','array'],
            'quantity' => ['required','array'],
        ]);

        $mainDiscount = 0;
        $productDiscount = [];
        $totalDiscount = 0;
        $subtotal = 0;
        $totalTax = 0;
        $grandTotal = 0;
        $tax = 0;


        $products = Product::whereIn('id', $validatedData['id'])->get(['price', 'tax']);
        foreach ($products as $key => $product) {
            $subtotal += ($product->price * (int) $validatedData['quantity'][$key]);
        }
        $discount = Discount::with('priceDiscounts', 'giftDiscounts', 'giftDiscounts.products')->find($request['discounts_id']);
        if ($discount != null) {
            if ($discount->category == 0) {
                $mainDiscount = $discount->priceDiscounts->find($request['discounts_tier_id']);
            }

            if ($discount->category == 1) {
                $mainDiscount =  $discount->giftDiscounts->find($request['discounts_tier_id']);
            }

            foreach ($products as $key => $product) {
                if ($discount->category == 0) {
                    $productDiscount[$key] = round((($product->price * (int) $validatedData['quantity'][$key]) * $mainDiscount->digit)/$subtotal, 2);
                    if ($mainDiscount->type == 0) {
                        $discountDigit = ($subtotal * $mainDiscount->digit)/100;
                        $productDiscount[$key] = round((($product->price * (int) $validatedData['quantity'][$key]) * $discountDigit)/$subtotal, 2);
                    }
                    $totalDiscount += $productDiscount[$key];
                    $tax = round(((($product->price * (int) $validatedData['quantity'][$key]) - $productDiscount[$key]) * $product->tax)/100, 2);
                    $totalTax += $tax;
                }
                if ($discount->category == 1) {
                    $productDiscount[$key] = 0;
                    $tax = round(((($product->price * (int) $validatedData['quantity'][$key]) - $productDiscount[$key]) * $product->tax)/100, 2);
                    $totalTax += $tax;
                }
            }
            if ($discount->category == 1) {
                $subtotal = $subtotal + $mainDiscount->products->price;
                $totalDiscount = $mainDiscount->products->price;
            }
        } else {
            foreach ($products as $key => $product) {
                $tax = (($product->price * (int) $validatedData['quantity'][$key]) * $product->tax)/100;
                $totalTax += $tax;
            }
        }
        $grandTotal = $subtotal - $totalDiscount + $totalTax;

        if ($request['discounts_id'] != "null") {
            $sales = Sales::create([
                'subtotal' => $subtotal,
                'total_tax' => $totalTax,
                'total' => $grandTotal,
                'total_discount' => $totalDiscount,
                'discount_id' => $request['discounts_id']
            ]);
        } else {
            $sales = Sales::create([
                'subtotal' => $subtotal,
                'total_tax' => $totalTax,
                'total' => $grandTotal,
                'total_discount' => $totalDiscount,
            ]);
        }

        foreach ($products as $key => $product) {
            if (sizeof($productDiscount) > 0) {
                SalesDetails::create([
                    'product_id' => $validatedData['id'][$key],
                    'sales_id' => $sales->id,
                    'product_quantity' => $validatedData['quantity'][$key],
                    'product_discount_id' => $request['discounts_tier_id'],
                    'product_discount' => $productDiscount[$key]
                ]);
            } else {
                SalesDetails::create([
                    'product_id' => $validatedData['id'][$key],
                    'sales_id' => $sales->id,
                    'product_quantity' => $validatedData['quantity'][$key],
                    'product_discount_id' => 0,
                ]);
            }
        }

        return back()->with([
            'success' => 'Order added successfully.'
        ]);
    }
}
