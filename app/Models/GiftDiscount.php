<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftDiscount extends Model
{
    use HasFactory;

    protected $fillable = ['discount_id', 'product_id', 'minimum_spend_amount'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
