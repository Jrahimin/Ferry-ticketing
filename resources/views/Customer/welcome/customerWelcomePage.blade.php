<?php
    use Carbon\Carbon;
    //use DateTime;
    //use Exception;
    //session()->flush();
?>

@extends('Customer.layouts.app')


@section('additionalCSS')
    
    <link rel="stylesheet" href="{{url('css/bootstrap-datepicker.min.css')}}">
    <link rel="stylesheet" href="{{url('css/wickedpicker.css')}}">
    <link rel="stylesheet" href="{{url('css/wickedpicker.min.css')}}">
    <link rel="stylesheet" href="{{url('datepicker/css/bootstrap-datetimepicker.min.css')}}">
@endsection

@section('content')
    <div class="container"> 
        <div class="row">
            <div class="col-md-12"> 
                <form  class="form-horizontal" role="form" action="{{route('customerWelcome')}}" method="GET">
                    <div >
                        <div class="radio">

                          <label>
                            <input type="radio" id="oneWay" name="tour_type" value="0">
                                One Way
                          </label>
                          <input type="hidden" id="searchWay"  value="{{$searchWay}}">
                          <label>
                            <input type="radio" name="tour_type" value="1"  id="roundWay" checked>
                                Round Trip
                          </label>
                        </div>
                    </div>
                    <br>
                    <div >
                        <div class="col-md-2">   
                            <select name="ferryId" class="form-control" id="dropdownId" >
                                    <option value=""> Ferry Name </option>
                                @foreach($ferries as $ferry)
                                    <option value="{{ $ferry->id }}" {{ (isset($appends['ferry_id']) && $appends['ferry_id'] == $ferry->id) ? 'selected' : '' }}>{{ $ferry->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">   
                            <select name="departurePort" class="form-control" id="dropdownId" >
                                    <option value=""> Source Port </option>
                                @foreach($ports as $port)
                                    <option value="{{ $port->id }}" {{ (isset($appends['departure_port_id']) && $appends['departure_port_id'] == $port->id) ? 'selected' : '' }}>{{ $port->name }}</option>
                                @endforeach
                            </select>
                        </div>

                         <div class="col-md-2">   
                            <select name="destinationPort" class="form-control" id="dropdownId" >
                                    <option  value="">Destination Port</option>
                                @foreach($ports as $port)
                                    <option value="{{$port->id}}" {{ (isset($appends['destination_port_id']) && $appends['destination_port_id'] == $port->id) ? 'selected' : '' }} >{{ $port->name }} 
                                    </option>
                                @endforeach
                            </select>
                        </div> 

                        <div class="col-md-2">   
                            <input type="text" class="form-control" name="start_date" placeholder="Departure Date"  value="{{ isset($start_date) ? $start_date : '' }}"  id='datepicker1'> 
                        </div> 
                        <div class="col-md-2">  
                            <input type="text" class="form-control" name="end_date" placeholder="Return Date"  value="{{ isset($end_date) ? $end_date : '' }}" id='datepicker2'>  
                           
                        </div>
                        <div class="col-md-1">   
                            <select name="seatNumber" class="form-control" id="dropdownId" >
                                    <option value="1"> 1 </option>
                                    <option value="2"> 2 </option>
                                    <option value="3"> 3 </option>
                                    <option value="4"> 4 </option>
                                    <option value="5"> 5 </option>
                                    <option value="6"> 6 </option>
                                    <option value="7"> 7 </option>
                                    <option value="8"> 8 </option>
                                    <option value="9"> 9 </option>
                                    <option value="10"> 10 </option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"> Submit </button>
                </form>
              <br>

              @if($searchExceptDate == 0)
                <table class="table table-stripe table-hover">
                    <thead>
                        <tr>
                            <th>Trip Number</th>
                            <th>Ferry Name</th>
                            <th>Ferry Seat</th>
                            <th>Departure Port</th>
                            <th>Destination Port</th>
                            <th>Departure Date</th>
                            <th>Departure Time</th>
                            <th>Action</th>
                                             
                        </tr>
                    </thead>

                    <tbody>
                       @foreach($trips as $trip)
                            <tr>
                                <td>{{ $trip->id }}</td>
                                <td>{{ $trip->ferry->name }}</td>
                                <td>{{ $trip->ferry_remaining_seat }}</td>
                                <td>{{ $trip->departure_port->name }} </td>
                                <td>{{ $trip->destination_port->name }} </td>
                                <td>{{ $trip->departure_date }} </td>
                                <td>{{ $trip->departure_time}} </td>
                                <td>
                                    <input type="hidden" name="tripHidden" value="0">
                                    <button class="btn btn-raised btn-success selectSeat" data-id-whole="{{$trip->id}}" href="#" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-btn fa-submit"></i>Select Seat </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table> 
              @endif

              @if($searchExceptDate == 1)
                <strong> Departure Trip </strong>  

                <table class="table table-stripe table-hover">
                    <thead>
                        <tr>
                            <th>Trip Number</th>
                            <th>Ferry Name</th>
                            <th>Ferry Seat</th>
                            <th>Departure Port</th>
                            <th>Destination Port</th>
                            <th>Departure Date</th>
                            <th>Departure Time</th>
                            <th>Action</th>                    
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($trips as $trip)
                            <?php  
                                $departure_convert_date = DateTime::createFromFormat('Y-m-d', $trip->departure_date);//'m/d/Y'
                                $departure_convert_date = $departure_convert_date->format('m/d/Y');//'Y-m-d'
                                  //dd($departure_convert_date,$start_date ,$end_date)  
                            ?>

                            @if($departure_convert_date == $start_date)
                                <tr>
                                    <td>{{ $trip->id }}</td>
                                    <td>{{ $trip->ferry->name }}</td>
                                    <td>{{ $trip->ferry_remaining_seat }}</td>
                                    <td>{{ $trip->departure_port->name }} </td>
                                    <td>{{ $trip->destination_port->name }} </td>
                                    <td>{{ $trip->departure_date }} </td>
                                    <td>{{ $trip->departure_time}} </td>
                                    <td>
                                        <input type="hidden" name="tripHidden" value="0">
                                        <button class="btn btn-raised btn-success selectSeatDeparture" data-id-depart="{{$trip->id}}" href="#" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-btn fa-submit"></i>Select Seat </button>
                                        <input type="hidden" class="remainingSeatInDeparture" value="{{$trip->ferry_remaining_seat}}">
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>

                @if($searchWay == 1)
                <strong>Return Trip </strong>

                <table class="table table-stripe table-hover">
                    <thead>
                        <tr>
                            <th>Trip Number</th>
                            <th>Ferry Name</th>
                            <th>Ferry Seat</th>
                            <th>Departure Port</th>
                            <th>Destination Port</th>
                            <th>Departure Date</th>
                            <th>Departure Time</th>
                            <th>Action</th>                    
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($trips as $trip)
                            <?php  
                                $departure_convert_date = DateTime::createFromFormat('Y-m-d', $trip->departure_date);//'m/d/Y'
                                $departure_convert_date = $departure_convert_date->format('m/d/Y');//'Y-m-d'
                                  //dd($departure_convert_date,$start_date ,$end_date)  
                            ?>

                            @if($departure_convert_date == $end_date)
                                <tr>
                                    <td>{{ $trip->id }}</td>
                                    <td>{{ $trip->ferry->name }}</td>
                                    <td>{{ $trip->ferry_remaining_seat }}</td>
                                    <td>{{ $trip->departure_port->name }} </td>
                                    <td>{{ $trip->destination_port->name }} </td>
                                    <td>{{ $trip->departure_date }} </td>
                                    <td>{{ $trip->departure_time}} </td>
                                    <td>
                                        <input type="hidden" name="tripHidden" value="0">
                                        <button class="btn btn-raised btn-success selectSeatDestination" data-id-destination="{{$trip->id}}" href="#" data-toggle="modal" data-target="#deleteModalDestination"><i class="fa fa-btn fa-submit"></i>Select Seat </button>
                                        <input type="hidden" class="remainingSeatInDestination" value="{{$trip->ferry_remaining_seat}}">
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                @endif
                    
            @endif
               <center> {{ $trips->appends($appends)->links() }} </center>
            </div>
        </div>    
    </div> 

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Select Seat Departure</h4>
      </div>
      <div class="modal-body">
        <p>Select Seat Number  </p>
        <div class="col-md-4"> 
            <select class="form-control" id="selectedSeatDeparture">
                <option value="0">0 </option>
                <option value="1">1 </option>
                <option value="2">2 </option>
                <option value="3">3 </option>
                <option value="4">4 </option>
                <option value="5">5 </option>
                <option value="6">6 </option>
                <option value="7">7 </option>
                <option value="8">8 </option>
                <option value="9">9 </option>
                <option value="10">10</option>
            </select>
        </div>    
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-raised btn-default" data-dismiss="modal" id="btnCancelDeparture">Cancel</button>
        <button id="btnSeatSelect" type="button" class="btn btn-raised btn-primary">Continue</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->       



<div class="modal fade" id="deleteModalDestination" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Select Seat Destination</h4>
      </div>
      <div class="modal-body">
        <p>Select Seat Number </p>
        <div class="col-md-4"> 
            <select class="form-control" id="selectSeatDestination">
                <option value="0">0 </option>
                <option value="1">1 </option>
                <option value="2">2 </option>
                <option value="3">3 </option>
                <option value="4">4 </option>
                <option value="5">5 </option>
                <option value="6">6 </option>
                <option value="7">7 </option>
                <option value="8">8 </option>
                <option value="9">9 </option>
                <option value="10">10 </option>
            </select>
        </div>    
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-raised btn-default" id="btnCancelDestination" data-dismiss="modal">Cancel</button>
        <button id="btnSeatSelectDestination" type="button" class="btn btn-raised btn-primary">Continue</button>
        <a href="#top" class="btn btn-primary btn-sm active" role="button">Go Destination Trip</a>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->       


                            
@endsection

@section('additionalJS')
    <script type="text/javascript" src="{{url('js/moment.js')}}"></script>
    <script type="text/javascript" src="{{url('js/bootstrap-datepicker.min.js')}}"></script>
    <script type="text/javascript" src="{{url('js/wickedpicker.js')}}"></script>
    <script type="text/javascript" src="{{url('datepicker/js/bootstrap-datetimepicker.min.js')}}"></script>

    <script type="text/javascript">
        $(function () {
            $('#datepicker1').datepicker({
                // startDate:'0d'
            });

            $('#datepicker1').change(function() {
                //var dateValue = $(this).val(); 
                //console.log(dateValue);

            });
            $('#datepicker2').datepicker({
                // startDate:'0d'
            });

            $('#datepicker2').change(function() {
                //var dateValue = $(this).val(); 
                //console.log(dateValue);

            });

         });   
    </script>
    <script type="text/javascript">
        $(function () {
            var searchWay = $('#searchWay').val();
            if(searchWay == 0)
            {
                $("#datepicker2").hide();
                $("#oneWay").attr('checked', 'checked');
            }

            $('#oneWay').change(function() {
                $("#datepicker2").hide();  
            });

            $('#roundWay').change(function() {
                $("#datepicker2").show();
                    
            });

        });    
    </script>


    <script type="text/javascript">

        $("a[href='#top']").click(function() {
            $("html, body").animate({ scrollTop: 0 }, "slow");
            $('#deleteModalDestination').modal('toggle');
            return false;
        });
        
        $( document ).ready(function(){
            var departureSelected = 1;
            var dataDestination = 1;
            var tripIdDeparture ;
            var tripIdDestination ;
            var remainInDepart ;
            var selectedValueDeparture;
            var selectedValueDestination;
            var searchWay = $('#searchWay').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': '{!! csrf_token() !!}'
                            }
                });

            $('.selectSeatDeparture').click(function()
            {
                departureSelected = 0;
                tripIdDeparture = $(this).data('id-depart');
                remainInDepart = $(this).closest('tr').find('.remainingSeatInDeparture').val();
                // console.log(remainInDepart);

                $("#btnSeatSelect").attr("data-id-depart", tripIdDeparture);
            });    
            $('.selectSeatDestination').click(function()
            {
                
                tripIdDestination = $(this).data('id-destination');
                remainInDestination = $(this).closest('tr').find('.remainingSeatInDestination').val();
                console.log(tripIdDestination);
                $("#btnSeatSelectDestination").attr("data-id-destination", tripIdDestination);
            });

            
            $('#btnCancelDeparture').click(function()
            {
                $('#deleteModal').modal('toggle');
            });

            $('#btnSeatSelect').click(function(event)
            {
                selectedValueDeparture = $("#selectedSeatDeparture option:selected").val();

                if(remainInDepart <= selectedValueDeparture)
                {
                    alert("Seat Unavaialable !!!");
                    event.preventDefault();
                    return ;
                }

                //console.log();

                if(searchWay == 0)
                {
                    //console.log("ok");
                     $.ajax({
                        method: "POST",
                        url: "{{route('insertBookings')}}",
                        data: { idDeparture: tripIdDeparture , seatBookedDeparture: selectedValueDeparture}
                    }).done(function( msg )
                    {
                        $('#deleteModal').modal('toggle');
                        window.location.href = "{{route('passengerDetails')}}";
                    });
                }
                $('#deleteModal').modal('toggle');
            });


            $('#btnCancelDestination').click(function()
            {
                $('#deleteModalDestination').modal('toggle');
            });

            $('#btnSeatSelectDestination').click(function(event)
            {
                selectedValueDestination = $("#selectSeatDestination option:selected").val();

                if(remainInDestination <= selectedValueDestination)
                {
                    alert("Seat Unavaialable !!!");
                    event.preventDefault();
                    return ;
                }

                if(departureSelected==1)
                {
                    
                    alert("Select Destination Seat First ");
                    event.preventDefault();
                    return;
                }

                

                console.log(searchWay,tripIdDeparture,selectedValueDeparture,tripIdDestination,selectedValueDestination); 

                $.ajax({
                        method: "POST",
                        url: "{{route('insertBookings')}}",
                        data: { idDeparture: tripIdDeparture , seatBookedDeparture: selectedValueDeparture , idDestination: tripIdDestination, seatBookedDestination: selectedValueDestination}
                    }).done(function( msg )
                    {
                        $('#deleteModalDestination').modal('toggle');
                        window.location.href =  "{{route('passengerDetails')}}";
                        //route('routeName', ['id' => 5])
                    }); 
            });
        });
    </script>
@endsection