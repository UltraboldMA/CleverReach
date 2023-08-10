<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CleverReachNewsletter extends Model
{
    use HasFactory;

    protected $fillable = [
        'clever_reach_client_id',
        'name',
        'key',
        'form_id',
        'group_id',
        'language',
        'double_opt_in',
        'cl_attributes',
        'cl_global_attributes'
    ];

    protected $casts = [
        'cl_attributes' => 'array',
        'cl_global_attributes' => 'array',
    ];

    public function clever_reach_client()
    {
        return $this->belongsTo(CleverReachClient::class);
    }

    public function clever_reach_form()
    {
        return $this->belongsTo(CleverReachForm::class, 'form_id');
    }

    public function clever_reach_group()
    {
        return $this->belongsTo(CleverReachGroup::class, 'group_id');
    }
}
