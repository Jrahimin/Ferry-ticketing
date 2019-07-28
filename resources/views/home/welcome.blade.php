@extends('layouts.app')

@section('additionalCSS')
<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}">
@stop

@section('content')
<div class="container">
    <div class="jumbotron">
        <form class="form" action="{{ route('search_trip') }}" method="GET">
            <div class="row">
                <div class="col-md-12">
                    <label class="radio-inline">
                        <input class="trip_type" type="radio" name="trip_type" id="trip_type_one" value="1" {{ old('trip_type') == '1' ? 'checked' : ''}}> One Way
                    </label>
                    <label class="radio-inline">
                        <input class="trip_type" type="radio" name="trip_type" id="trip_type_round" value="2" {{ old('trip_type') == '1' ? '' : 'checked'}}> Round Trip
                    </label>

                    <hr>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2">
                    <div class="form-group{{ $errors->has('departure_port_id') ? ' has-error' : '' }}">
                        <label for="departure_port_id">From</label>
                        <select class="form-control" name="departure_port_id">
                            <option value="">Select Departure Port</option>

                            @foreach($ports as $port)
                                <option value="{{ $port->id }}" {{ old('departure_port_id') == $port->id ? 'selected' : '' }}>{{ $port->name }}</option>
                            @endforeach
                        </select>

                        @if ($errors->has('departure_port_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('departure_port_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group{{ $errors->has('destination_port_id') ? ' has-error' : '' }}">
                        <label for="destination_port_id">To</label>
                        <select class="form-control" name="destination_port_id">
                            <option value="">Select Destination Port</option>

                            @foreach($ports as $port)
                                <option value="{{ $port->id }}" {{ old('destination_port_id') == $port->id ? 'selected' : '' }}>{{ $port->name }}</option>
                            @endforeach
                        </select>

                        @if ($errors->has('destination_port_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('destination_port_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group{{ $errors->has('departure_date') ? ' has-error' : '' }}">
                        <label for="departure_date">Departure Date</label>
                        <input type="text" class="form-control" id="departure_date" name="departure_date">

                        @if ($errors->has('departure_date'))
                            <span class="help-block">
                                <strong>{{ $errors->first('departure_date') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group{{ $errors->has('return_date') ? ' has-error' : '' }} form-group-return-date {{ old('trip_type') == '1' ? 'hide' : '' }}">
                        <label for="return_date">Return Date</label>
                        <input type="text" class="form-control" id="return_date" name="return_date">

                        @if ($errors->has('return_date'))
                            <span class="help-block">
                                <strong>{{ $errors->first('return_date') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="pax">No. of Pax</label>
                        <select class="form-control" name="pax">
                            @for($i=1; $i<=10; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for=""></label>
                        <button class="btn btn-primary form-control" type="submit">Search</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@stop

@section('additionalJS')
<script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
<script type="text/javascript">
    $(function() {
        $('#departure_date').datetimepicker({
            defaultDate: moment().add(1, 'days'),
            format: 'YYYY-MM-DD',
            minDate: moment()
        });

        $('#return_date').datetimepicker({
            defaultDate: moment().add(2, 'days'),
            useCurrent: false, //Important! See issue #1075
            format: 'YYYY-MM-DD'
        });

        $("#departure_date").on("dp.change", function (e) {
            $('#return_date').data("DateTimePicker").minDate(e.date);
        });

        $("#return_date").on("dp.change", function (e) {
            $('#departure_date').data("DateTimePicker").maxDate(e.date);
        });

        $('.trip_type').click(function() {
            if ($(this).val() == '1') {
                // One way
                $('.form-group-return-date').addClass('hide');
            } else {
                // Round trip
                $('.form-group-return-date').removeClass('hide');
            }
        });
    });
</script>
@stop