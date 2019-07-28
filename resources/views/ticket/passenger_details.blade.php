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
				<label for="email" class="col-md-4 control-label">Email</label>
				<div class="col-md-8">
					<input type="text" class="form-control" placeholder="Email" name="email">

					@if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
				</div>
			</div>

			<div class="form-group">
				<label for="contact_no" class="col-md-4 control-label">Contact No.</label>
				<div class="col-md-8">
					<input type="text" class="form-control" placeholder="Contact Number" name="contact_no">

					@if ($errors->has('contact_no'))
						<span class="help-block">
                            <strong>{{ $errors->first('contact_no') }}</strong>
                        </span>
					@endif
				</div>
			</div>

			@for($i=1; $i<=$pax_no; $i++)
				<h4>Passenger Information {{ $i }}</h4>
				<hr>

				<div class="form-group">
					<div class="col-md-6">
						<input type="text" class="form-control" placeholder="Full Name" name="name[]">
					</div>

					<div class="col-md-3">
						<select class="form-control" name="gender[]">
							<option value="">Gender</option>
							<option value="Male">Male</option>
							<option value="Female">Female</option>
						</select>
					</div>

					<div class="col-md-3">
						<input type="text" class="form-control date" placeholder="Date of Birth" name="dob[]">
					</div>
				</div>

				<div class="form-group">

					<div class="col-md-3">
						<input type="text" class="form-control" placeholder="Passport No" name="passport_no[]">
					</div>

					<div class="col-md-3">
						<input type="text" class="form-control date" placeholder="Passport Expiry" name="passport_exp[]">
					</div>

					<div class="col-md-3">
						<select class="form-control" name="nationality[]">
							<option value="">Nationality</option>
							<option value="bangladeshi">Bangladeshi</option>
							<option value="austratian">Australian</option>
						</select>
					</div>

					<div class="col-md-3">
						<select class="form-control type_id" name="type_id[]">
							@foreach($trip->prices as $price)
								<option data-price="{{$price->price}}" value="{{$price->passenger_type->id}}">{{$price->passenger_type->name}}</option>
							@endforeach
						</select>
					</div>

				</div>
			@endfor

			<button class="btn btn-primary">Confirm</button>
		</div>

		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Departing Info</h3>
				</div>
				<div class="panel-body">
					<h4>Departure Date:</h4>
					<p>{{ date('j M, Y - h:i A', strtotime($trip->departure_date_time)) }}</p>

					<h4>Depart From:</h4>
					<p>{{ $trip->departure_port->name }}</p>

					<h4>Arrive At:</h4>
					<p>{{ $trip->destination_port->name }}</p>

					<h4>Ferry:</h4>
					<p>{{ $trip->ferry->name }}</p>

					<h4>Number of Seats:</h4>
					<p>{{ $pax_no }}</p>

					<h4>Ticket Unit Price:</h4>
					<p>
						@foreach($trip->prices as $price)
							{{ $price->passenger_type->name.': $'.$price->price }}<br>
						@endforeach
					</p>

					<input type="hidden" name="departure_trip_id" value="{{$trip->id}}">
					<input type="hidden" name="trip_type" value="1">
					<input type="hidden" name="departure_date_time" value="{{$trip->departure_date_time}}">
					<input type="hidden" name="depart_from" value="{{$trip->departure_port->id}}">
					<input type="hidden" name="arrive_at" value="{{$trip->destination_port->id}}">
					<input type="hidden" name="no_of_passenger" id="no_of_passenger" value="{{$pax_no}}">
					<input type="hidden" name="trip_id" value="{{$trip->id}}">
				</div>
			</div>

			@if ($return_trip != null)

				<div class="col-md-3" id="returnPriceDiv">
						@foreach($return_trip->prices as $price)
							<input type="hidden" class="type_id_return" name="type_id_return[]" data-price="{{$price->price}}" value="{{$price->passenger_type->id}}">
						@endforeach
				</div>

				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Return Info</h3>
					</div>
					<div class="panel-body">
						<h4>Departure Date:</h4>
						<p>{{ date('j M, Y - h:i A', strtotime($return_trip->departure_date_time)) }}</p>

						<h4>Depart From:</h4>
						<p>{{ $return_trip->departure_port->name }}</p>

						<h4>Arrive At:</h4>
						<p>{{ $return_trip->destination_port->name }}</p>

						<h4>Ferry:</h4>
						<p>{{ $return_trip->ferry->name }}</p>

						<h4>Number of Seats:</h4>
						<p>{{ $pax_no }}</p>

						<h4>Ticket Unit Price:</h4>
						<p>
							@foreach($return_trip->prices as $price)
								{{ $price->passenger_type->name.': $'.$price->price }}<br>
							@endforeach
						</p>

						<input type="hidden" name="return_trip" value="1">
						<input type="hidden" name="trip_type" value="2">
						<input type="hidden" name="return_trip_id" value="{{$return_trip->id}}">
						<input type="hidden" name="departure_date_round" value="{{$return_trip->departure_date_time}}">
						<input type="hidden" name="trip_id_round" value="{{$return_trip->id}}">
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
							<td class="text-right"><span id="depart_fare">0</span></td>
							<input id="input_depart_fare" type="hidden" name="depart_fare" value="0">
						</tr>

						<tr>
							<td>Return Journey Fare:</td>
							<td class="text-right"><span id="return_fare">0</span></td>
							<input id="input_return_fare" type="hidden" name="return_fare" value="0">
						</tr>
					</table>

					<hr>

					<div class="row">
						<div class="col-md-8">
							<h4>Total</h4>
						</div>

						<div class="col-md-4">
							<h4 class="text-right">$<span id="total_fare">0</span></h4>
							<input id="input_total_fare" type="hidden" name="total_fare">
						</div>
					</div>

				</div>
			</div>
		</div>
	</form>
