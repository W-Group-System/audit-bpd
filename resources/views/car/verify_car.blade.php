@php
    $is_disabled = count($car->verify->where('user_id', auth()->user()->id)->where('status','Submitted'));
@endphp
@component('components.modal', [
    'id' => 'verify'.$car->id,
    'size' => 'modal-lg',
    'title' => 'Verify CAR - ' .$car->status,
    // 'is_view' => true
    'url' => url('verify_car/'.$car->id),
    'is_disabled' => $is_disabled
])
    <div class="row">
        @if($car->verify->isNotEmpty())
            <div class="col-md-12">
                Correction Immediate Action :
                <textarea name="correction_immediate_action" class="form-control" cols="30" rows="10" @if($car->immediate_action_status == 'Done') readonly @endif>{{ $car->immediate_action }}</textarea>
            </div>
            <div class="col-md-6 m-b-md">
                Action Date :
                <input type="date" name="correction_immediate_action_date" class="form-control input-sm" value="{{ $car->action_date_immediate_action }}" @if($car->immediate_action_status == 'Done') readonly @endif required>
            </div>
            
            <div class="col-md-12 m-b-md">
                Corrective Action : 
                {{-- <button type="button" class="btn btn-xs btn-primary" onclick="addRowBtn({{ $car->id }})"><i class="fa fa-plus"></i></button>
                <button type="button" class="btn btn-xs btn-danger" onclick="removeRowBtn({{ $car->id }})"><i class="fa fa-minus"></i></button> --}}

                @if($car->correctiveAction->isNotEmpty())
                    <div id="correctiveActionContainer{{ $car->id }}">
                        @foreach ($car->correctiveAction as $key=>$ca)
                        <div class="row" id="caNum_{{ $key+1 }}">
                            <div class="col-md-1">
                                {{ $key+1 }}
                            </div>
                            <div class="col-md-6">
                                <textarea name="corrective_action[]" class="form-control" cols="30" @if($ca->status == 'Done') readonly @endif required>{{ $ca->corrective_action }}</textarea>
                            </div>
                            <div class="col-md-5">
                                <input type="date" name="action_date[]" class="form-control input-sm" min="{{ date('Y-m-d') }}" value="{{ $ca->action_date }}" @if($ca->status == 'Done') readonly @endif required>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                <div id="correctiveActionContainer{{ $car->id }}">
                    <div class="row" id="caNum_1">
                        <div class="col-md-1">
                            1
                        </div>
                        <div class="col-md-6">
                            <textarea name="corrective_action[]" class="form-control" cols="30" required></textarea>
                        </div>
                        <div class="col-md-5">
                            <input type="date" name="action_date[]" class="form-control input-sm" min="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <hr>
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
                                    {{ date('M d Y', strtotime($verifier->updated_at)) }}
                                </div>
                                <div class="col-md-3 border border-1 border-top-bottom border-right-left">
                                    {{ $verifier->remarks }}
                                </div>
                            </div>
                        @endforeach
                        {{-- @dd($car->correctiveAction) --}}
                    </div>
                </div>
            </div>
        @else
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Verifiers
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6 border border-1 border-top-bottom border-left-right">
                                <b>Level</b>
                            </div>
                            <div class="col-md-6 border border-1 border-top-bottom border-left-right">
                                <b>Name</b>
                            </div>
                        </div>
                        @php
                            $auditor = $users->where('id', $car->auditor_id)->first();
                            $audit_head = $users->where('role_id', 4)->first();
                        @endphp
                        <div class="row">
                            <div class="col-md-6 border border-1 border-top-bottom border-left-right">
                                1
                            </div>
                            <div class="col-md-6 border border-1 border-top-bottom border-left-right">
                                {{ $auditor->name }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 border border-1 border-top-bottom border-left-right">
                                2
                            </div>
                            <div class="col-md-6 border border-1 border-top-bottom border-left-right">
                                {{ $audit_head->name }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif  
    </div>
@endcomponent