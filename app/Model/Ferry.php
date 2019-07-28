<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ferry extends Model
{
    use SoftDeletes;

    public $fillable = ['name','captain_name','image_url','number_of_seat','number_of_crew','status','company_id'];

    public function company(){
        return $this->belongsTo('App\Model\Company');
    }

}
