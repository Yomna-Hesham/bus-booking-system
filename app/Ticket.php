<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    //

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function trip(){
        return $this->belongsTo(Trip::class);
    }

    public function departureStation(){
        return $this->belongsTo(Station::class, "departure_id");
    }

    public function arrivalStation(){
        return $this->belongsTo(Station::class, "arrival_id");
    }
}
