@component('components.modal', [
    'id' => 'view_ofi'.$ofi->id,
    'size' => 'modal-xl',
    'title' => 'View OFI - '.$ofi->status,
    // 'is_view' => true
    'url' => url('ofi_store')
])
    <input type="hidden" name="ofi_id" value="{{ $ofi->id }}">
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

    @if($ofi->status != 'Fill-Out')
        <div class="row">
            <div class="col-md-12">
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
                                <th style="padding: 1px;">Attachments</th>
                                <th style="padding: 1px;">Verified Date</th>
                            </tr>
                            @foreach ($ofi->ofiImmediateAction as $correctionImmediateAction)
                            <tr>
                                <td style="padding: 1px;">{!! nl2br(e($correctionImmediateAction->immediate_action)) !!}</td>
                                <td style="padding: 1px;">{{ $ofi->issuedTo->name }}</td>
                                <td style="padding: 1px;">{{ date('Y-m-d', strtotime($correctionImmediateAction->implementation_date)) }}</td>
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
    @endif
    
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
                    @foreach ($ofi->approver as $approver)
                        <div class="row">
                            <div class="col-md-3 border border-1 border-top-bottom border-right-left">
                                {{ $approver->user->name }}
                            </div>
                            <div class="col-md-3 border border-1 border-top-bottom border-right-left">
                                {{ $approver->status }}
                            </div>
                            <div class="col-md-3 border border-1 border-top-bottom border-right-left">
                                {{ date('M d Y', strtotime($ofi->updated_at )) }}
                            </div>
                            <div class="col-md-3 border border-1 border-top-bottom border-right-left">
                                {{ $approver->remarks }}
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
    {{-- @endif --}}
@endcomponent