@extends('layouts.app')

@section('additionalCSS')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}">
@stop

@section('content')
    <div class="container">

        <form  class="form" action="{{ route('all_order') }}" method="GET">
            <div class="row">
                <div class="col-md-6">
                        <label class="radio-inline"><input type="radio" class="search" name="search_option" value="1">Search By Order Id</label>
                        <label class="radio-inline"><input type="radio" name="search_option" value="2">Search By Order Date</label>
                    <label class="radio-inline"><input type="radio" name="search_option" value="3">Search By Trip</label>
                </div>
            </div>
<br/>

            <div class="row">

                <div class="col-md-2 filter" id="tripDiv">
                    <div class="form-group">
                        <label>Trip Id</label>
                        <select class="form-control trip_id" name="trip_id">
                            <option value="">All Trips</option>
                            @foreach($trips as $trip)
                                <option value="{{ $trip->id }}" {{ (isset($appends['trip_id']) && $appends['trip_id'] == $trip->id) ? 'selected' : '' }}>
                                    {{ $trip->id }}: {{$trip->departure_port->name}} => {{$trip->destination_port->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-2 filter">
                    <div class="form-group">
                        <label>Departure</label>
                        <select class="form-control" name="departure_port_id">
                            <option value="">All Ports</option>
                            @foreach($ports as $port)
                                <option value="{{ $port->id }}" {{ (isset($appends['departure_port_id']) && $appends['departure_port_id'] == $port->id) ? 'selected' : '' }}>{{ $port->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-2 filter">
                    <div class="form-group">
                        <label>Destination</label>
                        <select class="form-control" name="destination_port_id">
                            <option value="">All Ports</option>
                            @foreach($ports as $port)
                                <option value="{{ $port->id }}" {{ (isset($appends['destination_port_id']) && $appends['destination_port_id'] == $port->id) ? 'selected' : '' }}>{{ $port->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-2 dateClass filter">
                    <div class="form-group">
                        <label>From</label>
                        <input type='text' class="form-control" name="start_date_trip" id="start_date_trip" value="{{ isset($appends['start_date_trip']) ? $appends['start_date_trip'] : '' }}" />
                    </div>
                </div>

                <div class="col-md-2 dateClass filter">
                    <div class="form-group">
                        <label>To</label>
                        <input type='text' class="form-control" name="end_date_trip" id="end_date_trip" value="{{ isset($appends['end_date_trip']) ? $appends['end_date_trip'] : '' }}" />
                    </div>
                </div>

            </div>

        <div class="row">
                <div class="col-md-2 filter2" id="idDiv">
                    <div class="form-group">
                        <label>Order Id</label>
                        <input type='text' class="form-control" name="order_id" id="order_id" value="{{ isset($appends['order_id']) ? $appends['order_id'] : '' }}" />
                    </div>
                </div>

                <div class="col-md-2 filter2" id="startDateDiv">
                    <div class="form-group">
                        <label>From</label>
                        <input type='text' class="form-control" name="start_date" id="start_date" value="{{ isset($appends['start_date']) ? $appends['start_date'] : '' }}" />
                    </div>
                </div>

                <div class="col-md-2 filter2" id="endDateDiv">
                    <div class="form-group">
                        <label>To</label>
                        <input type='text' class="form-control" name="end_date" id="end_date" value="{{ isset($appends['end_date']) ? $appends['end_date'] : '' }}" />
                    </div>
                </div>

                <div class="col-md-2" id="filterDiv">
                    <div class="form-group">
                        <label></label>
                        <button type="submit" class="btn btn-default form-control" id="filterSubmit">Filter</button>
                    </div>
                </div>

        </div>
        </form>
        <hr>

        <div class="row">
            <div class="col-md-12">
                <table class="table table-hover table-striped">
                    <thead>
                    <tr>
                        <th>Order Id</th>
                        <th>Trip Type</th>
                        <th>Customer Email</th>
                        <th>Contact No</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($orders as $order)
                        <tr>

                            <td>{{ $order->id }}</td>
                            <td>@if($order->trip_type === 1) One Way Trip @else Round Trip @endif</td>
                            <td>{{ $order->email }}</td>
                            <td>{{ $order->contact_no }}</td>

                            <td class="text-right">
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
                                        <li><a href="{{ route('view_ticket', ['orderId' => $order->id]) }}">View Tickets</a></li>
                                        <li><a href="{{ route('order_print', ['orderId' => $order->id]) }}">Print Order</a></li>
                                        <li><a class="delete" data-id="{{ $order->id }}" data-toggle="modal" data-target="#deleteModal">Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

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
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button id="btnDelete" type="button" class="btn btn-danger">Delete</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@section('additionalJS')
    <script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script type="text/javascript">
        $(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': '{!! csrf_token() !!}'
                }
            });
            $('#start_date').datetimepicker({
                format: 'YYYY-MM-DD'
            });

            $('#end_date').datetimepicker({
                useCurrent: false, //Important! See issue #1075
                format: 'YYYY-MM-DD'
            });


            $("#start_date").on("dp.change", function (e) {
                $('#end_date').data("DateTimePicker").minDate(e.date);
            });

            $("#end_date").on("dp.change", function (e) {
                $('#start_date').data("DateTimePicker").maxDate(e.date);
            });

            $('#start_date_trip').datetimepicker({
                format: 'YYYY-MM-DD'
            });

            $('#end_date_trip').datetimepicker({
                useCurrent: false, //Important! See issue #1075
                format: 'YYYY-MM-DD'
            });


            $("#start_date_trip").on("dp.change", function (e) {
                $('#end_date_trip').data("DateTimePicker").minDate(e.date);
            });

            $("#end_date_trip").on("dp.change", function (e) {
                $('#start_date_trip').data("DateTimePicker").maxDate(e.date);
            });

            $('.delete').click(function(){
                var id = $(this).data('id');
                var index = $(this).closest('tr').index();

                $("#btnDelete").attr("data-id", id);
                $("#btnDelete").attr("data-index", index);
            });

            $('#btnDelete').click(function(){
                //alert($(this).attr('data-id'));\
                var id = $(this).attr('data-id');
                var index = parseInt($(this).attr('data-index'))+1;

                $.ajax({
                    method: "POST",
                    url: "{{ route('delete_order') }}",
                    data: { id: id }
                }).done(function( data ) {
                    if (data.success == false) {
                        alert(data.message);
                    } else {
                        $('#deleteModal').modal('toggle');
                        $( 'tr:eq( '+index+' )' ).remove();
                    }
                });
            });

            $('.filter2').hide();
            $('.filter').hide();
            $('#filterDiv').hide();

        });

        /*$('#filterSubmit').click(function(e){
            if($('#order_id').val()!=""){
                if($('#start_date').val()!="" || $('#end_date').val()!=""){
                    alert("Other filters are not applicable with order id");
                    e.preventDefault();
                }
            }
        });*/

        $("input[name='search_option']").change(function(){

            var option = parseInt($(this).val());

            if(option === 1){
                //$('.filter2').show();
                $('#idDiv').show();
                $('#filterDiv').show();
                $('#startDateDiv').hide();
                $('#endDateDiv').hide();
                $('.filter').hide();
            }
            else if(option === 2){
                $('#startDateDiv').show();
                $('#endDateDiv').show();
                $('#filterDiv').show();
                $('#order_id').val("");
                $('#idDiv').hide();
                $('.filter').hide();
            }
            else if(option === 3){
                $('.filter2').hide();
                $('.filter').show();
                $('#filterDiv').show();

                $('#order_id').val("");
                $('#start_date').val("");
                $('#end_date').val("");
            }
        });

        $('.trip_id').change(function(){
           var trip_id = $(this).val();
            if(trip_id!==""){
                $('.filter').hide();
                $('#tripDiv').show();
            }
            else{
                $('.filter').show();
            }
        });

    </script>
@stop