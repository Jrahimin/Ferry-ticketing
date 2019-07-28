@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">Add Port</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('add_port_post') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('city_name') ? ' has-error' : '' }}">
                            <label for="city_name" class="col-md-4 control-label">City Name</label>

                            <div class="col-md-6">
                                <input id="city_name" type="text" class="form-control" name="city_name" value="{{ old('city_name') }}">

                                @if ($errors->has('city_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('city_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('country_code') ? ' has-error' : '' }}">
                            <label for="country_code" class="col-md-4 control-label">Country</label>

                            <div class="col-md-6">
                                <select class="form-control" name="country_code">
                                    <option>Select Country</option>
                                    @foreach($countries as $code => $country)
                                        <option value="{{$code}}">
                                            {{ $country }} 
                                        </option>
                                    @endforeach
                                </select>

                                @if ($errors->has('country_code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('country_code') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ ($errors->has('latitude') || $errors->has('longitude')) ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Location</label>

                            <div class="col-md-3">
                                <input id="latitude" type="text" class="form-control" name="latitude" value="{{ old('latitude') ? old('latitude') : '40.7324319' }}">

                                
                                @if ($errors->has('latitude'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('latitude') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-3">
                                <input id="longitude" type="text" class="form-control" name="longitude" value="{{ old('longitude') ? old('longitude') : '-73.82480777777776' }}">

                                @if ($errors->has('longitude'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('longitude') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div id="map" style="width: 100%; height: 250px;">    
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Add
                                </button>
                                <a class="btn btn-default" href="{{ route('view_all_port') }}">Cancel</a>
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
<script type="text/javascript" src='http://maps.google.com/maps/api/js?sensor=false&libraries=places&key=AIzaSyB7UxsEtYUqkRdMHSuOXSLbdc-LHt1CxYs'></script>
<script type="text/javascript" src="{{ asset('js/locationpicker.jquery.min.js') }}"></script>
<script>
    $(function() {
        var lat = $('#latitude').val();
        var lng = $('#longitude').val();

        $('#map').locationpicker({
            location: {
                latitude: lat,
                longitude: lng
            },
            radius: 0,
            zoom: 15,
            onchanged: function(currentLocation, radius, isMarkerDropped) {
                var latitude = currentLocation.latitude;
                var longitude = currentLocation.longitude;
                $('#longitude').val(currentLocation.longitude);
                $('#latitude').val(currentLocation.latitude) ;
            },
            inputBinding: {
                latitudeInput: $('#latitude'),
                longitudeInput: $('#longitude'),
            },
        });

        $('#latitude, #longitude').keyup(function() {
            var lat = $('#latitude').val();
            var lng = $('#longitude').val();

            $('#map').locationpicker({
                location: {
                    latitude: lat,
                    longitude: lng,
                },
                radius: 0,
            });
        });
    });
</script>
@stop