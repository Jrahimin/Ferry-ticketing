<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Port;
use App\Model\Trip;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index() {
    	$ports = Port::all();

    	return view('home.welcome', compact('ports'));
    }

	public function indexApi() {
		$ports = Port::all();
		return response()->json($ports, 200);
	}

    public function search(Request $request) {
    	$rules  = [
    			'departure_port_id' => 'required',
    			'destination_port_id' => 'required',
    			'departure_date' => 'required',
    			'trip_type' => 'required',
    			'pax' => 'required',
    		];

		if ($request->trip_type == "2")
			$rules['return_date'] = 'required';

    	$this->validate($request, $rules);

    	$ports = Port::all();

    	$trips = Trip::where('departure_port_id', $request->departure_port_id)
					->where('destination_port_id', $request->destination_port_id)
					->whereDate('departure_date_time', $request->departure_date)
					->where('ferry_remaining_seat', '>=', $request->pax)
					->with('ferry')
					->get();

		$return_trips = Trip::where('departure_port_id', $request->destination_port_id)
					->where('destination_port_id', $request->departure_port_id)
					->whereDate('departure_date_time', $request->return_date)
					->where('ferry_remaining_seat', '>=', $request->pax)
					->with('ferry')
					->get();


		$departure_port = Port::where('id', $request->departure_port_id)->first();
		$destination_port = Port::where('id', $request->destination_port_id)->first();

		return view('home.search_result', compact('trips', 'return_trips', 'ports', 'departure_port', 'destination_port', 'request'));
    }

	public function searchApi(Request $request) {

		$rules  = [
			'departure_port_id' => 'required',
			'destination_port_id' => 'required',
			'departure_date' => 'required|date',
			'trip_type' => 'required',
			'pax' => 'required|numeric|min:1',
		];

		if ($request->trip_type == "2")
			$rules['return_date'] = 'required|date|after_or_equal:departure_date';

		$validation = Validator::make($request->all(), $rules);
		if($validation->fails()){
			return response()->json([ "success" => false,
				"message" => $validation->errors()->first()], 406);
		}

		//$ports = Port::all();

		$trips = Trip::where('departure_port_id', $request->departure_port_id)
			->where('destination_port_id', $request->destination_port_id)
			->where('departure_date', $request->departure_date)
			->where('ferry_remaining_seat', '>=', $request->pax)
			->with('company','ferry')->get();

		$return_trips = collect([]);
		if ($request->trip_type == "2"){
			$return_trips = Trip::where('departure_port_id', $request->destination_port_id)
				->where('destination_port_id', $request->departure_port_id)
				->where('departure_date', $request->return_date)
				->where('ferry_remaining_seat', '>=', $request->pax)
				->with('company','ferry')->get();
		}

		$departure_port = Port::find($request->departure_port_id);
		$destination_port = Port::find($request->destination_port_id);

		$tripsWithCompany = array();
		foreach($trips as $trip)
		{
			$tripArray = array(
				"departure_date"=>$trip->departure_date,
				"departure_time"=>date('h:i A', strtotime($trip->departure_time)),
				"remaining_seat"=>$trip->ferry_remaining_seat,
				"comapany_name"=>$trip->company->name,
				"image_url"=>asset('').$trip->company->image_url,
				"ferry_name"=>$trip->ferry->name,
			);
			array_push($tripsWithCompany,$tripArray);
		}

		$returnTripsWithCompany = array();
		foreach($return_trips as $returnTrip)
		{
			$returnTripArray = array(
				"departure_date"=>$returnTrip->departure_date,
				"departure_time"=>date('h:i A', strtotime($returnTrip->departure_time)),
				"remaining_seat"=>$returnTrip->ferry_remaining_seat,
				"comapany_name"=>$returnTrip->company->name,
				"image_url"=>asset('').$returnTrip->company->image_url,
				"ferry_name"=>$returnTrip->ferry->name,
			);
			array_push($returnTripsWithCompany,$returnTripArray);
		}

		$departure_trip_count = $trips->count();
		$return_trip_count = $return_trips->count();

			$data = null;

		if(!empty($tripsWithCompany))
		{
			$data = array(
				"trips"=> array(
					"no_of_departure_trips"=>$departure_trip_count,
					"departure_port"=>$departure_port->name,
					"destination_port"=>$destination_port->name,
					"trip_info"=>$tripsWithCompany,
				),
				"return_trips"=> array(
					"no_of_return_trips"=>$return_trip_count,
					"departure_port"=>$destination_port->name,
					"destination_port"=>$departure_port->name,
					"trip_info"=>$returnTripsWithCompany,
				),
			);
		}

		if($data!==null)
			return response()->json(["success"=>true, "data"=>$data], 200);
		else
			return response()->json(["success"=>true, "data"=>$data], 200);

	}
}