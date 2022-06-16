<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Product extends Authenticatable
{
    use HasFactory;

    public const TAXES = [
        1 => 5,
        2 => 10,
        3 => 15,
        4 => 20,
        5 => 25,
        6 => 30,
    ];

    protected $fillable = ['name', 'price', 'category_id', 'tax', 'stock', 'image', 'path'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
