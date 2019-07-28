@extends('layouts.app')

@section('additionalCSS')
<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}">
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Add Trip</div>
                <div class="panel-body">
                    <form class="form" role="form" method="POST" action="{{ route('add_trip_post') }}">
                        {{ csrf_field() }}

                        <div class="col-md-4">
                            <h2>Information</h2>

                            <div class="form-group{{ $errors->has('company_id') ? ' has-error' : '' }}">
                                <label for="company_id">Company Name</label>
                                <select class="form-control" id="company_id" name="company_id" >
                                    <option value="">Select Company</option>

                                    @foreach($companies as $company)
                                        <option value="{{ $company['id'] }}" {{ old('company_id') == $company['id'] ? 'selected' : '' }}>{{ $company['name'] }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('company_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('company_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('ferry_id') ? ' has-error' : '' }}">
                                <label for="ferry_id">Ferry</label>
                                <select class="form-control" id="ferry_id" name="ferry_id" >
                                    <option value="">Select Ferry</option>
                                </select>

                                @if ($errors->has('ferry_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ferry_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('departure_port_id') ? ' has-error' : '' }}">
                                <label for="departure_port_id">Departure Port</label>
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

                            <div class="form-group{{ $errors->has('destination_port_id') ? ' has-error' : '' }}">
                                <label for="destination_port_id">Arrival Port</label>
                                <select class="form-control" name="destination_port_id" >
                                    <option value="">Select Arrival Port</option>

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

                        <div class="col-md-4">
                            <h2>Ticket Price</h2>

                            @foreach($passenger_type as $type)
                                <div class="form-group{{ $errors->has('price.'.$type->id) ? ' has-error' : '' }}">
                                    <label>{{ $type->name}}</label>
                                    <input class="form-control" type="text" name="price[{{ $type->id }}]" value="{{ old('price.'.$type->id)}}">

                                    @if ($errors->has('price.'.$type->id))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('price.'.$type->id) }}</strong>
                                        </span>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <div class="col-md-4">
                            <h2>Schedule</h2>
                            
                            <div class="radio">
                                <label>
                                    <input class="schedule_type" type="radio" name="schedule_type" value="1" checked>Manual
                                </label>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('manual_departure_date') ? ' has-error' : '' }}">
                                        <label for="manual_departure_date">Departure Date</label>
                                        <input class="form-control manual-item" type="text" name="manual_departure_date" id="manual_departure_date" value="{{ old('manual_departure_date') }}">

                                        @if ($errors->has('manual_departure_date'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('manual_departure_date') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('manual_departure_time') ? ' has-error' : '' }}">
                                        <label for="manual_departure_time">Departure Time</label>
                                        <input class="form-control manual-item" type="text" name="manual_departure_time" id="manual_departure_time" value="{{ old('manual_departure_time') }}">

                                        @if ($errors->has('manual_departure_time'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('manual_departure_time') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="radio">
                                <label>
                                    <input type="radio" class="schedule_type" name="schedule_type" value="2" {{ old('schedule_type') == '2' ? 'checked' : '' }}>Automatic
                                </label>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('automatic_date_from') ? ' has-error' : '' }}">
                                        <label for="automatic_date_from">From</label>
                                        <input class="form-control automatic-item" type="text" name="automatic_date_from" id="automatic_date_from">

                                        @if ($errors->has('automatic_date_from'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('automatic_date_from') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('automatic_date_to') ? ' has-error' : '' }}">
                                        <label for="automatic_date_to">To</label>
                                        <input class="form-control automatic-item" type="text" name="automatic_date_to" id="automatic_date_to">

                                        @if ($errors->has('automatic_date_to'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('automatic_date_to') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company_id">Days</label> <br>
                                        <input class="day automatic-item" type="checkbox" name="day[1]" value="1"> Monday <br>
                                        <input class="day automatic-item" type="checkbox" name="day[2]" value="2"> Tuesday<br>
                                        <input class="day automatic-item" type="checkbox" name="day[3]" value="3"> Wednesday<br>
                                        <input class="day automatic-item" type="checkbox" name="day[4]" value="4"> Thursday<br>
                                        <input class="day automatic-item" type="checkbox" name="day[5]" value="5"> Friday<br>
                                        <input class="day automatic-item" type="checkbox" name="day[6]" value="6"> Saturday<br>
                                        <input class="day automatic-item" type="checkbox" name="day[0]" value="0"> Sunday
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('automatic_time') ? ' has-error' : '' }}">
                                        <label for="automatic_time">Departure Time</label>
                                        <input class="form-control automatic-item" type="text" name="automatic_time" id="automatic_time">

                                        @if ($errors->has('automatic_time'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('automatic_time') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">
                                    Add
                                </button>
                                <a class="btn btn-default" href="{{ route('view_all_trip') }}">Cancel</a>
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
<script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
<script type="text/javascript">
    $(function() {
        var companies = <?php echo json_encode($companies, JSON_PRETTY_PRINT); ?>;
        var old_ferry_id = '{{ old('ferry_id') }}';
        
        $('#company_id').change(function() {
            var id = $(this).val();
            $('#ferry_id').html('<option value="">Select Ferry</option>');

            $.each(companies, function(index, company) {
                if (company.id == id) {
                    $.each(company.ferries, function(ferry_index, ferry) {
                        if (ferry.id == old_ferry_id)
                            $('#ferry_id').append('<option value="'+ferry.id+'" selected>'+ferry.name+'</option>');
                        else
                            $('#ferry_id').append('<option value="'+ferry.id+'">'+ferry.name+'</option>');
                    })
                }
            });
        });

        $('#company_id').trigger('change');

        $('#manual_departure_date').datetimepicker({
            format: 'YYYY-MM-DD',
            minDate: moment()
        });

        $('#manual_departure_time').datetimepicker({
            format: 'HH:mm',
        });

        $('#automatic_date_from').datetimepicker({
            format: 'YYYY-MM-DD',
            minDate: moment()
        });

        $('#automatic_date_to').datetimepicker({
            useCurrent: false, //Important! See issue #1075
            format: 'YYYY-MM-DD'
        });

        $("#automatic_date_from").on("dp.change", function (e) {
            $('#automatic_date_to').data("DateTimePicker").minDate(e.date);
        });

        $("#automatic_date_to").on("dp.change", function (e) {
            $('#automatic_date_from').data("DateTimePicker").maxDate(e.date);
        });

        $('#automatic_time').datetimepicker({
            format: 'HH:mm',
        });

        $('.schedule_type').click(function() {
            if ($(this).val() == '1') {
                // Manual
                $('.automatic-item').attr('disabled', true);
                $('.manual-item').attr('disabled', false);
            } else {
                // Automatic
                $('.manual-item').attr('disabled', true);
                $('.automatic-item').attr('disabled', false);
            }
        });

        $('.schedule_type:checked').trigger('click');
    });
</script>
@stop