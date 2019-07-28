@extends('Customer.layouts.app')



@section('content')
	
	<form class="form-horizontal" role="form" id="ticketPrint" method="POST" action="{{ route('ticketPrint') }}">
        {{ csrf_field() }}
	 	<div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" id="submit" class="btn btn-primary">
                    Print Ticket
                </button>
            </div>
        </div>
        <input type="hidden" name="keyValue" value="{{$data}}">
        <input type="hidden" name="maximumPassenger" value="{{$maximumPassenger}}">
       
        @foreach($name as $aName)
        	<input type="hidden" name="passengerName[]" value="{{$aName}}">
        @endforeach

        @foreach($passport as $aPassport)
        	<input type="hidden" name="passengerPassport[]" value="{{$aPassport}}">
        @endforeach

        <input type="hidden" name="departureFare" value="{{$departureFare}}">
    </form>

@endsection