<?php

namespace Flobbos\CleverReach\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CleverReachForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'external_id',
        'name',
        'customer_tables_id',
        'clever_reach_client_id'
    ];

    public function clever_reach_client()
    {
        return $this->belongsTo(CleverReachClient::class);
    }
}
