<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Discount;
use App\Models\GiftDiscount;
use App\Models\PriceDiscount;

class DiscountServices
{
    public static function updatePriceDiscount($validatedData, Discount $discount)
    {
        $priceDiscounts = PriceDiscount::where('discount_id', $discount->id)->get();

        if (count($priceDiscounts) === count($validatedData['minimum_spend_amount'])) {
            foreach ($validatedData['minimum_spend_amount'] as $key => $minimumSpendAmount) {
                PriceDiscount::where('discount_id', $discount->id)
                    ->where('minimum_spend_amount', $priceDiscounts[$key]->minimum_spend_amount)
                    ->update([
                        'type' => (int) $validatedData['type'],
                        'minimum_spend_amount' => (float) $minimumSpendAmount,
                        'digit' => (float) $validatedData['digit'][$key],
                    ]);
            }
        }

        if (count($priceDiscounts) < count($validatedData['minimum_spend_amount'])) {
            foreach ($priceDiscounts as $key => $priceDiscount) {
                PriceDiscount::where('discount_id', $discount->id)
                    ->where('minimum_spend_amount', $priceDiscount->minimum_spend_amount)
                    ->update([
                        'type' => (int) $validatedData['type'],
                        'minimum_spend_amount' => (float) $validatedData['minimum_spend_amount'][$key],
                        'digit' => (float) $validatedData['digit'][$key],
                    ]);
            }
            for ($i = count($priceDiscounts); $i < count($validatedData['minimum_spend_amount']); $i++) {
                PriceDiscount::create([
                    'discount_id' => $discount->id,
                    'type' => (int) $validatedData['type'],
                    'minimum_spend_amount' => (float) $validatedData['minimum_spend_amount'][$i],
                    'digit' => (float) $validatedData['digit'][$i],
                ]);
            }
        }

        if (count($priceDiscounts) > count($validatedData['minimum_spend_amount'])) {
            PriceDiscount::where('discount_id', $discount->id)->delete();
            foreach ($validatedData['minimum_spend_amount'] as $key => $minimumSpendAmount) {
                PriceDiscount::create([
                    'discount_id' => $discount->id,
                    'type' => (int) $validatedData['type'],
                    'minimum_spend_amount' => (float) $minimumSpendAmount,
                    'digit' => (float) $validatedData['digit'][$key],
                ]);
            }
        }
    }

    public static function updateGiftDiscount($validatedData, Discount $discount)
    {
        $giftDiscounts = GiftDiscount::where('discount_id', $discount->id)->get();

        if (count($giftDiscounts) === count($validatedData['minimum_spend_amount'])) {
            foreach ($validatedData['minimum_spend_amount'] as $key => $minimumSpendAmount) {
                GiftDiscount::where('discount_id', $discount->id)
                    ->where('minimum_spend_amount', $giftDiscounts[$key]->minimum_spend_amount)
                    ->update([
                        'minimum_spend_amount' => (float) $minimumSpendAmount,
                        'product_id' => $validatedData['product'][$key],
                    ]);
            }
        }

        if (count($giftDiscounts) < count($validatedData['minimum_spend_amount'])) {
            foreach ($giftDiscounts as $key => $giftDiscount) {
                GiftDiscount::where('discount_id', $discount->id)
                    ->where('minimum_spend_amount', $giftDiscount->minimum_spend_amount)
                    ->update([
                        'minimum_spend_amount' => (float) $validatedData['minimum_spend_amount'][$key],
                        'product_id' => $validatedData['product'][$key],
                    ]);
            }
            for ($i = count($giftDiscounts); $i < count($validatedData['minimum_spend_amount']); $i++) {
                GiftDiscount::create([
                    'discount_id' => $discount->id,
                    'minimum_spend_amount' => (float) $validatedData['minimum_spend_amount'][$i],
                    'product_id' => $validatedData['product'][$i],
                ]);
            }
        }

        if (count($giftDiscounts) > count($validatedData['minimum_spend_amount'])) {
            GiftDiscount::where('discount_id', $discount->id)->delete();
            foreach ($validatedData['minimum_spend_amount'] as $key => $minimumSpendAmount) {
                GiftDiscount::create([
                    'discount_id' => $discount->id,
                    'minimum_spend_amount' => (float) $minimumSpendAmount,
                    'product_id' => $validatedData['product'][$key],
                ]);
            }
        }
    }

    public static function saveDetails($validatedData)
    {
        $mainDiscount = Discount::create([
            'name' => $validatedData['name'],
            'promotion_type' => $validatedData['promotion_type'],
            'status' => $validatedData['status'],
        ]);

        if (Discount::PRICE_DISCOUNT === $validatedData['promotion_type']) {
            for ($i = 0; $i < count($validatedData['minimum_spend_amount']); $i++) {
                PriceDiscount::create([
                    'discount_id' => $mainDiscount->id,
                    'type' => (int) $validatedData['type'],
                    'minimum_spend_amount' => (float) $validatedData['minimum_spend_amount'][$i],
                    'digit' => (float) $validatedData['digit'][$i],
                ]);
            }
        }

        if (Discount::GIFT_DISCOUNT === $validatedData['promotion_type']) {
            for ($i = 0; $i < count($validatedData['minimum_spend_amount']); $i++) {
                GiftDiscount::create([
                    'discount_id' => $mainDiscount->id,
                    'minimum_spend_amount' => (float) $validatedData['minimum_spend_amount'][$i],
                    'product_id' => $validatedData['product'][$i],
                ]);
            }
        }
    }
}
