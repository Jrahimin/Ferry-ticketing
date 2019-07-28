<?php
namespace App\Some\Somenamespace;
namespace App\Http\Controllers\Company;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use App\Model\User;
use App\Trip;
use App\Company;
use App\Ferry;
use App\Port;
use App\PassengerType;
use App\TripPassengerPrice;
use DB;
use Auth;
use App\Enumeration\RoleType;
use Uuid;
use Intervention\Image\ImageManager;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use DateTime;
use Exception;
use App\Http\Controllers\Controller;


class TripController extends Controller
{
    public function AddTripForm()
 	{
        $companyId = Auth::User()->company_id;
 		$passengerTypeInfo = PassengerType::all();
        $ferryAllInfo = Ferry::where('company_id', $companyId)->get();
 		$portAllInfo = Port::all();
        $companyInfo = Company::all();
 		return view('FerryCompanyAdmin.trip.addTrip')->with('ports',$portAllInfo)->with('ferries',$ferryAllInfo)->with('passengerTypes',$passengerTypeInfo)->with('companies',$companyInfo);
 	}
 	public function InsertTrip(Request $request)
 	{
        $companyId = Auth::User()->company_id;

 		$modifiedTime = str_replace(' ', '', $request->departure_time.":00");

 		if($request->tour_type == 0)
 		{

	 		$this->validate($request, [
		        'ferry_id'          => 'required',
		        'departure_port'    => 'required',
	            'destination_port'  => 'required',
		        'departure_date'	=> 'required',
		        'departure_time'	=> 'required'
	        ]);
	        $departure_date = date('Y-m-d', strtotime($request->departure_date));
	 		$trip = Trip::create([
	    		'departure_port_id' => $request->departure_port,
	    		'destination_port_id' => $request->destination_port,
	    		'departure_date' => $departure_date,
	            'departure_time' => $modifiedTime,
	            'ferry_id' => $request->ferry_id,
                'company_id' => $companyId
	        ]);

	        foreach ($request->price as $key => $value) {

	    		$tripPassengerPrice = TripPassengerPrice::create([
	    			'trip_id' => $trip->id,
		    		'price_id' => $value,
		    		'passenger_type_id' => $request->idPassenger[$key],
	        	]);
	 		}
        }

        else
        {
        	$fromDateObj = \DateTime::createFromFormat('m/d/Y', $request->automatic_from);
        	$toDateObj = \DateTime::createFromFormat('m/d/Y', $request->automatic_until);

        	$modifiedTimeAuto = str_replace(' ', '', $request->automatic_time.":00");

	 		while( $fromDateObj->format('U')<=$toDateObj->format('U') )
	 		{
				$weekDay = $fromDateObj->format('N');

				foreach ($request->day as $key => $dayValue) 
				{
					if($dayValue == $weekDay )
					{
    			 		$trip = Trip::create([
    			    		'departure_port_id' => $request->departure_port,
    			    		'destination_port_id' => $request->destination_port,
    			    		'departure_date' => $fromDateObj->format('Y-m-d'),
    			            'departure_time' => $modifiedTimeAuto,
    			            'ferry_id' => $request->ferry_id,
                            'company_id' => $companyId
    			        ]);

    			        foreach ($request->price as $key => $value) {
    			    		$tripPassengerPrice = TripPassengerPrice::create([
    			    			'trip_id' => $trip->id,
    				    		'price_id' => $value,
    				    		'passenger_type_id' => $request->idPassenger[$key],
    			        	]);
    			 		}
					}
				}
				$fromDateObj->add(new \DateInterval('P1D'));
	 		}
        }
        return redirect()->route('viewAllCompanyTrip')->with('success', 'Trip Successfully Added ');
 		
 		
 	}

