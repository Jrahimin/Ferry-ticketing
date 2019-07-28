<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Price extends Model
{
    use SoftDeletes;

    protected $table = 'trip_passenger_price';
    public $fillable = ['passenger_type_id','price','trip_id'];

    public function passenger_type() {
    	return $this->belongsTo('App\Model\PassengerType');
    }
}
