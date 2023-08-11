<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CleverReachGroup extends Model
{
    use HasFactory;

    protected $casts = [
        'stamp' => 'datetime:d.m.Y',
        'last_mailing' => 'datetime:d.m.Y',
        'last_changed' => 'datetime:d.m.Y'
    ];

    protected $fillable = [
        'id',
        'clever_reach_client_id',
        'name',
        'locked',
        'backup',
        'receiver_info',
        'stamp',
        'last_mailing',
        'last_changed',
        'external_id'
    ];

    public function stamp(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value == 0 ? null : now()->parse($value)->format('Y-m-d H:i:s'),
        );
    }

    public function lastMailing(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value == 0 ? null : now()->parse($value)->format('Y-m-d H:i:s'),
        );
    }

    public function lastChanged(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value == 0 ? null : now()->parse($value)->format('Y-m-d H:i:s'),
        );
    }

    public function clever_reach_client()
    {
        return $this->belongsTo(CleverReachClient::class);
    }
}
