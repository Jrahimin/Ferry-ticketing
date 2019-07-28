<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Cart;
use App\Trip;
use App\TripPassengerPrice;
use Session;
use App\Port;
use App\Ferry;
use App\Order;
use App\Ticket;
use Uuid;
use App\PassengerType;
use PDF;
use App\library\CustomPdf;


class CustomerBookingController extends Controller
{
    public function Booking(Request $request) 
    {
        //dd($request->all());
        $request->session()->regenerate();
    	$sessionId = $request->session()->getId();

    	if(isset($request->idDestination))
    	{
            
    		$dataCardDetails =  [
	    		'departureTripId'  => $request->idDeparture,
	    		'departureSeat'    => $request->seatBookedDeparture,
	    		'destinationTripId'=> $request->idDestination,
	    		'destinationSeat'  => $request->seatBookedDestination,
	    		'tripWayType'	   => 1	
	    	]; 

    	}
    	else
    	{
    		$dataCardDetails =  [
	    		'departureTripId'  => $request->idDeparture,
	    		'departureSeat'    => $request->seatBookedDeparture,
	    		'tripWayType'	   => 0
	    	];
            //dd("ok from departure booking");
    	}
    	
        //dd("ok",json_encode($dataCardDetails));
    	$registeringAsCart = Cart::create([
    		'session_id' => $sessionId,
    		'cart_details' => json_encode($dataCardDetails)
        ]);

        //return redirect()->route('passengerDetails');


    	//return view('Customer.passengerDetails' compact($request->seatBookedDeparture));
    }
    public function PassengerDetails(Request $request)
    {
    	$sessionId = $request->session()->getId();
    	$cartInfoInSession = Cart::where('session_id', $sessionId)->first();
    	$data = json_decode($cartInfoInSession->cart_details);
    	//dd("ok from Details",$data);

    	$dataTripPassengerPrice =  TripPassengerPrice::all();
    	$dataTripPassengerPrice = json_encode($dataTripPassengerPrice);
    	//dd($dataTripPassengerPrice);

    	$departureTripId = $data->departureTripId;
        //dd($data->destinationTripId);
    	//$destinationTripId = $data->destinationTripId;

    	 //$departureSeat = $data->departureSeat;
        if(isset($data->destinationTripId))
        {
            $destinationTripId = $data->destinationTripId;
        }    
    	 
    	
    	if(isset($destinationTripId))
    	{
    		$dataDeparture['bookedSeatDeparture'] = $data->departureSeat;
	    	$dataDestination['bookedSeatDestiantion'] = $data->destinationSeat;

            $dataDeparture['bookedTripIdDeparture'] =  $departureTripId ;
            $dataDestination['bookedTripIdDestination'] =  $destinationTripId ;

	    	$departureTripInfo = Trip::where('id',$departureTripId )->first();
	    	$destinationTripInfo = Trip::where('id',$destinationTripId)->first();

    		$dataDeparture['dateDeparture'] =  $departureTripInfo->departure_date;
	    	$dataDestination['dateDestination'] = $destinationTripInfo->departure_date;

	    	$departureFerryForDepartureTrip = Ferry::where('id',$departureTripInfo->ferry_id)->first();
	    	$dstinationFerryForDepartureTrip = Ferry::where('id',$destinationTripInfo->ferry_id)->first();
	    	$dataDeparture['ferryDeparture'] = $departureFerryForDepartureTrip->name;
	    	$dataDestination['ferryDestination'] = $dstinationFerryForDepartureTrip->name;


	    	$departurePortForDepartureTrip = Port::where('id',$departureTripInfo->departure_port_id)->first();
	    	$destinationPortForDepartureTrip = Port::where('id',$departureTripInfo->destination_port_id)->first();
	    	$dataDeparture['portDepartureFrom'] = $departurePortForDepartureTrip->name;
	    	$dataDeparture['portDepartureTo'] = $destinationPortForDepartureTrip->name;

	    	$departurePortForDestinationTrip = Port::where('id',$destinationTripInfo->departure_port_id)->first();
	    	$destinationPortForDestinationTrip = Port::where('id',$destinationTripInfo->destination_port_id)->first();
	    	$dataDestination['portDestinationFrom'] = $departurePortForDestinationTrip->name;
	    	$dataDestination['portDestinationTo'] = $destinationPortForDestinationTrip->name;

	    	$priceDeparture = TripPassengerPrice::where('trip_id' ,$departureTripId)->get();
	    	$priceDestination = TripPassengerPrice::where('trip_id' ,$departureTripId)->get();
	    	$passengerType = PassengerType::all();
    		$destinationInclude = 1;

    		if($dataDestination['bookedSeatDestiantion'] >= $dataDeparture['bookedSeatDeparture'])
            {
            	$numberOfPassengerInfo = $dataDestination['bookedSeatDestiantion'];
            }
            else
            {
            	$numberOfPassengerInfo = $dataDeparture['bookedSeatDeparture'];
            }
    	}
    	else
    	{
    		$dataDeparture['bookedSeatDeparture'] = $data->departureSeat;
            $dataDeparture['bookedTripIdDeparture'] =  $departureTripId ;

    		$departureTripInfo = Trip::where('id',$departureTripId )->first();

    		$dataDeparture['dateDeparture'] =  $departureTripInfo->departure_date;

    		$departureFerryForDepartureTrip = Ferry::where('id',$departureTripInfo->ferry_id)->first();

    		$dataDeparture['ferryDeparture'] = $departureFerryForDepartureTrip->name;


	    	$departurePortForDepartureTrip = Port::where('id',$departureTripInfo->departure_port_id)->first();
	    	$destinationPortForDepartureTrip = Port::where('id',$departureTripInfo->destination_port_id)->first();
	    	$dataDeparture['portDepartureFrom'] = $departurePortForDepartureTrip->name;
	    	$dataDeparture['portDepartureTo'] = $destinationPortForDepartureTrip->name;


	    	$priceDeparture = TripPassengerPrice::where('trip_id' ,$departureTripId)->get();

	    	$numberOfPassengerInfo = $dataDeparture['bookedSeatDeparture'];

	    	$passengerType = PassengerType::all();

    		$destinationInclude = 0;
    	}	
    	//dd($departureTripInfo->departure_port_id,$departureTripInfo->destination_port_id);
    	//dd($departureTripInfo->departure_date,$destinationTripInfo->departure_date);//date

    	
        


    	// if( count($priceDeparture) > 0 )
    	// {
	    	// 	foreach ($priceDeparture as $key => $value) //price for departure Trip
	    	// 	{
	    	// 		$price[$key] = $value->price_id;
	    	// 	}
	    	// 	//dd($price);
    	// }
    	

    	return view('Customer.bookings.passengerDetails',compact('dataDeparture','dataDestination','priceDeparture','priceDestination','passengerType','destinationInclude','numberOfPassengerInfo','dataTripPassengerPrice','departureTripId','destinationTripId'));
    }

