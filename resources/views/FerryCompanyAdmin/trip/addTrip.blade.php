@extends('FerryCompanyAdmin.layouts.app')

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
    <div class="col-sm-10 col-md-11 main">

          <div class="row" >
          <form class="form-horizontal" role="form" method="POST" action="{{ route('insertCompanyTrip') }}"  enctype="multipart/form-data">
                {{ csrf_field() }}
            <div class="col-sm-12 col-md-12" style="padding-left:0px;"> 
            </div>
          </div>
          <div class="row">
              <div class="col-sm-4 col-md-4">
                
                <div class="form-group">
                  <label for="city">Ferry</label>
                  <select class="form-control" name="ferry_id" >
                    @foreach($ferries as $ferry)
                        <option value="{{$ferry->id}}"> {{$ferry->name}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="city">Departure</label>
                  <select class="form-control" name="departure_port" id="departurePortId" >
                        <option value="" > Select Departure</option>
                    @foreach($ports as $port)
                        <option value="{{$port->id}}" > {{$port->name}}</option>
                    @endforeach
                  </select>
                </div>

                <div class="form-group">
                  <label for="city">Arrival</label>
                    <select class="form-control" name="destination_port" id="destinationPortId"  >
                            <option value="" > Select Arrival</option>
                        @foreach($ports as $port)
                            <option value="{{$port->id}}"  > {{$port->name}}</option>
                        @endforeach
                    </select>
                </div>
                <br> <br>
                <div class="form-group">
                  <label for="start_price">Passenger Price</label><br>
                    @foreach($passengerTypes as $passengerType)
                      <strong>  {{$passengerType->name}} </strong> <input type="text" class="form-control" name="price[]" value="" >  <br>
                        <input type="hidden" name="idPassenger[]" value="{{$passengerType->id}}">
                    @endforeach
                </div>

              </div>

              <div class="col-sm-4 col-md-4 alert alert-warning" >
                  <div  class="form-group">
                    <div class="radio">
                      <label>
                        <input type="radio" id="manual" name="tour_type" value="0" checked>
                            Manual
                      </label>
                    </div>

                    <label for="dateandtime">Departure time</label>
                    <div class="row" id="departureAttributeId">
                        <div class="col-md-6  date" >
                            <input type="text" class="form-control" name="departure_date" placeholder="Date"  value="" id='datepicker1'>
                        </div>
                        
                       <!--  <div class="col-md-6 input-group clockpicker">
                            <input type="text" class="form-control" value="09:30" nadeparture_time" name="departure_time" id="clockManual">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-time"></span>
                            </span>
                        </div> -->

                         <div class="col-md-6  date" >
                              <input type="text" class="form-control" name="departure_time" placeholder="Time" data-date-format="HH:mm" value="" id='wickedpicker_depat_time'>
                        </div>
                    </div>
                  </div>
                  <hr/>
                  <div  class="form-group">
                    <div class="radio">
                      <label>
                        <input type="radio" name="tour_type" value="1"  id="auto">
                            Automatic
                      </label>
                    </div>
                    <label for="dateandtime">Period</label>
                    <div class="row" >
                        <div class="col-md-6  date" >
                            <input type="text" class="form-control" placeholder="From"  name="automatic_from" value="" id='datepicker3'>
                           
                        </div>
                          
                        <div class="col-md-6  date" >
                            <input type="text" class="form-control" placeholder="Until" name="automatic_until"  value="" id='datepicker4'>
                        </div>
                          
                    </div>
                  </div>
                  <div  class="form-group">

                    <div class="row" id="weekDay">
                        <div class="col-md-6 " >
                            <label for="automatic_day">Days</label><br>
                            <input type="checkbox" name="day[]" value="1" id="weekDay1">Monday <br>
                            <input type="checkbox" name="day[]" value="2" id="weekDay2">Tuesday<br>
                            <input type="checkbox" name="day[]" value="3" id="weekDay3">Wednesday<br>
                            <input type="checkbox" name="day[]" value="4" id="weekDay4">Thursday<br>
                            <input type="checkbox" name="day[]" value="5" id="weekDay5">Friday<br>
                            <input type="checkbox" name="day[]" value="6" id="weekDay6">Saturday<br>
                            <input type="checkbox" name="day[]" value="7" id="weekDay7">Sunday <br>
                        </div>
                        <label for="city">&nbsp;</label>
                       <!--  <div class="col-md-6  date" >
                              <input type="text" class="form-control" name="automatic_time" placeholder="Time" data-date-format="HH:mm" value="" id='timepicker5'>
                        </div> -->

                          <div class='col-sm-6'>
                           <!-- <div class="input-group clockpicker">
                                <input type="text" class="form-control" value="09:30" name="automatic_time" id="clockId">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div> -->

                            <div class='col-sm-12'>
                                <div class="form-group">
                                     <label for="dateandtime">Departure time</label>
                                    <div class='input-group date'>
                                        <input type='text' name="automatic_time" class="form-control" id='wickedpicker_time' />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
              <br><br>
              <div class="col-sm-12 col-md-12">
                <button type="submit" class="btn btn-success" value="submit"><span class="icon-checkmark"></span> Submit </button>
              </div>
            </form>
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