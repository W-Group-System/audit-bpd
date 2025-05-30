@extends('layouts.header')
@section('css')
<link href="{{ asset('login_css/css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">

<link href="{{ asset('login_css/css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
@endsection
@section('content')

<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Departments</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{count($departments)}}</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Active</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{count($departments->where('status',""))}}</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Deactivated</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{count($departments->where('status','Inactive'))}}</h1>
                </div>
            </div>
        </div>
        
    </div>
    <div class='row'>
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Departments <button class="btn btn-success "  data-target="#new" data-toggle="modal" type="button"><i class="fa fa-plus"></i>&nbsp;New Department</button></h5>
                  
                </div>
                <div class="ibox-content">
                    @include('components.error')
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover tables" >
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Department Head</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($departments as $department)
                            <tr>
                                <td >
                                    <button class="btn btn-warning btn-sm" type="button" data-toggle="modal" data-target="#edit{{ $department->id }}">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </button>

                                    @if($department->status)
                                    <button class="btn btn-info btn-sm activate-department" id="{{ $department->id }}" type="button">
                                        <i class="fa fa-check"></i>
                                    </button>
                                    @else
                                    <button class="btn btn-danger btn-sm deactivate-department" id="{{ $department->id }}" type="button">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    @endif
                                </td>
                                <td>{{ $department->code }}</td>
                                <td>{{ $department->name }}</td>
                                <td>{{ optional($department->dept_head)->name }}</td>
                                <td>
                                    @if($department->status)
                                        <span class="label label-danger">Inactive</span>
                                    @else
                                        <span class="label label-primary">Active</span>
                                    @endif
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

@include('department.create')
@foreach($departments as $department)
@include('department.edit')
@endforeach
@endsection

@section('js')
<script src="{{ asset('login_css/js/plugins/dataTables/datatables.min.js')}}"></script>
<script src="{{ asset('login_css/js/plugins/chosen/chosen.jquery.js') }}"></script>
<script src="{{ asset('login_css/js/plugins/sweetalert/sweetalert.min.js') }}"></script>

<script>
    $(document).ready(function(){
        $('.deactivate-department').click(function () {
            
            var id = this.id;
            swal({
                title: "Are you sure?",
                text: "This department will be deactivated!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, deactivated it!",
                closeOnConfirm: false
            }, function (){
                $.ajax({
                    dataType: 'json',
                    type:'POST',
                    url:  '{{url("deactivate_department")}}',
                    data:{id:id},
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                }).done(function(data){
                    console.log(data);
                    swal("Deactivated!", "User is now deactivated.", "success");
                    location.reload();
                }).fail(function(data)
                {
                    
                    swal("Deactivated!", "Department is now deactivated.", "success");
                location.reload();
                });
            });
        });

        $('.activate-department').click(function () {
        
            var id = this.id;
            swal({
                title: "Are you sure?",
                text: "This user will be activated!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, Activated it!",
                closeOnConfirm: false
            }, function (){
                $.ajax({
                    dataType: 'json',
                    type:'POST',
                    url:  '{{url("activate_department")}}',
                    data:{id:id},
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                }).done(function(data){
                    console.log(data);
                    swal("Activated!", "User is now activated.", "success");
                    location.reload();
                }).fail(function(data)
                {
                    
                    swal("Activated!", "User is now activated.", "success");
                location.reload();
                });
            });
        });
        
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
