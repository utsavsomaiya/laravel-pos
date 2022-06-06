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
        $validatedData = $request->validate([
            'name' => ['required','unique:discounts,name'],
            'promotion_type' => ['required'],
            'type' => ['required_if:promotion_type,in:"1"'],
            'minimum_spend_amount' => ['required','array'],
            'minimum_spend_amount.*' => ['required','distinct'],
            'digit' => ['required_if:promotion_type,in:"1"','array'],
            'digit.*' => [
                'required',
                'distinct',
                function ($attribute, $value, $fail) {
                    if (request()->input('type') == 0 && $value > 100) {
                        $fail('Percentage is not greater than 100');
                    }
                }
            ],
            'product' => ['required_if:promotion_type,in:"2"','array'],
            'product.*' => ['required','distinct'],
            'status' => ['required'],
        ]);

        $validatedData['promotion_type'] = (int) $validatedData['promotion_type'];
        $validatedData['status'] = (int) $validatedData['status'];

        $mainDiscount = Discount::create([
            'name' => $validatedData['name'],
            'promotion_type' => $validatedData['promotion_type'],
            'status' => $validatedData['status']
        ]);

        if ($validatedData['promotion_type'] == 1) {
            for ($i = 0; $i < count($validatedData['minimum_spend_amount']); $i++) {
                PriceDiscount::create([
                    'discount_id' => $mainDiscount->id,
                    'type' => (int) $validatedData['type'],
                    'minimum_spend_amount' => (double) $validatedData['minimum_spend_amount'][$i],
                    'digit' => (double) $validatedData['digit'][$i]
                ]);
            }
        }
        if ($validatedData['promotion_type'] == 2) {
            for ($i = 0; $i < count($validatedData['minimum_spend_amount']); $i++) {
                GiftDiscount::create([
                    'discount_id' => $mainDiscount->id,
                    'minimum_spend_amount' => (double) $validatedData['minimum_spend_amount'][$i],
                    'product_id' => $validatedData['product'][$i]
                ]);
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
        $validatedData = $request->validate([
            'name' => [
                'required',
                Rule::unique('discounts', 'name')->ignore($discount->id)
            ],
            'promotion_type' => ['required'],
            'type' => ['required_if:promotion_type,in:"1"'],
            'minimum_spend_amount' => ['required','array'],
            'minimum_spend_amount.*' => ['required','distinct'],
            'digit' => ['required_if:promotion_type,in:"1"','array'],
            'digit.*' => [
                'required',
                'distinct',
                function ($attribute, $value, $fail) {
                    if (request()->input('type') == 0 && $value > 100) {
                        $fail('Percentage is not greater than 100');
                    }
                }
            ],
            'product' => ['required_if:promotion_type,in:"2"','array'],
            'product.*' => ['required','distinct'],
            'status' => ['required'],
        ]);

        $validatedData['promotion_type'] = (int) $validatedData['promotion_type'];
        $validatedData['status'] = (int) $validatedData['status'];


        $discount->update([
            'name' => $validatedData['name'],
            'promotion_type' => $validatedData['promotion_type'],
            'status' => $validatedData['status']
        ]);

        if ($validatedData['promotion_type'] == 1) {
            $priceDiscounts = PriceDiscount::where('discount_id', $discount->id)->get();
            if (count($priceDiscounts) == count($validatedData['minimum_spend_amount'])) {
                for ($i = 0; $i < count($validatedData['minimum_spend_amount']); $i++) {
                    PriceDiscount::where('discount_id', $discount->id)
                        ->where('minimum_spend_amount', $priceDiscounts[$i]->minimum_spend_amount)
                        ->update([
                        'type' => (int) $validatedData['type'],
                        'minimum_spend_amount' => (double) $validatedData['minimum_spend_amount'][$i],
                        'digit' => (double) $validatedData['digit'][$i]
                    ]);
                }
            }
            if (count($priceDiscounts) < count($validatedData['minimum_spend_amount'])) {
                for ($i = 0; $i < count($priceDiscounts); $i++) {
                    PriceDiscount::where('discount_id', $discount->id)
                        ->where('minimum_spend_amount', $priceDiscounts[$i]->minimum_spend_amount)
                        ->update([
                            'type' => (int) $validatedData['type'],
                            'minimum_spend_amount' => (double) $validatedData['minimum_spend_amount'][$i],
                            'digit' => (double) $validatedData['digit'][$i]
                        ]);
                }
                for ($i = count($priceDiscounts); $i < count($validatedData['minimum_spend_amount']); $i++) {
                    PriceDiscount::create([
                        'discount_id' => $discount->id,
                        'type' => (int) $validatedData['type'],
                        'minimum_spend_amount' => (double) $validatedData['minimum_spend_amount'][$i],
                        'digit' => (double) $validatedData['digit'][$i]
                    ]);
                }
            }
            if (count($priceDiscounts) > count($validatedData['minimum_spend_amount'])) {
                PriceDiscount::where('discount_id', $discount->id)->delete();
                for ($i = 0; $i < count($validatedData['minimum_spend_amount']); $i++) {
                    PriceDiscount::create([
                        'discount_id' => $discount->id,
                        'type' => (int) $validatedData['type'],
                        'minimum_spend_amount' => (double) $validatedData['minimum_spend_amount'][$i],
                        'digit' => (double) $validatedData['digit'][$i]
                    ]);
                }
            }
        }

        if ($validatedData['promotion_type'] == 2) {
            $giftDiscounts = GiftDiscount::where('discount_id', $discount->id)->get();
            if (count($giftDiscounts) == count($validatedData['minimum_spend_amount'])) {
                for ($i = 0; $i < count($validatedData['minimum_spend_amount']); $i++) {
                    GiftDiscount::where('discount_id', $discount->id)
                        ->where('minimum_spend_amount', $giftDiscounts[$i]->minimum_spend_amount)
                        ->update([
                            'minimum_spend_amount' => (double) $validatedData['minimum_spend_amount'][$i],
                            'product_id' => $validatedData['product'][$i]
                        ]);
                }
            }
            if (count($giftDiscounts) < count($validatedData['minimum_spend_amount'])) {
                for ($i = 0; $i< count($giftDiscounts) ; $i++) {
                    GiftDiscount::where('discount_id', $discount->id)
                        ->where('minimum_spend_amount', $giftDiscounts[$i]->minimum_spend_amount)
                        ->update([
                            'minimum_spend_amount' => (double) $validatedData['minimum_spend_amount'][$i],
                            'product_id' => $validatedData['product'][$i]
                        ]);
                }
                for ($i = count($giftDiscounts); $i < count($validatedData['minimum_spend_amount']); $i++) {
                    GiftDiscount::create([
                        'discount_id' => $discount->id,
                        'minimum_spend_amount' => (double) $validatedData['minimum_spend_amount'][$i],
                        'product_id' => $validatedData['product'][$i]
                    ]);
                }
            }
            if (count($giftDiscounts) > count($validatedData['minimum_spend_amount'])) {
                GiftDiscount::where('discount_id', $discount->id)->delete();
                for ($i = 0; $i < count($validatedData['minimum_spend_amount']); $i++) {
                    GiftDiscount::create([
                        'discount_id' => $discount->id,
                        'minimum_spend_amount' => (double) $validatedData['minimum_spend_amount'][$i],
                        'product_id' => $validatedData['product'][$i]
                    ]);
                }
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
