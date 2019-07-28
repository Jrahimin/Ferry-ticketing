<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Faker\Provider\zh_CN\DateTime;
use Illuminate\Http\Request;
use App\Model\Trip;
use App\Model\Ferry;
use App\Model\Port;
use App\Model\Company;
use App\Model\PassengerType;
use App\Model\Price;
use App\Enumeration\RoleType;
use Illuminate\Support\Facades\Auth;

class TripController extends Controller
{
    public function all(Request $request) {
    	if (Auth::user()->role == RoleType::$COMPANY_USER) {
	    	$ferries = Ferry::where('company_id', Auth::user()->company_id)->get();
	    } else {
	    	$ferries = Ferry::all();
	    }

    	$ports = Port::all();

    	$parameters = [];
    	$date_parameters = [];
        $appends = [];

        if ($request->ferry_id){
            $parameters[] = array('ferry_id', '=', $request->ferry_id);
            $appends['ferry_id'] = $request->ferry_id;
        }

        if ($request->departure_port_id){
            $parameters[] = array('departure_port_id', '=', $request->departure_port_id);
            $appends['departure_port_id'] = $request->departure_port_id;
        }

        if ($request->destination_port_id){
            $parameters[] = array('destination_port_id', '=', $request->destination_port_id);
            $appends['destination_port_id'] = $request->destination_port_id;
        }

        if ($request->start_date){
            $date_parameters[] = array('departure_date_time', '>=', $request->start_date.' '.'00:00;00');
       		$appends['start_date'] = $request->start_date;
        }

        if ($request->end_date){
            $date_parameters[] = array('departure_date_time', '<=', $request->end_date.' '.'25:00;00');
       		$appends['end_date'] = $request->end_date;
        }

        if (Auth::user()->role == RoleType::$COMPANY_USER) {
        	$parameters[] = array('company_id', '=', Auth::user()->company_id);
        }

        $trips = Trip::where($parameters)->where($date_parameters)
		        	->with('ferry', 'departure_port', 'destination_port')
		        	->paginate(10);

    	return view('trip.all', compact('trips', 'ferries', 'ports', 'appends'));
    }

    public function add() {
        if (Auth::user()->role == RoleType::$ADMIN) {
            $companies = Company::with('ferries')->get()->toArray();
        } else {
            $companies = Company::where('id', Auth::user()->company_id)->with('ferries')->get()->toArray();
        }

    	$ports = Port::all();
    	$passenger_type = PassengerType::all();

    	return view('trip.add', compact('companies', 'ports', 'passenger_type'));
    }

    public function addPost(Request $request) {
    	$rules = [
    			'company_id' => 'required',
    			'ferry_id' => 'required',
    			'departure_port_id' => 'required',
    			'destination_port_id' => 'required',
    			'price.*' => 'required|numeric',
    		];

		if ($request->schedule_type == '1') {
			// Manual
			$rules['manual_departure_date'] = 'required';
			$rules['manual_departure_time'] = 'required';
		} else {
			// Automatic
			$rules['automatic_date_from'] = 'required';
			$rules['automatic_date_to'] = 'required';
			$rules['automatic_time'] = 'required';
		}

    	$this->validate($request, $rules);

        if (Auth::user()->role == RoleType::$COMPANY_USER && 
            $request->company_id != Auth::user()->company_id) {

            abort('401', 'unauthorized');
        }

    	// Dates Calculate
    	$dates = [];
    	$time = '';

    	if ($request->schedule_type == '1') {
			// Manual
			$dates[] = $request->manual_departure_date;
			$time = $request->manual_departure_time;
		} else {
			// Automatic
			$time = $request->automatic_time;
			$day_of_week = date('w', strtotime($request->automatic_date_from));

			if (isset($request->day[$day_of_week]))
				$dates[] = $request->automatic_date_from;

			$date = $request->automatic_date_from;

			while($date != $request->automatic_date_to) {
				$date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
				$day_of_week = date('w', strtotime($date));
				
				if (isset($request->day[$day_of_week]))
					$dates[] = $date;
			}
		}

		$ferry = Ferry::where('id', $request->ferry_id)->first();
		
		foreach($dates as $date) {
		    $dateTime = $date. ' '.$time;
		    $dateTime = date("Y-m-d H:i:s", strtotime($dateTime));
			$trip = Trip::create([
					'departure_port_id' => $request->departure_port_id,
		    		'destination_port_id' => $request->destination_port_id,
		    		'departure_date_time' => $dateTime,
		            'ferry_id' => $request->ferry_id,
	                'company_id' => $request->company_id,
	                'ferry_total_seat' => $ferry->number_of_seat,
	                'ferry_remaining_seat' => $ferry->number_of_seat,
				]);

			$data = [];
			foreach($request->price as $passenger_type_id => $price) {
				$data[] = [
						'passenger_type_id' => $passenger_type_id,
						'price' => $price
					];
			}
			$trip->prices()->createMany($data);
		}

		return redirect()->route('view_all_trip');
    }

