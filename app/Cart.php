<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use SoftDeletes;

    protected $table = 'cart';
    public $fillable = ['session_id','cart_details','passenger_info','seat_selected_departure','seat_selected_destination','collector_info'];
    protected $dates = ['deleted_at'];
}
