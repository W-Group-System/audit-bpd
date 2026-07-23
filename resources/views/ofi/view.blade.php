@component('components.modal', [
    'id' => 'view'.$ofi->id,
    'size' => 'modal-lg',
    'title' => 'View OFI',
    'is_view' => true
    // 'url' => url('store_car')
])
    <div class="row">
        <div class="col-md-6">
            <b>OFI# :</b>
           {{ $ofi->ofi_no }}
        </div>
        <div class="col-md-6">
            <b>Department :</b>
            {{ $ofi->department->name }}
        </div>
        <div class="col-md-6">
            <b>Issued By :</b>
            {{ $ofi->issuedBy->name }}
        </div>
        <div class="col-md-6">
            <b>Issued To :</b>
            {{ $ofi->issuedTo->name }}
        </div>
        <div class="col-md-6">
            <b>Date Issued :</b>
            {{ date('M d Y', strtotime($ofi->created_at)) }}
        </div>
        <div class="col-md-12">
            <div class="panel panel-primary  m-t-2">
                <div class="panel-heading">
                    Description :
                </div>
                <div class="panel-body">
                    {!! nl2br(e($ofi->description)) !!}
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="panel panel-primary  m-t-2">
                <div class="panel-heading">
                    Recommendation :
                </div>
                <div class="panel-body">
                    {!! nl2br(e($ofi->recommendation)) !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <form method="post" action="{{ url('update_ofi_verify/'.$ofi->id) }}" onsubmit="show()"
                enctype="multipart/form-data">
                @csrf

                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Immediate Action

                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <tr>
                                <th style="padding: 1px;">Immediate Action</th>
                                <th style="padding: 1px;">Action Responsible</th>
                                <th style="padding: 1px;">Action Date</th>
                                <th style="padding: 1px;">Status</th>
                                <th style="padding: 1px;">Remarks</th>
                                <th style="padding: 1px;">Attachment</th>
                                <th style="padding: 1px;">Date Verified</th>
                            </tr>
                            <tbody>
                            @foreach ($ofi->ofiImmediateAction as $ofiImmediateAction)
                                    {{-- <input type="hidden" name="immediate_action_id[]" value="{{ $ofiImmediateAction->id }}"> --}}
                                    <tr>
                                        <td style="padding: 1px;">{!! nl2br(e($ofiImmediateAction->immediate_action)) !!}</td>
                                        <td style="padding: 1px;">{{ $ofi->issuedTo->name }}</td>
                                        <td style="padding: 1px;">{{ date('M d Y', strtotime($ofiImmediateAction->implementation_date))}}</td>
                                        <td style="padding: 1px;">{{ $ofiImmediateAction->status }}</td>
                                        <td style="padding: 1px;">{!! nl2br(e($ofiImmediateAction->remarks)) !!}</td>
                                        <td style="padding: 1px;">
                                            @if($ofiImmediateAction->attachments)
                                            <a href="{{ url($ofiImmediateAction->attachments) }}"
                                                target="_blank">
                                                <i class="fa fa-file"></i>
                                            </a>
                                            @endif
                                        </td>
                                        <td style="padding: 1px;">
                                            @if($ofiImmediateAction->date_approved)
                                            {{ date('Y-m-d', strtotime($ofiImmediateAction->date_approved)) }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if($ofi->approver->isNotEmpty())
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
                        @foreach ($ofi->approver as $approver)
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
    @if($ofi->verify->isNotEmpty())
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
                        @foreach ($ofi->verify as $verify)
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