@extends('layouts.header')
@section('css')
<link href="{{ asset('login_css/css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">
<!-- c3 Charts -->
<link href="{{ asset('login_css/css/plugins/c3/c3.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Total CAR </h5>
                    <div class="pull-right">
                        <span class="label label-success">as of {{ date('Y-m-d') }}</span>
                    </div>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ count($cars) }}</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Total Open CAR</h5>
                    <div class="pull-right">
                        <span class="label label-primary">as of {{ date('Y-m-d') }}</span>
                    </div>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ count($cars->where('status','!=','Closed')) }}</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    @php
                        $closed_car = (intval((count($cars->where('status','Closed')))) / intval((count($cars)))) * 100;
                    @endphp
                    <h5>Total Closed CAR</h5>
                    <div class="pull-right">
                        <span class="label label-danger">as of {{ date('Y-m-d') }}</span>
                    </div>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ count($cars->where('status','Closed')) }} ({{ round($closed_car, 2) }}%)</h1>
                </div>
            </div>
        </div>
    </div>
    @if(auth()->user()->role->name != "Auditee")
    <div class="row">
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Root Cause Analysis Percentage</h5>
                    <div class="pull-right">
                        <span class="label label-warning">as of {{ date('Y-m-d') }}</span>
                    </div>
                </div>
                <div class="ibox-content" style="height: 538px;">
                    <div>
                        <div id="pie"></div>
                    </div>
                    <div class="panel panel-primary">
                        <div class="panel-heading">INFO</div>
                        <div class="panel-body">
                            <p>
                                <b>Man</b> - The findings was caused by Human error such as insufficient training, miscommunication and failure to follow the policy.
                            </p>
                            <p>
                                <b>Method</b> - The findings was caused due to incorrect procedures, unclear work instructions and lack of Standardized Processes.
                            </p>
                            <p>
                                <b>Combined (Man & Method)</b> - The findings was caused due to absences of Policies and incorrect implementation by personnel.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Root Cause Analysis</h5>
                    <div class="pull-right">
                        <span class="label label-warning">as of {{ date('Y-m-d') }}</span>
                    </div>
                </div>
                <div class="ibox-content" style="height:538px; overflow:auto;">
                    <div class="row">
                        {{-- <div class="col-md-2">
                            <p style="font-weight: bold;">MAN</p>
                            @php
                                $num = 0;
                                $man_analysis = $rca->whereNotIn('man',['N/A','n/a',null]);
                            @endphp
                            @foreach ($man_analysis as $man)
                                {{ $num+=1 }}. <a href="javascript:void(0)" data-toggle="modal" data-target="#view{{ $man->corrective_action_request->id }}">CAR-{{ str_pad($man->corrective_action_request->id,3,'0',STR_PAD_LEFT) }}</a> <br>

                                @php
                                    $car = $man->corrective_action_request;
                                @endphp
                                @include('car.view')
                            @endforeach
                        </div>
                        <div class="col-md-2">
                            <p style="font-weight: bold;">METHOD</p>
                            @php
                                $num = 0;
                                $method_analysis = $rca->whereNotIn('method',['N/A','n/a',null]);
                            @endphp
                            @foreach ($method_analysis as $method)
                                {{ $num+=1 }}. <a href="javascript:void(0)" data-toggle="modal" data-target="#view{{ $method->corrective_action_request->id }}">CAR-{{ str_pad($method->corrective_action_request->id,3,'0',STR_PAD_LEFT) }}</a> <br>

                                @php
                                    $car = $method->corrective_action_request;
                                @endphp
                                @include('car.view')
                            @endforeach
                        </div>
                        <div class="col-md-2">
                            <p style="font-weight: bold;">MACHINE</p>
                            @php
                                $num = 0;
                                $machine_analysis = $rca->whereNotIn('machine',['N/A','n/a',null]);
                            @endphp
                            @foreach ($machine_analysis as $machine)
                                {{ $num+=1 }}. <a href="javascript:void(0)" data-toggle="modal" data-target="#view{{ $machine->corrective_action_request->id }}">CAR-{{ str_pad($machine->corrective_action_request->id,3,'0',STR_PAD_LEFT) }}</a> <br>

                                @php
                                    $car = $machine->corrective_action_request;
                                @endphp
                                @include('car.view')
                            @endforeach
                        </div>
                        <div class="col-md-2">
                            <p style="font-weight: bold;">MEASUREMENT</p>
                            @php
                                $num = 0;
                                $measurement_analysis = $rca->whereNotIn('material',['N/A','n/a',null]);
                            @endphp
                            @foreach ($measurement_analysis as $measurement)
                                {{ $num+=1 }}. <a href="javascript:void(0)" data-toggle="modal" data-target="#view{{ $measurement->corrective_action_request->id }}">CAR-{{ str_pad($measurement->corrective_action_request->id,3,'0',STR_PAD_LEFT) }}</a> <br>

                                @php
                                    $car = $measurement->corrective_action_request;
                                @endphp
                                @include('car.view')
                            @endforeach
                        </div>
                        <div class="col-md-2">
                            <p style="font-weight: bold;">MOTHER NATURE</p>
                            @php
                                $num = 0;
                                $mother_nature_analysis = $rca->whereNotIn('mother_nature',['N/A','n/a',null]);
                            @endphp
                            @foreach ($mother_nature_analysis as $mother_nature)
                                {{ $num+=1 }}. <a href="javascript:void(0)" data-toggle="modal" data-target="#view{{ $mother_nature->corrective_action_request->id }}">CAR-{{ str_pad($mother_nature->corrective_action_request->id,3,'0',STR_PAD_LEFT) }}</a> <br>

                                @php
                                    $car = $mother_nature->corrective_action_request;
                                @endphp
                                @include('car.view')
                            @endforeach
                        </div> --}}

                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th class="text-center">MAN</th>
                                    <th class="text-center">METHOD</th>
                                    <th class="text-center">MACHINE</th>
                                    <th class="text-center">MEASUREMENT</th>
                                    <th class="text-center">MOTHER NATURE</th>
                                    <th class="text-center">COMBINED(MAN & METHOD)</th>
                                </tr>
                                @php
                                    $combined = $rca->whereNotIn('man',['N/A','n/a',null])->whereNotIn('method',['N/A','n/a',null])->unique('corrective_action_request_id');
                                @endphp
                                <tr>
                                    <td>
                                        @php
                                            $num = 0;
                                            $man_analysis = $rca->whereNotIn('man',['N/A','n/a',null])->whereNotIn('corrective_action_request_id', $combined->pluck('corrective_action_request_id')->toArray())->unique('corrective_action_request_id');
                                        @endphp
                                        @foreach ($man_analysis->sortBy('corrective_action_request_id') as $man)
                                            <div class="text-center">
                                                {{ $num+=1 }}. <a href="javascript:void(0)" data-toggle="modal" data-target="#view{{ $man->corrective_action_request->id }}">CAR-{{ str_pad($man->corrective_action_request->id,3,'0',STR_PAD_LEFT) }}</a> <br>
                                            </div>

                                            @php
                                                $car = $man->corrective_action_request;
                                            @endphp
                                            @include('car.view')
                                        @endforeach
                                    </td>
                                    <td>
                                        @php
                                            $num = 0;
                                            $method_analysis = $rca->whereNotIn('method',['N/A','n/a',null])->whereNotIn('corrective_action_request_id', $combined->pluck('corrective_action_request_id')->toArray())->unique('corrective_action_request_id');
                                        @endphp
                                        @foreach ($method_analysis->sortBy('corrective_action_request_id') as $method)
                                            <div class="text-center">
                                                {{ $num+=1 }}. <a href="javascript:void(0)" data-toggle="modal" data-target="#view{{ $method->corrective_action_request->id }}">CAR-{{ str_pad($method->corrective_action_request->id,3,'0',STR_PAD_LEFT) }}</a> <br>
                                            </div>

                                            @php
                                                $car = $method->corrective_action_request;
                                            @endphp
                                            @include('car.view')
                                        @endforeach
                                    </td>
                                    <td>
                                        @php
                                            $num = 0;
                                            $machine_analysis = $rca->whereNotIn('machine',['N/A','n/a',null])->unique('corrective_action_request_id');
                                        @endphp
                                        @foreach ($machine_analysis->sortBy('corrective_action_request_id') as $machine)
                                            <div class="text-center">
                                                {{ $num+=1 }}. <a href="javascript:void(0)" data-toggle="modal" data-target="#view{{ $machine->corrective_action_request->id }}">CAR-{{ str_pad($machine->corrective_action_request->id,3,'0',STR_PAD_LEFT) }}</a> <br>
                                            </div>

                                            @php
                                                $car = $machine->corrective_action_request;
                                            @endphp
                                            @include('car.view')
                                        @endforeach
                                    </td>
                                    <td>
                                        @php
                                            $num = 0;
                                            $measurement_analysis = $rca->whereNotIn('material',['N/A','n/a',null])->unique('corrective_action_request_id');
                                        @endphp
                                        @foreach ($measurement_analysis->sortBy('corrective_action_request_id') as $measurement)
                                            <div class="text-center">
                                                {{ $num+=1 }}. <a href="javascript:void(0)" data-toggle="modal" data-target="#view{{ $measurement->corrective_action_request->id }}">CAR-{{ str_pad($measurement->corrective_action_request->id,3,'0',STR_PAD_LEFT) }}</a> <br>
                                            </div>

                                            @php
                                                $car = $measurement->corrective_action_request;
                                            @endphp
                                            @include('car.view')
                                        @endforeach
                                    </td>
                                    <td>
                                        @php
                                            $num = 0;
                                            $mother_nature_analysis = $rca->whereNotIn('mother_nature',['N/A','n/a',null])->unique('corrective_action_request_id');
                                        @endphp
                                        @foreach ($mother_nature_analysis->sortBy('corrective_action_request_id') as $mother_nature)
                                            <div class="text-centet">
                                                {{ $num+=1 }}. <a href="javascript:void(0)" data-toggle="modal" data-target="#view{{ $mother_nature->corrective_action_request->id }}">CAR-{{ str_pad($mother_nature->corrective_action_request->id,3,'0',STR_PAD_LEFT) }}</a> <br>
                                            </div>

                                            @php
                                                $car = $mother_nature->corrective_action_request;
                                            @endphp
                                            @include('car.view')
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($combined->sortBy('corrective_action_request_id') as $combine)
                                            <div class="text-center">
                                                {{ $num+=1 }}. <a href="javascript:void(0)" data-toggle="modal" data-target="#view{{ $combine->corrective_action_request->id }}">CAR-{{ str_pad($combine->corrective_action_request->id,3,'0',STR_PAD_LEFT) }}</a> <br>
                                            </div>

                                            @php
                                                $car = $combine->corrective_action_request;
                                            @endphp
                                            @include('car.view')
                                        @endforeach
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    @if(auth()->user()->role->name == 'Auditor' || auth()->user()->role->name == 'Administrator')
                    <h5>Status of CAR per Department</h5>
                    @else
                    <h5>Status of CAR</h5>
                    @endif
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover tables">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Department</th>
                                    <th>Open CARs</th>
                                    {{-- <th>In Progress CARs</th> --}}
                                    <th>Closed CARs</th>
                                    <th>Rating %</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($car_per_dept_array as $key=>$car)
                                <tr>
                                    <td>{{ $key+1 }}.</td>
                                    <td>{{ $car->department }}</td>
                                    <td>
                                        <a href="" data-toggle="modal" data-target="#viewStatus{{ $car->dept_id }}">{{
                                            $car->open }}</a>
                                    </td>
                                    {{-- <td>{{ $car->in_progress }}</td> --}}
                                    <td>
                                        <a href="" data-toggle="modal"
                                            data-target="#viewCloseStatus{{ $car->dept_id }}">{{ $car->closed }}</a>
                                    </td>
                                    <td>
                                        @php
                                        $percentage = 0;
                                        if($car->closed != 0)
                                        {
                                        $percentage = $car->closed / ($car->open + $car->closed);
                                        }
                                        @endphp

                                        {{ round((float)$percentage * 100). '%' }}
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
                    <h5> List of CAR</h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover tables">
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
                                    <td>{{ $car->auditee->name }}</td>
                                    <td>
                                        @foreach ($car->correctiveAction as $key => $corrective_action)
                                        {{ date('M d Y', strtotime($corrective_action->action_date)) }} - {{
                                        $corrective_action->status }} <br>
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
    </div>
