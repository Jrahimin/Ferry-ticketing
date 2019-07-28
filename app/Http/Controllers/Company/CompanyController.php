<?php

namespace App\Http\Controllers\Company;

use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Model\User;
use App\Trip;
use App\Ferry;
use App\Company;
use DB;
use Auth;
use App\Enumeration\RoleType;
use Uuid;
use Intervention\Image\ImageManager;
use Intervention\Image\ImageManagerStatic as Image;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    public function AddCompanyForm()
    {
    	return view('company.addCompany');
    }
     public function InsertCompany(Request $request)
    {
    	//dd($request->accountNumber);
    	$uidNum = (string)Uuid::generate(4);
    	$this->validate($request, [
	        'companyName'           => 'required|max:100',
	        'description'    => 'required|max:300',
	        'location'   => 'required|max:300',
	        'image'			 => 'required'
        ]);

    	$file = $request->file('image');
    	$destinationPath = 'uploadsCompany';
    	$image = $file->move($destinationPath, $uidNum.".jpg");

    	
    	$registeringAsCompany = Company::create([
    		'name' => $request->companyName,
    		'description' => $request->description,
    		'location' => $request->location,
    		'image_url' => $image,
            'status' => $request->status,
            'telephone' => $request->telephone,
            'account_number' => $request->accountNumber
        ]);

        return redirect()->route('CompanyHome');
    }

    public function EditCompany(Request $request )
    {
        $companyId = Auth::User()->company_id;
        //dd($companyId);
        $company = Company::find($companyId);
        $companies = Company::all();
        return view('FerryCompanyAdmin.company.editCompany')->with('edit', $company)->with('companies', $companies);
    }

    public function viewAllCompany(Request $request)
    {
    	$companyAllInfo = Company::paginate(5);
    	return view('company.allCompanyList')->with('companies',$companyAllInfo);
    }
    public function UpdateCompany(Request $request )
    {
        
        $uidNum = (string)Uuid::generate(4);
        $this->validate($request, [
            'CompanyName' => 'required',
            'location'    => 'required|max:100',
            'description' => 'required|max:350',
            'telephone'   => 'required',
        ]);

        $companyId = Auth::User()->company_id;
        $company = Company::find($companyId);

        $company->name = $request->CompanyName;
        $company->location = $request->location;
        $company->description = $request->description;
        $company->telephone = $request->telephone;
        $company->status = $request->status;
        
        if(isset($request->image))
        {
            // $file = $request->file('image');
            // $img = Image::make($file->getRealPath());
            // $img_path = 'uploadsCompany\bla.jpg';
            // $img->save($img_path);
            // $company->image_url = $img_path;


            $file = $request->file('image');
            $destinationPath = 'uploadsCompany';
            $image = $file->move($destinationPath, $uidNum.".jpg");
            $company->image_url = $image;
        }
        
        $company->save();
        
        return redirect()->route('CompanyHome')->with('success', 'Successfully Edited');    
    }
}
