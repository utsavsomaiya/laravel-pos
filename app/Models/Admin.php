<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['username', 'email', 'password'];

    protected $hidden = ['password'];

    public function password(): Attribute
    {
        return Attribute::make(set: fn ($value) => bcrypt($value),);
    }
}
