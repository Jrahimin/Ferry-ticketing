@extends('layouts.app')

@section('additionalCSS')
<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}">
@stop

@section('content')
<div class="container">
	<div class="jumbotron">
        <form class="form">
            <div class="row">
                <div class="col-md-12">
                    <label class="radio-inline">
                        <input type="radio" class="trip_type" name="trip_type" id="trip_type_one" value="1" {{ $request->trip_type == '1' ? 'checked' : '' }}> One Way
                    </label>
                    <label class="radio-inline">
                        <input type="radio" class="trip_type" name="trip_type" id="trip_type_round" value="2" {{ $request->trip_type == '2' ? 'checked' : '' }}> Round Trip
                    </label>

                    <hr>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="departure_port_id">From</label>
                        <select class="form-control" name="departure_port_id">
                            <option value="">Select Departure Port</option>

                            @foreach($ports as $port)
                                <option value="{{ $port->id }}" {{ $request->departure_port_id == $port->id ? 'selected' : '' }}>{{ $port->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="destination_port_id">From</label>
                        <select class="form-control" name="destination_port_id">
                            <option value="">Select Destination Port</option>

                            @foreach($ports as $port)
                                <option value="{{ $port->id }}" {{ $request->destination_port_id == $port->id ? 'selected' : '' }}>{{ $port->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="departure_date">Departure Date</label>
                        <input type="text" class="form-control" id="departure_date" value="{{ $request->departure_date }}" name="departure_date">
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group {{ $request->trip_type == '1' ? 'hide' : '' }} form-group-return-date">
                        <label for="return_date">Return Date</label>
                        <input type="text" class="form-control" id="return_date" value="{{ $request->return_date or '' }}" name="return_date">
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="pax">No. of Pax</label>
                        <select class="form-control" name="pax">
                            @for($i=1; $i<=10; $i++)
                                <option value="{{ $i }}" {{ $request->pax == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for=""></label>
                        <button class="btn btn-primary form-control" type="submit">Search</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @if ($errors->any())
	    <div class="alert alert-danger">
	        <ul>
	            @foreach ($errors->all() as $error)
	                <li>{{ $error }}</li>
	            @endforeach
	        </ul>
	    </div>
    @else
		<div class="row">
			<div class="col-md-12">
				<h4>
					{{ $departure_port->name }}
					<i class="fa fa-long-arrow-right" aria-hidden="true"></i> 
					{{ $destination_port->name }}
				</h4>

				<h5>{{ date('d F, Y', strtotime($request->departure_date)) }}</h5>
				
				<hr>

				@if (sizeof($trips) > 0)
					<table class="table table-hover table-striped">
						<thead>
							<tr>
                                <th></th>
								<th>Company</th>
								<th>Ferry</th>
								<th>Available Seat</th>
								<th>Departure Time</th>
								<th></th>
							</tr>
						</thead>

						<tbody>
							@foreach($trips as $trip)
								<tr>
                                    <td><img class="img-rounded" src="{{ asset($trip->company->image_url) }}" height="50px" width="50px"></td>
									<td>{{ $trip->company->name }}</td>
									<td>{{ $trip->ferry->name }}</td>
									<td>{{ $trip->ferry_remaining_seat }}</td>
									<td>{{ date('h:i A', strtotime($trip->departure_time)) }}</td>
									<td class="text-right td-select" data-id="{{ $trip->id }}">
										<a class="btn btn-primary select-one-way" role="button">Select</a>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				@else
					<div class="alert alert-danger">
						No trip found.
					</div>
				@endif
			</div>
		</div>

		@if ($request->trip_type == '2')
			<div class="row">
				<div class="col-md-12">
					<h4>
						{{ $destination_port->name }}
						<i class="fa fa-long-arrow-right" aria-hidden="true"></i> 
						{{ $departure_port->name }}
					</h4>

					<h5>{{ date('d F, Y', strtotime($request->return_date)) }}</h5>
					
					<hr>

					@if(sizeof($return_trips) > 0)
						<table class="table table-hover table-striped">
							<thead>
								<tr>
                                    <th></th>
									<th>Company</th>
									<th>Ferry</th>
									<th>Available Seat</th>
									<th>Departure Time</th>
									<th></th>
								</tr>
							</thead>

							<tbody>
								@foreach($return_trips as $trip)
									<tr>
                                        <td><img class="img-rounded" src="{{ asset($trip->company->image_url) }}" height="50px" width="50px"></td>
										<td>{{ $trip->company->name }}</td>
										<td>{{ $trip->ferry->name }}</td>
										<td>{{ $trip->ferry_remaining_seat }}</td>
										<td>{{ date('h:i A', strtotime($trip->departure_time)) }}</td>
										<td class="text-right td-select-return" data-id="{{ $trip->id }}">
											<a class="btn btn-primary select-return" role="button">Select</a>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					@else
						<div class="alert alert-danger">
							No trip found.
						</div>
					@endif
				</div>
			</div>
		@endif
	@endif
</div>

<form id="trip-form" method="GET" action="{{ route('passenger_details') }}">
    <input type="hidden" name="trip_type" value="{{ $request->trip_type }}">
    <input type="hidden" name="pax_no" value="{{ $request->pax }}">
    <input type="hidden" id="input_one_way_trip_id" name="one_way_trip_id">
    <input type="hidden" id="input_return_trip_id" name="return_trip_id">
</form>
@stop

@section('additionalJS')
<script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
<script type="text/javascript">
    $(function() {
    	var one_way_trip_id = '';
    	var return_trip_id = '';
    	var trip_type = '{{ $request->trip_type }}';

    	console.log(trip_type);

        $('#departure_date').datetimepicker({
            defaultDate: moment().add(1, 'days'),
            format: 'YYYY-MM-DD',
            minDate: moment()
        });

        $('#return_date').datetimepicker({
            defaultDate: moment().add(2, 'days'),
            useCurrent: false, //Important! See issue #1075
            format: 'YYYY-MM-DD'
        });

        $("#departure_date").on("dp.change", function (e) {
            $('#return_date').data("DateTimePicker").minDate(e.date);
        });

        $("#return_date").on("dp.change", function (e) {
            $('#departure_date').data("DateTimePicker").maxDate(e.date);
        });

        $('.trip_type').click(function() {
            if ($(this).val() == '1') {
                // One way
                $('.form-group-return-date').addClass('hide');
            } else {
                // Round trip
                $('.form-group-return-date').removeClass('hide');
            }
        });

        $(document).on('click', '.select-one-way', function() {
        	var trip_type = '{{ $request->trip_type }}';
        	var td = $(this).closest('td');
        	one_way_trip_id = td.data('id');
            $('#input_one_way_trip_id').val(one_way_trip_id);

        	$('.td-select').each(function(index) {
        		$(this).html('<a class="btn btn-primary select-one-way" role="button">Select</a>');
        	});
        	
        	td.html('<span class="label label-success">Selected</span>');

            passenger_details();
        });

        $(document).on('click', '.select-return', function() {
            var trip_type = '{{ $request->trip_type }}';
            var td = $(this).closest('td');
            return_trip_id = td.data('id');
            $('#input_return_trip_id').val(return_trip_id);

            $('.td-select-return').each(function(index) {
                $(this).html('<a class="btn btn-primary select-return" role="button">Select</a>');
            });
            
            td.html('<span class="label label-success">Selected</span>');

            passenger_details();
        });

        function passenger_details() {
            if (trip_type == '1') {
                // One way trip
                if (one_way_trip_id != '')
                    $('#trip-form').submit();
            } else {
                // Round trip
                if (one_way_trip_id != '' && return_trip_id != '')
                    $('#trip-form').submit();
            }
        }
    });
</script>
@stop