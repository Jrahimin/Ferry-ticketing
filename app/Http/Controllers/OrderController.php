<?php

namespace App\Http\Controllers;

use App\Enumeration\RoleType;
use App\library\CustomPdf;
use App\Model\Order;
use App\Model\Port;
use App\Model\Ticket;
use App\Model\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function allOrder(Request $request)
    {
        $trips = Trip::orderBy('id', 'desc')->get();
        $ports = Port::all();
        $parameters = [];
        $trip_date_parameters = [];
        $trip_parameters = [];
        $appends = [];

        if ($request->order_id){
            $appends['order_id'] = $request->order_id;

            $orders = Order::where('id', $request->order_id);
            return view('order.all', compact('orders', 'ports', 'appends', 'parameters', 'trips'));
        }

        if ($request->trip_id){
            $appends['trip_id'] = $request->trip_id;

            $orders = Order::where('departure_trip_id', $request->trip_id)->orWhere('return_trip_id', $request->trip_id)->paginate(10);
            return view('order.all', compact('orders', 'ports', 'appends', 'parameters', 'trips'));
        }

        if ($request->start_date){
            $parameters[] = array('created_at', '>=', $request->start_date);
            $appends['start_date'] = $request->start_date;
        }

        if ($request->end_date){
            $parameters[] = array('created_at', '<=', $request->end_date);
            $appends['end_date'] = $request->end_date;
        }

        if ($request->start_date_trip){
            $trip_date_parameters[] = array('departure_date_time', '>=', $request->start_date_trip.' '.'00:00;00');
            $appends['start_date_trip'] = $request->start_date_trip;
        }

        if ($request->end_date_trip){
            $trip_date_parameters[] = array('departure_date_time', '<=', $request->end_date_trip.' '.'25:00;00');
            $appends['end_date_trip'] = $request->end_date_trip;
        }

        if ($request->departure_port_id){
            $trip_parameters[] = array('departure_port_id', $request->departure_port_id);
            $appends['departure_port_id'] = $request->departure_port_id;
        }

        if ($request->destination_port_id){
            $trip_parameters[] = array('destination_port_id', $request->destination_port_id);
            $appends['destination_port_id'] = $request->destination_port_id;
        }

        if (Auth::user()->role == RoleType::$COMPANY_USER) {
            $parameters[] = array('company_id', Auth::user()->company_id);
        }


        if ($request->start_date_trip || $request->end_date_trip || $request->departure_port_id || $request->destination_port_id)
        {
            $trips = Trip::where($trip_parameters)->where($trip_date_parameters)->get();

            $departureOrders = collect([]);
            foreach($trips as $trip)
            {
                $departures = Order::where('departure_trip_id', $trip->id)
                    ->orWhere('return_trip_id', $trip->id)->get();

                foreach($departures as $departure){
                    $departureOrders->push($departure);
                }
            }

            $departureOrders = $departureOrders->unique('id');

            $orders = $departureOrders->sortByDesc('id');
            return view('order.all', compact('orders', 'ports', 'appends', 'parameters', 'trips'));
        }


        $orders = Order::where($parameters)->paginate(10);

        return view('order.all', compact('orders', 'ports', 'appends', 'parameters', 'trips'));
    }

    public function delete(Request $request)
    {
        $order = Order::find($request->id);

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Item not found.']);
        }

        $order->deleteOrder($order);

        return response()->json(['success' => true, 'message' => 'Successfully Deleted.']);
    }

    public function viewOrder(Request $request)
    {
        $ticket = Ticket::find($request->ticket);
        return view('ticket.view_order', compact('ticket'));
    }

    public function orderPrint($orderId)
    {
        $order = Order::find($orderId);
        $tickets = collect([]);
        $roundTickets = collect([]);

        foreach($order->tickets as $oneTicket)
        {
            if($oneTicket->trip_id == $order->tickets->first()->trip_id)
            {
                $tickets->push($oneTicket);
            }
            else
            {
                $roundTickets->push($oneTicket);
            }
        }

        $ifRound = $order->trip_type;
        $count = $order->tickets();
        $count = $count->count();
        if($ifRound == 2)
        {
            $count = $count/2;
        }

        //Generating Tickets for one way...
        $ticketId = $tickets->first()->id;
        $pdf = new CustomPdf();
        $ticketCompany = new Ticket();
        $ticketCompany->printCompanyHead($pdf, $ticketId);

        //Generating Passengers for one way...
        $add = 0;
        $page = 0;
        for($i =0; $i<$count; $i++)
        {
            $ticketId = $tickets[$i]['id'];
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
            $ticketRoundId = $roundTickets->first()->id;
            $printReturnCompany = new Ticket();
            $printReturnCompany->printCompanyHead($pdf, $ticketRoundId);

            //Generating Passengers for round way...
            $add = 0;
            $page = 0;
            for($i =0; $i<$count; $i++)
            {
                $ticketRoundId = $roundTickets[$i]['id'];
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

    public function viewTripOrder($tripId)
    {
        $orders = Order::where('departure_trip_id', $tripId)->orWhere('return_trip_id', $tripId)->paginate(10);
        return view('trip.view_order_for_trip', compact('orders'));
    }
}
