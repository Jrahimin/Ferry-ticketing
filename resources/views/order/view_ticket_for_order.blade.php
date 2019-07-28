@extends('layouts.app')

@section('additionalCSS')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}">
@stop

@section('content')
    <div class="container">
        <form class="form-horizontal" id="ticketForm" method="POST" action="{{ route('ticketStore') }}">
            {{ csrf_field() }}

            <div class="col-md-8">
                <h4>Ticket Collector Info</h4>
                <hr>

                <div class="form-group">
                    <label for="email" class="col-md-4 control-label">Email: {{$order->email}}</label>
                </div>

                <div class="form-group">
                    <label for="contact_no" class="col-md-4 control-label">Contact No: {{$order->contact_no}}</label>
                </div>

                <?php
                    $number = 0;
                ?>
                @foreach($tickets as $ticket)

                    <h4>Passenger Information <?php echo ++$number; ?></h4>
                    <hr>

                    <div class="form-group">
                        <div class="col-md-6">
                            <label class="col-md-8 control-label">Full Name: {{ $ticket->passenger->name  }}</label>
                        </div>

                        <div class="col-md-6">
                            <label class="col-md-8 control-label">Gender: {{ $ticket->passenger->gender }}</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6">
                            <label class="col-md-8 control-label">Date of Birth: {{ $ticket->passenger->dob }}</label>
                        </div>
                    </div>

                    <div class="form-group">

                        <div class="col-md-6">
                            <label class="col-md-8 control-label">Passport No: {{ $ticket->passenger->passport_no }}</label>
                        </div>

                        <div class="col-md-6">
                            <label class="col-md-8 control-label">Passport Exp:{{ $ticket->passenger->passport_exp }}</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6">
                            <label class="col-md-8 control-label">Nationality: {{ $ticket->passenger->nationality }}</label>
                        </div>

                        <div class="col-md-6">
                            <label class="col-md-8 control-label">Passenger Type: {{ $ticket->passenger->type->name }}</label>
                        </div>

                    </div>

                    @if($count === $number)
                        <?php break; ?>
                    @endif
                @endforeach

            </div>

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Departing Info</h3>
                    </div>
                    <div class="panel-body">
                        <h4>Departure Date:</h4>
                        <p>{{ $ticketDepart->departure_date }}</p>

                        <h4>Depart From:</h4>
                        <p>{{ $ticketDepart->trip->departure_port->name }}</p>

                        <h4>Arrive At:</h4>
                        <p>{{ $ticketDepart->trip->destination_port->name }}</p>

                        <h4>Ferry:</h4>
                        <p>{{ $ticketDepart->trip->ferry->name }}</p>

                        <h4>Number of Seats:</h4>
                        <p>{{$count}}</p>

                        <h4>Ticket Price:</h4>
                        <p>
                            @foreach($ticketDepart->trip->prices as $price)
                                {{ $price->passenger_type->name }} {{$price->price}}<br/>
                            @endforeach
                        </p>

                    </div>
                </div>

                @if ($return_trip == 2)

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Return Info</h3>
                        </div>
                        <div class="panel-body">
                            <h4>Departure Date:</h4>
                            <p>{{ $ticketReturn->departure_date }}</p>

                            <h4>Depart From:</h4>
                            <p>{{ $ticketReturn->trip->departure_port->name }}</p>

                            <h4>Arrive At:</h4>
                            <p>{{ $ticketReturn->trip->destination_port->name }}</p>

                            <h4>Ferry:</h4>
                            <p>{{ $ticketReturn->trip->ferry->name }}</p>

                            <h4>Number of Seats:</h4>
                            <p>{{$count}}</p>

                            <h4>Ticket Price:</h4>
                            <p>
                                @foreach($ticketReturn->trip->prices as $price)
                                    {{ $price->passenger_type->name }} {{$price->price}}<br/>
                                @endforeach
                            </p>

                        </div>
                    </div>
                @endif

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Payment Info</h3>
                    </div>
                    <div class="panel-body">
                        <table style="width: 100%">
                            <tr>
                                <td>Depart Journey Fare:</td>
                                <td class="text-right"><span id="depart_fare">{{ $departPrice }}</span></td>

                            </tr>

                            <tr>
                                <td>Return Journey Fare:</td>
                                <td class="text-right"><span id="return_fare">{{ $returnPrice }}</span></td>

                            </tr>
                        </table>

                        <hr>

                        <div class="row">
                            <div class="col-md-8">
                                <h4>Total</h4>
                            </div>

                            <div class="col-md-4">
                                {{ $totalPrice }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
@stop
