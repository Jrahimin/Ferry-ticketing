<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Passenger extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'gender', 'date', 'nationality', 'passport_no', 'passport_exp', 'type_id', 'code'];
    protected $dates = ['deleted_at'];

    public function ticket() {
        return $this->hasOne('App\Model\Ticket');
    }

    public function type() {
        return $this->belongsTo('App\Model\PassengerType');
    }
}
