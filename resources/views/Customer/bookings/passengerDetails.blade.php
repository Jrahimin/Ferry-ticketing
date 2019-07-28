@extends('Customer.layouts.app')



@section('content')

<div  class="container">
	@if ($errors->any())
	<div class="alert alert-danger">
	    <ul>
	        @foreach ($errors->all() as $error)
	            <li>{{ $error }}</li>
	        @endforeach
	    </ul>
	</div>
	@endif
	
	<div class="row">
		<div class="col-md-5">
			<div class="panel-body">
				<strong><label> Ticket Collector Info </label></strong>

				<br>
				<hr>
				<br>
				
                    <form class="form-horizontal" role="form" id="ticketCollectorForm" method="POST" action="{{ route('ticketCollectorInfo') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('customerName') ? ' has-error' : '' }}">
                            <label for="customerName" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="customerName" type="text" class="form-control" name="customerName" value="{{ old('customerName') }}" required>

                                @if ($errors->has('customerName'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('customerName') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('reEnterEmail') ? ' has-error' : '' }}">
                            <label for="reEnterEmail" class="col-md-4 control-label">Re Enter E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="reEnterEmail" type="email" class="form-control" name="reEnterEmail" value="{{ old('reEnterEmail') }}" required>

                                @if ($errors->has('reEnterEmail'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('reEnterEmail') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('contact') ? ' has-error' : '' }}">
                            <label for="contact" class="col-md-4 control-label">Contact No</label>

                            <div class="col-md-6">
                                <input id="contact" type="text" class="form-control" name="contact" required>
                                @if ($errors->has('contact'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('contact') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <?php 
                        	$j=0;
                        ?>
                        @for($i=0; $i<=$destinationInclude; $i++)
	                        <div class="form-group">
	                            <label for="password-confirm" class="col-md-4 control-label">
	                            @if($j == 0)
	                            	Pax in Depart Journey
	                            </label>
	                            <input type="hidden" name="departureTripId" value="{{$dataDeparture['bookedTripIdDeparture']}}">
	                            <input type="hidden" name="departureTripSeat" value="{{$dataDeparture['bookedSeatDeparture']}}">
	                            <div class="col-md-6">
				                    @if(count($priceDeparture) > 0)
									    @foreach ($priceDeparture as $key => $value) 
									    	@foreach($passengerType as $passengerTypeValue)
									    		@if($passengerTypeValue->id == $value->passenger_type_id)
										    		<li>{{ $passengerTypeValue->name }}
										    		</li>
										    		<select class="form-control departureSelectedSeat" name="departureSeatValue[]" >
										    			@for($number=0 ; $number<=$dataDeparture['bookedSeatDeparture'] ; $number++)
											    			<option value="{{$number}}" > {{$number}}
											    			</option>
										    			@endfor
										    		</select>
										    		<br>
									    		@endif
									    	@endforeach
									    @endforeach
								    @endif
		                        </div>
		                    </div>	
	                            @else
	                            	Pax in Destination Journey
	                            </label>
	                            <input type="hidden" name="destinationTripId" value="{{$dataDestination['bookedTripIdDestination']}}" >
	                            <input type="hidden" name="destinationTripSeat" value="{{ $dataDestination['bookedSeatDestiantion'] }}">
	                            <div class="col-md-6">
				                    @if(count($priceDestination) > 0)
									    @foreach ($priceDestination as $key => $value) 
									    	@foreach($passengerType as $passengerTypeValue)
									    		@if($passengerTypeValue->id == $value->passenger_type_id)
										    		<li>{{ $passengerTypeValue->name }}
										    		</li>
										    		<select class="form-control destinationSelectedSeat" name="destinationSeatValue[]"  >
										    			@for($number=0 ; $number<=$dataDestination['bookedSeatDestiantion'] ; $number++)
											    			<option value="{{ $number }}" >
											    				{{$number}}
											    			</option>
										    			@endfor
										    		</select>
										    		<br>
									    		@endif
									    	@endforeach
									    @endforeach
								    @endif
		                        </div>
		                    </div>	
	                          	@endif
	                          	<?php
	                            	$j++;
	                          	?>
                        @endfor

                        <strong><hr> </strong>
                        @for($count=0; $count<=$numberOfPassengerInfo-1; $count++)
                        	<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
	                            <label for="name" class="col-md-4 control-label">Name</label>

	                            <div class="col-md-6">
	                                <input id="name" type="name" class="form-control" name="name[]" value="{{ old('name') }}" required>

	                                @if ($errors->has('name'))
	                                    <span class="help-block">
	                                        <strong>{{ $errors->first('name') }}</strong>
	                                    </span>
	                                @endif
	                            </div>
	                        </div>
	                        <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
	                            <label for="gender" class="col-md-4 control-label">Gender</label>

	                            <div class="col-md-6">
	                               <select class="form-control" name="gender[]" id="gender" >
	                               		<option value="0"> Male </option>
	                               		<option value="1"> Female </option>
	                               </select>
	                            </div>
	                        </div>
	                        <div class="form-group{{ $errors->has('passport') ? ' has-error' : '' }}">
	                            <label for="passport" class="col-md-4 control-label">Passport</label>

	                            <div class="col-md-6">
	                               <input type="text" class="form-control" name="passport[]" placeholder="Passport"> 
	                            </div>
	                        </div>
	                        <div class="form-group{{ $errors->has('expireDate') ? ' has-error' : '' }}">
	                            <label for="expireDate" class="col-md-4 control-label">Passport Expire Date</label>

	                            <div class="col-md-6">
	                               <input type="text" class="form-control datepicker2" name="expireDate[]" placeholder="Passport Expire Date" > 
	                            </div>
	                        </div>
	                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
	                            <label for="name" class="col-md-4 control-label">Birth date</label>

	                            <div class="col-md-6">
	                               <input type="text" class="form-control datepicker1" name="birthDate[]" placeholder="Birth Date" > 
	                            </div>
	                        </div>

	                        <hr>
                        @endfor

                        <input type="hidden" name="departureFare"  id="departureFare">
                        <input type="hidden" name="destinationFare" id="destinationFare">
                        <input type="hidden" name="totalFare" id="totalFare">
                        <input type="hidden" name="maximumPassenger" id="maximumPassenger">

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" id="submit" class="btn btn-primary">
                                    Pay Now
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
		</div>


		<div class="col-md-6" style="background-color:#E4E4E4;">
			<div class="row">
				<table class="table">
					<tr>
						<td>
							<br>
								<label for="label" class="control-label">Departure Tour Information</label><br>
							<br>
							<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
							    <label for="email" class="col-md-3 control-label">Departure Date</label>
							    <div class="col-md-3 col-md-offset-3">
							        <p> {{ $dataDeparture['dateDeparture'] }} </p>
							    </div>
							</div>
					 	</td>
				 	</tr>
				 	<tr>
						<td>
							<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
							    <label for="email" class="col-md-3  control-label">Departure Port name</label>
							    <div class="col-md-3 col-md-offset-3">
							        <p> {{ $dataDeparture['portDepartureFrom'] }} </p>
							    </div>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
							    <label for="email" class="col-md-3 control-label">Destination Port name</label>
							    <div class="col-md-3 col-md-offset-3">
							       	<p> {{ $dataDeparture['portDepartureTo'] }} </p> 
								</div>
							</div>	
						</td>
					</tr>
					<tr>
						<td>
							<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
							    <label for="email" class="col-md-3 control-label">Ferry Name</label>
							    <div class="col-md-3 col-md-offset-3">
							        <p> {{ $dataDeparture['ferryDeparture'] }} </p>
							    </div>
							</div>
						</td>
					</tr>
						<td>
							<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
							    <label for="email" class="col-md-3 control-label">Number Of Booked Seat</label>
							    <div class="col-md-3 col-md-offset-3" >
							        <p id="bookedSeatDeparture"> {{ $dataDeparture['bookedSeatDeparture'] }} </p>
							    </div>
							</div>
						</td>
					<tr>
						<td>
							<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
							    <label for="email" class="col-md-3 control-label">Price Of Seat </label>
							  
							    <div class="col-md-3 col-md-offset-3">
								    @if(count($priceDeparture) > 0)
								    	@foreach ($priceDeparture as $key => $value) 
								    		@foreach($passengerType as $passengerTypeValue)
								    			@if($passengerTypeValue->id == $value->passenger_type_id)
									    			<li>{{ $passengerTypeValue->name }}</li>
									    			<li>{{$value->price_id}}</li>
									    			<br>
								    			@endif
								    		@endforeach
								    	@endforeach
							    	@endif
							    </div>
							</div>
						</td>
					</tr>
				</table>	
				<br>
			</div>
			@if($destinationInclude == 1)
			<div class="row">
				<table class="table">
					<tr>
						<td>
							<br>
							<label for="label" class="control-label">Destination Tour Information</label><br>
							<br>
							<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
							    <label for="email" class="col-md-3 control-label">Departure Date</label>
							    <div class="col-md-3 col-md-offset-3">
							        <p> {{ $dataDestination['dateDestination'] }} </p>
							    </div>
							</div>
					 	</td>
				 	</tr>
				 	<tr>
						<td>
							<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
							    <label for="email" class="col-md-3  control-label">Departure Port name</label>
							    <div class="col-md-3 col-md-offset-3">
							    	<p> {{ $dataDestination['portDestinationTo'] }} </p>
							    </div>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
							    <label for="email" class="col-md-3 control-label">Destination Port name</label>
							    <div class="col-md-3 col-md-offset-3">
							       	<p> {{ $dataDestination['portDestinationFrom'] }} </p> 
								</div>
							</div>	
						</td>
					</tr>
					<tr>
						<td>
							<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
							    <label for="email" class="col-md-3 control-label">Ferry Name</label>
							    <div class="col-md-3 col-md-offset-3">
							         <p> {{ $dataDestination['ferryDestination'] }} </p>
				        
							    </div>
							</div>
						</td>
					</tr>
						<td>
							<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
							    <label for="email" class="col-md-3 control-label">Number Of Booked Seat</label>
							  
							    <div class="col-md-3 col-md-offset-3">
							        <p id="bookedSeatDestination"> {{ $dataDestination['bookedSeatDestiantion'] }} </p>
							    </div>
							</div>
						</td>
					<tr>
						<td>
							<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
							    <label for="email" class="col-md-3 control-label">Price Of Seat </label>
							  
							    <div class="col-md-3 col-md-offset-3">
								    @if(count($priceDestination) > 0)
								    	@foreach ($priceDestination as $key => $value) 
								    		@foreach($passengerType as $passengerTypeValue)
								    			@if($passengerTypeValue->id == $value->passenger_type_id)
									    			<li>{{ $passengerTypeValue->name }}</li>
									    			<li> {{ $value->price_id }} </li>
									    			<br>
								    			@endif
								    		@endforeach
								    	@endforeach
							    	@endif
							    </div>
							</div>
						</td>
					</tr>
				</table>	
				<br>
			</div> 
			@endif

			<div class="row">
				<table class="table">
					<tr>
						<td>
							<br>
							<label for="label" class="control-label">Payment Info</label><br>
							<br>
							<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
							    <label for="email" class="col-md-3 control-label">Departure Journey Fare:</label>
							    <div class="col-md-3 col-md-offset-3">
							        <p id="departureJourneyFare"> </p>
							    </div>
							</div>
					 	</td>
				 	</tr>
				 	@if($destinationInclude == 1)
				 	<tr>
						<td>
							<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
							    <label for="email" class="col-md-3 control-label">Return Journey Fare:</label>
							    <div class="col-md-3 col-md-offset-3">

							        <p id="destinationJourneyFare"> </p>
							    </div>
							</div>
					 	</td>
				 	</tr>
				 	@endif
				 	<tr>
						<td>
							<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
							    <label for="email" class="col-md-3 control-label">Total Journey Fare:</label>
							    <div class="col-md-3 col-md-offset-3">
							        <p id="totalJourneyCost"> </p>
							    </div>
							</div>
					 	</td>
				 	</tr>
				</table> 	
			</div>     
		</div>	
	</div>
</div>	

@endsection

@section('additionalJS')
	

	 	<script type="text/javascript" src="{{url('js/moment.js')}}"></script>
	    <script type="text/javascript" src="{{url('js/bootstrap-datepicker.min.js')}}"></script>
	    <script type="text/javascript" src="{{url('js/wickedpicker.js')}}"></script>
	    <script type="text/javascript" src="{{url('datepicker/js/bootstrap-datetimepicker.min.js')}}"></script>

	    <script type="text/javascript">
	        $(function () {
	        	
	            $('.datepicker1').datepicker({
	                 //startDate:'0d'
	            });

	            $('.datepicker1').change(function() {
	                //var dateValue = $(this).val(); 
	                //console.log(dateValue);

	            });
	             $('.datepicker2').datepicker({
	                startDate:'0d'
	            });

	            $('.datepicker2').change(function() {
	                //var dateValue = $(this).val(); 
	                //console.log(dateValue);

	            });
	         });   
	    </script>
	<script type="text/javascript">
		
		var bookedSeatDeparture = $('#bookedSeatDeparture').text();
		var bookedSeatDestination = $('#bookedSeatDestination').text();
		var destinationInclude = {{$destinationInclude}};
		var destinationTripId = {{ isset($destinationTripId) ? $destinationTripId : 0  }};
		var departureTripId = {{ $departureTripId }};
		var price=[];
		var total ;
		var overAllCost=0 ;
		var passengerDeparture = {{ $dataDeparture['bookedSeatDeparture'] }};
		var passengerDestination = {{ $dataDestination['bookedSeatDestiantion'] }};

		//console.log(passengerDeparture , passengerDestination);
		if(passengerDestination)
		{
			if(passengerDeparture >= passengerDestination )
			{
				if(passengerDeparture == 1)
				{
					$('#maximumPassenger').val(2);
					console.log("ok 1");
				}
				else
				{
					$('#maximumPassenger').val(passengerDeparture);
				}	

			}
			else
			{
				$('#maximumPassenger').val(passengerDestination);
			}

		}
		else
		{
			$('#maximumPassenger').val(passengerDeparture);
		}	
			

		var dataTripPassengerPrice = <?php echo $dataTripPassengerPrice; ?>;

		$( document ).ready(function() {  
			var sum = 0;
			
			// console.log(bookedSeatDeparture);
			// console.log(bookedSeatDestination);.
			$('#destinationJourneyFare').text("0");
			$('#departureJourneyFare').text("0");
			$('#totalJourneyCost').text("0");


			$('.departureSelectedSeat').change(function()
			{
				$('#departureJourneyFare').text("");

				var inputs = $(".departureSelectedSeat");
				//console.log(dataTripPassengerPrice.length);
				//console.log(dataTripPassengerPrice.trip_id);
				//console.log(dataTripPassengerPrice[destinationTripId].length);
				for(var j=0,k=0; j< dataTripPassengerPrice.length; j++ )
				{
						if(dataTripPassengerPrice[j].trip_id == departureTripId)
						{
							price[k] = dataTripPassengerPrice[j].price_id;
							k++;
						}
				}

				var totalCostDeparture = 0;

				for(var i = 0; i < inputs.length; i++)
				{
		    		var input = $(inputs[i]).val();
		    		total =  input * price[i] ;
		    		totalCostDeparture = totalCostDeparture + total;
		    		overAllCost = overAllCost + totalCostDeparture;
		    		$('#departureJourneyFare').text(totalCostDeparture);
		    		var firstValue = parseFloat($('#departureJourneyFare').text());
		    		
		    		if(destinationTripId == 0)
					{
		    			var secondValue = 0;
		    		}
		    		else
		    		{
		    			var secondValue = parseFloat($('#destinationJourneyFare').text());
		    			$('#destinationFare').val(secondValue);
		    		}	
		    		$('#departureFare').val(firstValue);
		    		

		    		$('#totalJourneyCost').text(firstValue+secondValue);
		    		$('#totalFare').val(firstValue+secondValue);

		    	}


			});


			if(!destinationTripId == 0)
			{
				$('.destinationSelectedSeat').change(function()
				{
					$('#destinationJourneyFare').text("");

					var inputs = $(".destinationSelectedSeat");
					//console.log(dataTripPassengerPrice.length);
					//console.log(dataTripPassengerPrice.trip_id);
					//console.log(dataTripPassengerPrice[destinationTripId].length);
					for(var j=0,k=0; j< dataTripPassengerPrice.length; j++ )
					{
							if(dataTripPassengerPrice[j].trip_id == destinationTripId)
							{
								price[k] = dataTripPassengerPrice[j].price_id;
								k++;
							}
					}

					var totalCostDestination = 0;

					for(var i = 0; i < inputs.length; i++)
					{
			    		var input = $(inputs[i]).val();
			    		total =  input * price[i] ;
			    		totalCostDestination = totalCostDestination + total;
			    		overAllCost = overAllCost + totalCostDestination;
			    		$('#destinationJourneyFare').text(totalCostDestination);
			    		var firstValue = parseFloat($('#departureJourneyFare').text());
			    		$('#departureFare').val(firstValue);
			    		var secondValue = parseFloat($('#destinationJourneyFare').text());
			    		$('#destinationFare').val(secondValue);

			    		$('#totalJourneyCost').text(firstValue+secondValue);
			    		$('#totalFare').val(firstValue+secondValue);
			    	}


				});
			}


			
		});


		$( "#submit" ).click(function(e)
		{
    		var sum = 0;
		     

			if(destinationInclude == 0)
			{
				$('select[name^="departureSeatValue"]').each(function() {

			  		var numberValue = $(this).val();
			  		var integernumberValue = parseInt(numberValue);
			  		sum = sum + integernumberValue;
				});
				if(sum > bookedSeatDeparture)
		  		{
		  			
			    	alert("Seat Unavailable");
			    	sum = 0;
			    	return false;
		  		}
		  		else
		  		{
		  			$( "#ticketCollectorForm" ).submit();
		  		}	

			}
			if(destinationInclude == 1)
			{
				$('select[name^="departureSeatValue"]').each(function() {

			  		var numberValue = $(this).val();
			  		var integernumberValue = parseInt(numberValue);
			  		sum = sum + integernumberValue;

				});
				if(sum > bookedSeatDeparture)
		  		{
			    	alert("Seat Unavailable");
			    	return false;
		  		}
		  		else
		  		{
		  			sum = 0;
		  		}	

				$('select[name^="destinationSeatValue"]').each(function() {
				    var numberValue = $(this).val();
			  		var integernumberValue = parseInt(numberValue);

			  		console.log(integernumberValue);
			  		sum = sum + integernumberValue;
			  		console.log(sum);
			  			
				});
				if(sum > bookedSeatDestination)
		  		{
		  			
			    	alert("Seat Unavailable");
			    	return false;
			    	
		  		}
		  		else
		  		{
		  			$( "#ticketCollectorForm" ).submit();
		  		}	
			  		
			}
			 
		});
	</script>

@endsection


