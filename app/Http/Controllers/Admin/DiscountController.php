<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Validation\Rule;
use App\Services\DiscountServices;

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

    public function store()
    {
        $validatedData = $this->validateDiscount();

        $validatedData['promotion_type'] = (int) $validatedData['promotion_type'];

        $validatedData['status'] = (int) $validatedData['status'];

        DiscountServices::createOrUpdateDiscount($validatedData, new Discount());

        return to_route('discounts')->with([
            'success' => 'Discount added successfully'
        ]);
    }


    public function edit(Discount $discount)
    {
        $products = Product::all();

        return view('admin.discounts.form', compact('discount', 'products'));
    }

    public function update(Discount $discount)
    {
        $validatedData = $this->validateDiscount($discount);

        $validatedData['promotion_type'] = (int) $validatedData['promotion_type'];

        $validatedData['status'] = (int) $validatedData['status'];

        DiscountServices::createOrUpdateDiscount($validatedData, $discount);

        if ($validatedData['promotion_type'] == 1) {
            DiscountServices::updatePriceDiscount($validatedData, $discount);
        }

        if ($validatedData['promotion_type'] == 2) {
            DiscountServices::updateGiftDiscount($validatedData, $discount);
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

    public function statusChanged(Discount $discount)
    {
        $validatedData = request()->validate([
            'status' => ['required', 'boolean']
        ]);
        $discount->update($validatedData);
    }

    protected function validateDiscount(?Discount $discount = null)
    {
        $discount ??= new Discount();

        return request()->validate([
            'name' => [
                'required',
                Rule::unique('discounts', 'name')->ignore($discount)
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
    }
}
