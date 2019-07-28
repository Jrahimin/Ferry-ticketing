<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\library\CustomPdf;
use App\Model\Passenger;
use App\Model\Price;
use Illuminate\Http\Request;
use App\Model\Trip;
use Illuminate\Support\Facades\DB;

class Ticket extends Model
{
    use SoftDeletes;

    protected $table = 'tickets';
    public $fillable = ['customer_id','trip_id', 'departure_date_time', 'depart_from', 'arrive_at', 'price',
        'order_id', 'company_id', 'checked'];

    protected $dates = ['deleted_at'];

    public function order() {
        return $this->belongsTo('App\Model\Order');
    }

    public function passenger() {
        return $this->hasOne('App\Model\Passenger');
    }

    public function trip() {
        return $this->belongsTo('App\Model\Trip');
    }

    public function deleteTicket(Ticket $ticket)
    {
        $ticket->passenger()->delete();
        $ticket->delete();
    }

    public function printCompanyHead(CustomPdf $pdf, $ticketId)
    {
        $ticket = Ticket::find($ticketId);
        $company = $ticket->trip->company;

        $ldate = date('Y-m-d H:i:s');
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetTitle('Ticket');

        $pdf->AddPage();

        $image_file = url($company->image_url);
        $qrcode_file = url('/qrcode.png');

        $pdf->SetXY(26, 17);
        $pdf->SetFont('helvetica', '', 16);
        $pdf->Cell(0, 0, "$company->name", 0, 1, 'L', 0, '', 0, false, 'T', 'M' );
        $pdf->SetXY(30, 7);
        $pdf->Cell(0, 0, 'Boarding Pass', 0, 1, 'R', 0, '', 0, false, 'T', 'M' );
        $pdf->SetFont('times', '', 13);
        $pdf->SetXY(10, 25);
        $pdf->Cell(0, 1, "$company->location", 0, 1, 'L', 0, '', 0, false, 'T', 'M' );
        $pdf->Cell(0, 1, 'Ferry Port Country & Other Informations', 0, 1, 'L', 0, '', 0, false, 'T', 'M' );


        $pdf->Image($image_file, 5, 9, 15, '', 'JPG', '', 'T', false, 300, 'L', false, false, 0,false, false, false);

        $pdf->SetXY(10, 40);
        $pdf->Cell(40, 5, 'Ticketing-Office  ', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
        $pdf->Cell(30, 5, 'Head-Quarter ', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
        $pdf->Cell(30, 5, 'Kualalampur ', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
        $pdf->Cell(30, 5, 'Lankawai ', 0, 1, 'L', 0, '', 0, false, 'T', 'M' );


        $pdf->Cell(40, 5, 'Telephone-Number  ', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
        $pdf->Cell(30, 5, "$company->telephone", 0, false, 'L', 0, '', 0, false, 'T', 'M' );
        $pdf->Cell(30, 5, '4396598 ', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
        $pdf->Cell(30, 5, '43965980987 ', 0, 1, 'L', 0, '', 0, false, 'T', 'M' );


        $pdf->Cell(40, 5, 'Fax-Number', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
        $pdf->Cell(30, 5, '4396598 ', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
        $pdf->Cell(30, 5, '475894375 ', 0, false, 'L', 0, '', 0, false, 'T', 'M' );
        $pdf->Cell(30, 5, '4758943753457 ', 0, 1, 'L', 0, '', 0, false, 'T', 'M' );

        $pdf->Cell(40, 10, 'Email : example@gmail.com', 0, 1, 'L', 0, '', 0, false, 'T', 'M' );


        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->Cell(40, 1, 'Ref Id: 348734 / Sales Id : 435435', 0, 1, 'L', 0, '', 0, false, 'T', 'M' );

        $pdf->SetFont('helvetica', '', 13);

        //$pdf->Image($qrcode_file, 14, 15, 57, '', 'PNG', '', 'T', false, 20, 'R', false, false, 0,false, false, false);

        $style = array(
            'vpadding' => 'auto',
            'hpadding' => 'auto',
            'fgcolor' => array(0,0,0),
            'bgcolor' => false, //array(255,255,255)
            'module_width' => 1, // width of a single module in points
            'module_height' => 1 // height of a single module in points
        );

        $pdf->write2DBarcode($ticket->order->id, 'QRCODE,H', 150, 20, 45, 60, $style, 'N');

        $pdf->SetXY(5, 35);
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(130, 55, 'Printed On: '.$ldate.' ', 0, false, 'R', 0, '', 0, false, 'T', 'M' );

        return $pdf;

    }

    public function printPassengers(CustomPdf $pdf, $ticketId, $add, $page, $i)
    {
        $ticket = Ticket::find($ticketId);
        $trip = $ticket->trip;
        $departurePort = $trip->departure_port->name;
        $destinationPort = $trip->destination_port->name;

        $journey = $departurePort.' >> '.$destinationPort;
        $price = $ticket->price;
        $passengerType = $ticket->passenger->type->name;

        if($page!==1)
        {
            $blockPosition = 79+$add;

            $linestyle = array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => '4,2', 'color' => array(0, 0, 0));
            //$pdf->Ln(2);
            $pdf->Line(0, 75, 210,75, $linestyle);
            //$pdf->Ln(1);
            $pdf->SetFont('helvetica', '', 12);
            //$pdf->Cell(100, 'Journey:');
        }
        else
        {
            $blockPosition = 15+$add;
            $linestyle = array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => '4,2', 'color' => array(0, 0, 0));
            //$pdf->Ln(2);
            $pdf->Line(0, 10, 210,10, $linestyle);
            //$pdf->Ln(1);
            $pdf->SetFont('helvetica', '', 12);
            //$pdf->Cell(100, 'Journey:');
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

        $tripDepartureJourneyDepartureDate = date("d M Y, g:i A", strtotime($ticket->departure_date_time));
        $pdf->SetFont('helvetica', '', 9);
        $pdf->Cell(0, 10, 'Date :  ', 0, 2, 'L', 0, '', 0, false, '', 'M' );
        $pdf->SetXY(20,$blockPosition+7);
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(0, 10, ''.$tripDepartureJourneyDepartureDate, 0, 2, 'L', 0, '', 0, false, '', 'M' );

        $pdf->SetXY(12,$blockPosition+12);
        $pdf->SetFont('helvetica', '', 9);
        $pdf->Cell(0, 10, 'Passenger Name :  ', 0, 2, 'L', 0, '', 0, false, '', 'M' );
        $pdf->SetXY(37,$blockPosition+12);
        $pdf->SetFont('helvetica', '', 13);
        $pdf->Cell(0, 10, '  '.$ticket->passenger->name.'', 0, 2, 'L', 0, '', 0, false, '', 'M' );

        $pdf->SetXY(12,$blockPosition+17);
        $pdf->SetFont('helvetica', '', 9);
        $pdf->Cell(0, 10, 'Passport : ', 0, 2, 'L', 0, '', 0, false, '', 'M' );
        $pdf->SetXY(25,$blockPosition+17);
        $pdf->SetFont('helvetica', '', 13);
        //Passenger Name
        $pdf->Cell(0, 10, '  '.$ticket->passenger->passport_no.'', 0, 2, 'L', 0, '', 0, false, '', 'M' );
        $pdf->SetFont('helvetica', '', 10);
        $pdf->SetXY(12,$blockPosition+22);
        $pdf->SetFont('helvetica', '', 9);
        $pdf->Cell(0, 10, 'Price : ', 0, 2, 'L', 0, '', 0, false, '', 'M' );
        $pdf->SetXY(23,$blockPosition+22);
        $pdf->SetFont('helvetica', '', 11);

        //Passenger Type & price
        $pdf->Cell(0, 10, ''.$passengerType.'- '.$price.' USD ', 0, 2, 'L', 0, '', 0, false, '', 'M' );

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
        $pdf->Cell(25, 10, $ticket->id, 0, 2, 'R', 0, '', 1, false, '', 'M' );
        $pdf->SetFont('helvetica', '', 8);

        $pdf->SetXY(90, $blockPosition+31);

        $pdf->Cell(20, 10, 'Seat No:', 0, false, 'R', 0, '', 1, false, '', 'M' );
        $pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));

        $pdf->SetXY(120, $blockPosition+33);
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(15, 7, '786', 1, 2, 'R', 0, '', 0, false, '', 'M' );
        $pdf->SetFont('helvetica', '', 8);

        $imagePosition = $blockPosition + 8;

        //$pdf->Image($qrcode_file, 0, $imagePosition, 38, '', 'PNG', '', 'T', false, 10, 'R', false, false, 0,false, false, false);

        // set style for Qrcode
        $style = array(
            'vpadding' => 'auto',
            'hpadding' => 'auto',
            'fgcolor' => array(0,0,0),
            'bgcolor' => false, //array(255,255,255)
            'module_width' => 1, // width of a single module in points
            'module_height' => 1 // height of a single module in points
        );

        $pdf->write2DBarcode($ticket->passenger->code, 'QRCODE,H', 150, $imagePosition-3, 45, 43, $style, 'N');
        //$pdf->Text(20, 145, 'QRCODE Q');

        $pdf->SetXY(155,$blockPosition+41);
        $pdf->SetFont('helvetica', '', 8);
        $pdf->Cell(22, 10, 'Ticket No:', 0, false, 'R', 0, '', 1, false, '', 'M' );
        $pdf->SetFont('helvetica', '', 8);
        $pdf->Cell(7, 10, $ticket->id, 0, 2, 'R', 0, '', 1, false, '', 'M' );
        $pdf->SetFont('helvetica', '', 8);


        $linePositionY1 = $blockPosition + 7 ;
        $linePositionY2 =  $blockPosition + 53 ;

        $style = array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter',  'phase' => 10, 'color' => array(178, 190, 181));

        $lowerlinePosition =  $blockPosition + 61;

        $pdf->Line(150, $linePositionY1, 150,  $linePositionY2, $style);
        $pdf->Line(10, $linePositionY1-7, 10,  $linePositionY2, $style);
        $pdf->Line(201, $linePositionY1-7, 201,  $linePositionY2, $style);
        $pdf->Line(10, $lowerlinePosition-5, 201, $lowerlinePosition-5, $style);

        $linestyle = array('width' => 0.4, 'cap' => 'butt', 'join' => 'miter',  'dash' => '4,2', 'color' => array(0,0,0));

        //paper cut
        $pdf->SetXY(201,$blockPosition+55.6);
        $check = "$";
        $pdf->SetFont('ZapfDingbats','', 24);
        $pdf->Cell(10, 10, $check, 0, 0);
        $pdf->Line(0, $lowerlinePosition, 215, $lowerlinePosition, $linestyle);

        $pdf->SetXY(10,$blockPosition);

        return $pdf;
    }
}
