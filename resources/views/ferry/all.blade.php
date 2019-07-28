@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12 text-right">
			<a href="{{ route('add_ferry') }}" class="btn btn-primary">Add Ferry</a>
		</div>
	</div>

	<hr>

    <div class="row">
        <div class="col-md-12">
        	<table class="table table-hover table-striped">
        		<thead>
        			<tr>
        				<th></th>
						<th>Name</th>
						<th>Captain Name</th>
						<th>Nummber Of Seat</th>
						<th>Number Of Crew</th>
						<th>Status</th>
						<th></th>
					</tr>
        		</thead>
				
				<tbody>
					@foreach ($ferries as $ferry)
						<tr>
							<td><img class="img-circle" src="{{ asset($ferry->image_url) }}" height="50px" width="50px"></td>
							<td>{{ $ferry->name }}</td>
							<td>{{ $ferry->captain_name }}</td>
							<td>{{ $ferry->number_of_seat }}</td>
							<td>{{ $ferry->number_of_crew }}</td>
							<td>
								@if($ferry->status == 1)
									<span class="label label-success">Active</span>
								@else
									<span class="label label-danger">Deactive</span>
								@endif
							</td>
							<td class="text-right">
								<div class="dropdown">
									<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
										<span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
									</button>
									<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
										<li><a href="{{ route('edit_ferry', ['ferry' => $ferry->id]) }}">Edit</a></li>
										<li><a class="delete" data-id="{{ $ferry->id }}" data-toggle="modal" data-target="#deleteModal">Delete</a></li>
									</ul>
								</div>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>

			<div class="pagination"> {{ $ferries->links() }} </div>
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
<script type="text/javascript">
	$(function(){
		$.ajaxSetup({
	        headers: {
	            'X-CSRF-Token': '{!! csrf_token() !!}'
	        }
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
				url: "{{ route('delete_ferry') }}",
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