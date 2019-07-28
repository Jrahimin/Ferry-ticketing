<?php

namespace App\Http\Controllers\Company;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ErrorController extends Controller
{
    public function ShowError()
    {
    	return view('FerryCompanyAdmin.errorCompanyUser');
    }
}
