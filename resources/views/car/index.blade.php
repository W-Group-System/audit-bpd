@extends('layouts.header')
@section('css')
<link href="{{ asset('login_css/css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>CAR </h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">0</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Open</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">0</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Closed</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">0</h1>
                </div>
            </div>
        </div>
        
    </div>
    <div class='row'>
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Corrective Action Request <button class="btn btn-success" data-target="#new" data-toggle="modal" type="button"><i class="fa fa-plus"></i>&nbsp;New CAR</button></h5>
                </div>
                <div class="ibox-content">
                    @include('components.error')
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover tables" >
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>CAR #</th>
                                    <th>Standard and Clause</th>
                                    <th>Classification of Nonconformity</th>
                                    <th>Nature of Nonconformity</th>
                                    <th>Type of Nonconformity</th>
                                    <th>Issued By</th>
                                    <th>Issued To</th>
                                    <th>Issued Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($corrective_action_requests as $car)
                                    <tr>
                                        <td>
                                            <button type="button" class="btn btn-warning btn-sm">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </button>
                                        </td>
                                        <td>CAR-{{ str_pad($car->id,3,'0',STR_PAD_LEFT) }}</td>
                                        <td>{!! nl2br(e($car->standard_and_clause)) !!}</td>
                                        <td>{{ $car->classification_of_nonconformity }}</td>
                                        <td>{{ $car->nature_of_nonconformity }}</td>
                                        <td>{{ $car->type_of_nonconformity }}</td>
                                        <td>{{ $car->auditor->name }}</td>
                                        <td>{{ $car->auditee->name }}</td>
                                        <td>{{ date('M d Y', strtotime($car->created_at)) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('car.create')
@endsection

@section('js')
<script src="{{ asset('login_css/js/plugins/dataTables/datatables.min.js')}}"></script>
<script src="{{ asset('login_css/js/plugins/chosen/chosen.jquery.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.cat').chosen({width:"100%"});

        $('.tables').DataTable({
            pageLength: 25,
            responsive: true,
            stateSave: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                { extend: 'copy'},
                {extend: 'csv'},
                {extend: 'excel', title: 'ExampleFile'},
                {extend: 'pdf', title: 'ExampleFile'},

                {extend: 'print',
                    customize: function (win){
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');

                        $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                }
                }
            ]
        });
    })
</script>
@endsection