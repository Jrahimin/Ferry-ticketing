<?php

namespace App\Model;

use App\Model\Ticket;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $table = 'orders';
    public $fillable = ['email','contact_no','trip_type','departure_trip_id','return_trip_id','departure_port_id','destination_port_id'];
    protected $dates = ['deleted_at'];

    public function tickets(){
        return $this->hasMany('App\Model\Ticket');
    }

    public function departure_trip(){
        return $this->belongsTo('App\Model\Trip');
    }

    public function destination_trip(){
        return $this->belongsTo('App\Model\Trip');
    }

    public function deleteOrder(Order $order)
    {
        $tickets = $order->tickets;

        foreach($tickets as $ticket)
        {
            $ticket->deleteTicket($ticket);
        }

        $order->delete();
    }
}
