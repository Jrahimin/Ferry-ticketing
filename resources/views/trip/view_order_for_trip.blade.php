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
                        <th>Trip Type</th>
                        <th>Customer Email</th>
                        <th>Contact No</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>@if($order->trip_type === 1) One Way Trip @else Round Trip @endif</td>
                            <td>{{ $order->email }}</td>
                            <td>{{ $order->contact_no }}</td>

                            <td class="text-right">
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
                                        <li><a href="{{ route('view_ticket', ['orderId' => $order->id]) }}">View Tickets</a></li>
                                        <li><a href="{{ route('order_print', ['orderId' => $order->id]) }}">Print Order</a></li>
                                        <li><a class="delete" data-id="{{ $order->id }}" data-toggle="modal" data-target="#deleteModal">Delete</a></li>
                                    </ul>
                                </div>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="pagination"> {{ $orders->links() }} </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Delete</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure want to delete?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button id="btnDelete" type="button" class="btn btn-danger">Delete</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
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

            $('.delete').click(function(){
                var id = $(this).data('id');
                var index = $(this).closest('tr').index();

                $("#btnDelete").attr("data-id", id);
                $("#btnDelete").attr("data-index", index);
            });

            $('#btnDelete').click(function(){
                //alert($(this).attr('data-id'));\
                var id = $(this).attr('data-id');
                var index = parseInt($(this).attr('data-index'))+1;

                $.ajax({
                    method: "POST",
                    url: "{{ route('delete_order') }}",
                    data: { id: id }
                }).done(function( data ) {
                    if (data.success == false) {
                        alert(data.message);
                    } else {
                        $('#deleteModal').modal('toggle');
                        $( 'tr:eq( '+index+' )' ).remove();
                    }
                });
            });
        })
    </script>
@stop