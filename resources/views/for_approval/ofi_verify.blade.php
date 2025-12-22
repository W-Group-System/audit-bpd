@component('components.modal', [
    'id' => 'ofiVerifiers'.$ofi->id,
    'size' => 'modal-lg',
    'title' => 'View OFI',
    // 'is_view' => true
    'url' => url('ofi_action')
])
    <input type="hidden" name="ofi_id" value="{{ $ofi->id }}">
    <div class="row">
        <div class="col-md-6">
            <b>OFI# :</b>
            OFI-{{ str_pad($ofi->id,3,'0',STR_PAD_LEFT) }}
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
                    @foreach ($ofi->verifiers as $approver)
                        <div class="row">
                            <div class="col-md-3 border border-1 border-top-bottom border-right-left">
                                {{ $approver->user->name }}
                            </div>
                            <div class="col-md-3 border border-1 border-top-bottom border-right-left">
                                {{ $approver->status }}
                            </div>
                            <div class="col-md-3 border border-1 border-top-bottom border-right-left">
                                @if($ofi->status == "Approved")
                                {{ date('M d Y', strtotime($ofi->updated_at )) }}
                                @endif
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
@endcomponent