    public function TicketCollector(Request $request)
    {  
        $customer = $request->customerName;
        $maximumPassenger = $request->maximumPassenger;


        $uuidNumber = Uuid::generate(4);
        $randomKeyForOrder = $uuidNumber->string;

               

        $this->validate($request, [
            'customerName' => 'required|max:35',
            'email' => 'required|email|unique:users',
            'contact' => 'required|digits:11'
        ]);

        //dd("oekk");
        $sucess = $this->PaymentProcess();  

        if( $sucess == "true")
        {
           if($request->destinationTripId)
            {
                $insertInCustomer = Order::create([
                    'name' => $request->customerName ,
                    'email' => $request->email ,
                    'contact_number' => $request->contact,
                    'trip' => 1,
                    'key' => $randomKeyForOrder
                ]);
            }
            else
            {
                $insertInCustomer = Order::create([
                    'name' => $request->customerName,
                    'email' => $request->email ,
                    'contact_number' => $request->contact,
                    'trip' => 0 ,
                    'key' => $randomKeyForOrder
                ]);
            }    
            
            if($request->departureTripId)
            {    
                for ($i=0; $i < sizeof($request->name) ; $i++)
                { 
                    $insertInTicket = Ticket::create([
                        'customer_id' =>$insertInCustomer->id,
                        'trip_id' => $request->departureTripId,
                        'trip_type' => 0,
                        'name' => $request->name[$i],
                        'gender' => $request->gender[$i],
                        'passport' => $request->passport[$i] ,
                        'passport_expire_date' => $request->expireDate[$i],
                        'birth_date' => $request->birthDate[$i],
                    ]);
                }

            }

            if($request->destinationTripId)
            {
                for ($i=0; $i < sizeof($request->name) ; $i++)
                { 
                    $insertInTicket = Ticket::create([
                        'customer_id' =>$insertInCustomer->id,
                        'trip_id' => $request->destinationTripId,
                        'trip_type' => 1,
                        'name' => $request->name[$i] ,
                        'gender' => $request->gender[$i],
                        'passport' => $request->passport[$i] ,
                        'passport_expire_date' => $request->expireDate[$i],
                        'birth_date' => $request->birthDate[$i],
                    ]);
                }
            }

            $tripSeatNumberDeparture=Trip::where('id',$request->departureTripId)->select('ferry_remaining_seat')->first();
            $tripSeatNumberDestination=Trip::where('id',$request->destinationTripId)->select('ferry_remaining_seat')->first();

            

            $remainSeatDeparture = $tripSeatNumberDeparture->ferry_remaining_seat - $request->departureTripSeat;
            $departureTripSeatUpdate = Trip::where('id',$request->departureTripId)->update([
                    'ferry_remaining_seat' => $remainSeatDeparture
                ]);

            if($request->destinationTripSeat)
            {
                $remainSeatDestination = $tripSeatNumberDestination->ferry_remaining_seat - $request->destinationTripSeat;

                $destinationTripSeatUpdate = Trip::where('id',$request->destinationTripId)->update([
                    'ferry_remaining_seat' => $remainSeatDestination
                ]);
            }
              
            $passengerInfo = [];
            $seatDeparture = [];
            $seatDestination = [];
            $collectorInfo = [];

            for($i=0; $i<sizeof($request->name); $i++) {
                $passengerInfo[] = [
                        'name' => $request->name[$i],
                        'passport'=>$request->passport[$i],
                        'expireDate' => $request->expireDate[$i],
                        'birthDate' => $request->birthDate[$i]
                    ];
            }
            for($j=0; $j<sizeof($request->departureSeatValue); $j++) {
                $seatDeparture[] = [
                        'seatDeparture' => $request->departureSeatValue[$j],
                    ];  
            }
            if($request->destinationSeatValue)
            {
                for($k=0; $k<sizeof($request->destinationSeatValue); $k++) {
                    $seatDestination[] = [
                        'seatDestination' => $request->destinationSeatValue[$k],
                    ];
                } 
            }    
            
            $collectorInfo[] = [
                'email' => $request->email,
                'reEnterEmail' => $request->reEnterEmail,
                'contact' => $request->contact,
            ];


            $sessionId = $request->session()->getId();
            $cartInfoInSession = Cart::where('session_id', $sessionId)->first();
            //dd($cartInfoInSession);
            if($cartInfoInSession && isset($seatDestination))
            {
                $cartInfoInSession->update([
                    'passenger_info' => json_encode($passengerInfo),
                    'seat_selected_departure' => json_encode($seatDeparture),
                    'seat_selected_destination' => json_encode($seatDestination),
                    'collector_info' => json_encode($collectorInfo)
                ]);
            }
            if(!isset($seatDestination) && $cartInfoInSession)
            {
               $cartInfoInSession->update([
                    'passenger_info' => json_encode($passengerInfo),
                    'seat_selected_departure' => json_encode($seatDeparture),
                    'collector_info' => json_encode($collectorInfo)
                ]);
            }   


            $data = $randomKeyForOrder;
            //return redirect()->route('successPage');
            $name = $request->name;
            $passport = $request->passport;
            $departureFare = $request->departureFare;

            //dd($name);

            return view('Customer.bookings.successPage', compact('data','maximumPassenger','name','passport','departureFare'));
        }
        else
        {
            $flag = 0;
            return view('Customer.bookings.failurePage',compact('flag'));
        }     

        
    } 

