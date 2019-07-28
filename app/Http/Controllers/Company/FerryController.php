<?php

namespace App\Http\Controllers\Company;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use App\Model\User;
use App\Trip;
use App\Ferry;
use App\Company;
use Auth;
use DB;
use App\Enumeration\RoleType;
use Uuid;
use Intervention\Image\ImageManager;
use Intervention\Image\ImageManagerStatic as Image;
use App\Http\Controllers\Controller;

class FerryController extends Controller
{
    public function AddCompanyFerry()
    {
    	return view('FerryCompanyAdmin.ferry.addCompanyFerry');
    }
    public function insertCompanyFerry(Request $request)
    {
        // dd("Ok");
    	$companyId = Auth::User()->company_id;
    	$uidNum = (string)Uuid::generate(4);
    	$this->validate($request, [
	        'name'           => 'required|max:100',
	        'captainName'    => 'required|max:100',
	        'numberOfSeat'   => 'required|Integer',
            'numberOfCrew'   => 'required|Integer',
	        'image'			 => 'required',
        ]);

    	$file = $request->file('image');
    	$destinationPath = 'uploads';
    	$image = $file->move($destinationPath, $uidNum.".jpg");

    	
    	$registeringAsFerry = Ferry::create([
    		'name' => $request->name,
    		'captain_name' => $request->captainName,
    		'number_of_crew' => $request->numberOfCrew,
    		'image_url' => $image,
    		'number_of_seat' => $request->numberOfSeat,
            'status' => $request->status,
            'company_id' => $companyId
        ]);

        return redirect()->route('viewAllCompanyFerry');
    }
    public function AddTrip()
    {
    	return view('trip.addTrip');
    }
    public function InsertTrip(Request $request)
    {
    	$this->validate($request, [
        	'name'        => 'required|max:100'
        ]);

    	$registeringAsTrip = Trip::create([
    		'name' => $request->name, 
        ]);
        // return redirect()->route('');
    }
    public function viewAllCompanyFerry(Request $request)
    {
        $companyId=Auth::User()->company_id;
    	$ferryAllInfo = Ferry::where('company_id' , $companyId )->paginate(5);
    	return view('FerryCompanyAdmin.ferry.allListCompanyFerry')->with('ferries',$ferryAllInfo);
    }

    public function EditFerry(Request $request , $ferryId)
    {        
          $ferry = Ferry::find($ferryId);

          if(!$ferry )
          {
            return redirect()->route('errorCompanyUser')->with('unsuccess', 'Not Found In Database');
          }
          if(!(Auth::User()->company_id == $ferry->company_id))
          {
            return redirect()->route('errorCompanyUser')->with('unsuccess', 'Not Authorised User');
          }

          return view('FerryCompanyAdmin.ferry.editCompanyFerry')->with('edit', $ferry); 
          
    	
    }

    public function UpdateFerry(Request $request , $ferryId)
    {


        $uidNum = (string)Uuid::generate(4);
        $this->validate($request, [
            'name'           => 'required|max:100',
            'captainName'    => 'required|max:100',
            'numberOfSeat'   => 'required|Integer',
            'numberOfCrew'   => 'required|Integer'
         ]);

        $ferry = Ferry::find($ferryId);
        if(!$ferry )
          {
            return redirect()->route('errorCompanyUser')->with('unsuccess', 'Not Found In Database');
          }
          if(!(Auth::User()->company_id == $ferry->company_id))
          {
            return redirect()->route('errorCompanyUser')->with('unsuccess', 'Not Authorised User');
          }

        
        $companyId=Auth::User()->company_id;

        $ferry->name = $request->name;
        $ferry->captain_name = $request->captainName;
        $ferry->number_of_crew = $request->numberOfCrew;
        $ferry->number_of_seat = $request->numberOfSeat;
        $ferry->status = $request->status;
        $ferry->company_id = $companyId;
     
        if(isset($request->image))
        {
            // $file = $request->file('image');
            // $img = Image::make($file->getRealPath());
            // $img_path = 'uploads\bla.jpg';
            // $img->save($img_path);
            // $ferry->image_url = $img_path;

            $file = $request->file('image');
            $destinationPath = 'uploads';
            $image = $file->move($destinationPath, $uidNum.".jpg");
            $ferry->image_url = $image;

        }


        $ferry->save();
        return redirect()->route('viewAllCompanyFerry')->with('success', 'Successfully Edited');
        
    }

    public function DeleteFerry(Request $request)
    {
        Ferry::find($request->id)->delete();
        return redirect()->route('viewAllCompanyFerry');
    }
}
