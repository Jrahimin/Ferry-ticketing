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
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><center><h3> Edit Trip</h3> </center></div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('updateTrip', ['tripId' => $tripInfo->id]) }}"  enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Ferry Name</label>

                            <div class="col-md-6">   
                               <!--  <select name="ferryName" class="form-control" id="dropdownId" readonly>
                                    @foreach($ferries as $ferry)
                                        <option value="{{$ferry->id}}" {{ $ferry->id == $tripInfo->ferry_id ? 'selected' : '' }} >
                                           {{ $ferry->name }} 
                                        </option>
                                    @endforeach
                                </select> -->
                                @foreach($ferries as $ferry)
                                    @if($ferry->id == $tripInfo->ferry_id)
                                <input type="text" name="ferryName" class="form-control" readonly value="{{ $ferry->name }} ">

                                <input type="hidden" name="ferryId" class="form-control" readonly value="{{ $ferry->id }} ">
                                  	@endif
                                @endforeach
                            </div>
                        </div>
                       
                        <div  class="form-group{{ $errors->has('CompanyName') ? ' has-error' : '' }}">
                              <label class="col-md-4 control-label" for="CompanyName">Company Name</label>
                              <div class="col-md-6">
                                  <select class="form-control" name="companyName" >
                                    @foreach($companies as $company)
                                        <option value="{{$company->id}}" {{ $company->id == $tripInfo->company_id ? 'selected' : '' }} > {{$company->name}}</option>
                                    @endforeach
                                  </select>
                              </div>
                        </div>

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Ferry Seat</label>

                            <div class="col-md-6">   
                                <input type="text" name="seatCapacity" class="form-control" value="{{ $seatCapacity }}">

                            </div>
                        </div>
                         <div class="form-group{{ $errors->has('departurePort') ? ' has-error' : '' }}">
                            <label for="departurePort" class="col-md-4 control-label">Departure Port</label>

                            <div class="col-md-6">   
                                <select name="departurePort" class="form-control" id="dropdownId">
                                    @foreach($ports as $port)
                                            <option value="{{$port->id}}" {{ $port->id == $tripInfo->departure_port_id ? 'selected' : '' }}>{{ $port->name }} 
                                            </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                     
                        <div class="form-group{{ $errors->has('destinationPort') ? ' has-error' : '' }}">
                            <label for="destinationPort" class="col-md-4 control-label">Destination Port</label>

                           <div class="col-md-6">   
                                <select name="destinationPort" class="form-control" id="dropdownId">
                                    @foreach($ports as $port)
                                    	
                                            <option value="{{$port->id}}" {{ $port->id == $tripInfo->destination_port_id ? 'selected' : '' }}>{{ $port->name }} 
                                            </option>
                                            
                                    @endforeach
                                </select>
                            </div>
                        </div>
	                   <div class="form-group{{ $errors->has('departureDate') ? ' has-error' : '' }}">
	                   		<label for="departureDate" class="col-md-4 control-label">Departure Date</label>
	                   		<div class="col-md-6">
	                            <input type="text" class="form-control" name="departure_date" placeholder="Date"  value="{{$tripInfo->departure_date}}" id='datepicker1'>
	                        </div>    
	                    </div>
	                    <div class="form-group{{ $errors->has('departureTime') ? ' has-error' : '' }}">
	                     	<label for="departureDate" class="col-md-4 control-label">Departure Time</label>
	                         <div class="col-md-6  date" >
	                              <input type="text" class="form-control" name="departure_time" placeholder="Time" data-date-format="HH:mm" value="" id='wickedpicker_depat_time'>
	                        </div>
	                    </div>


                       

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
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
            startDate:'0d'
        });

        $('#datepicker1').change(function() {
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


                    $("#datepicker3").prop('disabled', true);
                    $("#datepicker4").prop('disabled', true);
                    $("#datepicker4").prop('disabled', true);
                    $("#clockId").prop('disabled', true);
                    $("#weekDay1").prop('disabled', true);
                    $("#weekDay2").prop('disabled', true);
                    $("#weekDay3").prop('disabled', true);
                    $("#weekDay4").prop('disabled', true);
                    $("#weekDay5").prop('disabled', true);
                    $("#weekDay6").prop('disabled', true);
                    $("#weekDay7").prop('disabled', true);
                    $('#clockManual').prop('disabled', false);
                    $("#datepicker1").prop('disabled', false);
                    console.log("hi");

                $('#manual').change(function() {
                    $("#datepicker3").prop('disabled', true);
                    $("#datepicker4").prop('disabled', true);
                    $("#datepicker4").prop('disabled', true);
                    $("#clockId").prop('disabled', true);
                    $("#weekDay1").prop('disabled', true);
                    $("#weekDay2").prop('disabled', true);
                    $("#weekDay3").prop('disabled', true);
                    $("#weekDay4").prop('disabled', true);
                    $("#weekDay5").prop('disabled', true);
                    $("#weekDay6").prop('disabled', true);
                    $("#weekDay7").prop('disabled', true);

                    $('#clockManual').prop('disabled', false);
                    $("#datepicker1").prop('disabled', false);
                    console.log("hi");
                    
                });

                 $('#auto').change(function() {
                    $("#datepicker3").prop('disabled', false);
                    $("#datepicker4").prop('disabled', false);
                    $("#datepicker4").prop('disabled', false);
                    $("#clockId").prop('disabled', false);
                    $("#weekDay1").prop('disabled', false);
                    $("#weekDay2").prop('disabled', false);
                    $("#weekDay3").prop('disabled', false);
                    $("#weekDay4").prop('disabled', false);
                    $("#weekDay5").prop('disabled', false);
                    $("#weekDay6").prop('disabled', false);
                    $("#weekDay7").prop('disabled', false);

                    $('#clockManual').prop('disabled', true);
                    $("#datepicker1").prop('disabled', true);
                    console.log("hi from Auto");
                    
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
       
    
@stop