</div>
@stop

@section('additionalJS')
<script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
<script type="text/javascript">

	$(function() {
		$('.date').datetimepicker({
			format: 'YYYY-MM-DD',
		});

		//fragment for calculating total departure price
		var total = 0;
		var price = 0;
		var type_ids = [];
		$('.type_id').each(function() {
			var price = $('.type_id').find(':selected').data('price');
			type_ids.push($(this).val());
			total = total + price;
		});
		$('#depart_fare').html(total.toFixed(2));
		$('#input_depart_fare').val(total.toFixed(2));

		//fragment for calculating total return trip price
		var totalReturn = 0;
		var priceReturn = 0;
		$.each(type_ids, function (key, value) {
			$('.type_id_return').each(function() {
				value2 = parseInt($(this).val());
				if(value == value2)
				{
					totalReturn = totalReturn + $(this).data('price');
				}
			});
		});

		$('#return_fare').html(totalReturn.toFixed(2));
		$('#input_return_fare').val(totalReturn.toFixed(2));

		//calculating total fare cost
		var total_fare = parseFloat($('#input_depart_fare').val()) + parseFloat($('#input_return_fare').val());
		$('#total_fare').html(total_fare.toFixed(2));
		$('#input_total_fare').val(total_fare.toFixed(2));

		//fragment for calculating total when passenger type is changed
		$('.type_id').change(function(){
			//calculating departure total
			total = 0;
			price = 0;
			var totalReturn = 0;
			var priceReturn = 0;
			type_ids = [];
			console.log("in main");
			$('.type_id').each(function() {
				type_ids.push($(this).val());
				var price = $(this).find(':selected').data('price');
				total = total + price;
			});
			$('#depart_fare').html(total.toFixed(2));
			$('#input_depart_fare').val(total.toFixed(2));


			//fragment for calculating total return total
			$.each(type_ids, function (key, value) {
				console.log(value+"\n");
				$('.type_id_return').each(function() {
					value2 = $(this).val();
					console.log(value+' - '+value2);
					if(value == value2)
					{
						totalReturn = totalReturn + $(this).data('price');
					}
				});
			});
			$('#return_fare').html(totalReturn.toFixed(2));
			$('#input_return_fare').val(totalReturn.toFixed(2));

			//calculating total fare cost
			var total_fare = parseFloat($('#input_depart_fare').val()) + parseFloat($('#input_return_fare').val());
			$('#total_fare').html(total_fare.toFixed(2));
			$('#input_total_fare').val(total_fare.toFixed(2));
		});
	});
</script>
@stop