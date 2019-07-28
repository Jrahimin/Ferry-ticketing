<?php

namespace App\Http\Controllers;

use App\library\CustomPdf;
use App\Model\Passenger;
use App\Model\Price;
use App\Model\Ticket;
use App\Model\Order;
use Illuminate\Http\Request;
use App\Model\Trip;
use Illuminate\Support\Facades\DB;
use Milon\Barcode\DNS1D;
use Mockery\Generator\StringManipulation\Pass\Pass;

class TicketBookingController extends Controller
{
    public function passengerDetails(Request $request)
	{
    	$trip = Trip::where('id', $request->one_way_trip_id)
    		->with('ferry', 'departure_port', 'destination_port', 'prices')->first();

    	$return_trip = null;

    	if ($request->trip_type == '2')
			$return_trip = Trip::where('id', $request->return_trip_id)
    		->with('ferry', 'departure_port', 'destination_port', 'prices')->first();

    	return view('ticket.passenger_details', compact('trip', 'return_trip'))
    		->with('pax_no', $request->pax_no);
    }

	public function passengerDetailsApi(Request $request)
	{
		$trip = Trip::where('id', $request->one_way_trip_id)
			->with('ferry', 'departure_port', 'destination_port', 'prices')->first();

		$return_trip = null;

		if ($request->trip_type == '2')
			$return_trip = Trip::where('id', $request->return_trip_id)
				->with('ferry', 'departure_port', 'destination_port', 'prices')->first();

		$passenger_types = array();
		foreach($trip->prices as $price)
		{
			$passengerTypeArray = array(
				"id"=>$price->passenger_type->id,
				"name"=>$price->passenger_type->name,
				"price"=>$price->price,
			);
			array_push($passenger_types, $passengerTypeArray);
		}

		$return_passenger_types = array();
		foreach($return_trip->prices as $price)
		{
			$returnPassengerTypeArray = array(
				"id"=>$price->passenger_type->id,
				"name"=>$price->passenger_type->name,
				"price"=>$price->price,
			);
			array_push($return_passenger_types, $returnPassengerTypeArray);
		}

		$trip = array(
			"departure_date"=>$trip->departure_date,
			"departure_port"=>$trip->departure_port->name,
			"destination_port"=>$trip->destination_port->name,
			"ferry"=>$trip->ferry->name,
			"no_of_seat"=>$trip->ferry_total_seat,
			"passenger_type"=>$passenger_types,
		);

		$return_trip = array(
			"departure_date"=>$return_trip->departure_date,
			"departure_port"=>$return_trip->departure_port->name,
			"destination_port"=>$return_trip->destination_port->name,
			"ferry"=>$return_trip->ferry->name,
			"no_of_seat"=>$return_trip->ferry_total_seat,
			"passenger_type"=>$return_passenger_types,
		);

		$data = array(
			"departure_trip"=>$trip,
			"return_trip"=>$return_trip,
		);

		return response()->json(["success"=>true, "data"=>$data], 200);
	}

