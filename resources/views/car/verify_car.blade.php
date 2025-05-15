@php
    $is_disabled = count($car->verify->where('user_id', auth()->user()->id)->where('status','Submitted'));
@endphp
@component('components.modal', [
    'id' => 'verify'.$car->id,
    'size' => 'modal-lg',
    'title' => 'Verify CAR',
    // 'is_view' => true
    'url' => url('verify_car/'.$car->id),
    'is_disabled' => $is_disabled
])
    <div class="row">
        @if($car->verify->isNotEmpty())
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