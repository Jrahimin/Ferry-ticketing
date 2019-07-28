<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ErrorController extends Controller
{
    public function ShowError()
    {
    	return view('Customer.errorCustomer');
    }
}
