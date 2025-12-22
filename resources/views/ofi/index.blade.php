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
                    <h5>OFI </h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ count($ofis) }}</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
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
                                @foreach ($ofis as $ofi)
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
                                        <td>OFI-{{ str_pad($ofi->id,3,'0',STR_PAD_LEFT) }}</td>
                                        <td>{{ $ofi->department->name }}</td>
                                        <td>{{ $ofi->issuedBy->name }}</td>
                                        <td>{{ $ofi->issuedTo->name }}</td>
                                        <td>{{ date('M d Y', strtotime($ofi->created_at)) }}</td>
                                    </tr>

                                    @include('ofi.view')
                                    @include('ofi.edit')
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('ofi.create')
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