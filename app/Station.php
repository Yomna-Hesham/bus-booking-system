<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    //

    public function ticketsAsDepartureStation(){
        return $this->hasMany(Ticket::class, "departure_id");
    }

    public function ticketsAsArrivalStation(){
        return $this->hasMany(Ticket::class, "arrival_id");
    }

    public function trips(){
        return $this->belongsToMany(Trip::class)->withPivot("order");
    }

    public function getStationOrderInTrip(Trip $trip){
        return $trip->stations($this->id)->first()->pivot->order;
    }
}