</div>

@foreach ($car_per_dept_array as $car)
@include('view_open_car_status')
@include('view_closed_car_status')
@endforeach
@endsection

@section('js')
<script src="{{ asset('login_css/js/plugins/dataTables/datatables.min.js')}}"></script>
<script>
    $(document).ready(function() {
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

@if(auth()->user()->role->name != 'Auditee')
<script>
    var total_car = {!! json_encode($cars->count()) !!}
    var combined = {!! json_encode($rca->whereNotIn('man',['N/A','n/a',null])->whereNotIn('method',['N/A','n/a',null])->unique('corrective_action_request_id')->count()) !!}
    var man = {!! json_encode($rca->where('man','!=',null)->whereNotIn('man', ['N/A','n/a'])->whereNotIn('corrective_action_request_id', $combined->pluck('corrective_action_request_id')->toArray())->unique('corrective_action_request_id')->count()) !!}
    var method = {!! json_encode($rca->where('method','!=',null)->whereNotIn('method', ['N/A','n/a'])->whereNotIn('corrective_action_request_id', $combined->pluck('corrective_action_request_id')->toArray())->unique('corrective_action_request_id')->count()) !!}
    var machine = {!! json_encode($rca->where('machine','!=',null)->whereNotIn('machine', ['N/A','n/a'])->whereNotIn('corrective_action_request_id', $combined->pluck('corrective_action_request_id')->toArray())->unique('corrective_action_request_id')->count()) !!}
    var material = {!! json_encode($rca->where('material','!=',null)->whereNotIn('material', ['N/A','n/a'])->whereNotIn('corrective_action_request_id', $combined->pluck('corrective_action_request_id')->toArray())->unique('corrective_action_request_id')->count()) !!}
    var mother_nature = {!! json_encode($rca->where('mother_nature','!=',null)->whereNotIn('mother_nature', ['N/A','n/a'])->whereNotIn('corrective_action_request_id', $combined->pluck('corrective_action_request_id')->toArray())->unique('corrective_action_request_id')->count()) !!}
    
    $(document).ready(function() {
        c3.generate({
            bindto: '#pie',
            data:{
                columns: [
                    ['MAN', man],
                    ['METHOD', method],
                    ['MACHINE', machine],
                    ['MEASUREMENT', material],
                    ['MOTHER NATURE', mother_nature],
                    ['COMBINED (MAN & METHOD)', combined]
                ],
                colors:{
                    data1: '#d4afb9',
                    data2: '#d1cfe2',
                    data3: '#9cadce',
                    data4: '#7ec4cf',
                    data5: '#daeaf6',
                    data5: '##e8dff5',
                },
                type : 'pie'
            }
        });
    })
</script>
@endif
@endsection