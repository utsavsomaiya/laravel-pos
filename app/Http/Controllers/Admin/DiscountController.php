<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DiscountRequest;
use App\Models\Discount;
use App\Models\Product;
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

    public function store(DiscountRequest $request)
    {
        $validatedData = $request->validated();

        $validatedData['promotion_type'] = (int) $validatedData['promotion_type'];

        $validatedData['status'] = (int) $validatedData['status'];

        DiscountServices::saveDetails($validatedData);

        return to_route('discounts')->with([
            'success' => 'Discount added successfully',
        ]);
    }

    public function edit(Discount $discount)
    {
        $products = Product::all();

        return view('admin.discounts.form', compact('discount', 'products'));
    }

    public function update(DiscountRequest $request, Discount $discount)
    {
        $validatedData = $request->validated();

        $validatedData['promotion_type'] = (int) $validatedData['promotion_type'];

        $validatedData['status'] = (int) $validatedData['status'];

        $discount->update([
            'name' => $validatedData['name'],
            'promotion_type' => $validatedData['promotion_type'],
            'status' => $validatedData['status'],
        ]);

        if (Discount::PRICE_DISCOUNT === $validatedData['promotion_type']) {
            DiscountServices::updatePriceDiscount($validatedData, $discount);
        }

        if (Discount::GIFT_DISCOUNT === $validatedData['promotion_type']) {
            DiscountServices::updateGiftDiscount($validatedData, $discount);
        }

        return to_route('discounts')->with([
            'success' => 'Discount updated successfully.',
        ]);
    }

    public function delete(Discount $discount)
    {
        $discount->delete();

        return back()->with([
            'success' => 'Discount deleted successfully',
        ]);
    }

    public function statusChanged(Discount $discount)
    {
        $validatedData = request()->validate([
            'status' => ['required', 'boolean'],
        ]);

        $discount->update($validatedData);
    }
}
