@extends('Customer.layouts.app')



@section('content')
	
    @if($flag == 0)
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-10 col-md-offset-1">
                <div class="alert alert-danger alert-dismissible fade in text-center" role="alert">
                    <strong>Error!</strong> A problem has been occurred In your Payment Process. Please Re check.
                </div>
            </div>

            <div class="col-md-10 col-md-offset-9">
                <div class="">
                    <a href="{{route('passengerDetails')}}"> Go To payment Section</a>
                </div>
            </div>
      </div>
    </div>

    @else

    <div class="container-fluid">
        <div class="row">

            <div class="col-md-10 col-md-offset-1">
                <div class="alert alert-danger alert-dismissible fade in text-center" role="alert">
                    <strong>Error!</strong> A problem has been occurred In your Payment Process Or Ticketing Sytem. Please Re check.
                </div>
            </div>

            

            <div class="col-md-10 col-md-offset-9">
                <div class="">
                    <a href="{{route('passengerDetails')}}"> Go To payment Section</a>
                </div>
            </div>


      </div>
    </div>

    @endif

@endsection