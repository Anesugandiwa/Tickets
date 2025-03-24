<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    protected $fillable = [
        'title',
        'description',
        'slug',
        'start_date',
        'end_date',
        'preview_image',
        'location',
        'total_tickets',
        'is_priced'
    ];

    public function tickets(){
        
        return $this->hasMany(Tickets::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function organisers()
    {
        return $this->hasMany(Organiser::class);
    }
}
