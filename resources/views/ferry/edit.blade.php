<?php use App\Enumeration\RoleType; ?>
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">Edit Ferry</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('edit_ferry_post', ['ferry' => $ferry->id]) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') ? old('name') : $ferry->name }}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        @if (Auth::user()->role == RoleType::$ADMIN)
                            <div  class="form-group{{ $errors->has('company_id') ? ' has-error' : '' }}">
                                  <label class="col-md-4 control-label" for="company_id">Company Name</label>
                                  <div class="col-md-6">
                                      <select class="form-control" name="company_id" >
                                        <option value="">Select Company</option>
                                        @foreach($companies as $company)
                                            <option value="{{$company->id}}" {{ $company->id == $ferry->company_id ? 'selected' : '' }}> {{$company->name}}</option>
                                        @endforeach
                                      </select>

                                      @if ($errors->has('company_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('company_id') }}</strong>
                                        </span>
                                    @endif
                                  </div>
                            </div>
                        @endif

                        <div class="form-group{{ $errors->has('captain_name') ? ' has-error' : '' }}">
                            <label for="captain_name" class="col-md-4 control-label">Captain Name</label>

                            <div class="col-md-6">
                                <input id="captain_name" type="text" class="form-control" name="captain_name" value="{{ old('captain_name') ? old('captain_name') : $ferry->captain_name }}">

                                @if ($errors->has('captain_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('captain_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('number_of_seat') ? ' has-error' : '' }}">
                            <label for="number_of_seat" class="col-md-4 control-label">Number Of Seat</label>

                            <div class="col-md-6">
                                <input id="number_of_seat" type="number" class="form-control" name="number_of_seat" value="{{ old('number_of_seat') ? old('number_of_seat') : $ferry->number_of_seat }}">

                                @if ($errors->has('number_of_seat'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('number_of_seat') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('number_of_crew') ? ' has-error' : '' }}">
                            <label for="number_of_crew" class="col-md-4 control-label">Number Of Crew</label>

                            <div class="col-md-6">
                                <input id="number_of_crew" type="number" class="form-control" name="number_of_crew" value="{{ old('number_of_crew') ? old('number_of_crew') : $ferry->number_of_crew }}">

                                @if ($errors->has('number_of_crew'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('number_of_crew') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="status" class="col-md-4 control-label">Active</label>

                            <div class="col-md-6">
                                <label class="switch">
                                    <input type="checkbox" name="status" {{ $ferry->status == '1' ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('logo') ? ' has-error' : '' }}">
                            <label for="logo" class="col-md-4 control-label">Logo</label>
                            <div class="col-md-6" >
                                <img id="logoPreview" src="{{ asset($ferry->image_url) }}" alt="Invalid Image" height="90px" width="90px"/>

                                <button class="btn btn-default" type="button" id="get_file"><span class="glyphicon glyphicon-picture" aria-hidden="true"></span> Change</button>
                                    
                                <input name="logo" type="file" id="logo" style=" display: none;" accept="image/*">
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
                                    Save
                                </button>
                                <a class="btn btn-default" href="{{ route('view_all_ferry') }}">Cancel</a>
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
    });
</script>
@stop