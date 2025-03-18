<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'event_id',
        'name',
        'image',
        'image',
        'total_available',
        'price',
    ];

    public function event(){
        return $this->belongsTo(Event::class);
    }
}
