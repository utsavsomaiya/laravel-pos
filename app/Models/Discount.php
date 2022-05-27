<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = ['name','status','category'];

    public function priceDiscount()
    {
        $this->hasMany(PriceDiscount::class);
    }

    public function giftDiscount()
    {
        $this->hasMany(giftDiscount::class);
    }
}
