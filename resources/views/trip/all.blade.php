@extends('layouts.app')

@section('additionalCSS')
<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}">
@stop

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12 text-right">
			<a href="{{ route('add_trip') }}" class="btn btn-primary">Add New Trip</a>
		</div>
	</div>

	<br>

	<div class="row">
		<form  class="form" action="{{ route('view_all_trip') }}" method="GET">
			<div class="col-md-2">
				<div class="form-group">
					<label>Ferry</label>
					<select class="form-control" name="ferry_id">
						<option value="">All Ferry</option>
						@foreach($ferries as $ferry)
							<option value="{{ $ferry->id }}" {{ (isset($appends['ferry_id']) && $appends['ferry_id'] == $ferry->id) ? 'selected' : '' }}>{{ $ferry->name }}</option>
						@endforeach
					</select>
				</div>
			</div>

			<div class="col-md-2">
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

			<div class="col-md-2">
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

			<div class="col-md-2">
				<div class="form-group">
					<label>From</label>
					<input type='text' class="form-control" name="start_date" id="start_date" value="{{ isset($appends['start_date']) ? $appends['start_date'] : '' }}" />
				</div>
			</div>

			<div class="col-md-2">
				<div class="form-group">
					<label>To</label>
					<input type='text' class="form-control" name="end_date" id="end_date" value="{{ isset($appends['end_date']) ? $appends['end_date'] : '' }}" />
				</div>
			</div>

			<div class="col-md-2">
				<div class="form-group">
					<label></label>
					<button type="submit" class="btn btn-default form-control">Filter</button>
				</div>
				
			</div>
		</form>
	</div>

	<hr>

    <div class="row">
        <div class="col-md-12">
        	<table class="table table-hover table-striped">
        		<thead>
        			<tr>
						<th>Ferry Name</th>
						<th>Seat</th>
						<th>Departure Port</th>
						<th>Destination Port</th>
						<th>Departure Date</th>
						<th>Departure Time</th>
						<th></th>
					</tr>
        		</thead>
				
				<tbody>
					@foreach ($trips as $trip)
						@php
							$dateTime = new dateTime($trip->departure_date_time);
							$date = date_format($dateTime, 'Y-m-d');
							$time = date_format($dateTime, 'g:i A');

						@endphp
						<tr>
							<td>{{ $trip->ferry->name }}</td>
							<td>{{ $trip->ferry->number_of_seat }}</td>
							<td>{{ $trip->departure_port->name }}</td>
							<td>{{ $trip->destination_port->name }}</td>
							<td>{{ $date }} </td>
							<td>{{ $time }} </td>

							<td class="text-right">
								<div class="dropdown">
									<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
										<span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
									</button>
									<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
										<li><a href="{{ route('view_order', ['tripId' => $trip->id]) }}">View Orders</a></li>
										<li><a href="{{ route('edit_trip', ['trip' => $trip->id]) }}">Edit</a></li>
										<li><a class="delete" data-id="{{ $trip->id }}" data-toggle="modal" data-target="#deleteModal">Delete</a></li>
									</ul>
								</div>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>

			<div class="pagination"> {{ $trips->appends($appends)->links() }} </div>
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
				url: "{{ route('delete_trip') }}",
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
	})
</script>
@stop