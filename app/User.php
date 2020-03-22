<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //
    protected $fillable = ['name', 'phone'];

    public function tickets(){
        return $this->hasMany(Ticket::class);
    }
}
