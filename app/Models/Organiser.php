<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organiser extends Model
{
    protected $table = 'organisers';
    
    protected $fillable =[
        'name',
        'email',
        'phone_number',
        'organization_name',
        'profile_image'
    ];

    public function events(){
        return $this->belongsToMany(Event::class,'event_organiser');
    }
}
