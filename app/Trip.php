<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    //
    protected $fillable = ['time', 'bus_id'];

    public function getStationsStringified(){
        $stations = $this->stations()->orderBy('order', 'asc')->pluck('name')->toArray();
        return implode(" , ", $stations);
    }

    public function bus(){
        return $this->belongsTo(Bus::class);
    }

    public function tickets(){
        return $this->hasMany(Ticket::class);
    }

    public function stations(){
        return $this->belongsToMany(Station::class)->withPivot("order");
    }
}
