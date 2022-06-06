<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\GiftDiscount;
use App\Models\PriceDiscount;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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

        return view('admin.discounts.form', compact('products'));
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
            'digit.*' => [
                'required',
                'distinct',
                function ($attribute, $value, $fail) {
                    if (request('type') == 0 && (int) $value > 100) {
                        $fail('Percentage is not greater than 100');
                    }
                }
            ],
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

        return to_route('discounts')->with([
            'success' => 'Discount added successfully'
        ]);
    }


    public function edit(Discount $discount)
    {
        $products = Product::all();

        return view('admin.discounts.form', compact('discount', 'products'));
    }

    public function update(Discount $discount, Request $request)
    {
        $discounts = $request->validate([
            'name' => [
                'required',
                Rule::unique('discounts', 'name')->ignore($discount->id)
            ],
            'category' => ['required'],
            'type' => ['required_if:category,in:"0"'],
            'minimum_spend_amount' => ['required','array'],
            'minimum_spend_amount.*' => ['required','distinct'],
            'digit' => ['required_if:category,in:"0"','array'],
            'digit.*' => [
                'required',
                'distinct',
                function ($attribute, $value, $fail) {
                    if (request('type') == 0 && (int) $value > 100) {
                        $fail('Percentage is not greater than 100');
                    }
                }
            ],
            'product' => ['required_if:category,in:"1"','array'],
            'product.*' => ['required','distinct'],
            'status' => ['required'],
        ]);

        $discounts['category'] = (int) $discounts['category'];
        $discounts['status'] = (int) $discounts['status'];

        $MainDiscount = [
            'name' => $discounts['name'],
            'category' => $discounts['category'],
            'status' => $discounts['status']
        ];

        $discount->update($MainDiscount);

        if ($discounts['category'] == 0) {
            $priceDiscounts = PriceDiscount::where('discount_id', $discount->id)->get();
            if (sizeof($priceDiscounts) == sizeof($discounts['minimum_spend_amount'])) {
                for ($i = 0; $i < sizeof($discounts['minimum_spend_amount']); $i++) {
                    $priceDiscount = [
                        'type' => (int) $discounts['type'],
                        'minimum_spend_amount' => (double) $discounts['minimum_spend_amount'][$i],
                        'digit' => (double) $discounts['digit'][$i]
                    ];
                    PriceDiscount::where('discount_id', $discount->id)
                        ->where('minimum_spend_amount', $priceDiscounts[$i]->minimum_spend_amount)
                        ->update($priceDiscount);
                }
            }
            if (sizeof($priceDiscounts) < sizeof($discounts['minimum_spend_amount'])) {
                for ($i = 0; $i < sizeof($priceDiscounts); $i++) {
                    $priceDiscount = [
                        'type' => (int) $discounts['type'],
                        'minimum_spend_amount' => (double) $discounts['minimum_spend_amount'][$i],
                        'digit' => (double) $discounts['digit'][$i]
                    ];
                    PriceDiscount::where('discount_id', $discount->id)
                        ->where('minimum_spend_amount', $priceDiscounts[$i]->minimum_spend_amount)
                        ->update($priceDiscount);
                }
                for ($i = sizeof($priceDiscounts); $i < sizeof($discounts['minimum_spend_amount']); $i++) {
                    $priceDiscount = [
                        'discount_id' => $discount->id,
                        'type' => (int) $discounts['type'],
                        'minimum_spend_amount' => (double) $discounts['minimum_spend_amount'][$i],
                        'digit' => (double) $discounts['digit'][$i]
                    ];
                    PriceDiscount::create($priceDiscount);
                }
            }
            $minimumSpendAmount = [];
            if (sizeof($priceDiscounts) > sizeof($discounts['minimum_spend_amount'])) {
                for ($i = 0; $i < sizeof($discounts['minimum_spend_amount']); $i++) {
                    $priceDiscount = [
                        'type' => (int) $discounts['type'],
                        'minimum_spend_amount' => (double) $discounts['minimum_spend_amount'][$i],
                        'digit' => (double) $discounts['digit'][$i]
                    ];
                    PriceDiscount::where('discount_id', $discount->id)
                        ->where('minimum_spend_amount', $priceDiscounts[$i]->minimum_spend_amount)
                        ->update($priceDiscount);
                }
                foreach ($priceDiscounts as $key => $priceDiscount) {
                    $minimumSpendAmount[$key] = $priceDiscount->minimum_spend_amount;
                }
                $differenceOfPriceDiscount = array_diff($minimumSpendAmount, $discounts['minimum_spend_amount']);
                PriceDiscount::whereIn('minimum_spend_amount', $differenceOfPriceDiscount)
                    ->where('discount_id', $discount->id)
                    ->delete();
            }
        }

        if ($discounts['category'] == 1) {
            $giftDiscounts = GiftDiscount::where('discount_id', $discount->id)->get();
            if (sizeof($giftDiscounts) == sizeof($discounts['minimum_spend_amount'])) {
                for ($i = 0; $i < sizeof($discounts['minimum_spend_amount']); $i++) {
                    $giftDiscount = [
                        'minimum_spend_amount' => (double) $discounts['minimum_spend_amount'][$i],
                        'product_id' => $discounts['product'][$i]
                    ];
                    GiftDiscount::where('discount_id', $discount->id)
                        ->where('minimum_spend_amount', $giftDiscounts[$i]->minimum_spend_amount)
                        ->update($giftDiscount);
                }
            }
            if (sizeof($giftDiscounts) < sizeof($discounts['minimum_spend_amount'])) {
                for ($i = 0; $i< sizeof($giftDiscounts) ; $i++) {
                    $giftDiscount = [
                        'minimum_spend_amount' => (double) $discounts['minimum_spend_amount'][$i],
                        'product_id' => $discounts['product'][$i]
                    ];
                    GiftDiscount::where('discount_id', $discount->id)
                        ->where('minimum_spend_amount', $giftDiscounts[$i]->minimum_spend_amount)
                        ->update($giftDiscount);
                }
                for ($i = sizeof($giftDiscounts); $i < sizeof($discounts['minimum_spend_amount']); $i++) {
                    $giftDiscount = [
                        'discount_id' => $discount->id,
                        'minimum_spend_amount' => (double) $discounts['minimum_spend_amount'][$i],
                        'product_id' => $discounts['product'][$i]
                    ];
                    GiftDiscount::create($giftDiscount);
                }
            }
            $minimumSpendAmount = [];
            if (sizeof($giftDiscounts) > sizeof($discounts['minimum_spend_amount'])) {
                for ($i = 0; $i < sizeof($discounts['minimum_spend_amount']); $i++) {
                    $giftDiscount = [
                        'minimum_spend_amount' => (double) $discounts['minimum_spend_amount'][$i],
                        'product_id' => $discounts['product'][$i]
                    ];
                    GiftDiscount::where('discount_id', $discount->id)
                        ->where('minimum_spend_amount', $giftDiscounts[$i]->minimum_spend_amount)
                        ->update($giftDiscount);
                }
                foreach ($giftDiscounts as $key => $giftDiscount) {
                    $minimumSpendAmount[$key] = $giftDiscount->minimum_spend_amount;
                }
                $differenceOfGiftDiscount = array_diff($minimumSpendAmount, $discounts['minimum_spend_amount']);
                GiftDiscount::whereIn('minimum_spend_amount', $differenceOfGiftDiscount)
                    ->where('discount_id', $discount->id)
                    ->delete();
            }
        }

        return to_route('discounts')->with([
            'success' => 'Discount updated successfully.'
        ]);
    }

    public function delete(Discount $discount)
    {
        $discount->delete();
        return back()->with([
                'success' => 'Discount deleted successfully'
            ]);
    }

    public function statusChanged(Discount $discount, Request $request)
    {
        $discount->update(['status' => $request->status]);
    }
}
