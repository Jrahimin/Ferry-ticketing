<?php 
    use App\Enumeration\RoleType;
?>

@extends('FerryAdmin.layouts.app')

@section('additionalCSS')

    <link rel="stylesheet" href="{{url('css/bootstrap-datepicker.min.css')}}">
    <link rel="stylesheet" href="{{url('css/wickedpicker.css')}}">
    <link rel="stylesheet" href="{{url('css/wickedpicker.min.css')}}">
    <!-- <link rel="stylesheet" href="{{url('css/bootstrap-datetimepicker.min.css')}}"> -->
    <!-- <link rel="stylesheet" type="text/css" href="{{url('css/jquery-clockpicker.min.css')}}"> -->
    <link rel="stylesheet" href="{{url('datepicker/css/bootstrap-datetimepicker.min.css')}}">


@endsection


@section('content')

    <div class="container">
    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if(Session::has('success'))
    <div class='alert alert-success'>
        {{Session::get('success')}}
    </div>
    @endif
    @if(Session::has('unsuccess'))
        <div class='alert alert-danger'>
            {{Session::get('unsuccess')}}
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <!-- <label> Search </label> -->
            
            <form  class="form-horizontal" role="form" action="{{route('viewTicketTrip')}}" method="GET">
                <div class="col-md-2">   
                    <select name="ferryId" class="form-control" id="dropdownId" >
                            <option value=""> Ferry Name </option>
                        @foreach($ferries as $ferry)
                            <option value="{{ $ferry->id }}" {{ (isset($appends['ferry_id']) && $appends['ferry_id'] == $ferry->id) ? 'selected' : '' }} > {{ $ferry->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">   
                    <select name="departurePort" class="form-control" id="dropdownId" >
                            <option value=""> Source Port </option>
                        @foreach($ports as $port)
                            <option value="{{ $port->id }}" {{ (isset($appends['departure_port_id']) && $appends['departure_port_id'] == $port->id) ? 'selected' : '' }} > {{ $port->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                 <div class="col-md-2">   
                    <select name="destinationPort" class="form-control" id="dropdownId" >
                            <option  value="">Destination Port</option>
                        @foreach($ports as $port)
                            <option value="{{ $port->id }}" {{ (isset($appends['destination_port_id']) && $appends['destination_port_id'] == $port->id) ? 'selected' : '' }} > {{ $port->name }} 
                            </option>
                        @endforeach
                    </select>
                </div> 
                <div class="col-md-2">   
                    <input type="text" class="form-control" name="start_date" placeholder="Start Date"  value="{{ isset($appends['start_date']) ? $appends['start_date'] : '' }}"  id='datepicker1'> 
                </div> 
                <div class="col-md-2">  
                    <input type="text" class="form-control" name="end_date" placeholder="End Date"  value="{{ isset($appends['end_date']) ? $appends['end_date'] : '' }}" id='datepicker2'>  
                </div>
                <button type="submit" class="btn btn-primary">  Submit </button>
            </form>
            
            <table class="table table-stripe table-hover">
                <thead>
                    <tr>
                        <th>Trip Number</th>
                        <th>Ferry Name</th>
                        <th>Ferry Seat</th>
                        <!-- <th>Ferry Logo</th> -->
                        <th>Departure Port</th>
                        <th>Destination Port</th>
                        <th>Departure Date</th>
                        <th>Departure Time</th>
                       
                        @if(Auth::user()->role == RoleType::$CUSTOMER)
                            
                        @else
                          <th>Action</th>
                        @endif                  
                    </tr>
                </thead>
                
                <tbody>
                    @foreach($trips as $trip)
                        <tr>
                            <td>{{ $trip->id }}</td>
                            <td>{{ $trip->ferry->name }}</td>
                            <td>{{ $trip->ferry->number_of_seat }}</td>
                            <!-- <td>  </td> -->
                            <td>{{ $trip->departure_port->name }} </td>
                            <td>{{ $trip->destination_port->name }} </td>
                            <td>{{ $trip->departure_date }} </td>
                            <td>{{ $trip->departure_time}} </td>
                            @if(Auth::user()->role == RoleType::$CUSTOMER)
                            
                            @else
                                <td>
                                    <a class="btn btn-raised btn-success editUser"  href="{{route('editTrip', ['tripId' => $trip->id ])}}"> Edit 
                                    </a>
                                </td>

                                <td>
                                    <a class="btn btn-raised btn-success"  href="{{route('tripAllTicketInfo', ['tripId' => $trip->id ])}}">
                                     Order List
                                    </a>
                                </td>
                            @endif    
                        </tr>
                    @endforeach
                </tbody>
            </table>
            


               <center> {{ $trips->appends($appends)->links() }} </center>
        </div> 
    </div>
</div>


<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Delete</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure want to delete?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-raised btn-default" data-dismiss="modal">Cancel</button>
        <button id="btnDelete" type="button" class="btn btn-raised btn-danger">Delete</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


@endsection

@section('additionalJS')
    
    <script type="text/javascript" src="{{url('js/bootstrap-datepicker.min.js')}}"></script>
    <script type="text/javascript" src="{{url('js/wickedpicker.js')}}"></script>
    <!-- <script type="text/javascript" src="{{url('js/bootstrap-datetimepicker.min.js')}}"></script> -->
    <!-- <script type="text/javascript" src="{{url('js/jquery-clockpicker.min.js')}}"></script> -->
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
         $(document).ready(function(){
            var options = { 
             twentyFour: true  };
          $('#wickedpicker_time').wickedpicker(options);
         });
    </script>
    <script type="text/javascript">
         $(document).ready(function(){
            var options = { 
             twentyFour: true  };
          $('#wickedpicker_depat_time').wickedpicker(options);
         });
    </script>



      <!-- <script type="text/javascript">
            $(function () {
                $('#timepicker1').datetimepicker({
                    pickDate: false
                });
                $('#timepicker1').change(function() {
                    var timeValue = $(this).val(); 
                    alert('form-hi');
                    console.log(timeValue);
                });
            });
    </script> -->
    <script type="text/javascript">
    $(function () {
        $('#datepicker3').datepicker({
            startDate:'0d'
        });
        $('#datepicker3').change(function() {
            var periodDateValue = $(this).val(); 
            console.log(periodDateValue);
        });
    });
    </script>
    <script type="text/javascript">
        $(function () {
            $('#datepicker4').datepicker({
                startDate:'0d'
            });
            $('#datepicker4').change(function() {
                var periodEndDateValue = $(this).val(); 
                console.log(periodEndDateValue);
            });
        });
    </script>

    <script type="text/javascript">
        $('.clockpicker').clockpicker({
              donetext: 'Done'
        });
    </script>

        <script type="text/javascript">

            $(function () {
                $('#departurePortId').change(function() {
                    $('#destinationPortId').prop('selectedIndex',0);
                    $('#destinationPortId').children('option').show();
                    var idDeparture = $('#departurePortId').find(":selected").val();
                    console.log(idDeparture);
                    $("#destinationPortId option[value = "+idDeparture+"]").hide();
                });
            });
        </script>
        

         <script type="text/javascript">
            $(function () {
                $('#datetimepicker3').datetimepicker({
                    format: 'LT'
                });
            });
        </script>
@endsection