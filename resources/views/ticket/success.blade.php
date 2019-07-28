@extends('.layouts.app')

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
        <input type="hidden" name="maximumPassenger" value="{{$count}}">

        <input type="hidden" name="ifRound" value="1">
        @foreach($tickets as $oneTicket)
            <input type="hidden" name="ticketIds[]" value="{{$oneTicket->id}}">
            <input type="hidden" name="passengerNames[]" value="{{$oneTicket->passenger->name}}">
            <input type="hidden" name="passengerTypeIds[]" value="{{$oneTicket->passenger->type_id}}">
            <input type="hidden" name="passengerTypes[]" value="{{$oneTicket->passenger->type->name}}">
            <input type="hidden" name="passengerPassports[]" value="{{$oneTicket->passenger->passport_no}}">
        @endforeach

        @if(!empty($ticketRounds))
            <input type="hidden" name="ifRound" value="2">

            @foreach($ticketRounds as $oneTicketRound)
                <input type="hidden" name="ticketRoundIds[]" value="{{$oneTicketRound->id}}">
                <input type="hidden" name="passengerRoundNames[]" value="{{$oneTicketRound->passenger->name}}">
                <input type="hidden" name="passengerRoundTypeIds[]" value="{{$oneTicketRound->passenger->type_id}}">
                <input type="hidden" name="passengerRoundTypes[]" value="{{$oneTicketRound->passenger->type->name}}">
                <input type="hidden" name="passengerRoundPassports[]" value="{{$oneTicketRound->passenger->passport_no}}">
            @endforeach
        @endif

        <input type="hidden" name="departureFare" value="{{$tickets->first()->depart_from}}">
        <input type="hidden" name="arriveFare" value="{{$tickets->first()->arrive_at}}">
        <input type="hidden" name="ferry" value="{{$tickets->first()->trip->ferry->name}}">
        <input type="hidden" name="departureDate" value="{{$tickets->first()->trip->ferry->name}}">
        <input type="hidden" name="departureTime" value="{{$tickets->first()->trip->ferry->name}}">
    </form>

@endsection