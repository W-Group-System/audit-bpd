@component('components.modal', [
    'id' => 'view'.$car->id,
    'size' => 'modal-xl',
    'title' => 'View CAR - ' .$car->status,
    'is_view' => true
    // 'url' => url('store_car')
])
    <div class="row">
        <div class="col-lg-6">
            <b>CAR :</b>
            CAR-{{ str_pad($car->id,3,'0',STR_PAD_LEFT) }}
        </div>
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
        <div class="col-lg-6">
            @if($car->evidence_attachment)
            <b>Evidence :</b>
            <a href="{{ url($car->evidence_attachment) }}" target="_blank">
                <i class="fa fa-file-pdf-o"></i>
            </a>
            @endif
        </div>
        <div class="col-lg-6">
            <b>Auditor : </b>
            {{ $car->auditor->name }}
        </div>
        
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
    
    @if($car->status != 'Fill-Out')
    <div class="row">
        {{-- <div class="col-md-4">
            <b>Action Date :</b>
            {{ date('M d Y', strtotime($car->action_date_immediate_action)) }}
        </div> --}}
        {{-- <div class="col-md-4">
            <b>Action Responsible :</b>
            {{ $car->auditee->name }}
        </div> --}}
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    II. Correction Immediate Action
                </div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <tr>
                            <th style="padding: 1px;">Correction Immediate Action</th>
                            <th style="padding: 1px;">Action Responsible</th>
                            <th style="padding: 1px;">Action Date</th>
                            <th style="padding: 1px;">Status</th>
                            <th style="padding: 1px;">Remarks</th>
                            <th style="padding: 1px;">Attachments</th>
                            <th style="padding: 1px;">Verified Date</th>
                        </tr>
                        {{-- @if($car->immediate_action)
                        <tr>
                            <td style="padding: 1px;">{!! nl2br(e($car->immediate_action)) !!}</td>
                            <td style="padding: 1px;">{{ $car->auditee->name }}</td>
                            <td style="padding: 1px;">{{ date('Y-m-d', strtotime($car->action_date_immediate_action)) }}</td>
                            <td style="padding: 1px;">{{ $car->immediate_action_status }}</td>
                            <td style="padding: 1px;">{!! nl2br(e($car->immediate_action_remarks)) !!}</td>
                            <td style="padding: 1px;">
                                @if($car->immediate_action_file)
                                <a href="{{ url($car->immediate_action_file) }}" target="_blank">
                                    <i class="fa fa-file"></i>
                                </a>
                                @endif
                            </td>
                            <td>
                                @if($car->approved_date)
                                {{ date('Y-m-d', strtotime($car->approved_date)) }}
                                @endif
                            </td>
                        </tr>
                        @else
                        @endif --}}
                        @foreach ($car->correctionImmediateAction as $correctionImmediateAction)
                        <tr>
                            <td style="padding: 1px;">{!! nl2br(e($correctionImmediateAction->correction_immediate_action)) !!}</td>
                            <td style="padding: 1px;">{{ $correctionImmediateAction->corrective_action_request->auditee->name }}</td>
                            <td style="padding: 1px;">{{ date('Y-m-d', strtotime($correctionImmediateAction->correction_action_date)) }}</td>
                            <td style="padding: 1px;">{{ $correctionImmediateAction->status }}</td>
                            <td style="padding: 1px;">
                                {{-- @if($car->immediate_action_file)
                                <a href="{{ url($car->immediate_action_file) }}" target="_blank">
                                    <i class="fa fa-file"></i>
                                </a>
                                @endif --}}
                            </td>
                            <td style="padding: 1px;">
                                {{-- @if($car->approved_date)
                                {{ date('Y-m-d', strtotime($car->approved_date)) }}
                                @endif --}}
                            </td>
                            <td style="padding: 1px;">
                                {{-- @if($car->approved_date)
                                {{ date('Y-m-d', strtotime($car->approved_date)) }}
                                @endif --}}
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- <hr> --}}
    <div class="row">
        {{-- <div class="col-md-6">
            <b>Action Date :</b>
            {{ date('M d Y', strtotime($car->action_date_root_cause)) }}
        </div>
        <div class="col-md-6"></div> --}}
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    III. Root Cause Analysis
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr><th style="padding: 1px;">#</th>
                                <th style="padding: 1px;">Man</th>
                                <th style="padding: 1px;">Method</th>
                                <th style="padding: 1px;">Machine</th>
                                <th style="padding: 1px;">Material</th>
                                <th style="padding: 1px;">Mother Nature</th>
                            </tr>
                            @foreach ($car->rootCauseAnalysis as $key=>$rootCauseAnalysis)
                                <tr>
                                    <td style="padding: 1px;">{{ $key+1 }}</td>
                                    <td style="padding: 1px;">{!! nl2br(e($rootCauseAnalysis->man)) !!}</td>
                                    <td style="padding: 1px;">{!! nl2br(e($rootCauseAnalysis->method)) !!}</td>
                                    <td style="padding: 1px;">{!! nl2br(e($rootCauseAnalysis->machine)) !!}</td>
                                    <td style="padding: 1px;">{!! nl2br(e($rootCauseAnalysis->material)) !!}</td>
                                    <td style="padding: 1px;">{!! nl2br(e($rootCauseAnalysis->mother_nature)) !!}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <hr> --}}
    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    IV. Corrective Action
                </div>
                <div class="panel-body">
                    <table class="table table-bordered table-sm">
                        <tr>
                            <th style="padding: 1px;">Corrective Action</th>
                            <th style="padding: 1px;">Action Date</th>
                            <th style="padding: 1px;">Status</th>
                            <th style="padding: 1px;">Remarks</th>
                            <th style="padding: 1px;">Attachment</th>
                            <th style="padding: 1px;">Verified Date</th>
                        </tr>
                        @foreach ($car->correctiveAction as $corrective_action)
                        <tr>
                            <td style="padding: 1px;">{!! nl2br(e($corrective_action->corrective_action)) !!}</td>
                            <td style="padding: 1px;">{{ date('M d, Y', strtotime($corrective_action->action_date)) }}</td>
                            <td style="padding: 1px;">{{ $corrective_action->status }}</td>
                            <td style="padding: 1px;">{!! nl2br(e($corrective_action->remarks)) !!}
                                @foreach ($corrective_action->remarks_history as $remarks)
                                    @if($corrective_action->remarks !== $remarks->remarks)
                                    <hr>
                                    {!! nl2br(e($remarks->remarks)) !!} <br>
                                    @endif
                                @endforeach
                            </td>
                            <td style="padding: 1px;">
                                @if($corrective_action->file_attachments)
                                <a href="{{ url($corrective_action->file_attachments) }}" target="_blank">
                                    <i class="fa fa-file"></i>
                                </a>
                                @endif
                            </td>
                            <td style="padding: 1px;">
                                @if($corrective_action->status == "Done")
                                    {{ date('Y-m-d', strtotime($corrective_action->updated_at)) }}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    <hr>
    @endif

    @if($car->approver->isNotEmpty())
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Approvers
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3 border border-1 border-top-bottom border-left-right">
                                <b>Name</b>
                            </div>
                            <div class="col-md-3 border border-1 border-top-bottom border-left-right">
                                <b>Status</b>
                            </div>
                            <div class="col-md-3 border border-1 border-top-bottom border-left-right">
                                <b>Action Date</b>
                            </div>
                            <div class="col-md-3 border border-1 border-top-bottom border-left-right">
                                <b>Remarks</b>
                            </div>
                        </div>
                        @foreach ($car->approver as $approver)
                            <div class="row">
                                <div class="col-md-3 border border-1 border-top-bottom border-left-right">
                                    {{ $approver->user->name }}
                                </div>
                                <div class="col-md-3 border border-1 border-top-bottom border-left-right">
                                    {{ $approver->status }}
                                </div>
                                <div class="col-md-3 border border-1 border-top-bottom border-left-right">
                                    {{ date('M d Y', strtotime($approver->updated_at )) }}
                                </div>
                                <div class="col-md-3 border border-1 border-top-bottom border-left-right">
                                    {{ $approver->remarks }}
                                </div>
                            </div>
                        @endforeach
                        {{-- @dd($car->correctiveAction) --}}
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if($car->verify->isNotEmpty())
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Verifiers
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3 border border-1 border-top-bottom border-left-right">
                                <b>Name</b>
                            </div>
                            <div class="col-md-3 border border-1 border-top-bottom border-left-right">
                                <b>Status</b>
                            </div>
                            <div class="col-md-3 border border-1 border-top-bottom border-left-right">
                                <b>Action Date</b>
                            </div>
                            <div class="col-md-3 border border-1 border-top-bottom border-left-right">
                                <b>Remarks</b>
                            </div>
                        </div>
                        @foreach ($car->verify as $verify)
                            <div class="row">
                                <div class="col-md-3 border border-1 border-top-bottom border-left-right">
                                    {{ $verify->user->name }}
                                </div>
                                <div class="col-md-3 border border-1 border-top-bottom border-left-right">
                                    {{ $verify->status }}
                                </div>
                                <div class="col-md-3 border border-1 border-top-bottom border-left-right">
                                    {{ date('M d Y', strtotime($verify->updated_at )) }}
                                </div>
                                <div class="col-md-3 border border-1 border-top-bottom border-left-right">
                                    {{ $verify->remarks }}
                                </div>
                            </div>
                        @endforeach
                        {{-- @dd($car->correctiveAction) --}}
                    </div>
                </div>
            </div>
        </div>
    @endif
@endcomponent