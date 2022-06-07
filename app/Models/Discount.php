<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    public const STATUS = [
        1 => [1, 'Active'],
        2 => [0, 'Inactive'],
    ];

    public const PROMOTION_TYPE = [
        1 => 'Price Discount',
        2 => 'Gift Discount'
    ];

    protected $fillable = ['name','status','promotion_type'];

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
