<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Discount;
use App\Models\PriceDiscount;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DiscountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', Rule::unique('discounts', 'name')->ignore(request()->route('discount'))],
            'promotion_type' => ['required'],
            'type' => ['required_if:promotion_type,in:"1"'],
            'minimum_spend_amount' => ['required', 'array'],
            'minimum_spend_amount.*' => ['required', 'distinct'],
            'digit' => ['required_if:promotion_type,in:' . Discount::PRICE_DISCOUNT, 'array'],
            'digit.*' => [
                'required',
                'distinct',
                function ($attribute, $value, $fail) {
                    if (request()->input('type') === PriceDiscount::PERCENTAGE_DISCOUNT && $value > 100) {
                        $fail('Percentage is not greater than 100');
                    }
                },
            ],
            'product' => ['required_if:promotion_type,in:' . Discount::GIFT_DISCOUNT, 'array'],
            'product.*' => ['required', 'distinct'],
            'status' => ['required', 'boolean'],
        ];
    }
}