	public function storeTicket(Request $request)
	{
		$this->validate($request,[
			'email'=>'email|required',
			'contact_no' => 'required',
			'name.*' => 'required',
			'gender.*' => 'required',
			'dob.*' => 'required',
			'passport_no.*' => 'required',
			'passport_exp.*' => 'required',
			'nationality.*' => 'required',
			'type_id.*' => 'required'
		]);

		$return = $request->return_trip;
		$count = $request->no_of_passenger;
		$trip = Trip::find($request->trip_id);
		$request['company_id'] = $trip->company->id;

		//creating order info
		$request['departure_port_id'] = $trip->departure_port_id;
		$request['destination_port_id'] = $trip->destination_port_id;
		$order = Order::create($request->all());
		$request['order_id'] = $order->id;

		//Generating tickets and including passengers for mandatory departure trip
		$tickets = collect([]);
		for($i=0; $i<$count; $i++)
		{
			$price = DB::table('trip_passenger_price')->where('trip_id', $request->trip_id)
				->where('passenger_type_id', $request->type_id[$i])->first();

			//Booking ticket for each passenger
			$request['price'] = $price->price;
			$ticket = Ticket::create($request->all());
			$tickets->push($ticket);

			//trip remaining seat calculation
			$trip->ferry_remaining_seat = $trip->ferry_remaining_seat - 1;
			$trip->save();

			$request['code'] = str_random(20);
			$passenger = new Passenger();
			$passenger->name = $request->name[$i];
			$passenger->gender = $request->gender[$i];
			$passenger->type_id = $request->type_id[$i];
			$passenger->dob = $request->dob[$i];
			$passenger->nationality = $request->nationality[$i];
			$passenger->passport_no = $request->passport_no[$i];
			$passenger->passport_exp = $request->passport_exp[$i];
			$passenger->ticket_id = $ticket->id;
			$passenger->code = $request->code;
			$passenger->save();

			//concatenating passenger Id to barcode and updating passenger
			$code = $passenger->id.':'.$passenger->code;
			$passenger->code = $code;
			$passenger->save();
		}

		if(!empty($passenger))
		{
			//checking if round trip...
			if($return==1)
			{

				$tripRound = Trip::find($request->trip_id_round);
				$request['company_id'] = $tripRound->company->id;
				$ticketRounds = collect([]);
				for($i=0; $i<$count; $i++)
				{
					$priceRound = DB::table('trip_passenger_price')->where('trip_id', $request->trip_id_round)
						->where('passenger_type_id', $request->type_id[$i])->first();
					$request['price'] = $priceRound->price;

					$request['code'] = str_random(20);

					// Booking ticket for return trip
					$ticketRound = new Ticket();

					$ticketRound->departure_date_time = $request->departure_date_round;
					$ticketRound->depart_from = $ticket->arrive_at;
					$ticketRound->arrive_at = $ticket->depart_from;
					$ticketRound->order_id = $order->id;
					$ticketRound->trip_id = $request->trip_id_round;
					$ticketRound->price = $request->price;
					$ticketRound->company_id = $request->company_id;
					$ticketRound->save();
					$ticketRounds->push($ticketRound);

					//inserting passenger for the round trip
					$passenger = new Passenger();
					$passenger->name = $request->name[$i];
					$passenger->gender = $request->gender[$i];
					$passenger->type_id = $request->type_id[$i];
					$passenger->dob = $request->dob[$i];
					$passenger->nationality = $request->nationality[$i];
					$passenger->passport_no = $request->passport_no[$i];
					$passenger->passport_exp = $request->passport_exp[$i];
					$passenger->ticket_id = $ticketRound->id;
					$passenger->code = $request->code;
					$passenger->save();

					//concatenating passenger Id to barcode and updating passenger
					$code = $passenger->id.":".$passenger->code;
					$passenger->code = $code;
					$passenger->save();
				}
				if(!empty($passenger))
				{
					return view('ticket.success', compact('tickets', 'ticketRounds', 'count'));
				}
			}
			else
			{
				$ticketRounds = null;
				return view('ticket.success', compact('tickets', 'ticketRounds', 'count'));
			}
		}
		else
		{
			return response("Booking Failed", 400);
		}
	}

	public function ticketPrint(Request $request)
	{
		$ifRound = $request->ifRound;
		$count = $request->maximumPassenger;

		//Generating Tickets for one way...
		$ticketId = ($request->ticketIds[0]);
		$pdf = new CustomPdf();
		$ticketCompany = new Ticket();
		$ticketCompany->printCompanyHead($pdf, $ticketId);

		//Generating Passengers for one way...
		$add = 0;
		$page = 0;
		for($i =0; $i<$count; $i++)
		{
			$ticketId = $request->ticketIds[$i];
			$printPassengers = new Ticket();
			$printPassengers->printPassengers($pdf, $ticketId, $add, $page, $i);

			$add= $add + 65;
			if($i==2)
			{
				$pdf->AddPage();
				$page = 1;
				$add=0;
			}

			if($i!=2 && $page==1 && ($i-2)%4==0)
			{
				$pdf->AddPage();
				$pdf->SetXY(10,10);
				$add = 0;
			}

		}

		//Generating Tickets for round way...
		if($ifRound==2)
		{
			$ticketRoundId = $request->ticketRoundIds[0];

			$printReturnCompany = new Ticket();
			$printReturnCompany->printCompanyHead($pdf, $ticketRoundId);

			//Generating Passengers for round way...
			$add = 0;
			$page = 0;
			for($i =0; $i<$count; $i++)
			{
				$ticketRoundId = $request->ticketRoundIds[$i];
				$printPassengers = new Ticket();
				$printPassengers->printPassengers($pdf, $ticketRoundId, $add, $page, $i);

				$add= $add + 65;
				if($i==2)
				{
					$pdf->AddPage();
					$page = 1;
					$add=0;
				}

				if($i!=2 && $page==1 && ($i-2)%4==0)
				{
					$pdf->AddPage();
					$pdf->SetXY(10,10);
					$add = 0;
				}

			}
		}
		$pdf->Output('ticket.pdf');
	}

	public function checkTicketApi(Request $request)
    {
        $code = "1:9dUY2Cq7ydSuycGMgjW9";
        $passenger = Passenger::where('code', $code)->first();

        $requestTripId = 63;
        //$passengerId = strtok($code, ':');

        if($passenger)
        {
            $ticket = Ticket::find($passenger->ticket_id);

            $tripIdFromCode = $ticket->trip->id;

            if($requestTripId === $tripIdFromCode)
            {
                return response()->json(["success"=>true, "message"=>"Ticket info matched"], 200);
            }
        }
        else
        {
            return response()->json(["success"=>false, "message"=>"ticket info did not match"], 401);
        }
    }
}
