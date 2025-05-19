@extends('layouts.header')
@section('css')
<link href="{{ asset('login_css/css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> List of CAR</h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover tables" >
                            <thead>
                                <tr>
                                    <th>Finding ID</th>
                                    <th>Non-Conformance Description</th>
                                    <th>Status</th>
                                    <th>Responsible Person</th>
                                    <th>Target Completion Date</th>
                                    <th>Proof / Evidence</th>
                                    <th>Action Required</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cars as $car)
                                    <tr>
                                        <td>CAR-{{ str_pad($car->id,3,'0',STR_PAD_LEFT) }}</td>
                                        <td>{{ $car->description_of_nonconformity }}</td>
                                        <td>
                                            {{-- @if($car->status == 'Open')
                                            <span class="label label-primary">
                                            @elseif($car->status == 'In Progress')
                                            <span class="label label-warning">
                                            @elseif($car->status == 'Closed')
                                            <span class="label label-danger">
                                            @endif

                                            </span> --}}
                                            {{ $car->status }}
                                        </td>
                                        <td>{{ $car->auditee->name  }}</td>
                                        <td>
                                            @foreach ($car->correctiveAction as $key => $corrective_action)
                                                {{ date('M d Y', strtotime($corrective_action->action_date)) }} - {{ $corrective_action->status }} <br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($car->correctiveAction as $key => $corrective_action)
                                                @if($corrective_action->file_attachments)
                                                <a href="{{ url($corrective_action->file_attachments) }}" target="_blank">
                                                    <i class="fa fa-file"></i> 
                                                </a> <br>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($car->correctiveAction as $key => $corrective_action)
                                                @if($corrective_action->corrective_action)
                                                    {!! nl2br(e($corrective_action->corrective_action)) !!} <br>
                                                @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Status of CAR per Department</h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover tables" >
                            <thead>
                                <tr>
                                    <th>Department</th>
                                    <th>Open CARs</th>
                                    <th>In Progress CARs</th>
                                    <th>Closed CARs</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($car_per_dept_array as $car)
                                    <tr>
                                        <td>{{ $car->department }}</td>
                                        <td>{{ $car->open }}</td>
                                        <td>{{ $car->in_progress }}</td>
                                        <td>{{ $car->closed }}</td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('login_css/js/plugins/dataTables/datatables.min.js')}}"></script>
<script>
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
</script>
@endsection