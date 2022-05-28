<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\GiftDiscount;
use App\Models\PriceDiscount;
use App\Models\Product;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::all();

        return view('admin.discounts.index', compact('discounts'));
    }

    public function add()
    {
        $products = Product::all();

        return view('admin.discounts.add', compact('products'));
    }

    public function store(Request $request)
    {
        $discount = $request->validate([
            'name' => ['required','unique:discounts,name'],
            'category' => ['required'],
            'type' => ['required_if:category,in:"0"'],
            'minimum_spend_amount' => ['required','array'],
            'minimum_spend_amount.*' => ['required','distinct'],
            'digit' => ['required_if:category,in:"0"','array'],
            'digit.*' => ['required','distinct',function ($attribute, $value, $fail) {
                if (request('type') == 0 && (int) $value > 100) {
                    $fail('Percentage is not greater than 100');
                }
            }],
            'product' => ['required_if:category,in:"1"','array'],
            'product.*' => ['required','distinct'],
            'status' => ['required'],
        ]);

        $discount['category'] = (int) $discount['category'];
        $discount['status'] = (int) $discount['status'];

        $MainDiscount = [
            'name' => $discount['name'],
            'category' => $discount['category'],
            'status' => $discount['status']
        ];

        $mainDiscount = Discount::create($MainDiscount);

        if ($discount['category'] == 0) {
            for ($i = 0; $i < sizeof($discount['minimum_spend_amount']); $i++) {
                $priceDiscount = [
                    'discount_id' => $mainDiscount->id,
                    'type' => (int) $discount['type'],
                    'minimum_spend_amount' => (double) $discount['minimum_spend_amount'][$i],
                    'digit' => (double) $discount['digit'][$i]
                ];
                PriceDiscount::create($priceDiscount);
            }
        }
        if ($discount['category'] == 1) {
            for ($i = 0; $i < sizeof($discount['minimum_spend_amount']); $i++) {
                $giftDiscount = [
                    'discount_id' => $mainDiscount->id,
                    'minimum_spend_amount' => (double) $discount['minimum_spend_amount'][$i],
                    'product_id' => $discount['product'][$i]
                ];
                GiftDiscount::create($giftDiscount);
            }
        }

        return to_route('discounts_list')->with([
            'success' => 'Discount added successfully'
        ]);
    }

    public function delete($discountId)
    {
        Discount::findOrFail($discountId)->delete();
        return back()->with([
            'success' => 'Discount deleted successfully'
        ]);
    }

    public function statusChanged(Request $request)
    {
        Discount::findOrFail($request->id)->update(['status' => $request->status]);
    }

    public function edit($discountId)
    {
        $discounts = Discount::with(['priceDiscounts','giftDiscounts','giftDiscounts.products:name,id'])->findOrFail($discountId);
        $products = Product::all();
        return view('admin.discounts.add', compact('discounts', 'products'));
    }
}
