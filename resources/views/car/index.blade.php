@extends('layouts.header')
@section('css')
<link href="{{ asset('login_css/css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="wrapper wrapper-content">
    {{-- <div class="row">
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>CAR </h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ count($corrective_action_requests) }}</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Closed</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ count($corrective_action_requests->where('status','Closed')) }}</h1>
                </div>
            </div>
        </div>
    </div> --}}
    <div class='row'>
        @if(auth()->user()->role->name == 'Auditor')
            <div class="col-lg-8">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Corrective Action Request 
                            @if(auth()->user()->role->name == 'Auditor' || auth()->user()->role->name == 'Administrator')
                                <button class="btn btn-success" data-target="#new" data-toggle="modal" type="button"><i class="fa fa-plus"></i>&nbsp;New CAR</button>
                            @endif
                        </h5>
                    </div>
                    <div class="ibox-content">
                        @include('components.error')
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover tables" >
                                <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>CAR #</th>
                                        <th>Department</th>
                                        {{-- <th>Standard and Clause</th> --}}
                                        {{-- <th>Classification of Nonconformity</th> --}}
                                        {{-- <th>Nature of Nonconformity</th> --}}
                                        <th>Description of Nonconformity</th>
                                        <th>Issued By</th>
                                        <th>Issued To</th>
                                        <th>Issued Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($corrective_action_requests->where('auditor_id', auth()->user()->id) as $car)
                                        <tr>
                                            <td>
                                                @php
                                                    $approver = ($car->approver)->where('user_id', $car->auditee_id)->where('status','Submitted')
                                                @endphp
                                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#view{{ $car->id }}">
                                                    <i class="fa fa-eye"></i>
                                                </button>

                                                @if(auth()->user()->role->name == 'Auditee')
                                                    @if(count($approver) == 0)
                                                    <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#edit{{ $car->id }}">
                                                        <i class="fa fa-pencil-square-o"></i>
                                                    </button>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>CAR-{{ str_pad($car->id,3,'0',STR_PAD_LEFT) }}</td>
                                            <td>{{ $car->department->name }}</td>
                                            {{-- <td>{!! nl2br(e($car->standard_and_clause)) !!}</td>
                                            <td>{{ $car->classification_of_nonconformity }}</td>
                                            <td>{{ $car->nature_of_nonconformity }}</td>
                                            <td>{{ $car->type_of_nonconformity }}</td> --}}
                                            <td>{!! nl2br(e($car->description_of_nonconformity)) !!}</td>
                                            <td>{{ $car->auditor->name }}</td>
                                            <td>{{ $car->auditee->name }}</td>
                                            <td>{{ date('M d Y', strtotime($car->created_at)) }}</td>
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
                                        </tr>

                                        {{-- @include('car.view') --}}
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>List of Corrective Action Request 
                        </h5>
                    </div>
                    <div class="ibox-content">
                        @include('components.error')
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover tables" >
                                <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>CAR #</th>
                                        <th>Department</th>
                                        {{-- <th>Standard and Clause</th> --}}
                                        {{-- <th>Classification of Nonconformity</th> --}}
                                        {{-- <th>Nature of Nonconformity</th> --}}
                                        <th>Description of Nonconformity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($corrective_action_requests as $car)
                                        <tr>
                                            <td>
                                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#view{{ $car->id }}">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </td>
                                            <td>CAR-{{ str_pad($car->id,3,'0',STR_PAD_LEFT) }}</td>
                                            <td>{{ $car->department->name }}</td>
                                            <td>{!! nl2br(e($car->description_of_nonconformity)) !!}</td>
                                        </tr>

                                        {{-- @include('car.view') --}}
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @else
            @if(auth()->user()->role->name == 'Audit Head')
                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Corrective Action Request in Department</h5>
                        </div>
                        <div class="ibox-content">
                            @include('components.error')
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover tables" >
                                    <thead>
                                        <tr>
                                            <th>Action</th>
                                            <th>CAR #</th>
                                            <th>Department</th>
                                            {{-- <th>Standard and Clause</th> --}}
                                            {{-- <th>Classification of Nonconformity</th> --}}
                                            {{-- <th>Nature of Nonconformity</th> --}}
                                            <th>Description of Nonconformity</th>
                                            <th>Issued By</th>
                                            <th>Issued To</th>
                                            <th>Issued Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($corrective_action_requests->where('department_id', auth()->user()->department_id) as $car)
                                            <tr>
                                                <td>
                                                    @php
                                                        $approver = ($car->approver)->where('user_id', $car->auditee_id)->where('status','Submitted');

                                                        $approver_data = false;
                                                        if ($car->approver->isNotEmpty())
                                                        {
                                                            $approver_data = ($car->approver)->every(function($item, $key) {
                                                                if (in_array($item->status, ['Approved', 'Submitted']))
                                                                {
                                                                    return true;
                                                                }
                                                            });
                                                        }
                                                        $verifier = ($car->verify)->where('user_id', auth()->user()->id)->first();
                                                    @endphp
                                                    
                                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#view{{ $car->id }}">
                                                        <i class="fa fa-eye"></i>
                                                    </button>

                                                    @if(($approver_data) && (auth()->user()->role->name == 'Auditee' || auth()->user()->role->name == 'Audit Head') && ($car->status != 'Closed'))
                                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#verify{{ $car->id }}">
                                                            <i class="fa fa-check"></i>
                                                        </button>
                                                    @endif

                                                    @if(auth()->user()->role->name == 'Auditee' || auth()->user()->role->name == 'Audit Head')
                                                        @if(count($approver) == 0)
                                                        <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#edit{{ $car->id }}">
                                                            <i class="fa fa-pencil-square-o"></i>
                                                        </button>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>CAR-{{ str_pad($car->id,3,'0',STR_PAD_LEFT) }}</td>
                                                <td>{{ $car->department->name }}</td>
                                                {{-- <td>{!! nl2br(e($car->standard_and_clause)) !!}</td>
                                                <td>{{ $car->classification_of_nonconformity }}</td>
                                                <td>{{ $car->nature_of_nonconformity }}</td>
                                                <td>{{ $car->type_of_nonconformity }}</td> --}}
                                                <td>{!! nl2br(e($car->description_of_nonconformity)) !!}</td>
                                                <td>{{ $car->auditor->name }}</td>
                                                <td>{{ $car->auditee->name }}</td>
                                                <td>{{ date('M d Y', strtotime($car->created_at)) }}</td>
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
                                            </tr>

                                            @include('car.verify_car')
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div @if(auth()->user()->role->name == 'Audit Head') class="col-lg-6" @else class="col-lg-12" @endif>
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Corrective Action Request 
                            @if(auth()->user()->role->name == 'Auditor' || auth()->user()->role->name == 'Administrator')
                                <button class="btn btn-success" data-target="#new" data-toggle="modal" type="button"><i class="fa fa-plus"></i>&nbsp;New CAR</button>
                            @endif
                        </h5>
                    </div>
                    <div class="ibox-content">
                        @include('components.error')
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover tables" >
                                <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>CAR #</th>
                                        <th>Department</th>
                                        {{-- <th>Standard and Clause</th> --}}
                                        {{-- <th>Classification of Nonconformity</th> --}}
                                        {{-- <th>Nature of Nonconformity</th> --}}
                                        <th>Description of Nonconformity</th>
                                        <th>Issued By</th>
                                        <th>Issued To</th>
                                        <th>Issued Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($corrective_action_requests as $car)
                                        <tr>
                                            <td>
                                                @php
                                                    $approver = ($car->approver)->where('user_id', $car->auditee_id)->where('status','Submitted');

                                                    $approver_data = false;
                                                    if ($car->approver->isNotEmpty())
                                                    {
                                                        $approver_data = ($car->approver)->every(function($item, $key) {
                                                            if (in_array($item->status, ['Approved', 'Submitted']))
                                                            {
                                                                return true;
                                                            }
                                                        });
                                                    }
                                                    $verifier = ($car->verify)->where('user_id', auth()->user()->id)->first();
                                                @endphp
                                                
                                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#view{{ $car->id }}">
                                                    <i class="fa fa-eye"></i>
                                                </button>

                                                @if($approver_data && auth()->user()->role->name == 'Auditee' && $car->status != 'Closed')
                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#verify{{ $car->id }}">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                @endif

                                                @if(auth()->user()->role->name == 'Auditee')
                                                    @if(count($approver) == 0)
                                                    <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#edit{{ $car->id }}">
                                                        <i class="fa fa-pencil-square-o"></i>
                                                    </button>
                                                    @endif
                                                @endif

                                                @if(auth()->user()->role->name == 'Administrator')
                                                <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editAdmin{{ $car->id }}">
                                                    <i class="fa fa-pencil-square-o"></i>
                                                </button>
                                                @endif
                                            </td>
                                            <td>CAR-{{ str_pad($car->id,3,'0',STR_PAD_LEFT) }}</td>
                                            <td>{{ $car->department->name }}</td>
                                            {{-- <td>{!! nl2br(e($car->standard_and_clause)) !!}</td>
                                            <td>{{ $car->classification_of_nonconformity }}</td>
                                            <td>{{ $car->nature_of_nonconformity }}</td>
                                            <td>{{ $car->type_of_nonconformity }}</td> --}}
                                            <td>{!! nl2br(e($car->description_of_nonconformity)) !!}</td>
                                            <td>{{ $car->auditor->name }}</td>
                                            <td>{{ $car->auditee->name }}</td>
                                            <td>{{ date('M d Y', strtotime($car->created_at)) }}</td>
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
                                        </tr>

                                        @include('car.verify_car')
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@include('car.create')'
@foreach ($corrective_action_requests as $car)
@include('car.edit')
@include('car.view')
@include('car.edit_admin')
@endforeach
@endsection

