<?php

namespace App\Http\Controllers;

use App\Enumeration\RoleType;
use App\Model\Order;
use App\Model\Port;
use App\Model\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketObserveController extends Controller
{
    public function getAllTicket(Request $request)
    {
        $ports = Port::all();

        $parameters = [];
        $date_parameters = [];
        $appends = [];

        if ($request->departure_port_id){
            $parameters[] = array('depart_from', $request->departure_port_id);
            $appends['departure_port_id'] = $request->departure_port_id;
        }

        if ($request->destination_port_id){
            $parameters[] = array('arrive_at', $request->destination_port_id);
            $appends['destination_port_id'] = $request->destination_port_id;
        }

        if ($request->start_date){
            $parameters[] = array('departure_date', '>=', $request->start_date);
            $appends['start_date'] = $request->start_date;
        }

        if ($request->end_date){
            $parameters[] = array('departure_date', '<=', $request->end_date);
            $appends['end_date'] = $request->end_date;
        }

        if (Auth::user()->role == RoleType::$COMPANY_USER) {
            $parameters[] = array('company_id', Auth::user()->company_id);
        }

        $tickets = Ticket::where($parameters)->paginate(10);


        return view('ticket.show_all', compact('tickets', 'ports', 'appends', 'parameters'));
    }

    public function delete(Request $request)
    {
        $ticket = Ticket::find($request->id);

        if (!$ticket) {
            return response()->json(['success' => false, 'message' => 'Item not found.']);
        }

        if (Auth::user()->role == RoleType::$COMPANY_USER) {
            if (Auth::user()->company_id !== $ticket->company_id) {
                return response()->json(['success' => false, 'message' => 'Unauthorized']);
            }
        }

        $ticket->deleteTicket($ticket);
        return response()->json(['success' => true, 'message' => 'Successfully Deleted.']);
    }

    public function viewOrder(Request $request)
    {
        $ticket = Ticket::find($request->ticket);
        return view('ticket.view_order', compact('ticket'));
    }

    public function getTicketForOrder($orderId)
    {
        $order = Order::find($orderId);
        $return_trip = $order->trip_type;
        $tickets = Ticket::where('order_id', $orderId)->get();
        $count = $tickets->count();
        $ticketDepart = $tickets->first();
        $ticketReturn = $tickets->last();

        $departPrice = 0;
        $returnPrice = 0;

        foreach($tickets as $ticket)
        {
            if($ticket->trip_id === $ticketDepart->trip_id){
                $departPrice = $departPrice + $ticket->price;
            }
            else {
                $returnPrice = $returnPrice + $ticket->price;
            }
        }

        $totalPrice = $departPrice + $returnPrice;

        if($return_trip == 2)
        {
            $count = $count/2;
        }


        return view('order.view_ticket_for_order', compact('tickets', 'ticketDepart', 'ticketReturn', 'order', 'return_trip', 'count', 'departPrice', 'returnPrice', 'totalPrice'));
    }
}
