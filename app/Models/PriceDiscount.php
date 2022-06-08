<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceDiscount extends Model
{
    use HasFactory;

    public const TYPE = [
        1 => 'Percentage Discount',
        2 => 'Flat Discount',
    ];

    protected $fillable = ['discount_id', 'digit', 'type', 'minimum_spend_amount'];
}
