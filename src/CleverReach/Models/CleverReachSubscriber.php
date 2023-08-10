<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CleverReachSubscriber extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function activated(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value == 0 ? null : now()->parse($value)->format('Y-m-d H:i:s'),
        );
    }

    public function registered(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value == 0 ? null : now()->parse($value)->format('Y-m-d H:i:s'),
        );
    }
}
