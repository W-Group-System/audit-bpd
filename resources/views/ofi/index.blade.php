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
                    <h5>OFI </h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ count($ofis) }}</h1>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Filter by Year</h5>
                </div>
                <div class="ibox-content">
                    <form method="GET" action="{{ request()->url() }}" id="filterForm">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <h5>Filter by Year</h5>
                                    </div>
                                    <div class="ibox-content">
                                        <div class="input-group">
                                            <input type="text"
                                                id="filter_year_ofi"
                                                name="year"
                                                class="form-control"
                                                placeholder="Select Year"
                                                value="{{ request('year') }}"
                                                readonly>
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if(auth()->user()->role->name == 'Auditor' || auth()->user()->role->name == 'Administrator')
                                <div class="col-lg-3">
                                    <div class="ibox float-e-margins">
                                        <div class="ibox-title">
                                            <h5>Filter by Department</h5>
                                        </div>
                                        <div class="ibox-content">
                                            <select
                                                id="filter_department_ofi"
                                                name="department_filter"
                                                class="cat form-control">
                                                <option value=""></option>
                                                @foreach ($departments as $department)
                                                    <option value="{{ $department->id }}"
                                                        {{ request('department_filter') == $department->id ? 'selected' : '' }}>
                                                        {{ $department->code . ' - ' . $department->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="col-lg-2">
                                @if(request()->has('year') || request()->has('department_filter'))
                                    <a href="{{ request()->url() }}" class="btn btn-default m-t-lg">
                                        <i class="fa fa-times"></i> Clear Filters
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @if(auth()->user()->role->name == 'Auditor')
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Opportunities for Improvements
                            @if(auth()->user()->role->name == "Auditor" || auth()->user()->role->name == "Administrator")
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#new">
                                <i class="fa fa-plus"></i>
                                Add OFI
                            </button>
                            @endif
                        </h5>
                    </div>
                    <div class="ibox-content">
                        @include('components.error')
                        <div class="table-responsive">
                            <table class="table table-bordered tables">
                                <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>OFI #</th>
                                        <th>Department</th>
                                        <th>Issued By</th>
                                        <th>Issued To</th>
                                        <th>Date Issued</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ofis->where('issued_by', auth()->user()->id) as $ofi)
                                        <tr>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-info" data-target="#view{{ $ofi->id }}" data-toggle="modal">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                                @if(auth()->user()->role->name == "Auditee" || auth()->user()->role->name == "Administrator")
                                                <button type="button" class="btn btn-sm btn-warning" data-target="#edit{{ $ofi->id }}" data-toggle="modal">
                                                    <i class="fa fa-pencil-square-o"></i>
                                                </button>
                                                @endif
                                            </td>
                                            <td>{{ $ofi->ofi_no }}</td>
                                            <td>{{ $ofi->department->name }}</td>
                                            <td>{{ $ofi->issuedBy->name }}</td>
                                            <td>{{ $ofi->issuedTo->name }}</td>
                                            <td>{{ date('M d Y', strtotime($ofi->created_at)) }}</td>
                                        </tr>

                                        {{-- @include('ofi.view')
                                        @include('ofi.edit') --}}
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
                            <h5>Opportunities for Improvements in Department</h5>
                        </div>
                        <div class="ibox-content">
                            @include('components.error')
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover tables" >
                                    <thead>
                                        <tr>
                                            <th>Action</th>
                                            <th>OFI #</th>
                                            <th>Department</th>
                                            <th>Issued By</th>
                                            <th>Issued To</th>
                                            <th>Date Issued</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ofis->where('department_id', auth()->user()->department_id) as $ofi)
                                            <tr>
                                                <td>
                                                    @php
                                                        $approver = ($ofi->approver)->where('user_id', $ofi->issued_to)->where('status','Submitted');

                                                        $approver_data = false;
                                                        if ($ofi->approver->isNotEmpty())
                                                        {
                                                            $approver_data = ($ofi->approver)->every(function($item, $key) {
                                                                if (in_array($item->status, ['Approved', 'Submitted']))
                                                                {
                                                                    return true;
                                                                }
                                                            });
                                                        }
                                                        $verifier = $ofi->verify
                                                            ? $ofi->verify->where('user_id', auth()->user()->id)->first()
                                                            : null;
                                                    @endphp
                                                    
                                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#view{{ $ofi->id }}">
                                                        <i class="fa fa-eye"></i>
                                                    </button>

                                                    @if(($approver_data) && (auth()->user()->role->name == 'Auditee' || auth()->user()->role->name == 'Audit Head') && ($ofi->status != 'Closed'))
                                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#verify{{ $ofi->id }}">
                                                            <i class="fa fa-check"></i>
                                                        </button>
                                                    @endif

                                                    @if(auth()->user()->role->name == 'Auditee' || auth()->user()->role->name == 'Audit Head')
                                                        @if(count($approver) == 0)
                                                        <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#edit{{ $ofi->id }}">
                                                            <i class="fa fa-pencil-square-o"></i>
                                                        </button>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (!empty($ofi->ofi_no))
                                                        {{ $ofi->ofi_no }}
                                                    @else
                                                    @endif
                                                </td>
                                                <td>{{ $ofi->department->name }}</td>
                                                <td>{{ $ofi->issuedBy->name }}</td>
                                                <td>{{ $ofi->issuedTo->name }}</td>
                                                <td>{{ date('M d Y', strtotime($ofi->created_at)) }}</td>
                                            </tr>

                                            {{-- @include('car.verify_car') --}}
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
                        <h5>Opportunities for Improvements 
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
                                        <th>OFI #</th>
                                        <th>Department</th>
                                        <th>Issued By</th>
                                        <th>Issued To</th>
                                        <th>Date Issued</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ofis as $ofi)
                                        <tr>
                                            <td>
                                                @php
                                                    $approver = ($ofi->approver)->where('user_id', $ofi->issued_to)->where('status','Submitted');

                                                    $approver_data = false;
                                                    if ($ofi->approver->isNotEmpty())
                                                    {
                                                        $approver_data = ($ofi->approver)->every(function($item, $key) {
                                                            if (in_array($item->status, ['Approved', 'Submitted']))
                                                            {
                                                                return true;
                                                            }
                                                        });
                                                    }
                                                    // $verifier = ($ofi->verify)->where('user_id', auth()->user()->id)->first();
                                                    $verifier = $ofi->verify
                                                        ? $ofi->verify->where('user_id', auth()->user()->id)->first()
                                                        : null;
                                                @endphp
                                                
                                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#view{{ $ofi->id }}">
                                                    <i class="fa fa-eye"></i>
                                                </button>

                                                @if($approver_data && auth()->user()->role->name == 'Auditee' && $ofi->status != 'Closed')
                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ofi_verifiers{{ $ofi->id }}">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                @endif

                                                @if(auth()->user()->role->name == 'Auditee')
                                                    @if(count($approver) == 0)
                                                    <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#edit{{ $ofi->id }}">
                                                        <i class="fa fa-pencil-square-o"></i>
                                                    </button>
                                                    @endif
                                                @endif

                                                @if(auth()->user()->role->name == 'Administrator')
                                                <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editAdmin{{ $ofi->id }}">
                                                    <i class="fa fa-pencil-square-o"></i>
                                                </button>
                                                @endif
                                            </td>
                                            <td>
                                                @if (!empty($ofi->ofi_no))
                                                    {{ $ofi->ofi_no }}
                                                @endif
                                            </td>
                                            <td>{{ $ofi->department->name }}</td>
                                            <td>{{ $ofi->issuedBy->name }}</td>
                                            <td>{{ $ofi->issuedTo->name }}</td>
                                            <td>{{ date('M d Y', strtotime($ofi->created_at)) }}</td>
                                        </tr>

                                        @include('ofi.verify_ofi')
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

