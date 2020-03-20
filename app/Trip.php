<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    //

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
