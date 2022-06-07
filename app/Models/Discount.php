<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    public const STATUS = [
        0 => 'Inactive',
        1 => 'Active',
    ];

    public const PROMOTION_TYPE = [
        1 => 'Price Discount',
        2 => 'Gift Discount'
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
}
