<?php

namespace Flobbos\CleverReach\Models;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CleverReachClient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'client_id',
        'client_secret',
        'token',
        'token_expiration',
    ];

    protected $appends = [
        'token_valid'
    ];

    public function clever_reach_newsletters()
    {
        return $this->hasMany(CleverReachNewsletter::class);
    }

    public function tokenValid(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => Arr::get($attributes, 'token_expiration') ? now()->parse(Arr::get($attributes, 'token_expiration'))->format('d.m.Y H:i') . ' Uhr' : '-'
        );
    }
}
