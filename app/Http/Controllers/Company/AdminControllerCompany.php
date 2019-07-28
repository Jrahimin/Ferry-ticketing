<?php

namespace App\Http\Controllers\Company;

use Illuminate\Http\Request;
use App\Company;
use App\Http\Controllers\Controller;

class AdminControllerCompany extends Controller
{
    
	public function CompanyWelcomePage()
	{
		return view('FerryCompanyAdmin.layouts.app');
	}

    public function AddAdminForm()
    {
    	$companies = Company::all();
    	return view('FerryCompanyAdmin.companyUser.addCompanyAdmin')->with('companies' , $companies);
    }
}
