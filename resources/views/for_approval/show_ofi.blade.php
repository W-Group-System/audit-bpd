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
                    <h5>View OFI - {{ $ofi->status }}</h5>

                    <a href="{{ url('for-approval') }}" class="btn btn-danger pull-right">Back</a>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-6">
                            <b>OFI# :</b>
                            {{ $ofi->ofi_no }}
                        </div>
                        <div class="col-lg-6">
                            <b>Department :</b>
                            {{ $ofi->department->name }}
                        </div>
                        <div class="col-lg-6">
                            <b>Issued By :</b>
                            {{ $ofi->issuedBy->name }}
                        </div>
                        <div class="col-lg-6">
                            <b>Issued To :</b>
                            {{ $ofi->issuedTo->name }}
                        </div>
                        <div class="col-lg-6">
                            <b>Date Issued :</b>
                            {{ date('M d Y', strtotime($ofi->created_at)) }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    Description
                                </div>
                                <div class="panel-body">
                                    {!! nl2br(e($ofi->description)) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    Recommendation
                                </div>
                                <div class="panel-body">
                                    {!! nl2br(e($ofi->recommendation)) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <form method="post" action="{{ url('update_ofi_verify/'.$ofi->id) }}" onsubmit="show()"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        Immediate Action

                                        @if(auth()->user()->role->name != "Audit Head")
                                        <div class="pull-right">
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                Save
                                            </button>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="panel-body">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th style="padding: 1px;">Immediate Action</th>
                                                <th style="padding: 1px;">Action Responsible</th>
                                                <th style="padding: 1px;">Action Date</th>
                                                <th style="padding: 1px;">Status</th>
                                                <th style="padding: 1px;">Remarks</th>
                                                <th style="padding: 1px;">Attachment</th>
                                                <th style="padding: 1px;">Date Verified</th>
                                            </tr>
                                            <tbody>
                                                {{-- @if($ofi->immediate_action)
                                                <tr>
                                                    <td style="padding: 1px;">{!! nl2br(e($ofi->immediate_action)) !!}</td>
                                                    <td style="padding: 1px;">{{ $ofi->auditee->name }}</td>
                                                    <td style="padding: 1px;">{{ date('M d Y', strtotime($ofi->action_date_immediate_action))}}</td>
                                                    <td style="padding: 1px;">
                                                        <select name="immediate_action_status" class="immediate_action_status form-control input-sm" required>
                                                            <option value=""></option>
                                                            <option value="Pending" @if($ofi->immediate_action_status == 'Pending') selected @endif>Pending</option>
                                                            <option value="Done" @if($ofi->immediate_action_status == 'Done') selected @endif>Done</option>
                                                        </select>

                                                        <div id="immediateActionFile" hidden>
                                                            <input type="file" name="immediate_action_file"
                                                                class="form-control input-sm">
                                                        </div>
                                                    </td>
                                                    <td style="padding: 1px;">
                                                        <textarea name="immediate_action_remarks" class="form-control" cols="30" required>{{ $ofi->immediate_action_remarks }}</textarea>
                                                    </td>
                                                    <td style="padding: 1px;">
                                                        @if($ofi->immediate_action_file)
                                                        <a href="{{ url($ofi->immediate_action_file) }}"
                                                            target="_blank">
                                                            <i class="fa fa-file"></i>
                                                        </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @else
                                                @endif --}}
                                                @foreach ($ofi->ofiImmediateAction as $ofiImmediateAction)
                                                    <input type="hidden" name="immediate_action_id[]" value="{{ $ofiImmediateAction->id }}">
                                                    <tr>
                                                        <td style="padding: 1px;">{!! nl2br(e($ofiImmediateAction->immediate_action)) !!}</td>
                                                        <td style="padding: 1px;">{{ $ofi->issuedTo->name }}</td>
                                                        <td style="padding: 1px;">{{ date('M d Y', strtotime($ofiImmediateAction->implementation_date))}}</td>
                                                        <td style="padding: 1px;">
                                                            @if(auth()->user()->role->name != "Audit Head")
                                                            <select name="immediate_action_status[]" class="form-control input-sm" required onchange="showUploadFile({{ $ofiImmediateAction->id }}, this.value)">
                                                                <option value=""></option>
                                                                <option value="Pending" @if($ofiImmediateAction->status == 'Pending') selected @endif>Pending</option>
                                                                <option value="Done" @if($ofiImmediateAction->status == 'Done') selected @endif>Done</option>
                                                            </select>

                                                            <div id="immediateActionFile{{ $ofiImmediateAction->id }}" hidden>
                                                                <input type="file" name="immediate_action_file[]" class="form-control input-sm">
                                                            </div>
                                                            @else
                                                            {{ $ofiImmediateAction->status }}
                                                            @endif
                                                        </td>
                                                        <td style="padding: 1px;">
                                                            @if(auth()->user()->role->name != "Audit Head")
                                                            <textarea name="immediate_action_remarks[]" class="form-control" cols="30" required>{{ $ofiImmediateAction->remarks }}</textarea>
                                                            @else
                                                            {!! nl2br(e($ofiImmediateAction->remarks)) !!}
                                                            @endif
                                                        </td>
                                                        <td style="padding: 1px;">
                                                            @if($ofiImmediateAction->attachments)
                                                            <a href="{{ url($ofiImmediateAction->attachments) }}"
                                                                target="_blank">
                                                                <i class="fa fa-file"></i>
                                                            </a>
                                                            @endif
                                                        </td>
                                                        <td style="padding: 1px;">
                                                            @if($ofiImmediateAction->date_approved)
                                                            {{ date('Y-m-d', strtotime($ofiImmediateAction->date_approved)) }}
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
                                    @foreach ($ofi->verify as $key=>$verifier)
                                    <div class="row">
                                        <div class="col-md-3 border border-1 border-top-bottom border-right-left">
                                            {{ $verifier->user->name }}
                                        </div>
                                        <div class="col-md-3 border border-1 border-top-bottom border-right-left">
                                            {{ $verifier->status }}
                                        </div>
                                        <div class="col-md-3 border border-1 border-top-bottom border-right-left">
                                            @if($verifier->status == "Approved" || $verifier->status == "Submitted")
                                            {{ date('M d Y', strtotime($verifier->updated_at )) }}
                                            @endif
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

                    <form method="POST" action="{{ url('ofi_verify_action') }}" onsubmit="show()"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="ofi_id" value="{{ $ofi->id }}">
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
                    @if($ofi->remarksHistory->isNotEmpty())
                        @foreach ($ofi->remarksHistory as $history)
                            @if($history->correctiveActionRequest)
                            <h3 class="text-dark">{{ $history->correctiveActionRequest->immediate_action }}
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

    function showUploadFile(id,value)
    {
        if (value == 'Done')
        {
            $("#immediateActionFile"+id).removeAttr('hidden')
        }
        else
        {
            $("#immediateActionFile"+id).prop('hidden', true)
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

        $(".immediate_action_status").on('change', function() {
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