 	public function ViewAllTrip(Request $request)
 	{
 		$parameters = [];
        $appends = array();

        $companyId = Auth::User()->company_id;
        //dd(Auth::User()->role);

        if(Auth::User()->role == RoleType::$COMPANY_USER)
        {
            $parameters[] = array('company_id', '=', $companyId);
            $appends['company_id'] = $companyId;
        }

        if ($request->ferryId){
            $parameters[] = array('ferry_id', '=', $request->ferryId);
            $appends['ferry_id'] = $request->ferryId;
        }
        if ($request->departurePort){
            $parameters[] = array('departure_port_id', '=', $request->departurePort);
            $appends['departure_port_id'] = $request->departurePort;
        }
        if ($request->destinationPort){
            $parameters[] = array('destination_port_id', '=', $request->destinationPort);
            $appends['destination_port_id'] = $request->destinationPort;

        }
        
        if($request->start_date){
        	try {
			    $carbonDate = Carbon::createFromFormat('m/d/Y', $request->start_date)->toDateString();
			    $parameters[] = array('departure_date', '>=', $carbonDate);
           		$appends['start_date'] = $carbonDate;
			}
			catch(\Exception $err)
		 	{
			    $carbonDate = "";
			}  
        }
        if ($request->end_date){
			try {
			    $carbonDate = Carbon::createFromFormat('m/d/Y', $request->end_date)->toDateString();
			    $parameters[] = array('departure_date', '<=', $carbonDate);
           		$appends['end_date'] = $carbonDate;
			}
			catch(\Exception $err)
		 	{
			    $carbonDate = "";
			}
        	
        }

       
        if($parameters)
        {
            //$parameters[] = array('ferry_remaining_seat', '!=', 0);
        	$tripsInfo =Trip::with('ferry', 'departure_port', 'destination_port')->where($parameters)->paginate(10);
        	// if($tripsInfo)
        	// {
        	// 	$flag = 1;
        	// }
        	// else
        	// {
        	// 	$flag = 0;
        	// }
        	
        }
        else
        {
            //$tripsInfo =Trip::with('ferry', 'departure_port', 'destination_port')->where(['ferry_remaining_seat', '!=', 0])->paginate(10);
        	$tripsInfo =Trip::with('ferry', 'departure_port', 'destination_port')->paginate(10);
        }
        $data['appends'] = $appends;
        $ports = Port::all();
        $ferries = Ferry::all();
 		return view('FerryCompanyAdmin.trip.allTrip', $data)->with('trips',$tripsInfo)->with('ports',$ports)->with('ferries',$ferries);
 		//return view('trip/allTrip', compact('data', 'trips','ports','ferry'));

 	}

    

 	public function EditTrip(Request $request , $tripId)
    {
          $tripInfo = Trip::where('id', $tripId)->first();

          if(!$tripInfo )
          {
            return redirect()->route('errorCompanyUser')->with('unsuccess', 'Not Found In Database');
          }
          if(!(Auth::User()->company_id == $tripInfo->company_id))
          {
            return redirect()->route('errorCompanyUser')->with('unsuccess', 'Not An Authorised User');
          }
          $ports = Port::all();
          $ferries = Ferry::all();
          $ferryInfo = Ferry::where('id', $tripInfo->ferry_id)->first();
          $seatCapacity = $ferryInfo->number_of_seat;
          return view('FerryCompanyAdmin.trip.editTrip', compact('ports', 'tripInfo','ferries','seatCapacity'));  
           
    	
    }

     public function UpdateTrip(Request $request , $tripId)
    {
        $companyId = Auth::User()->company_id;
    	//dd($companyId,$request->all());
        $this->validate($request, [
	        'departurePort'   => 'required|max:100',
            'destinationPort' => 'required',
	        'departure_date'  => 'required',
	        'departure_time'  => 'required',
	        'seatCapacity'    => 'required'
        ]);

        $trip = Trip::find($tripId);
        if(!$trip)
          {
            return redirect()->route('errorCompanyUser')->with('unsuccess', 'Not Found In Database');
          }
          if(!(Auth::User()->company_id == $trip->company_id))
          {
            return redirect()->route('errorCompanyUser')->with('unsuccess', 'Not An Authorised User');
          }
        $trip->departure_port_id = $request->departurePort;
        $trip->destination_port_id = $request->destinationPort;
        $trip->company_id = $companyId;

        //dd($request->destinationPort);

        if ($request->departure_date)
        {
			try 
			{
			    $carbonDate = Carbon::createFromFormat('m/d/Y', $request->departure_date)->toDateString();
			}
			catch(\Exception $err)
		 	{
		 		$carbonDate = Carbon::createFromFormat('Y-m-d', $request->departure_date)->toDateString();
			}
        }

        $modifiedTime = str_replace(' ', '', $request->departure_time.":00");
        $trip->departure_date = $carbonDate;
        $trip->departure_time = $modifiedTime;
        $trip->save();

        $ferryInfo = Ferry::find($request->ferryId);
        $ferryInfo->number_of_seat = $request->seatCapacity;
        $ferryInfo->save();
        

        return redirect()->route('viewAllCompanyTrip')->with('success', 'Successfully Updated');  
    }

 	
}
