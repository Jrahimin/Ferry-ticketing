@extends('FerryAdmin.layouts.app')

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
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">

                <div class="panel panel-primary">

                	<div class="panel-heading">

                    		<h3 class="panel-title">General</h3>
                    </div>

            	<div class="panel-body">
            		<form class="form-horizontal" role="form" method="POST" action="{{ route('update_settings') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Company Name</label>
                            
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="CompanyName" value="{{$settings['CompanyName']}}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('logo') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label" for="logo">Logo</label>
                            <div class="col-md-6">
                                <img id="logoPreview" src="{{asset($settings['CompanyLogo'])}}" alt="logo" height="50px" width="50px" name="CompanyLogo" />

                                <button class="btn btn-default" type="button" id="get_file"><span class="glyphicon glyphicon-picture" aria-hidden="true"></span> Change</button>
                                
                                <input name="CompanyLogo" type="file" id="logo" style=" display: none;">
                                @if ($errors->has('logo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('logo') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
                            <label for="location" class="col-md-4 control-label">Company Location</label>

                            <div class="col-md-6">
                                <input id="location" type="text" class="form-control" name="CompanyAddress" value="{{$settings['CompanyAddress']}}">

                                @if ($errors->has('location'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('location') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="phone" class="col-md-4 control-label">Phone</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control" name="CompanyPhone" value="{{$settings['CompanyPhone']}}">

                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
	               </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('additionalJS')
<script type="text/javascript">
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
</script>
@stop