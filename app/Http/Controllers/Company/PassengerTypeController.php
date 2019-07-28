<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use App\Model\User;
use App\Trip;
use App\Ferry;
use App\PassengerType;
use DB;
use App\Enumeration\RoleType;
use Uuid;
use Intervention\Image\ImageManager;
use Intervention\Image\ImageManagerStatic as Image;
use App\Http\Controllers\Controller;


class PassengerTypeController extends Controller
{
 	public function AddPassengerType()
 	{
 		return view('passengerTypes.addPassengerTypes');
 	} 
 	public function InsertPassengerType(Request $request)
 	{
 		$this->validate($request, [
	        'name'           => 'required|max:100',
	        'status'    => 'required|max:100'
         ]);

 		$passengerType = PassengerType::create([
    		'name' => $request->name,
            'status' => $request->status
        ]);

        return redirect()->route('viewAllPassengerType');
 	} 
 	public function ViewAllPassengerType()
 	{
 		$passengerTypeAllInfo = PassengerType::paginate(4);
    	return view('passengerTypes.allPassengerType')->with('passengerTypes',$passengerTypeAllInfo);
 	} 

 	public function EditPassengerType(Request $request , $passengerTypeId)
    {
    	$passengerType = PassengerType::find($passengerTypeId);
        return view('passengerTypes.editPassengerType')->with('edit', $passengerType);
    }
    public function UpdatePassengerType(Request $request , $passengerTypeId)
    {
        $this->validate($request, [
            'name'           => 'required|max:100'
         ]);

        $passengerType = PassengerType::find($passengerTypeId);

        $passengerType->name = $request->name;
        $passengerType->status = $request->status;
     
        $passengerType->save();
        return redirect()->route('viewAllPassengerType')->with('success', 'Successfully Edited');
       // return redirect()->route('viewAllFerry')->with('success', 'Successfully Edited');
        
    }
    public function DeletePassengerType(Request $request)
    {
        PassengerType::find($request->id)->delete();
        return redirect()->route('viewAllPassengerType');
    }
}
