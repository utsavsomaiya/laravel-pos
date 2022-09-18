<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    public const PRICE_DISCOUNT = 1;
    
    public const GIFT_DISCOUNT = 2;

    public const STATUS = [
        0 => 'Inactive',
        1 => 'Active',
    ];

    public const PROMOTION_TYPE = [
        Self::PRICE_DISCOUNT => 'Price Discount',
        Self::GIFT_DISCOUNT => 'Gift Discount'
    ];

    protected $fillable = ['name', 'status', 'promotion_type'];

    public function priceDiscounts()
    {
        return $this->hasMany(PriceDiscount::class);
    }

    public function giftDiscounts()
    {
        return $this->hasMany(GiftDiscount::class);
    }

    public function sales()
    {
        return $this->hasMany(Sales::class);
    }

    public function salesDetails()
    {
        return $this->hasMany(SalesDetails::class);
    }
}
