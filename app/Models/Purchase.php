<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'event_id',
        'ticket_id',
        'user_id',
        'quantity',
        'qr_path',
        'status',
        'referenceNumber',
    ];

    // protected $guarded = []

    public function event(){
        return $this->belongsTo(Event::class);
    }

    public function ticket(){
        return $this->belongsTo(Ticket::class);

    }

    public function user(){
        return $this->belongs(User::class);
    }
}