@include('ofi.create')
@foreach ($ofis as $ofi)
@include('ofi.view')
@include('ofi.edit')
@endforeach
@endsection

@section('js')
<script src="{{ asset('login_css/js/plugins/dataTables/datatables.min.js')}}"></script>
<script src="{{ asset('login_css/js/plugins/chosen/chosen.jquery.js') }}"></script>
<script>
    function refreshDeptHead(element) {
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

    function addOfiCorrectionBtn(ofiId)
    {
        var id = $("#ofiImmediateAction"+ofiId).children().last().attr('id');
        var lastId = id.split('_');
        var displayNum = parseInt(lastId[1]) + 1;
            
        var newRow = `
            <div class="row" id="ofiNum_${displayNum}">
                <div class="col-md-1">
                    ${displayNum}
                </div>
                <div class="col-md-6">
                    <textarea name="ofi_immediate_action[]" class="form-control" cols="30" required></textarea>
                </div>
                <div class="col-md-5">
                    <input type="date" name="ofi_implementation_date[]" class="form-control input-sm" min="{{ date('Y-m-d') }}" required>
                </div>
            </div>
        `
        $("#ofiImmediateAction"+ofiId).append(newRow)
    }

    function removeOfiCorrectionBtn(ofiId)
    {
        if ($("#ofiImmediateAction"+ofiId).children().length > 1)
        {
            $("#ofiImmediateAction"+ofiId).children().last().remove();
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

        $('#filter_year_ofi').datepicker({
            format: 'yyyy',
            viewMode: 'years',
            minViewMode: 'years',
            autoclose: true
        }).on('changeDate', function () {
            $('#filterForm').submit();
        });

        $('#filter_department_ofi').on('change', function () {
            $('#filterForm').submit();
        });
    })
</script>
@endsection