<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Port extends Model
{
    use SoftDeletes;

    protected $table = 'ports';
    public $fillable = ['name','city_name','country','country_code','latitude','longitude','status'];
}
