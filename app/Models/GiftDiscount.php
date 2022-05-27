<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftDiscount extends Model
{
    use HasFactory;

    protected $fillable = ['discount_id','product'];

    public function discount()
    {
        $this->belongsTo(Discount::class, 'discount_id', 'id');
    }
}
