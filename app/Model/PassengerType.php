<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PassengerType extends Model
{
    use SoftDeletes;

    protected $table = 'passenger_types';
    public $fillable = ['name','status'];

    public function type() {
        return $this->hasMany('App\Model\Passenger', 'type_id');
    }
}
