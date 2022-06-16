<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceDiscount extends Model
{
    use HasFactory;

    public const PERCENTAGE_DISCOUNT = 1;

    public const FLAT_DISCOUNT = 2;

    public const TYPE = [
        Self::PERCENTAGE_DISCOUNT => 'Percentage Discount',
        Self::FLAT_DISCOUNT => 'Flat Discount',
    ];

    protected $fillable = ['discount_id', 'digit', 'type', 'minimum_spend_amount'];
}
