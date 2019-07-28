<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Port;

class PortController extends Controller
{
    public function all() {
    	$ports = Port::paginate(10);
    	$countries = config('country.countries');
		//return response()->json(["ports"=>$ports, "countries"=>$countries],200);
    	return view('port.all', compact('ports', 'countries'));
    }

	public function allApi() {

		$ports = Port::all();
		$countries = config('country.countries');
		return response()->json($ports,200);
		//return view('port.all', compact('ports', 'countries'));
	}

    public function add() {
    	$countries = config('country.countries');

    	return view('port.add', compact('countries'));
    }

    public function addPost(Request $request) {
    	$this->validate($request, [
	        'name'          => 'required|max:255',
	        'city_name'    	=> 'required|max:255',
            'country_code'   => 'required',
	        'latitude'		=> 'required|numeric',
	        'longitude'		=> 'required|numeric',
        ]);

        Port::create([
    		'name' => $request->name,
    		'city_name' => $request->city_name,
    		'country_code' => $request->country_code,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude
        ]);

        return redirect()->route('view_all_port');
    }

    public function edit(Port $port) {
    	$countries = config('country.countries');

    	return view('port.edit', compact('port', 'countries'));
    }

    public function editPost(Request $request, Port $port) {
    	$this->validate($request, [
	        'name'          => 'required|max:255',
	        'city_name'    	=> 'required|max:255',
            'country_code'   => 'required',
	        'latitude'		=> 'required|numeric',
	        'longitude'		=> 'required|numeric',
        ]);

    	$port->name = $request->name;
    	$port->city_name = $request->city_name;
    	$port->country_code = $request->country_code;
    	$port->latitude = $request->latitude;
    	$port->longitude = $request->longitude;

        $port->save();

        return redirect()->route('view_all_port');
    }

    public function delete(Request $request) {
    	$id = $request->id;

    	$port = Port::where('id', $id)->first();
    	$port->delete();
    }
}
