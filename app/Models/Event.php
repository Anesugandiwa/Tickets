<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $casts = [
        'organisers' => 'array',
    ];
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
        
        return $this->hasMany(Ticket::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function organisers()
    {
        return $this->belongsToMany(Organiser::class, 'event_organiser', 'event_id','organiser_id');
    }
}
