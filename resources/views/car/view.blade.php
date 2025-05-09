@component('components.modal', [
    'id' => 'view'.$car->id,
    'size' => 'modal-lg',
    'title' => 'View CAR',
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
    
    @if($car->status == 'In Progress')
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
                    1. {!! nl2br(e($car->man )) !!} <br>
                    2. {!! nl2br(e($car->method )) !!} <br>
                    3. {!! nl2br(e($car->machine )) !!} <br>
                    4. {!! nl2br(e($car->material )) !!} <br>
                    5. {!! nl2br(e($car->mother_nature )) !!}
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
                                {{-- {{ $corrective_action->status }} --}}
                            </div>
                            <div class="col-md-3 border border-1 border-top-bottom border-right-left">
                                {{-- {{ $corrective_action->remarks }} --}}
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