@section('js')
<script src="{{ asset('login_css/js/plugins/dataTables/datatables.min.js')}}"></script>
<script src="{{ asset('login_css/js/plugins/chosen/chosen.jquery.js') }}"></script>
<script>
    function refreshDeptHead(element)
    {
        var deptId = element.value
        
        $.ajax({
            type: "POST",
            url: "{{ url('refresh_dept_head') }}",
            data: {
                department_id: deptId
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res)
            {
                // document.getElementById('auditee').innerHTML = res
                $("#auditee").html(res)
            }
        })
    }

    function addRowBtn(carId)
    {
        var id = $("#correctiveActionContainer"+carId).children().last().attr('id');
        var lastId = id.split('_');
        var displayNum = parseInt(lastId[1]) + 1;
        
        var newRow = `
            <div class="row" id="caNum_${displayNum}">
                <div class="col-md-1">
                    ${displayNum}
                </div>
                <div class="col-md-6">
                    <textarea name="corrective_action[]" class="form-control" cols="30" required></textarea>
                </div>
                <div class="col-md-5">
                    <input type="date" name="action_date[]" class="form-control input-sm" min="{{ date('Y-m-d') }}">
                </div>
            </div>
        `
        $("#correctiveActionContainer"+carId).append(newRow)
    }

    function removeRowBtn(carId)
    {
        if ($("#correctiveActionContainer"+carId).children().length > 1)
        {
            $("#correctiveActionContainer"+carId).children().last().remove();
        }
    }

    function addCorrectionBtn(carId)
    {
        var id = $("#correctionImmediateAction"+carId).children().last().attr('id');
        var lastId = id.split('_');
        var displayNum = parseInt(lastId[1]) + 1;
        
        var newRow = `
            <div class="row" id="caNum_${displayNum}">
                <div class="col-md-1">
                    ${displayNum}
                </div>
                <div class="col-md-6">
                    <textarea name="correction_immediate_action[]" class="form-control" cols="30" required></textarea>
                </div>
                <div class="col-md-5">
                    <input type="date" name="correction_action_date[]" class="form-control input-sm" min="{{ date('Y-m-d') }}" required>
                </div>
            </div>
        `
        $("#correctionImmediateAction"+carId).append(newRow)
    }

    function removeCorrectionBtn(carId)
    {
        if ($("#correctionImmediateAction"+carId).children().length > 1)
        {
            $("#correctionImmediateAction"+carId).children().last().remove();
        }
    }

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

        $("#evidence").on('change', function() {
            if ($(this).val() == 'Yes')
            {
                $("#uploadEvidence").removeAttr('hidden')
                $("[name='upload_evidence']").prop('required', true)
            }
            else
            {
                $("#uploadEvidence").prop('hidden', true)
                $("[name='upload_evidence']").removeAttr('required')
            }
        })
    })
</script>
@endsection