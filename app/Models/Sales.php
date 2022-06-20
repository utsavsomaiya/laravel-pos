<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    protected $fillable = ['subtotal', 'total_tax', 'total'];

    public function discounts()
    {
        return $this->belongsTo(Discount::class, 'discount_id', 'id');
    }

    public function salesDetails()
    {
        return $this->hasMany(SalesDetails::class);
    }
}
