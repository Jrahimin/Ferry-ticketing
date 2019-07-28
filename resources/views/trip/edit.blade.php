@extends('layouts.app')

@section('additionalCSS')
<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}">
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">Edit Trip</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('edit_trip_post', ['trip' => $trip->id]) }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('company_id') ? ' has-error' : '' }}">
                            <label for="company_id" class="col-md-4 control-label">Company Name</label>

                            <div class="col-md-6">
                                <select class="form-control" id="company_id" name="company_id" >
                                    <option value="">Select Company</option>

                                    @foreach($companies as $company)
                                        <option value="{{ $company['id'] }}" {{ $trip->company_id == $company['id'] ? 'selected' : '' }}>{{ $company['name'] }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('company_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('company_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('ferry_id') ? ' has-error' : '' }}">
                            <label for="ferry_id" class="col-md-4 control-label">Ferry Name</label>

                            <div class="col-md-6">
                                <select class="form-control" id="ferry_id" name="ferry_id" >
                                    <option value="">Select Ferry</option>
                                </select>

                                @if ($errors->has('ferry_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ferry_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="total_seat" class="col-md-4 control-label">Total Seat</label>

                            <div class="col-md-6">
                                <input id="total_seat" type="text" class="form-control" value="{{ $trip->ferry_total_seat }}" disabled>
                                <input type="hidden" name="total_seat" value="{{ $trip->ferry_total_seat }}">
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('available_seat') ? ' has-error' : '' }}">
                            <label for="available_seat" class="col-md-4 control-label">Available Seat</label>

                            <div class="col-md-6">
                                <input id="available_seat" type="text" class="form-control" name="available_seat" value="{{ $trip->ferry_remaining_seat }}">

                                @if ($errors->has('available_seat'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('available_seat') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('departure_date') ? ' has-error' : '' }}">
                            <label for="departure_date" class="col-md-4 control-label">Departure Date</label>

                            <div class="col-md-6">
                                <input id="departure_date" type="text" class="form-control" name="departure_date" value="{{ $trip->departure_date }}">

                                @if ($errors->has('departure_date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('departure_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('departure_time') ? ' has-error' : '' }}">
                            <label for="departure_time" class="col-md-4 control-label">Departure Time</label>

                            <div class="col-md-6">
                                <input id="departure_time" type="text" class="form-control" name="departure_time" value="{{ $trip->departure_time }}">

                                @if ($errors->has('departure_time'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('departure_time') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('departure_port_id') ? ' has-error' : '' }}">
                            <label for="departure_port_id" class="col-md-4 control-label">Departure Port</label>

                            <div class="col-md-6">
                                <select class="form-control" id="departure_port_id" name="departure_port_id" >
                                    <option value="">Select Departure Port</option>

                                    @foreach($ports as $port)
                                        <option value="{{ $port->id }}" {{ $port->id == $trip->departure_port_id ? 'selected' : '' }}>{{ $port->name }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('departure_port_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('departure_port_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('destination_port_id') ? ' has-error' : '' }}">
                            <label for="destination_port_id" class="col-md-4 control-label">Destination Port</label>

                            <div class="col-md-6">
                                <select class="form-control" id="destination_port_id" name="destination_port_id" >
                                    <option value="">Select Departure Port</option>

                                    @foreach($ports as $port)
                                        <option value="{{ $port->id }}" {{ $port->id == $trip->destination_port_id ? 'selected' : '' }}>{{ $port->name }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('destination_port_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('destination_port_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <hr> <h2 class="text-center">Ticket Price</h2> <hr>

                        @foreach($passenger_type as $type)
                            <div class="form-group{{ $errors->has('price.'.$type->id) ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">{{ $type->name}}</label>

                                <div class="col-md-6">
                                    <?php 
                                        $p = 0;

                                        foreach($trip->prices as $item) {
                                            if ($item->passenger_type_id == $type->id) {
                                                $p = $item->price;
                                                break;
                                            }
                                        }
                                    ?>

                                    <input class="form-control" type="text" name="price[{{ $type->id }}]" value="{{ $p }}">

                                    @if ($errors->has('price.'.$type->id))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('price.'.$type->id) }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Save
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
        var old_ferry_id = '{{ $trip->ferry_id }}';

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

        $('#ferry_id').on('change', function() {
            $('#total_seat').val(0);
            $.each(companies, function(index, company) {
                $.each(company.ferries, function(ferry_index, ferry) {
                    if (ferry.id == $('#ferry_id').val()){
                        //console.log(ferry.number_of_seat+' d');
                        $('#total_seat').val(ferry.number_of_seat);
                    }
                })
            });
        });

        $('#departure_date').datetimepicker({
            format: 'YYYY-MM-DD',
            minDate: moment()
        });

        $('#departure_time').datetimepicker({
            format: 'HH:mm',
        });
    });
</script>
@stop