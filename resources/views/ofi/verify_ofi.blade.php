@php
    $is_disabled = count($ofi->verifiers->where('user_id', auth()->user()->id)->where('status','Submitted'));
@endphp
@component('components.modal', [
    'id' => 'ofi_verifiers'.$ofi->id,
    'size' => 'modal-lg',
    'title' => 'Verify CAR - ' .$ofi->status,
    // 'is_view' => true
    'url' => url('ofi_verifiers/'.$ofi->id),
    'is_disabled' => $is_disabled
])
    <div class="row">
        @if($ofi->verifiers->isNotEmpty())
            {{-- <div class="col-md-12">
                Immediate Action :
                <textarea name="immediate_action" class="form-control" cols="30" rows="10" @if($ofi->immediate_action_status == 'Done') readonly @endif>{{ $ofi->immediate_action }}</textarea>
            </div>
            <div class="col-md-6 m-b-md">
                Action Date :
                <input type="date" name="correction_immediate_action_date" class="form-control input-sm" value="{{ $ofi->action_date_immediate_action }}" @if($ofi->immediate_action_status == 'Done') readonly @endif required>
            </div> --}}
            
            {{-- <div class="col-md-12 m-b-md">
                Corrective Action : 
                @if($ofi->correctiveAction->isNotEmpty())
                    <div id="correctiveActionContainer{{ $ofi->id }}">
                        @foreach ($ofi->correctiveAction as $key=>$ca)
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
                <div id="correctiveActionContainer{{ $ofi->id }}">
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
            </div> --}}
            {{-- <hr> --}}
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
                        @foreach ($ofi->verifiers as $verifier)
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
                        {{-- @dd($ofi->correctiveAction) --}}
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
                            $auditor = $users->where('id', $ofi->issued_by)->first();
                            $audit_head = $users->where('role_id', 4)->first();
                        @endphp
                        @if($ofi->department_id == 2)
                            <div class="row">
                                <div class="col-md-6 border border-1 border-top-bottom border-left-right">
                                    1
                                </div>
                                <div class="col-md-6 border border-1 border-top-bottom border-left-right">
                                    @if($auditor)
                                    {{ $auditor->name }}
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-md-6 border border-1 border-top-bottom border-left-right">
                                    1
                                </div>
                                <div class="col-md-6 border border-1 border-top-bottom border-left-right">
                                    @if($auditor)
                                    {{ $auditor->name }}
                                    @endif
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
                        @endif
                    </div>
                </div>
            </div>
        @endif  
    </div>
@endcomponent