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
                    <h5>Companies</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{count($companies)}}</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Active</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{count($companies->where('status',""))}}</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Deactivated</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{count($companies->where('status','Inactive'))}}</h1>
                </div>
            </div>
        </div>
        
    </div>
    <div class='row'>
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Companies <button class="btn btn-success "  data-target="#new" data-toggle="modal" type="button"><i class="fa fa-plus"></i>&nbsp;New Company</button></h5>
                  
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
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($companies as $company)
                            <tr>
                                <td>
                                    <button class="btn btn-warning btn-sm" type="button">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm" type="button">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                                <td>{{ $company->code }}</td>
                                <td>{{ $company->name }}</td>
                                <td>
                                    @if($company->status)
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
@endsection

@section('js')
<script src="{{ asset('login_css/js/plugins/dataTables/datatables.min.js')}}"></script>
<script src="{{ asset('login_css/js/plugins/chosen/chosen.jquery.js') }}"></script>
<script src="{{ asset('login_css/js/plugins/sweetalert/sweetalert.min.js') }}"></script>

<script>
    $(document).ready(function(){
        // $('.deactivate-user').click(function () {
        
        //     var id = this.id;
        //     swal({
        //         title: "Are you sure?",
        //         text: "This user will be deactivated!",
        //         type: "warning",
        //         showCancelButton: true,
        //         confirmButtonColor: "#DD6B55",
        //         confirmButtonText: "Yes, deactivated it!",
        //         closeOnConfirm: false
        //     }, function (){
        //         $.ajax({
        //             dataType: 'json',
        //             type:'POST',
        //             url:  '{{url("deactivate_user")}}',
        //             data:{id:id},
        //             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        //         }).done(function(data){
        //             console.log(data);
        //             swal("Deactivated!", "User is now deactivated.", "success");
        //             location.reload();
        //         }).fail(function(data)
        //         {
                    
        //             swal("Deactivated!", "User is now deactivated.", "success");
        //         location.reload();
        //         });
        //     });
        // });

        // $('.activate-user').click(function () {
        
        //     var id = this.id;
        //     swal({
        //         title: "Are you sure?",
        //         text: "This user will be activated!",
        //         type: "warning",
        //         showCancelButton: true,
        //         confirmButtonColor: "#DD6B55",
        //         confirmButtonText: "Yes, Activated it!",
        //         closeOnConfirm: false
        //     }, function (){
        //         $.ajax({
        //             dataType: 'json',
        //             type:'POST',
        //             url:  '{{url("activate_user")}}',
        //             data:{id:id},
        //             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        //         }).done(function(data){
        //             console.log(data);
        //             swal("Activated!", "User is now activated.", "success");
        //             location.reload();
        //         }).fail(function(data)
        //         {
                    
        //             swal("Activated!", "User is now activated.", "success");
        //         location.reload();
        //         });
        //     });
        // });
        
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
