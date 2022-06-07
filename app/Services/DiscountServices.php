<?php

namespace App\Services;

use App\Models\Discount;
use App\Models\GiftDiscount;
use App\Models\PriceDiscount;

class DiscountServices
{
    public static function updatePriceDiscount($validatedData, Discount $discount)
    {
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

    public static function updateGiftDiscount($validatedData, Discount $discount)
    {
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

    public static function createOrUpdateDiscount($validatedData, Discount $discount)
    {
        if (is_null($discount->id)) {
            $mainDiscount =  $discount->create([
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
            return;
        }
        return $discount->update([
            'name' => $validatedData['name'],
            'promotion_type' => $validatedData['promotion_type'],
            'status' => $validatedData['status']
        ]);
    }
}
