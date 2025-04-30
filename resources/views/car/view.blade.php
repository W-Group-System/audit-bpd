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
        <div class="col-lg-12">
            <b>Reference Document </b> <i>(if any) :</i>
            {!! nl2br(e($car->reference_document)) !!}
        </div>
        
        <div class="col-md-12">
            <hr>

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
    <hr>
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
    <hr>
    <div class="row">
        <div class="col-md-6">
            <b>Action Date :</b>
            {{ date('M d Y', strtotime($car->action_date_root_cause)) }}
        </div>
        <div class="col-md-6"></div>
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    III. Root Cause Analysis
                </div>
                <div class="panel-body">
                    {!! nl2br(e($car->root_cause_analysis)) !!}
                </div>
            </div>
        </div>
    </div>

    <hr>
    <div class="row">
        <div class="col-md-4">
            <b>Action Date :</b>
            {{ date('M d Y', strtotime($car->action_date_corrective_action)) }}
        </div>
        <div class="col-md-4">
            <b>Action Responsible :</b>
            {{ $car->auditee->name }}
        </div>
        <div class="col-md-4">
            <b>Verification :</b>
            {{ $car->verification_corrective_action }}
        </div>
        <div class="col-md-6"></div>
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    IV. Corrective Action
                </div>
                <div class="panel-body">
                    {!! nl2br(e($car->corrective_action)) !!}
                </div>
            </div>
        </div>
    </div>
    @endif
@endcomponent