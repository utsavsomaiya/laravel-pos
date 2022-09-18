<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\PriceDiscount;
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

        $products = Product::whereIn('id', $validatedData['id'])->get();
        foreach ($validatedData['id'] as $key => $id) {
            $product = $products->firstWhere('id', $id);
            $product->update(['stock' => $product->stock - $validatedData['quantity'][$key]]);
            $subtotal += ((float) $product->price * (int) $validatedData['quantity'][$key]);
        }

        $discount = Discount::with('priceDiscounts', 'giftDiscounts', 'giftDiscounts.product')->find($request['discounts_id']);
        if ($discount != null) {
            if ($discount->promotion_type === Discount::PRICE_DISCOUNT) {
                $mainDiscount = $discount->priceDiscounts->find($request['discounts_tier_id']);
            }

            if ($discount->promotion_type === Discount::GIFT_DISCOUNT) {
                $mainDiscount =  $discount->giftDiscounts->find($request['discounts_tier_id']);
            }

            foreach ($validatedData['id'] as $key => $id) {
                $product = $products->firstWhere('id', $id);

                if ($discount->promotion_type === Discount::PRICE_DISCOUNT) {
                    $productDiscount[$key] = round((($product->price * (int) $validatedData['quantity'][$key]) * $mainDiscount->digit)/$subtotal, 2);
                    if ($mainDiscount->type === PriceDiscount::PERCENTAGE_DISCOUNT) {
                        $discountDigit = ($subtotal * $mainDiscount->digit)/100;
                        $productDiscount[$key] = round((($product->price * (int) $validatedData['quantity'][$key]) * $discountDigit)/$subtotal, 2);
                    }
                    $totalDiscount += $productDiscount[$key];
                    $tax = round(((($product->price * (int) $validatedData['quantity'][$key]) - $productDiscount[$key]) * $product->tax)/100, 2);
                    $totalTax += $tax;
                }

                if ($discount->promotion_type === Discount::GIFT_DISCOUNT) {
                    $productDiscount[$key] = 0;
                    $tax = round(((($product->price * (int) $validatedData['quantity'][$key]) - $productDiscount[$key]) * $product->tax)/100, 2);
                    $totalTax += $tax;
                }
            }
            if ($discount->promotion_type === Discount::GIFT_DISCOUNT) {
                $subtotal = $subtotal + $mainDiscount->product->price;
                $totalDiscount = $mainDiscount->product->price;
            }
        } else {
            foreach ($validatedData['id'] as $key => $id) {
                $product = $products->firstWhere('id', $id);
                $tax = (($product->price * (int) $validatedData['quantity'][$key]) * $product->tax)/100;
                $totalTax += $tax;
            }
        }
        $grandTotal = $subtotal - $totalDiscount + $totalTax;

        if ($request['discounts_id'] !== "null") {
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

        foreach ($validatedData['id'] as $key => $id) {
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