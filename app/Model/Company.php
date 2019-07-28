<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;
    
    public $fillable = ['name','description','location','image_url','status','telephone','account_number'];

    public function ferries() {
    	return $this->hasMany('App\Model\Ferry');
    }
    public function trip() {
        return $this->hasMany('App\Model\Trip');
    }
}
