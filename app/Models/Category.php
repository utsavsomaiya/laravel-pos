<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Category extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['name'];
}
