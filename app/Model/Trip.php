<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trip extends Model
{
    use SoftDeletes;

    public $fillable = ['departure_port_id','destination_port_id','departure_date_time','ferry_id',
        'company_id','ferry_total_seat','ferry_remaining_seat'];

    public function ferry() {
    	return $this->belongsTo('App\Model\Ferry');
    }

    public function departure_port() {
    	return $this->belongsTo('App\Model\Port', 'departure_port_id', 'id');
    }

    public function destination_port() {
    	return $this->belongsTo('App\Model\Port', 'destination_port_id', 'id');
    }

    public function company() {
        return $this->belongsTo('App\Model\Company');
    }

    public function prices() {
        return $this->hasMany('App\Model\Price')->with('passenger_type');
    }

    public function tickets() {
        return $this->hasMany('App\Model\Ticket');
    }

    public function departure_orders() {
        return $this->hasMany('App\Model\Order', 'departure_trip_id');
    }

    public function destination_orders() {
        return $this->hasMany('App\Model\Order', 'return_trip_id');
    }
}
