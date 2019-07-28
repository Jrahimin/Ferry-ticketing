@extends('layouts.app')

@section('additionalCSS')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}">
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-hover table-striped">
                    <thead>
                    <tr>
                        <th>Order Id</th>
                        <th>Email</th>
                        <th>Contact No</th>
                        <th></th>
                    </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>{{ $ticket->order->id }}</td>
                            <td>{{ $ticket->order->email }}</td>
                            <td>{{ $ticket->order->contact_no }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('additionalJS')
    <script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script type="text/javascript">
        $(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': '{!! csrf_token() !!}'
                }
            });

            $('#start_date').datetimepicker({
                format: 'YYYY-MM-DD'
            });

            $('#end_date').datetimepicker({
                useCurrent: false, //Important! See issue #1075
                format: 'YYYY-MM-DD'
            });

            $("#start_date").on("dp.change", function (e) {
                $('#end_date').data("DateTimePicker").minDate(e.date);
            });

            $("#end_date").on("dp.change", function (e) {
                $('#start_date').data("DateTimePicker").maxDate(e.date);
            });
        })
    </script>
@stop