    public function delete(Request $request) {
    	$id = $request->id;

    	$trip = Trip::where('id', $id)->first();

    	if (!$trip) {
            return response()->json(['success' => false, 'message' => 'Item not found.']);
        }

        if (Auth::user()->role == RoleType::$COMPANY_USER) {
            if (Auth::user()->company_id == $trip->company_id) {
                $trip->prices()->delete();
    			$trip->delete();

                return response()->json(['success' => true, 'message' => 'Successfully Deleted.']);
            } else {
                return response()->json(['success' => false, 'message' => 'Unauthorized']);
            }
        }

        $trip->prices()->delete();
		$trip->delete();
        return response()->json(['success' => true, 'message' => 'Successfully Deleted.']);
    }

    public function edit(Trip $trip) {
    	if (Auth::user()->role == RoleType::$COMPANY_USER && 
            $trip->company_id != Auth::user()->company_id) {

            abort('401', 'unauthorized');
        }


    	$trip->load('prices', 'company');
    	
    	$ports = Port::all();
    	$passenger_type = PassengerType::all();

    	if (Auth::user()->role == RoleType::$ADMIN) {
            $companies = Company::with('ferries')->get()->toArray();
        } else {
        	$companies = Company::where('id', Auth::user()->company_id)->with('ferries')->get()->toArray();
        }

    	return view('trip.edit', compact('trip', 'companies', 'ports', 'passenger_type'));
    }

    public function editPost(Request $request, Trip $trip) {
    	if (Auth::user()->role == RoleType::$COMPANY_USER && 
            $trip->company_id != Auth::user()->company_id) {

            abort('401', 'unauthorized');
        }

    	$rules = [
    			'company_id' => 'required',
    			'ferry_id' => 'required',
    			'departure_port_id' => 'required',
    			'destination_port_id' => 'required',
    			'price.*' => 'required|numeric',
    			'available_seat' => 'required|integer|min:0|max:'.$request->total_seat,
    			'departure_date' => 'required',
    			'departure_time' => 'required',
    		];

		$this->validate($request, $rules);

        $dateTime = $request->departure_date. ' '.$request->departure_time;
        $dateTime = date("Y-m-d H:i:s", strtotime($dateTime));

		if (Auth::user()->role == RoleType::$COMPANY_USER && 
            $request->company_id != Auth::user()->company_id) {

            abort('401', 'unauthorized');
        }

		$trip->company_id = $request->company_id;
		$trip->ferry_id = $request->ferry_id;
		$trip->ferry_remaining_seat = $request->available_seat;
		$trip->departure_date_time = $dateTime;
		$trip->departure_port_id = $request->departure_port_id;
		$trip->destination_port_id = $request->destination_port_id;

		$trip->prices()->delete();

		$data = [];
		foreach($request->price as $passenger_type_id => $price) {
			$data[] = [
					'passenger_type_id' => $passenger_type_id,
					'price' => $price
				];
		}
		$trip->prices()->createMany($data);
		$trip->save();

		return redirect()->route('view_all_trip');
    }

	public function upcomingTripsApi()
	{
	    $add = 8;
		$trips = Trip::where('departure_date_time', '>=', Carbon::now())
			->where('departure_date_time', '<=', Carbon::now()->addHours($add))->get();

		return response()->json(["success"=>true, "data"=>$trips], 200);
	}
}
