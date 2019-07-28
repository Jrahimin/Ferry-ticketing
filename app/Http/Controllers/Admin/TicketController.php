<?php

namespace App\Some\Somenamespace;
namespace App\Http\Controllers\Admin;

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

class TicketController extends Controller
{
    public function ViewAllTicketTrip(Request $request)
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
 		return view('FerryAdmin.ticket.tripTicket', $data)->with('trips',$tripsInfo)->with('ports',$ports)->with('ferries',$ferries);
 		//return view('trip/allTrip', compact('data', 'trips','ports','ferry'));

 	}

    public function AllTicketOrderTrip(Request $request ,$tripId)
    {
        dd($tripId);

        $tripDepartureJourneyPortId = Trip::select('departure_port_id','destination_port_id','departure_date','departure_time')->where('id',$departureTripId)->first();
        $tripDepartureJourneyDeparturePortName = Port::select('name')->where('id',$tripDepartureJourneyPortId->departure_port_id)->first();
        $tripDepartureJourneyDestinationPortName = Port::select('name')->where('id',$tripDepartureJourneyPortId->destination_port_id)->first();
        $tripDepartureJourneyDepartureDate = $tripDepartureJourneyPortId->departure_date;
        $tripDepartureJourneyDepartureTime = $tripDepartureJourneyPortId->departure_time;


        $tripDepartureJourneyDeparturePortName=$tripDepartureJourneyDeparturePortName->name;
        $tripDepartureJourneyDestinationPortName= $tripDepartureJourneyDestinationPortName->name;

        $journey = $tripDepartureJourneyDeparturePortName .' >> '.$tripDepartureJourneyDestinationPortName;

        $uuidNumber = Uuid::generate(4);
        $randomKey = $uuidNumber->string;


        $renderer = new \BaconQrCode\Renderer\Image\Png();
        $renderer->setHeight(256);
        $renderer->setWidth(256);
        $renderer->setMargin(1);
        $writer = new \BaconQrCode\Writer($renderer);

        $writer->writeFile($randomKey.$request->departureTripId, 'qrcode.png');

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
    } 
        
}
