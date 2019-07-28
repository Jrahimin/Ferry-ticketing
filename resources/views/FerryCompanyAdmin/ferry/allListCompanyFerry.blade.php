@extends('FerryCompanyAdmin.layouts.app')

@section('content')
	
	<div class="container">
@if ( count($errors) > 0)
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
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
            	<div class="panel-heading" style="background-color:skyblue; color: black;">
                <strong> All Users </strong> 
                </div>
	        	<table class="table table-stripe table-hover">
	        		<thead>
	        			<tr>
							<th>Ferry Name</th>
							<th>Captain Name</th>
							<th>Nummber Of Seat </th>
							<th>Number Of Crew</th>
							<th>Status</th>
							<th><center>Action</center></th>
						</tr>
	        		</thead>
					
					<tbody>
						@foreach($ferries as $ferry)
								<tr>
									<td>{{ $ferry->name }}</td>
									<td>{{ $ferry->captain_name }}</td>
									<td>{{ $ferry->number_of_seat }}</td>
									<td>{{ $ferry->number_of_crew }}</td>
									<td>@if($ferry->status == 1)
											 Activated 
										@else
											 InActivated 
										@endif		
									</td>
									<td>
										<a class="btn btn-raised btn-success editUser"  href="{{ route('editCompanyFerry', ['ferryId' => $ferry->id ])}}" </i>Edit </a>
									</td>

									<td>
										<button class="btn btn-raised btn-danger deleteFerry" data-id="{{ $ferry->id }}" href="#" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-btn fa-remove"></i>Delete </button>
									</td>
									

								</tr>
						@endforeach
					</tbody>
				</table>

				 <center> {{ $ferries->links() }} </center>
				<!-- <div class="pagination" > 
					
				 </div> -->
			</div>
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
	<script type="text/javascript">
		
		$( document ).ready(function(){

			$.ajaxSetup({
		        headers: {
			            'X-CSRF-Token': '{!! csrf_token() !!}'
			        		}
			    });


			$('.deleteFerry').click(function()
			{
				var id = $(this).data('id');
				var index = $(this).closest('tr').index();

				$("#btnDelete").attr("data-id", id);
				$("#btnDelete").attr("data-index", index);
			});

			$('#btnDelete').click(function()
			{
				//console.log("sss")

				var id = $(this).attr('data-id');
				console.log(id)
				var index = parseInt($(this).attr('data-index'))+1;

				$.ajax({
					method: "POST",
					url: "{{ route('deleteCompanyFerry') }}",
					data: { id: id }
				}).done(function( msg )
				{
					$('#deleteModal').modal('toggle');
					$( 'tr:eq( '+index+' )' ).remove();
			  	});
			});

		});
	</script>

@endsection