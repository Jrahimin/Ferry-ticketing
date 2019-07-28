<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Company;
use Uuid;
use App\Enumeration\RoleType;
use Auth;

class CompanyController extends Controller
{
    public function all() {
    	$companies = Company::paginate(10);

    	return view('company.all', compact('companies'));
    }

    public function add() {
    	return view('company.add');
    }

    public function addPost(Request $request) {
    	$this->validate($request, [
	        'name'  		=> 'required|max:255',
	        'description'  	=> 'required|max:255',
	        'location'     	=> 'required|max:255',
	        'logo'		   	=> 'required|max:1000|image',
            'telephone'     => 'required'
        ]);

    	// Active Status
    	$active = 0;
    	if ($request->status)
    		$active = 1;

    	// Upload logo
        $file = $request->file('logo');
        $extension = $file->getClientOriginalExtension();
        $filename = (string)Uuid::generate(4).".".$extension;
    	$destinationPath = 'images/company_logo';
    	$image = $file->move($destinationPath, $filename);

    	Company::create([
    		'name' => $request->name,
    		'description' => $request->description,
    		'location' => $request->location,
    		'image_url' => $destinationPath.'/'.$filename,
            'status' => $active,
            'telephone' => $request->telephone,
            'account_number' => (string)Uuid::generate(4),
        ]);

        return redirect()->route('view_all_company');
    }

    public function edit(Company $company) {
        if (Auth::user()->role == RoleType::$COMPANY_USER && 
            $company->id != Auth::user()->company_id) {

            abort('401', 'unauthorized');
        }

    	return view('company.edit', compact('company'));
    }

    public function editPost(Request $request, Company $company) {
        if (Auth::user()->role == RoleType::$COMPANY_USER && 
            $company->id != Auth::user()->company_id) {

            abort('401', 'unauthorized');
        }

    	$this->validate($request, [
	        'name'  		=> 'required|max:255',
	        'description'  	=> 'required|max:255',
	        'location'     	=> 'required|max:255',
	        'logo'		   	=> 'max:1000|image',
            'telephone'     => 'required'
        ]);

        // Active Status
    	$active = 0;
    	if ($request->status)
    		$active = 1;

        $company->name = $request->name;
        $company->location = $request->location;
        $company->description = $request->description;
        $company->telephone = $request->telephone;
        $company->status = $active;

        if ($request->logo) {
        	$file = $request->file('logo');
	        $extension = $file->getClientOriginalExtension();
	        $filename = (string)Uuid::generate(4).".".$extension;
	    	$destinationPath = 'images/company_logo';
	    	$image = $file->move($destinationPath, $filename);

	    	$company->image_url = $destinationPath.'/'.$filename;
        }

        $company->save();

        if (Auth::user()->role == RoleType::$ADMIN)
            return redirect()->route('view_all_company');
        else
            return redirect('/');
    }

    public function delete(Request $request) {
    	$id = $request->id;

    	$company = Company::where('id', $id)->first();
    	$company->delete();
    }
}
