@extends('FerryCompanyAdmin.layouts.app')

@section('additionalCSS')
    <style type="text/css">
        .btn-default.btn-on.active{background-color: #5BB75B;color: white;}
        .btn-default.btn-off.active{background-color: #DA4F49;color: white;}

        .btn-default.btn-on-1.active{background-color: #006FFC;color: white;}
        .btn-default.btn-off-1.active{background-color: #DA4F49;color: white;}

        .btn-default.btn-on-2.active{background-color: #00D590;color: white;}
        .btn-default.btn-off-2.active{background-color: #A7A7A7;color: white;}

        .btn-default.btn-on-3.active{color: #5BB75B;font-weight:bolder;}
        .btn-default.btn-off-3.active{color: #DA4F49;font-weight:bolder;}

        .btn-default.btn-on-4.active{background-color: #006FFC;color: #5BB75B;}
        .btn-default.btn-off-4.active{background-color: #DA4F49;color: #DA4F49;}
    </style>
@endsection

@section('content')
<?php
 $asset = asset('/');
?>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.js"></script>
    <script type="text/javascript">
    $( document ).ready(function() {
            $("#checkboxId").change(function(){
                var check = this.checked;
                if(check){
                    $("#dropdownId").prop("disabled",true);
                }
                else{
                    $("#dropdownId").prop("disabled",false);
                }
            });
        });
    </script>

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
                <div class="panel-heading"><center><h3> Edit Ferry </h3> </center></div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('updateCompanyFerry', ['ferryId' => $edit->id]) }}"  enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{$edit->name}}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('captainName') ? ' has-error' : '' }}">
                            <label for="captainName" class="col-md-4 control-label">Captain Name</label>

                            <div class="col-md-6">
                                <input id="captainName" type="text" class="form-control" name="captainName" value="{{ $edit->captain_name}}" required autofocus>

                                @if ($errors->has('captainName'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('captainName') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('numberOfSeat') ? ' has-error' : '' }}">
                            <label for="numberOfSeat" class="col-md-4 control-label">Number Of Seat</label>

                            <div class="col-md-6">
                                <input id="numberOfSeat" type="number" class="form-control" name="numberOfSeat" value="{{ $edit->number_of_seat }}" required autofocus min="0">

                                @if ($errors->has('numberOfSeat'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('numberOfSeat') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                            <label for="status" class="col-md-4 control-label">Status</label>

                            <div class="col-md-5">
                                <div class="btn-group" id="status" data-toggle="buttons">
                                  <label class="btn btn-default btn-on {{ $edit->status == 1 ? 'active' : '' }}" >
                                  <input type="radio" value="1" name="status" {{ $edit->status == 1 ? 'checked' : '' }}>Activate</label>
                                  <label class="btn btn-default btn-off {{ $edit->status == 0 ? 'active' : '' }} ">
                                  <input type="radio" value="0" name="status" {{ $edit->status == 0 ? 'class="active" checked' : '' }}>Inactivate</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('numberOfCrew') ? ' has-error' : '' }}">
                            <label for="numberOfCrew" class="col-md-4 control-label">Number Of Crew</label>

                            <div class="col-md-6">
                                <input id="numberOfCrew" type="text" class="form-control" name="numberOfCrew" value="{{ $edit->number_of_crew  }}" required>

                                @if ($errors->has('numberOfCrew'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('numberOfCrew') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('logo') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Image</label>
                            <div class="col-md-6" >
                                <img id="logoPreview" src="{{$asset}}{{$edit->image_url}}" alt="Image " height="90px" width="90px"/>

                                <button class="btn btn-default" type="button" id="get_file"><span class="glyphicon glyphicon-picture" aria-hidden="true"></span> Upload</button>
                                    
                                <input name="image" type="file" id="logo" style=" display: none;">
                                    @if($errors->has('logo'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('logo') }}</strong>
                                        </span>
                                    @endif
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

<script type="text/javascript">
$(function() {
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#logoPreview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#logo").change(function(){
        readURL(this);
    });

    $('#get_file').click(function(){
        $('#logo').click();
    });
})
    
</script>
@stop