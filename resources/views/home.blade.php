@extends('layouts.header')
@section('css')
<link href="{{ asset('login_css/css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">
<!-- c3 Charts -->
<link href="{{ asset('login_css/css/plugins/c3/c3.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="wrapper wrapper-content">
    @php
        $category = request('category', 'all');

        $records = collect();

        if ($category == 'car') {
            $records = collect($cars);
        } elseif ($category == 'ofi') {
            $records = collect($ofis);
        } else {
            $records = collect($cars)->concat(collect($ofis));
        }

        $totalCount = $records->count();
        $openCount = $records->where('status', '!=', 'Closed')->count();
        $closedCount = $records->where('status', 'Closed')->count();

        $closedPercentage = $totalCount > 0
            ? ($closedCount / $totalCount) * 100
            : 0;
    @endphp
    <div class="row" style="display: flex; flex-wrap: wrap;">
         <div style="flex: 1; min-width: 0; padding: 0 10px;">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Total {{ $category == 'all' ? 'CAR / OFI' : strtoupper($category) }}</h5>
                    <div class="pull-right">
                        <span class="label label-success">as of {{ date('Y-m-d') }}</span>
                    </div>
                </div>
                <div class="ibox-content">
                   <h1 class="no-margins">{{ $totalCount }}</h1>
                </div>
            </div>
        </div>
         <div style="flex: 1; min-width: 0; padding: 0 10px;">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Total Open {{ $category == 'all' ? 'CAR / OFI' : strtoupper($category) }}</h5>
                    <div class="pull-right">
                        <span class="label label-primary">as of {{ date('Y-m-d') }}</span>
                    </div>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ $openCount }}</h1>
                </div>
            </div>
        </div>
         <div style="flex: 1; min-width: 0; padding: 0 10px;">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    {{-- @php
                        // $closed_car = (intval((count($cars->where('status','Closed')))) / intval((count($cars)))) * 100;
                        $totalCars = count($cars);
                        $closedCount = count($cars->where('status','Closed'));

                        $closed_car = $totalCars > 0
                            ? ($closedCount / $totalCars) * 100
                            : 0;
                    @endphp --}}
                    <h5>Total Closed CAR</h5>
                    <div class="pull-right">
                        <span class="label label-danger">as of {{ date('Y-m-d') }}</span>
                    </div>
                </div>
                <div class="ibox-content">
                    {{-- <h1 class="no-margins">{{ count($cars->where('status','Closed')) }} ({{ round($closed_car, 2) }}%)</h1> --}}
                    <h1 class="no-margins">{{ $closedCount }} ({{ round($closedPercentage, 2) }}%)</h1>
                </div>
            </div>
        </div>
         <div style="flex: 1; min-width: 0; padding: 0 10px;">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Filter by Year</h5>
                </div>
                <div class="ibox-content">
                    <form method="GET" action="{{ request()->url() }}">
                        <div class="input-group">
                            <input type="text"
                                id="filter_year"
                                name="year"
                                class="form-control"
                                placeholder="Select Year"
                                value="{{ request('year') }}"
                                readonly>
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                        </div>
                        @if(request('year'))
                            <a href="{{ request()->url() }}" class="btn btn-sm btn-default btn-block m-t-sm">
                                <i class="fa fa-times"></i> Clear
                            </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>
         <div style="flex: 1; min-width: 0; padding: 0 10px;">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Filter by Category</h5>
                </div>
                <div class="ibox-content">
                    <form method="GET" action="{{ request()->url() }}">
                        <div style="width: 100%;">
                            <select name="category" class="cat form-control" onchange="this.form.submit()">
                                <option value="all" {{ request('category', 'all') == 'all' ? 'selected' : '' }}>
                                    All
                                </option>
                                <option value="car" {{ request('category') == 'car' ? 'selected' : '' }}>
                                    CAR
                                </option>
                                <option value="ofi" {{ request('category') == 'ofi' ? 'selected' : '' }}>
                                    OFI
                                </option>
                            </select>
                        </div>

                        @if(request('year'))
                            <input type="hidden" name="year" value="{{ request('year') }}">
                        @endif
                    </form>
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
                                                {{ $num+=1 }}. <a href="javascript:void(0)" data-toggle="modal" data-target="#view{{ $man->corrective_action_request->id }}">
                                                    
                                                    @if (!empty($man->corrective_action_request->car_no))
                                                        {{ $man->corrective_action_request->car_no }}
                                                    @else
                                                        CAR-{{ str_pad($man->corrective_action_request->id,3,'0',STR_PAD_LEFT) }}
                                                    @endif
                                                </a> <br>
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
                                                {{ $num+=1 }}. <a href="javascript:void(0)" data-toggle="modal" data-target="#view{{ $method->corrective_action_request->id }}">
                                                    @if (!empty($method->corrective_action_request->car_no))
                                                        {{ $method->corrective_action_request->car_no }}
                                                    @else
                                                        CAR-{{ str_pad($method->corrective_action_request->id,3,'0',STR_PAD_LEFT) }}
                                                    @endif
                                                </a> <br>
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
                                                {{ $num+=1 }}. <a href="javascript:void(0)" data-toggle="modal" data-target="#view
                                                {{ $machine->corrective_action_request->id }}">
                                                @if (!empty($machine->corrective_action_request->car_no))
                                                    {{ $machine->corrective_action_request->car_no }}
                                                @else
                                                    CAR-{{ str_pad($machine->corrective_action_request->id,3,'0',STR_PAD_LEFT) }}
                                                @endif </a> <br>
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
                                                {{ $num+=1 }}. <a href="javascript:void(0)" data-toggle="modal" data-target="#view{{ $measurement->corrective_action_request->id }}">
                                                    @if (!empty($measurement->corrective_action_request->car_no))
                                                        {{ $measurement->corrective_action_request->car_no }}
                                                    @else
                                                        CAR-{{ str_pad($measurement->corrective_action_request->id,3,'0',STR_PAD_LEFT) }}
                                                    @endif
                                                </a> <br>
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
                                                {{ $num+=1 }}. <a href="javascript:void(0)" data-toggle="modal" data-target="#view{{ $mother_nature->corrective_action_request->id }}">
                                                    
                                                    @if (!empty($mother_nature->corrective_action_request->car_no))
                                                        {{ $mother_nature->corrective_action_request->car_no }}
                                                    @else
                                                        CAR-{{ str_pad($mother_nature->corrective_action_request->id,3,'0',STR_PAD_LEFT) }}
                                                    @endif
                                                </a> <br>
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
                                                {{ $num+=1 }}. <a href="javascript:void(0)" data-toggle="modal" data-target="#view{{ $combine->corrective_action_request->id }}">
                                                    
                                                    @if (!empty($combine->corrective_action_request->car_no))
                                                        {{ $combine->corrective_action_request->car_no }}
                                                    @else
                                                        CAR-{{ str_pad($combine->corrective_action_request->id,3,'0',STR_PAD_LEFT) }}
                                                    @endif
                                                </a> <br>
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
                    <h5>
                        @if($category == 'all')
                            Status of CAR and OFI per Department
                        @elseif($category == 'car')
                            Status of CAR per Department
                        @else
                            Status of OFI per Department
                        @endif
                    </h5>
                    @else
                     <h5>
                        @if($category == 'all')
                            Status of CAR and OFI
                        @elseif($category == 'car')
                            Status of CAR
                        @else
                            Status of OFI
                        @endif
                    </h5>
                    @endif
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover tables">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Department</th>
                                    @if($category == 'all')
                                        <th>Open CARs / OFIs</th>
                                    @elseif($category == 'car')
                                        <th>Open CARs</th>
                                    @elseif($category == 'ofi')
                                        <th>Open OFIs</th>
                                    @endif
                                    {{-- <th>In Progress CARs</th> --}}
                                    @if($category == 'all')
                                        <th>Delayed CARs / OFIs</th>
                                    @elseif($category == 'car')
                                        <th>Delayed CARs</th>
                                    @elseif($category == 'ofi')
                                        <th>Delayed OFIs</th>
                                    @endif
                                    @if($category == 'all')
                                        <th>Closed CARs / OFIs</th>
                                    @elseif($category == 'car')
                                        <th>Closed CARs</th>
                                    @elseif($category == 'ofi')
                                        <th>Closed OFIs</th>
                                    @endif
                                    <th>Rating %</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($car_per_dept_array as $key=>$car)
                                @php
                                    if ($category == 'car') {
                                        $open = $car->open;
                                        $closed = $car->closed;
                                        $delayed = $car->delayed;
                                    } elseif ($category == 'ofi') {
                                        $open = $car->ofi_open;
                                        $closed = $car->ofi_closed;
                                        $delayed = 0;
                                    } else {
                                        $open = $car->open + $car->ofi_open;
                                        $closed = $car->closed + $car->ofi_closed;
                                        $delayed = $car->delayed;
                                    }

                                    $total = $open + $closed;
                                    $percentage = $total > 0
                                        ? ($closed / $total) * 100
                                        : 100;
                                @endphp
                                <tr>
                                    <td>{{ $key+1 }}.</td>
                                    <td>{{ $car->department }}</td>
                                    <td>
                                        <a href="" data-toggle="modal" data-target="#viewStatus{{ $car->dept_id }}">{{
                                            $open }}</a>
                                    </td>
                                    <td>
                                        <a href="" data-toggle="modal" data-target="#viewDelayedStatus{{ $car->dept_id }}">{{
                                            $delayed }}</a>
                                    </td>
                                    {{-- <td>{{ $car->in_progress }}</td> --}}
                                    <td>
                                        <a href="" data-toggle="modal"
                                            data-target="#viewCloseStatus{{ $car->dept_id }}">{{ $closed }}</a>
                                    </td>
                                    <td>
                                        @if($open == 0 && $closed == 0) 
                                            100%
                                        @else
                                            @php
                                            $percentage = 0;
                                            if($closed != 0)
                                            {
                                            $percentage = $closed / ($open + $closed);
                                            }
                                            @endphp

                                        {{ round((float)$percentage * 100). '%' }}
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                @php
                                    $sumOpenCAR = collect($car_per_dept_array)->sum('open');
                                    $sumClosedCAR = collect($car_per_dept_array)->sum('closed');
                                    $sumOpenOFI = collect($car_per_dept_array)->sum('ofi_open');
                                    $sumClosedOFI = collect($car_per_dept_array)->sum('ofi_closed');
                                    $sumDelayedCAR = collect($car_per_dept_array)->sum('delayed');

                                    if ($category == 'car') {
                                        $totalOpen = $sumOpenCAR;
                                        $totalClosed = $sumClosedCAR;
                                        $totalDelayed = $sumDelayedCAR;
                                    } elseif ($category == 'ofi') {
                                        $totalOpen = $sumOpenOFI;
                                        $totalClosed = $sumClosedOFI;
                                        $totalDelayed = 0;
                                    } else {
                                        $totalOpen = $sumOpenCAR + $sumOpenOFI;
                                        $totalClosed = $sumClosedCAR + $sumClosedOFI;
                                        $totalDelayed = $sumDelayedCAR;
                                    }

                                    $totalRecords = $totalOpen + $totalClosed;
                                    $overallPercentage = $totalRecords > 0
                                        ? ($totalClosed / $totalRecords) * 100
                                        : 100;
                                @endphp
                                <tr>
                                    <td colspan="2"><strong>Total:</strong></td>
                                    <td><strong>{{ $totalOpen }}</strong></td>
                                    <td><strong>{{ $totalDelayed }}</strong></td>
                                    <td><strong>{{ $totalClosed }}</strong></td>

                                    {{-- @php
                                        // $total_open = collect($car_per_dept_array)->sum('open');
                                        // $total_closed = collect($car_per_dept_array)->sum('closed');
                                        // $overall_percentage = 0;

                                        // if ($total_closed != 0)
                                        // {
                                        //     $overall_percentage = $total_closed / ($total_open + $total_closed);
                                        // }
                                        // $overall_percentage = (collect($car_per_dept_array)->sum('closed') / intval((count($cars)))) * 100;
                                        $totalCars = count($cars);
                                        $overall_percentage = $totalCars > 0
                                            ? (collect($car_per_dept_array)->sum('closed') / $totalCars) * 100
                                            : 0;
                                    @endphp --}}
                                    <td><strong>{{ round($overallPercentage, 2) }}%</strong></td>
                                </tr>
                            </tfoot>
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
                                    <td>
                                        @if (!empty($car->car_no))
                                            {{ $car->car_no }}
                                        @else
                                            CAR-{{ str_pad($car->id,3,'0',STR_PAD_LEFT) }}
                                        @endif
                                    </td>
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
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> List of OFI</h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover tables">
                            <thead>
                                <tr>
                                    <th>OFI ID</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Responsible Person</th>
                                    <th>Target Completion Date</th>
                                    <th>Proof / Evidence</th>
                                    <th>Implementation Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ofis as $ofi)
                                <tr>
                                    <td> {{$ofi->ofi_no }}</td>
                                    <td>{{ $ofi->description }}</td>
                                    <td>{{ $ofi->status }}</td>
                                    <td>{{ $ofi->issuedTo->name }}</td>
                                    <td>
                                        @foreach ($ofi->ofiImmediateAction as $key => $ofiImmediateAction)
                                            @if (!empty($ofiImmediateAction->implementation_date))
                                                {{ date('M d Y', strtotime($ofiImmediateAction->implementation_date)) }} - 
                                                {{ $ofiImmediateAction->status }} <br>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($ofi->ofiImmediateAction as $key => $ofiImmediateAction)
                                        @if($ofiImmediateAction->attachments)
                                        <a href="{{ url($ofiImmediateAction->attachments) }}" target="_blank">
                                            <i class="fa fa-file"></i>
                                        </a> <br>
                                        @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($ofi->ofiImmediateAction as $key => $ofiImmediateAction)
                                        @if($ofiImmediateAction->immediate_action)
                                        {!! nl2br(e($ofiImmediateAction->immediate_action)) !!} <br>
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
@include('view_delayed_car_status')
@endforeach
@endsection

@section('js')
<script src="{{ asset('login_css/js/plugins/dataTables/datatables.min.js')}}"></script>
<script src="{{ asset('login_css/js/plugins/chosen/chosen.jquery.js') }}"></script>

<script>
    $(document).ready(function() {
        $('.cat').chosen({width:"100%"});
        $('.tables').DataTable({
            pageLength: 25,
            paging: true,
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

         $('#filter_year').datepicker({
            format: 'yyyy',
            viewMode: 'years',
            minViewMode: 'years',
            autoclose: true,
        }).on('changeDate', function () {
            $(this).closest('form').submit();
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