    private function PaymentProcess()      
    {
       return true;
    }

    public function TicketPrint(Request $request)      
    {
        $maximumPassenger =$request->maximumPassenger;

        $orderDetils = Order::where('key',$request->keyValue)->first();
        $ticketDetails = Ticket::where('customer_id',$orderDetils->id)->select('trip_id','trip_type')->get();


        if($ticketDetails == "true")
        {
            foreach($ticketDetails as  $value)
            {
                if($value->trip_type == 0)
                {
                    $departureTripId = $value->trip_id;
                }
                if($value->trip_type == 1)
                {
                    $destinationTripId = $value->trip_id;
                }
            }
            //calculate the port name for pdf show 
            //dd($destinationTripId);
            $tripDepartureJourneyPortId = Trip::select('departure_port_id','destination_port_id','departure_date','departure_time')->where('id',$departureTripId)->first();
            $tripDepartureJourneyDeparturePortName = Port::select('name')->where('id',$tripDepartureJourneyPortId->departure_port_id)->first();
            $tripDepartureJourneyDestinationPortName = Port::select('name')->where('id',$tripDepartureJourneyPortId->destination_port_id)->first();
            $tripDepartureJourneyDepartureDate = $tripDepartureJourneyPortId->departure_date;
            $tripDepartureJourneyDepartureTime = $tripDepartureJourneyPortId->departure_time;
            
            if($destinationTripId)
            {
                $tripDestinationJourneyPortId = Trip::select('departure_port_id','destination_port_id','departure_date','departure_time')->where('id',$destinationTripId)->first();

                $tripDestinationJourneyDeparturePortName = Port::select('name')->where('id',$tripDestinationJourneyPortId->departure_port_id)->first();

                $tripDestinationJourneyDestinationPortName = Port::select('name')->where('id',$tripDestinationJourneyPortId->destination_port_id)->first();

            }
            
            $tripDepartureJourneyDeparturePortName=$tripDepartureJourneyDeparturePortName->name;
            $tripDepartureJourneyDestinationPortName= $tripDepartureJourneyDestinationPortName->name;
            $tripDestinationJourneyDeparturePortName = $tripDestinationJourneyDeparturePortName->name;
            $tripDestinationJourneyDestinationPortName=$tripDestinationJourneyDestinationPortName->name;
            $tripDestinationJourneyDepartureDate = $tripDestinationJourneyPortId->departure_date;
            $tripDestinationJourneyDepartureTime = $tripDestinationJourneyPortId->departure_time;
           // dd("okj");

            // dd($tripDepartureJourneyDeparturePortName->name,$tripDepartureJourneyDestinationPortName->name,
            //     $tripDestinationJourneyDeparturePortName->name,
            //     $tripDestinationJourneyDestinationPortName->name );
            $journey = $tripDepartureJourneyDeparturePortName .' >> '.$tripDepartureJourneyDestinationPortName;

            // end of calculation


            $uuidNumber = Uuid::generate(4);
            $randomKey = $uuidNumber->string;
            //dd($randomKey); 


            $renderer = new \BaconQrCode\Renderer\Image\Png();
            $renderer->setHeight(256);
            $renderer->setWidth(256);
            $renderer->setMargin(1);
            $writer = new \BaconQrCode\Writer($renderer);

            //dd($writer);

            if(!isset($seatDestination))
            {
                $writer->writeFile($randomKey.$request->departureTripId, 'qrcode.png');
            }
            else
            {
                $writer->writeFile($randomKey.$request->destinationTripId, 'qrcode.png');
            }    
            

            $ldate = date('Y-m-d H:i:s');

            
            $pdf = new CustomPdf();
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            $pdf->SetTitle('Ticket');

            $pdf->AddPage();

            $image_file = url('/images/logo.png');
            $qrcode_file = url('/qrcode.png');

            $pdf->SetXY(30, 15);
            $pdf->SetFont('helvetica', '', 16);

            $pdf->Cell(0, 0, 'Ferry Ticketing System', 0, 1, 'L', 0, '', 0, false, 'T', 'M' );
            $pdf->SetXY(30, 7);
            $pdf->Cell(0, 0, 'Boarding Pass', 0, 1, 'R', 0, '', 0, false, 'T', 'M' );
            $pdf->SetFont('times', '', 13);
            $pdf->SetXY(10, 25);
            $pdf->Cell(0, 1, 'Ferry Port Name', 0, 1, 'L', 0, '', 0, false, 'T', 'M' );
            $pdf->Cell(0, 1, 'Ferry Port Country & Other Informations', 0, 1, 'L', 0, '', 0, false, 'T', 'M' );
            

            $pdf->Image($image_file, 5, 10, 18, '', 'JPG', '', 'T', false, 300, 'L', false, false, 0,false, false, false);

            $pdf->SetXY(10, 40);
            $pdf->Cell(40, 5, 'Ticketing-Office  ', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
            $pdf->Cell(30, 5, 'Head-Quarter ', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
            $pdf->Cell(30, 5, 'Kualalampur ', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
            $pdf->Cell(30, 5, 'Lankawai ', 0, 1, 'L', 0, '', 0, false, 'T', 'M' );
           
            
            $pdf->Cell(40, 5, 'Telephone-Number  ', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
            $pdf->Cell(30, 5, '+908-786 ', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
            $pdf->Cell(30, 5, '4396598 ', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
            $pdf->Cell(30, 5, '43965980987 ', 0, 1, 'L', 0, '', 0, false, 'T', 'M' );
           
            
            $pdf->Cell(40, 5, 'Fax-Number', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
            $pdf->Cell(30, 5, '4396598 ', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
            $pdf->Cell(30, 5, '475894375 ', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
            $pdf->Cell(30, 5, '4758943753457 ', 0, 1, 'L', 0, '', 0, false, 'T', 'M' );

            
            $pdf->Cell(40, 10, 'Email : sdg@gmail.com', 0, 1, 'L', 0, '', 0, false, 'T', 'M' );

            
            $pdf->SetFont('helvetica', 'B', 14);
            $pdf->Cell(40, 1, 'Ref Id: 348734 / Sales Id : 435435', 0, 1, 'L', 0, '', 0, false, 'T', 'M' );

            $pdf->SetFont('helvetica', '', 13);
           
            $pdf->Image($qrcode_file, 14, 15, 57, '', 'PNG', '', 'T', false, 20, 'R', false, false, 0,false, false, false);
            
            $pdf->SetXY(5, 35);
            $pdf->SetFont('helvetica', '', 12);
            $pdf->Cell(130, 55, 'Printed On: '.$ldate.' ', 0, false, 'R', 0, '', 0, false, 'T', 'M' );
            
           
            $linestyle = array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => '4,2', 'color' => array(0, 0, 0));
            //$pdf->Ln(2);
            $pdf->Line(0, 75, 210,75, $linestyle);
            //$pdf->Ln(1);
            $pdf->SetFont('helvetica', '', 12);
            //$pdf->Cell(100, 'Journey:');

            $flagBlock = 0;
            $blockPosition = 80;

            $lowerlinePosition =80;
            $maximumPassenger = $request->maximumPassenger;

            for($i=1 ; $i<=$maximumPassenger ; $i++)
            {
                //$seatNumber = $request->departureSeatValue[$i-1];
                if($i<=5)
                {
                    $passengerType = "Adult";
                } 
                else if($i<=7)
                {
                    $passengerType = "Child";
                }
                else
                {
                    $passengerType = "Senior";
                }  
               

                $pdf->SetXY(10,$blockPosition);

                
                $pdf->setFillColor(124,252,0);
                $pdf->SetFont('helvetica', '', 11);
                $pdf->Cell(191,7,'Journey: '.$journey.'',0,2,'L',1); //your cell

                $pdf->setFillColor(210, 210, 210);
                $pdf->SetXY(10,$blockPosition+53);
                $pdf->SetFont('helvetica', '', 8);
                $pdf->Cell(191,0,'All terms & Condition are reserved to www.ferryticketingsystem.com',0,2,'L',1); 
              
                $pdf->SetXY(12,$blockPosition+7);
                $tripDepartureJourneyDepartureDate = date("d M Y", strtotime($tripDepartureJourneyDepartureDate));
                $tripDepartureJourneyDepartureTime = date("g:i A", strtotime($tripDepartureJourneyDepartureTime));
                $pdf->SetFont('helvetica', '', 9);
                $pdf->Cell(0, 10, 'Date :  ', 0, 2, 'L', 0, '', 0, false, '', 'M' );
                $pdf->SetXY(20,$blockPosition+7);
                $pdf->SetFont('helvetica', '', 12);
                $pdf->Cell(0, 10, ''.$tripDepartureJourneyDepartureDate.',  '.$tripDepartureJourneyDepartureTime, 0, 2, 'L', 0, '', 0, false, '', 'M' );

                $pdf->SetXY(12,$blockPosition+12);
                $pdf->SetFont('helvetica', '', 9);
                $pdf->Cell(0, 10, 'Passenger Name :  ', 0, 2, 'L', 0, '', 0, false, '', 'M' );
                $pdf->SetXY(37,$blockPosition+12);
                $pdf->SetFont('helvetica', '', 13);
                $pdf->Cell(0, 10, '  '.$request->passengerName[$i-1].'', 0, 2, 'L', 0, '', 0, false, '', 'M' );

                $pdf->SetXY(12,$blockPosition+17);
                $pdf->SetFont('helvetica', '', 9);
                $pdf->Cell(0, 10, 'Passport : ', 0, 2, 'L', 0, '', 0, false, '', 'M' );
                $pdf->SetXY(25,$blockPosition+17);
                $pdf->SetFont('helvetica', '', 13);
                $pdf->Cell(0, 10, '  '.$request->passengerPassport[$i-1].'', 0, 2, 'L', 0, '', 0, false, '', 'M' );

                $pdf->SetFont('helvetica', '', 10);
                $pdf->SetXY(12,$blockPosition+22);
                $pdf->SetFont('helvetica', '', 9);
                $pdf->Cell(0, 10, 'Price : ', 0, 2, 'L', 0, '', 0, false, '', 'M' );
                $pdf->SetXY(23,$blockPosition+22);
                $pdf->SetFont('helvetica', '', 11);
                $pdf->Cell(0, 10, ''.$passengerType.'-'.$request->departureFare.' USD ', 0, 2, 'L', 0, '', 0, false, '', 'M' );

                $pdf->SetXY(163,$blockPosition+44);
                $pdf->SetFont('helvetica', '', 8);
                $pdf->Cell(0, 10, 'Price : ', 0, 2, 'L', 0, '', 0, false, '', 'M' );
                $pdf->SetXY(172,$blockPosition+44);
                $pdf->SetFont('helvetica', '', 8);
                $pdf->Cell(0, 10, ''.$request->departureFare.' USD ', 0, 2, 'L', 0, '', 0, false, '', 'M' );

                $pdf->SetFont('helvetica', 'B', 12);;
                $pdf->SetXY(12,$blockPosition+30);
                $pdf->Cell(0, 1, 'Boarding 30 minutes Before Departure ', 0, 2, 'L', 0, '', 0, false, '', 'M' );

                $pdf->SetXY(12,$blockPosition+35);
                $pdf->SetFont('helvetica', 'B', 10);
                $pdf->Cell(0, 8, ' ** Ticket Sold Is Not Refundable', 0, 2, 'L', 0, '', 1, false, '', 'M' );

                $pdf->SetXY(12,$blockPosition+42);
                $pdf->SetFont('helvetica', '', 9);
                $pdf->Cell(0, 10, 'Online Ticket Support : ', 0, 2, 'L', 0, '', 0, false, '', 'M' );
                $pdf->SetXY(45,$blockPosition+42);
                $pdf->SetFont('helvetica', '', 13);
                $pdf->Cell(0, 10, '+8801754231998', 0, 2, 'L', 0, '', 0, false, '', 'M' );
           
               
              
                $pdf->SetXY(90,$blockPosition+25);
                $pdf->SetFont('helvetica', '', 8);
                $pdf->Cell(20, 10, 'Ticket No :', 0, false, 'R', 0, '', 1, false, '', 'M' );
                $pdf->SetXY(110,$blockPosition+25);
                $pdf->SetFont('helvetica', '', 11);
                $pdf->Cell(25, 10, '908', 0, 2, 'R', 0, '', 1, false, '', 'M' );
                $pdf->SetFont('helvetica', '', 8);

               
                $pdf->SetXY(90, $blockPosition+31);
                

                $pdf->Cell(20, 10, 'Seat No:', 0, false, 'R', 0, '', 1, false, '', 'M' );
                $pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
                
                $pdf->SetXY(120, $blockPosition+33);
                $pdf->SetFont('helvetica', '', 12);
                $pdf->Cell(15, 7, '786', 1, 2, 'R', 0, '', 0, false, '', 'M' );
                $pdf->SetFont('helvetica', '', 8);

                $imagePosition = $blockPosition + 8;
            
                $pdf->Image($qrcode_file, 0, $imagePosition, 38, '', 'PNG', '', 'T', false, 10, 'R', false, false, 0,false, false, false);

                $pdf->SetXY(155,$blockPosition+41);
                $pdf->SetFont('helvetica', '', 8);
                $pdf->Cell(22, 10, 'Ticket No:', 0, false, 'R', 0, '', 1, false, '', 'M' );
                $pdf->SetFont('helvetica', '', 8);
                $pdf->Cell(7, 10, '908', 0, 2, 'R', 0, '', 1, false, '', 'M' );
                $pdf->SetFont('helvetica', '', 8);
             

                $linePositionY1 = $blockPosition + 7 ;
                $linePositionY2 =  $blockPosition + 53 ;

                $style = array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter',  'phase' => 10, 'color' => array(178, 190, 181));

                $lowerlinePosition =  $blockPosition + 61;

                $pdf->Line(150, $linePositionY1, 150,  $linePositionY2, $style);
                $pdf->Line(10, $linePositionY1-7, 10,  $linePositionY2, $style);
                $pdf->Line(201, $linePositionY1-7, 201,  $linePositionY2, $style);
                $pdf->Line(10, $lowerlinePosition-5, 201, $lowerlinePosition-5, $style);
                //$pdf->SetXY(155,$blockPosition+47);

                $linestyle = array('width' => 0.4, 'cap' => 'butt', 'join' => 'miter',  'dash' => '4,2', 'color' => array(0,0,0));

                $pdf->SetXY(202,$blockPosition+56);
                $check = "$";
                $pdf->SetFont('ZapfDingbats','', 24);
                $pdf->Cell(10, 10, $check, 0, 0);
                $pdf->Line(0, $lowerlinePosition, 215, $lowerlinePosition, $linestyle);

                
                $blockPosition+=65;
               
                if($i == 3)
                {    
                    $pdf->AddPage();

                    $blockPosition = 15;
                    $flagBlock = 1;
                }
                else if(($i-3)%4 == 0 && $i!=18)
                {

                    $pdf->AddPage();

                    $blockPosition = 15;
                }   
            }

         

           if(isset($destinationTripId))
           {

                $pdf->AddPage();

                $journey = $tripDepartureJourneyDestinationPortName  .' >> '.
                    $tripDepartureJourneyDeparturePortName;

                

                $image_file = url('/images/logo.png');
                $qrcode_file = url('/qrcode.png');

                $pdf->SetXY(30, 15);
                $pdf->SetFont('helvetica', '', 16);

                $pdf->Cell(0, 0, 'Ferry Ticketing System', 0, 1, 'L', 0, '', 0, false, 'T', 'M' );
                $pdf->SetXY(30, 7);
                $pdf->Cell(0, 0, 'Boarding Pass', 0, 1, 'R', 0, '', 0, false, 'T', 'M' );
                $pdf->SetFont('times', '', 13);
                $pdf->SetXY(10, 25);
                $pdf->Cell(0, 1, 'Ferry Port Name', 0, 1, 'L', 0, '', 0, false, 'T', 'M' );
                $pdf->Cell(0, 1, 'Ferry Port Country & Other Informations', 0, 1, 'L', 0, '', 0, false, 'T', 'M' );
                

                $pdf->Image($image_file, 5, 10, 18, '', 'JPG', '', 'T', false, 300, 'L', false, false, 0,false, false, false);

                $pdf->SetXY(10, 40);
                $pdf->Cell(40, 5, 'Ticketing-Office  ', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
                $pdf->Cell(30, 5, 'Head-Quarter ', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
                $pdf->Cell(30, 5, 'Kualalampur ', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
                $pdf->Cell(30, 5, 'Lankawai ', 0, 1, 'L', 0, '', 0, false, 'T', 'M' );
               
                
                $pdf->Cell(40, 5, 'Telephone-Number  ', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
                $pdf->Cell(30, 5, '+908-786 ', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
                $pdf->Cell(30, 5, '4396598 ', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
                $pdf->Cell(30, 5, '43965980987 ', 0, 1, 'L', 0, '', 0, false, 'T', 'M' );
               
                
                $pdf->Cell(40, 5, 'Fax-Number', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
                $pdf->Cell(30, 5, '4396598 ', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
                $pdf->Cell(30, 5, '475894375 ', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
                $pdf->Cell(30, 5, '4758943753457 ', 0, 1, 'L', 0, '', 0, false, 'T', 'M' );

                
                $pdf->Cell(40, 10, 'Email : sdg@gmail.com', 0, 1, 'L', 0, '', 0, false, 'T', 'M' );

                
                $pdf->SetFont('helvetica', 'B', 14);
                $pdf->Cell(40, 1, 'Ref Id: 348734 / Sales Id : 435435', 0, 1, 'L', 0, '', 0, false, 'T', 'M' );

                $pdf->SetFont('helvetica', '', 13);
               
                $pdf->Image($qrcode_file, 14, 15, 57, '', 'PNG', '', 'T', false, 20, 'R', false, false, 0,false, false, false);
                
                $pdf->SetXY(5, 35);
                $pdf->SetFont('helvetica', '', 12);
                $pdf->Cell(130, 55, 'Printed On: '.$ldate.' ', 0, false, 'R', 0, '', 0, false, 'T', 'M' );
                
               
                $linestyle = array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => '4,2', 'color' => array(0, 0, 0));
                //$pdf->Ln(2);
                $pdf->Line(0, 75, 210,75, $linestyle);
                //$pdf->Ln(1);
                $pdf->SetFont('helvetica', '', 12);
                //$pdf->Cell(100, 'Journey:');

                $flagBlock = 0;
                $blockPosition = 80;

                $lowerlinePosition =80;

                for($i=1 ; $i<=$maximumPassenger ; $i++)
                {
                    //$seatNumber = $request->departureSeatValue[$i-1];
                    if($i<=5)
                    {
                        $passengerType = "Adult";
                    } 
                    else if($i<=7)
                    {
                        $passengerType = "Child";
                    }
                    else
                    {
                        $passengerType = "Senior";
                    }  
                   

                    $pdf->SetXY(10,$blockPosition);

                    
                    $pdf->setFillColor(124,252,0);
                    $pdf->SetFont('helvetica', '', 11);
                    $pdf->Cell(191,7,'Journey: '.$journey.'',0,2,'L',1); //your cell

                    $pdf->setFillColor(210, 210, 210);
                    $pdf->SetXY(10,$blockPosition+53);
                    $pdf->SetFont('helvetica', '', 8);
                    $pdf->Cell(191,0,'All terms & Condition are reserved to www.ferryticketingsystem.com',0,2,'L',1); 
                  
                    $pdf->SetXY(12,$blockPosition+7);
                    $tripDepartureJourneyDepartureDate = date("d M Y", strtotime($tripDepartureJourneyDepartureDate));
                    $tripDepartureJourneyDepartureTime = date("g:i A", strtotime($tripDepartureJourneyDepartureTime));
                    $pdf->SetFont('helvetica', '', 9);
                    $pdf->Cell(0, 10, 'Date :  ', 0, 2, 'L', 0, '', 0, false, '', 'M' );
                    $pdf->SetXY(20,$blockPosition+7);
                    $pdf->SetFont('helvetica', '', 12);
                    $pdf->Cell(0, 10, ''.$tripDepartureJourneyDepartureDate.',  '.$tripDepartureJourneyDepartureTime, 0, 2, 'L', 0, '', 0, false, '', 'M' );

                    $pdf->SetXY(12,$blockPosition+12);
                    $pdf->SetFont('helvetica', '', 9);
                    $pdf->Cell(0, 10, 'Passenger Name :  ', 0, 2, 'L', 0, '', 0, false, '', 'M' );
                    $pdf->SetXY(37,$blockPosition+12);
                    $pdf->SetFont('helvetica', '', 13);
                    $pdf->Cell(0, 10, '  '.$request->passengerName[$i-1].'', 0, 2, 'L', 0, '', 0, false, '', 'M' );

                    $pdf->SetXY(12,$blockPosition+17);
                    $pdf->SetFont('helvetica', '', 9);
                    $pdf->Cell(0, 10, 'Passport : ', 0, 2, 'L', 0, '', 0, false, '', 'M' );
                    $pdf->SetXY(25,$blockPosition+17);
                    $pdf->SetFont('helvetica', '', 13);
                    $pdf->Cell(0, 10, '  '.$request->passengerPassport[$i-1].'', 0, 2, 'L', 0, '', 0, false, '', 'M' );

                    $pdf->SetFont('helvetica', '', 10);
                    $pdf->SetXY(12,$blockPosition+22);
                    $pdf->SetFont('helvetica', '', 9);
                    $pdf->Cell(0, 10, 'Price : ', 0, 2, 'L', 0, '', 0, false, '', 'M' );
                    $pdf->SetXY(23,$blockPosition+22);
                    $pdf->SetFont('helvetica', '', 11);
                    $pdf->Cell(0, 10, ''.$passengerType.'-'.$request->departureFare.' USD ', 0, 2, 'L', 0, '', 0, false, '', 'M' );

                    $pdf->SetXY(163,$blockPosition+44);
                    $pdf->SetFont('helvetica', '', 8);
                    $pdf->Cell(0, 10, 'Price : ', 0, 2, 'L', 0, '', 0, false, '', 'M' );
                    $pdf->SetXY(172,$blockPosition+44);
                    $pdf->SetFont('helvetica', '', 8);
                    $pdf->Cell(0, 10, ''.$request->departureFare.' USD ', 0, 2, 'L', 0, '', 0, false, '', 'M' );

                    $pdf->SetFont('helvetica', 'B', 12);;
                    $pdf->SetXY(12,$blockPosition+30);
                    $pdf->Cell(0, 1, 'Boarding 30 minutes Before Departure ', 0, 2, 'L', 0, '', 0, false, '', 'M' );

                    $pdf->SetXY(12,$blockPosition+35);
                    $pdf->SetFont('helvetica', 'B', 10);
                    $pdf->Cell(0, 8, ' ** Ticket Sold Is Not Refundable', 0, 2, 'L', 0, '', 1, false, '', 'M' );

                    $pdf->SetXY(12,$blockPosition+42);
                    $pdf->SetFont('helvetica', '', 9);
                    $pdf->Cell(0, 10, 'Online Ticket Support : ', 0, 2, 'L', 0, '', 0, false, '', 'M' );
                    $pdf->SetXY(45,$blockPosition+42);
                    $pdf->SetFont('helvetica', '', 13);
                    $pdf->Cell(0, 10, '+8801754231998', 0, 2, 'L', 0, '', 0, false, '', 'M' );
               
                   
                  
                    $pdf->SetXY(90,$blockPosition+25);
                    $pdf->SetFont('helvetica', '', 8);
                    $pdf->Cell(20, 10, 'Ticket No :', 0, false, 'R', 0, '', 1, false, '', 'M' );
                    $pdf->SetXY(110,$blockPosition+25);
                    $pdf->SetFont('helvetica', '', 11);
                    $pdf->Cell(25, 10, '908', 0, 2, 'R', 0, '', 1, false, '', 'M' );
                    $pdf->SetFont('helvetica', '', 8);

                   
                    $pdf->SetXY(90, $blockPosition+31);
                    

                    $pdf->Cell(20, 10, 'Seat No:', 0, false, 'R', 0, '', 1, false, '', 'M' );
                    $pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
                    
                    $pdf->SetXY(120, $blockPosition+33);
                    $pdf->SetFont('helvetica', '', 12);
                    $pdf->Cell(15, 7, '786', 1, 2, 'R', 0, '', 0, false, '', 'M' );
                    $pdf->SetFont('helvetica', '', 8);

                    $imagePosition = $blockPosition + 8;
                
                    $pdf->Image($qrcode_file, 0, $imagePosition, 38, '', 'PNG', '', 'T', false, 10, 'R', false, false, 0,false, false, false);

                    $pdf->SetXY(155,$blockPosition+41);
                    $pdf->SetFont('helvetica', '', 8);
                    $pdf->Cell(22, 10, 'Ticket No:', 0, false, 'R', 0, '', 1, false, '', 'M' );
                    $pdf->SetFont('helvetica', '', 8);
                    $pdf->Cell(7, 10, '908', 0, 2, 'R', 0, '', 1, false, '', 'M' );
                    $pdf->SetFont('helvetica', '', 8);
                 

                    $linePositionY1 = $blockPosition + 7 ;
                    $linePositionY2 =  $blockPosition + 53 ;

                    $style = array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter',  'phase' => 10, 'color' => array(178, 190, 181));

                    $lowerlinePosition =  $blockPosition + 61;

                    $pdf->Line(150, $linePositionY1, 150,  $linePositionY2, $style);
                    $pdf->Line(10, $linePositionY1-7, 10,  $linePositionY2, $style);
                    $pdf->Line(201, $linePositionY1-7, 201,  $linePositionY2, $style);
                    $pdf->Line(10, $lowerlinePosition-5, 201, $lowerlinePosition-5, $style);
                    //$pdf->SetXY(155,$blockPosition+47);

                    $linestyle = array('width' => 0.4, 'cap' => 'butt', 'join' => 'miter',  'dash' => '4,2', 'color' => array(0,0,0));

                    $pdf->SetXY(202,$blockPosition+56);
                    $check = "$";
                    $pdf->SetFont('ZapfDingbats','', 24);
                    $pdf->Cell(10, 10, $check, 0, 0);
                    $pdf->Line(0, $lowerlinePosition, 215, $lowerlinePosition, $linestyle);

                    
                    $blockPosition+=65;
                   
                    if($i == 3)
                    {    
                        $pdf->AddPage();

                        $blockPosition = 15;
                        $flagBlock = 1;
                    }
                    else if(($i-3)%4 == 0 && $i!=18)
                    {

                        $pdf->AddPage();

                        $blockPosition = 15;
                    }   
                }
           } 

            $pdf->Output('ticket.pdf');

            //have done if both of departure & destination is selected ...but only for departure is not completed yet
            return false;
        }
        else
        {
            $flag = 1;
            return view('Customer.bookings.failurePage',compact('flag'));
        } 
    }
}
