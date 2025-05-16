@extends('layouts.header')
@section('css')
<link href="{{ asset('login_css/css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">

<link href="{{ asset('login_css/css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
@endsection
@section('content')

<div class="wrapper wrapper-content">
    {{-- @include('error') --}}
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>For Approval</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">0</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Pending</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">0</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Approved</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">0</h1>
                </div>
            </div>
        </div>
        
    </div>
    <div class='row'>
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Acceptance of CAR</h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover tables" >
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>CAR #</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($approvers as $approver)
                                    @php
                                        $car = $approver->correctiveActionRequest;
                                    @endphp
                                    <tr>
                                        <td>
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#view{{ $car->id }}">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </td>
                                        <td>CAR-{{ str_pad($car->id,3,'0',STR_PAD_LEFT) }}</td>
                                        <td>{!! nl2br(e($car->description_of_nonconformity)) !!}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Verification of CAR</h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover tables" >
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>CAR #</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($verifiers as $verify)
                                @php
                                    $car = $verify->correctiveActionRequest;
                                @endphp
                                <tr>
                                    <td>
                                        <a href="{{ url('show_verification/'.$car->id) }}" class="btn btn-info btn-sm">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                    <td>CAR-{{ str_pad($car->id,3,'0',STR_PAD_LEFT) }}</td>
                                    <td>{!! nl2br(e($car->description_of_nonconformity)) !!}</td>
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

@foreach ($approvers as $approver)
@include('for_approval.for_approval')
@endforeach

@endsection
@section('js')
<script src="{{ asset('login_css/js/plugins/dataTables/datatables.min.js')}}"></script>
<script src="{{ asset('login_css/js/plugins/chosen/chosen.jquery.js') }}"></script>
<script src="{{ asset('login_css/js/plugins/sweetalert/sweetalert.min.js') }}"></script>

<script>
    $(document).ready(function(){
        
        
        $('.cat').chosen({width: "100%"});
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
    });

</script>
@endsection
