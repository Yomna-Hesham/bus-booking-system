<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    //
    protected $fillable = ['license_num'];

    public function trips(){
        return $this->hasMany(Trip::class);
    }
}
