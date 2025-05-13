{{-- @component('components.modal', [
    'id' => 'view'.$car->id,
    'size' => 'modal-lg',
    'title' => 'View CAR',
    // 'is_view' => true
    'url' => url('verify_action')
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
    <div class="row">
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

    <div class="row">
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
                        <input type="hidden" name="verifier_id[]" value="{{ $verifier->id }}">

                        <div class="row">
                            <div class="col-md-3 border border-1 border-top-bottom border-right-left">
                                {{ $corrective_action->corrective_action }}
                            </div>
                            <div class="col-md-3 border border-1 border-top-bottom border-right-left">
                                {{ date('M d, Y', strtotime($corrective_action->action_date)) }}
                            </div>
                            <div class="col-md-3 border border-1 border-top-bottom border-right-left">
                                <select name="status[]" class="form-control input-sm" required>
                                    <option value=""></option>
                                    <option value="Pending" @if($corrective_action->status == 'Pending') selected @endif>Pending</option>
                                    <option value="Done" @if($corrective_action->status == 'Done') selected @endif>Done</option>
                                </select>
                            </div>
                            <div class="col-md-3 border border-1 border-top-bottom border-right-left">
                                <textarea name="remarks_action[]" class="form-control input-sm" cols="30" required >{{ $corrective_action->remarks }}</textarea>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
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
@endcomponent --}}

