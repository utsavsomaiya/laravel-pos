<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Product extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['name','price','category_id','tax','stock','image'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
