<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Company;
use App\Ferry;
use App\Trip;
use App\Port;
use Carbon\Carbon;
use DateTime;
use Exception;

class CustomerWelcomeController extends Controller
{
 	public function WelcomePage(Request $request) {
 		$anotherParameters= [];
 		$parameters = [];
        $appends = array();

        if ($request->ferryId){
            $parameters[] = array('ferry_id', '=', $request->ferryId);
            $appends['ferry_id'] = $request->ferryId; 
            $searchExceptDate = 0;
        }
        if ($request->departurePort){
	        $parameters[] = array('departure_port_id', '=', $request->departurePort);
	        $appends['departure_port_id'] = $request->departurePort;
	       	$searchExceptDate = 0;
        }
        	
        if ($request->destinationPort){
        	$parameters[] = array('destination_port_id', '=', $request->destinationPort);
            $appends['destination_port_id'] = $request->destinationPort;
            $searchExceptDate = 0;
        }

        //$parameters[] = array('ferry_remaining_seat', '!=', 0);

        if($parameters || !empty($request->start_date) || !empty($request->end_date))
        {
        	if (!empty($request->start_date) && !empty($request->end_date))
        	{
        		$start_date = DateTime::createFromFormat('m/d/Y', $request->start_date);
				$start_date = $start_date->format('Y-m-d');

				$end_date = DateTime::createFromFormat('m/d/Y', $request->end_date);
				$end_date = $end_date->format('Y-m-d');
				$appends['start_date'] = $start_date;
				$appends['end_date'] = $end_date;


	        	$tripsInfo =Trip::with('ferry', 'departure_port', 'destination_port')
	        				->where($parameters)
	        				->whereIn('departure_date', [$start_date, $end_date])
	        				->where('ferry_remaining_seat', '!=', 0)
	        				->orderBy('departure_date', 'asc')
	        				->paginate(10);

	        	$searchExceptDate = 1;
	        } 
	        else if (!empty($request->start_date))
	        {
	        	$start_date = DateTime::createFromFormat('m/d/Y', $request->start_date);
				$start_date = $start_date->format('Y-m-d');
				$appends['start_date'] = $start_date;

	        	$tripsInfo =Trip::with('ferry', 'departure_port', 'destination_port')
	        				->where($parameters)
	        				->where('departure_date', '=', $start_date)
	        				->where('ferry_remaining_seat', '!=', 0)
	        				->orderBy('departure_date', 'asc')
	        				//->where('number_of_seat', '>=',$request->seatNumber)
				            ->paginate(10);
				$searchExceptDate = 1;

	        } else if (!empty($request->end_date)) {
	        	$end_date = DateTime::createFromFormat('m/d/Y', $request->end_date);
				$end_date = $end_date->format('Y-m-d');
				$appends['end_date'] = $end_date;

	        	$tripsInfo =Trip::with('ferry','departure_port', 'destination_port')
	        				->where($parameters)
	        				->where('departure_date', '=', $end_date)
	        				->where('ferry_remaining_seat', '!=', 0)
	        				->orderBy('departure_date', 'asc')
	        				//->where('ferry.number_of_seat', '>=',$request->seatNumber)
				            ->paginate(10);
				$searchExceptDate = 1;
	        } else {
	        	$tripsInfo =Trip::with('ferry', 'departure_port', 'destination_port')
	        				->where($parameters)
	        				->where('ferry_remaining_seat', '!=', 0)
	        				->orderBy('departure_date', 'asc')
	        				//->where('ferry.number_of_seat', '>=',$request->seatNumber)
				            ->paginate(10);
				$searchExceptDate = 0;         
	        }
        }
        else
        {
        	$tripsInfo =Trip::with('ferry', 'departure_port', 'destination_port')->where('ferry_remaining_seat','!=',0)->orderBy('departure_date', 'asc')->paginate(10);
        	//$tripsInfo =Trip::with('ferry','departure_port', 'destination_port')->paginate(10);
        	$searchExceptDate = 0;
        }

        $data['appends'] = $appends;
        $data['start_date'] = (isset($request->start_date) ? $request->start_date : '');
        $data['end_date'] = (isset($request->end_date) ? $request->end_date : '');
        $ports = Port::all();
        $ferries = Ferry::all();
	    if(isset($request->tour_type))
	    {
	       	$searchWay = $request->tour_type ;
	    }
	    else
	    {
	       	$searchWay = 1 ;
	    }	
        
        
 		return view('Customer.welcome.customerWelcomePage', $data)->with('trips',$tripsInfo)->with('ports',$ports)->with('ferries',$ferries)->with('searchWay',$searchWay)->with('searchExceptDate',$searchExceptDate);


 		// return view('Customer.welcome.customerWelcomePage', compact('data', 'tripsInfo','ports','ferries','searchWay'));

 		// $ferryId = $request->ferryId;
 		// $departurePort = $request->departurePort;
 		// $destinationPort = $request->destinationPort;
 		// $startDate = $request->start_date;
 		// $endDate = $request->end_date;
 		// tripInfo()
 	}
}
