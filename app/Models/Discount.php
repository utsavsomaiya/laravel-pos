<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = ['name','status','category'];

    public function priceDiscounts()
    {
        return $this->hasMany(PriceDiscount::class);
    }

    public function giftDiscounts()
    {
        return $this->hasMany(GiftDiscount::class);
    }
}
