<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use App\Model\User;
use App\Trip;
use App\Ferry;
use App\Port;
use DB;
use Uuid;
use App\PassengerType;
use App\Enumeration\RoleType;
use Intervention\Image\ImageManager;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManagerStatic as Image;


class PortController extends Controller
{
    public function AddPort()
 	{
 		$countries = config('country.countries');
 		return view('port.addPort')->with('countries',$countries);
 	}
 	public function InsertPort(Request $request)
 	{
 		//dd($request);
 		$this->validate($request, [
	        'name'          => 'required|max:100',
	        'cityName'    	=> 'required|max:100',
            'countryCode'   => 'required',
	        'latitude'		=> 'required',
	        'longitude'		=> 'required',

        ]);

 		$port = Port::create([
    		'name' => $request->name,
    		'city_name' => $request->cityName,
    		'country_code' => $request->countryCode,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude
        ]);

        return redirect()->route('viewAllPort')->with('success', 'Successfully Added');
 	}
 	public function ViewAllPort(Request $request)
    {
    	$portAllInfo = Port::paginate(5);
    	$countries = config('country.countries');
    	return view('port.allPort')->with('ports',$portAllInfo)->with('countries',$countries);
    }
    public function EditPort(Request $request , $portId)
    {
    	$port = Port::find($portId);
    	$countries = config('country.countries');
        return view('port.editPort')->with('edit', $port)->with('countries',$countries);
    }
    public function UpdatePort(Request $request , $portId)
    {
        $this->validate($request, [
            'name'          => 'required|max:100',
	        'cityName'    	=> 'required|max:100',
            'countryCode'   => 'required',
	        'latitude'		=> 'required',
	        'longitude'		=> 'required',
         ]);

        $port = Port::find($portId);
        $port->name = $request->name;
        $port->city_name = $request->cityName;
        $port->country_code = $request->countryCode;
        $port->latitude = $request->latitude;
        $port->longitude = $request->longitude;

        $port->save();
        return redirect()->route('viewAllPort')->with('success', 'Successfully Updated');  
    }
     public function DeletePort(Request $request)
    {
        Port::find($request->id)->delete();
        return redirect()->route('viewAllPort');
    }
}
