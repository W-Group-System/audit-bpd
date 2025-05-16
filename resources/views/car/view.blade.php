@component('components.modal', [
    'id' => 'view'.$car->id,
    'size' => 'modal-lg',
    'title' => 'View CAR -' .$car->status,
    'is_view' => true
    // 'url' => url('store_car')
])
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
        <div class="col-lg-6">
            @if($car->evidence_attachment)
            <b>Evidence :</b>
            <a href="{{ url($car->evidence_attachment) }}" target="_blank">
                <i class="fa fa-file-pdf-o"></i>
            </a>
            @endif
        </div>
        {{-- <div class="col-lg-12">
            <b>Reference Document </b> <i>(if any) :</i>
            {!! nl2br(e($car->reference_document)) !!}
        </div> --}}
        
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
        <div class="col-md-4">
            <b>Action Date :</b>
            {{ date('M d Y', strtotime($car->action_date_immediate_action)) }}
        </div>
        <div class="col-md-4">
            <b>Action Responsible :</b>
            {{ $car->auditee->name }}
        </div>
        <div class="col-md-4">
            <b>Verification :</b>
            {{ $car->verification_correction }}
        </div>
        <div class="col-md-6"></div>
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    II. Correction Immediate Action
                </div>
                <div class="panel-body">
                    {!! nl2br(e($car->immediate_action)) !!}
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
                        <table class="table">
                            <thead>
                                <tr><th>#</th>
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

    {{-- <hr> --}}
    <div class="row">
        {{-- <div class="col-md-4">
            <b>Action Date :</b>
            {{ date('M d Y', strtotime($car->action_date_corrective_action)) }}
        </div> --}}
        {{-- <div class="col-md-4">
            <b>Action Responsible :</b>
            {{ $car->auditee->name }}
        </div>
        <div class="col-md-4">
            <b>Verification :</b>
            {{ $car->verification_corrective_action }}
        </div> --}}
        <div class="col-md-6"></div>
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    IV. Corrective Action
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3 border border-1 border-top-bottom border-left-right">
                            <b>Corrective Action</b>
                        </div>
                        <div class="col-md-3 border border-1 border-top-bottom border-left-right">
                            <b>Action Date</b>
                        </div>
                        <div class="col-md-3 border border-1 border-top-bottom border-left-right">
                            <b>Status</b>
                        </div>
                        <div class="col-md-3 border border-1 border-top-bottom border-left-right">
                            <b>Remarks</b>
                        </div>
                    </div>
                    @foreach ($car->correctiveAction as $corrective_action)
                        <div class="row">
                            <div class="col-md-3 border border-1 border-top-bottom border-left-right">
                                {!! nl2br(e($corrective_action->corrective_action)) !!}
                            </div>
                            <div class="col-md-3 border border-1 border-top-bottom border-left-right">
                                {{ date('M d, Y', strtotime($corrective_action->action_date)) }}
                            </div>
                            <div class="col-md-3 border border-1 border-top-bottom border-left-right">
                                {{ $corrective_action->status }}
                                @if(empty($corrective_action->status))
                                &nbsp;
                                @endif
                            </div>
                            <div class="col-md-3 border border-1 border-top-bottom border-left-right">
                                {{ $corrective_action->remarks }}
                                @if(empty($corrective_action->remarks))
                                &nbsp;
                                @endif
                            </div>
                        </div>
                    @endforeach
                    {{-- @dd($car->correctiveAction) --}}
                </div>
            </div>
        </div>
    </div>
    <hr>

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