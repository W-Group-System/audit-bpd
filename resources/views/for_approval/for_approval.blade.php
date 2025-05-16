@component('components.modal', [
    'id' => 'view'.$car->id,
    'size' => 'modal-lg',
    'title' => 'View CAR - '.$car->status,
    // 'is_view' => true
    'url' => url('car_action')
])
    <input type="hidden" name="car_id" value="{{ $car->id }}">
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
                        <div class="col-md-3 border border-1 border-top-bottom border-right-left">
                            <b>Corrective Action</b>
                        </div>
                        <div class="col-md-3 border border-1 border-top-bottom border-right-left">
                            <b>Action Date</b>
                        </div>
                        <div class="col-md-3 border border-1 border-top-bottom border-right-left">
                            <b>Status</b>
                        </div>
                        <div class="col-md-3 border border-1 border-top-bottom border-right-left">
                            <b>Remarks</b>
                        </div>
                    </div>
                    @foreach ($car->correctiveAction as $corrective_action)
                        <div class="row">
                            <div class="col-md-3 border border-1 border-top-bottom border-right-left">
                                {{ $corrective_action->corrective_action }}
                            </div>
                            <div class="col-md-3 border border-1 border-top-bottom border-right-left">
                                {{ date('M d, Y', strtotime($corrective_action->action_date)) }}
                            </div>
                            <div class="col-md-3 border border-1 border-top-bottom border-right-left">
                                {{ $corrective_action->status }}
                            </div>
                            <div class="col-md-3 border border-1 border-top-bottom border-right-left">
                                {{ $corrective_action->remarks }}
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