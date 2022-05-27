<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceDiscount extends Model
{
    use HasFactory;

    protected $fillable = ['discount_id','digit','type'];

    public function discount()
    {
        $this->belongsTo(Discount::class, 'discount_id', 'id');
    }
}
