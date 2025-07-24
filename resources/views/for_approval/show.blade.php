@extends('layouts.header')
@section('css')
<link href="{{ asset('login_css/css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">

<link href="{{ asset('login_css/css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
@endsection
@section('content')

<div class="wrapper wrapper-content">
    {{-- @include('error') --}}
    <div class='row'>
        <div class="col-lg-9">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>View Corrective Action - {{ $car->status }}</h5>

                    <a href="{{ url('for-approval') }}" class="btn btn-danger pull-right">Back</a>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-6">
                            <b>Standard and Clause :</b>
                            {!! nl2br(e($car->standard_and_clause)) !!}
                        </div>
                        <div class="col-lg-6">
                            <b>Classification of Nonconformity :</b>
                            {!! nl2br(e($car->classification_of_nonconformity)) !!}
                        </div>
                        <div class="col-lg-6">
                            <b>Nature of Nonconformity :</b>
                            {!! nl2br(e($car->nature_of_nonconformity)) !!}
                        </div>
                        <div class="col-lg-6">
                            <b>Type of Nonconformity :</b>
                            {!! nl2br(e($car->type_of_nonconformity)) !!}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    I. Description of Nonconformity
                                </div>
                                <div class="panel-body">
                                    {!! nl2br(e($car->description_of_nonconformity)) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <b>Action Date :</b>
                            {{ date('M d Y', strtotime($car->action_date_immediate_action)) }}
                        </div>
                        <div class="col-md-4">
                            <b>Action Responsible :</b>
                            {{ $car->auditee->name }}
                        </div>
                        {{-- <div class="col-md-4">
                            <b>Verification :</b>
                            {{ $car->verification_correction }}
                        </div> --}}
                        <div class="col-md-12">
                            <form method="post" action="{{ url('update_cia/'.$car->id) }}" onsubmit="show()"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        II. Correction Immediate Action

                                        <div class="pull-right">
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                Save
                                            </button>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        {{-- {!! nl2br(e($car->immediate_action)) !!} --}}
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        Correction Immediate Action
                                                    </th>
                                                    <th>
                                                        Action Date
                                                    </th>
                                                    <th>
                                                        Status
                                                    </th>
                                                    <th>
                                                        Remarks
                                                    </th>
                                                    <th>
                                                        Attachment
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        {!! nl2br(e($car->immediate_action)) !!}
                                                    </td>
                                                    <td>
                                                        {{ date('M d Y', strtotime($car->action_date_immediate_action))
                                                        }}
                                                    </td>
                                                    <td>
                                                        <select name="immediate_action_status"
                                                            class="form-control input-sm" required>
                                                            <option value=""></option>
                                                            <option value="Pending" @if($car->immediate_action_status ==
                                                                'Pending') selected @endif>Pending</option>
                                                            <option value="Done" @if($car->immediate_action_status ==
                                                                'Done') selected @endif>Done</option>
                                                        </select>

                                                        <div id="immediateActionFile" hidden>
                                                            <input type="file" name="immediate_action_file"
                                                                class="form-control input-sm">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <textarea name="immediate_action_remarks" class="form-control"
                                                            cols="30"
                                                            required>{{ $car->immediate_action_remarks }}</textarea>
                                                    </td>
                                                    <td>
                                                        @if($car->immediate_action_file)
                                                        <a href="{{ url($car->immediate_action_file) }}"
                                                            target="_blank">
                                                            <i class="fa fa-file"></i>
                                                        </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    III. Root Cause Analysis
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Man</th>
                                                    <th>Method</th>
                                                    <th>Machine</th>
                                                    <th>Material</th>
                                                    <th>Mother Nature</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($car->rootCauseAnalysis as $key=>$rootCauseAnalysis)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{!! nl2br(e($rootCauseAnalysis->man)) !!}</td>
                                                    <td>{!! nl2br(e($rootCauseAnalysis->method)) !!}</td>
                                                    <td>{!! nl2br(e($rootCauseAnalysis->machine)) !!}</td>
                                                    <td>{!! nl2br(e($rootCauseAnalysis->material)) !!}</td>
                                                    <td>{!! nl2br(e($rootCauseAnalysis->mother_nature)) !!}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-12">
                            <form method="post" action="{{ url('update_ca/'.$car->id) }}" onsubmit="show()" enctype="multipart/form-data">
                                @csrf
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        IV. Corrective Action

                                        <div class="pull-right">
                                            <button type="submit" class="btn btn-sm btn-danger">Save</button>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Corrective Action</th>
                                                    <th>Action Date</th>
                                                    <th>Status</th>
                                                    <th>Remarks</th>
                                                    <th>Attachment</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($car->correctiveAction as $corrective_action)
                                                <tr>
                                                    <input type="hidden" name="corrective_action_id[]"
                                                        value="{{ $corrective_action->id }}">
    
                                                    <td>
                                                        {{ $corrective_action->corrective_action }}
                                                    </td>
                                                    <td>
                                                        {{ date('M d, Y', strtotime($corrective_action->action_date)) }}
                                                    </td>
                                                    <td>
                                                        <select name="status[]" class="form-control input-sm" required
                                                            onchange="correctiveActionStatus({{ $corrective_action->id }}, this.value)">
                                                            <option value=""></option>
                                                            <option value="Pending" @if($corrective_action->status ==
                                                                'Pending') selected @endif>Pending</option>
                                                            <option value="Done" @if($corrective_action->status == 'Done')
                                                                selected @endif>Done</option>
                                                        </select>
    
                                                        <div id="correctiveActionFile{{ $corrective_action->id }}" hidden>
                                                            <input type="file" name="corrective_action_files[]"
                                                                class="form-control">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <textarea name="remarks_action[]" class="form-control input-sm"
                                                            cols="30" required>{{ $corrective_action->remarks }}</textarea>
                                                    </td>
                                                    <td>
                                                        @if($corrective_action->file_attachments)
                                                        <a href="{{ url($corrective_action->file_attachments) }}"
                                                            target="_blank"><i class="fa fa-file"></i></a>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    Verifiers
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-3 border border-1 border-top-bottom border-right-left">
                                            <b>Name</b>
                                        </div>
                                        <div class="col-md-3 border border-1 border-top-bottom border-right-left">
                                            <b>Status</b>
                                        </div>
                                        <div class="col-md-3 border border-1 border-top-bottom border-right-left">
                                            <b>Action Date</b>
                                        </div>
                                        <div class="col-md-3 border border-1 border-top-bottom border-right-left">
                                            <b>Remarks</b>
                                        </div>
                                    </div>
                                    @foreach ($car->verify as $verifier)
                                    <div class="row">
                                        <div class="col-md-3 border border-1 border-top-bottom border-right-left">
                                            {{ $verifier->user->name }}
                                        </div>
                                        <div class="col-md-3 border border-1 border-top-bottom border-right-left">
                                            {{ $verifier->status }}
                                        </div>
                                        <div class="col-md-3 border border-1 border-top-bottom border-right-left">
                                            {{ date('M d Y', strtotime($verifier->updated_at )) }}
                                        </div>
                                        <div class="col-md-3 border border-1 border-top-bottom border-right-left">
                                            {{ $verifier->remarks }}
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <form method="POST" action="{{ url('verify_action') }}" onsubmit="show()"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="car_id" value="{{ $car->id }}">
                        <div class="row">
                            <div class="col-md-6">
                                Action :
                                <select data-placeholder="Select Action" name="action" class="cat form-control"
                                    required>
                                    <option value=""></option>
                                    <option value="Approved">Approved</option>
                                    <option value="Returned">Returned</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                Remarks :
                                <textarea name="remarks" class="form-control" cols="30" required></textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block m-t-md">Save</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="ibox float-e-marging">
                <div class="ibox-title">
                    <h5>History</h5>
                </div>
                <div class="ibox-content">
                    @if($car->remarksHistory->isNotEmpty())
                        @foreach ($car->remarksHistory as $history)
                            @if($history->corrective_action_request_id)
                            <h3 class="text-dark">{{ $history->correctiveActionRequest->immediate_action }}
                            @else
                            <h3 class="text-dark">{{ $history->correctiveActionRequest }}
                            @endif
                        @if($history->status =='Pending') <span class="label label-warning">{{ $history->status }}</span> @else <span
                                class="label label-primary">{{ $history->status }}</span> @endif</h3>
                        <small>Date: {{ date('M d Y', strtotime($history->created_at)) }}</small> <br>
                        <small>Remarks : {!! nl2br(e($history->remarks)) !!}</small>
                        <hr class="hr-line-dashed">
                        @endforeach
                    @else
                    <p>No History Remarks</p>
                    @endif
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
    function correctiveActionStatus(id, value)
    {
        if (value == 'Done')
        {
            $("#correctiveActionFile"+id).removeAttr('hidden')
        }
        else
        {
            $("#correctiveActionFile"+id).prop('hidden', true)
        }
        
    }

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

        $("[name='immediate_action_status']").on('change', function() {
            var value = $(this).val();

            if (value == 'Done')
            {
                $("#immediateActionFile").removeAttr('hidden');
            }
            else
            {
                $("#immediateActionFile").prop('hidden', true);
            }
        })
    });

</script>
@endsection