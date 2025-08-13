@component('components.modal', [
    'id' => 'view'.$car->id,
    'size' => 'modal-xl',
    'title' => 'View CAR - '.$car->status,
    // 'is_view' => true
    'url' => url('car_action')
])
    <input type="hidden" name="car_id" value="{{ $car->id }}">
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
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    III. Root Cause Analysis
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th style="padding: 1px;">#</th>
                                <th style="padding: 1px;">Man</th>
                                <th style="padding: 1px;">Method</th>
                                <th style="padding: 1px;">Machine</th>
                                <th style="padding: 1px;">Measurement</th>
                                <th style="padding: 1px;">Mother Nature</th>
                            </tr>
                            <tbody>
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
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <hr> --}}
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    IV. Corrective Action
                </div>
                <div class="panel-body">
                    <table class="table-bordered table">
                        <tr>
                            <th style="padding: 1px;">Corrective Action</th>
                            <th style="padding: 1px;">Action Date</th>
                            <th style="padding: 1px;">Status</th>
                            <th style="padding: 1px;">Remarks</th>
                        </tr>
                        @foreach ($car->correctiveAction as $corrective_action)
                        <tr>
                            <td style="padding: 1px;">{{ $corrective_action->corrective_action }}</td>
                            <td style="padding: 1px;">{{ date('M d, Y', strtotime($corrective_action->action_date)) }}</td>
                            <td style="padding: 1px;">{{ $corrective_action->status }}</td>
                            <td style="padding: 1px;">{{ $corrective_action->remarks }}</td>
                        </tr>
                        @endforeach
                    </table>
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
                    @foreach ($car->approver as $approver)
                        <div class="row">
                            <div class="col-md-3 border border-1 border-top-bottom border-right-left">
                                {{ $approver->user->name }}
                            </div>
                            <div class="col-md-3 border border-1 border-top-bottom border-right-left">
                                {{ $approver->status }}
                            </div>
                            <div class="col-md-3 border border-1 border-top-bottom border-right-left">
                                {{ date('M d Y', strtotime($corrective_action->updated_at )) }}
                            </div>
                            <div class="col-md-3 border border-1 border-top-bottom border-right-left">
                                {{ $approver->remarks }}
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
        <div class="col-md-6">
            Action :
            <select data-placeholder="Select Action" name="action" class="cat form-control" required>
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
    @endif
@endcomponent