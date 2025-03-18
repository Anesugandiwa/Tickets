<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable =[
        'referenceNumber',
        'pollUrl',
        'user_id',
        'is_paid',
    ];
}
