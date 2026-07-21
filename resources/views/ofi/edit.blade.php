@component('components.modal', [
    'id' => 'edit'.$ofi->id,
    'size' => 'modal-xl',
    'title' => 'Edit OFI',
    // 'is_view' => true
    'url' => url('/ofi/update/'.$ofi->id),
    'has_enctype' => true
])
    <div class="row">
        <div class="col-md-12">
            Immediate Action :
            <button type="button" class="btn btn-xs btn-primary" onclick="addOfiCorrectionBtn({{ $ofi->id }})"><i class="fa fa-plus"></i></button>
            <button type="button" class="btn btn-xs btn-danger" onclick="removeOfiCorrectionBtn({{ $ofi->id }})"><i class="fa fa-minus"></i></button>
            @if(count($ofi->ofiImmediateAction) > 0)
                <div id="ofiImmediateAction{{ $ofi->id }}">
                    @foreach ($ofi->ofiImmediateAction as $key=>$ofiImmediateAction)
                    @php
                        $hasReturnedApprover = collect($ofi->approver)
                            ->contains('status', 'Returned');
                    @endphp
                    <div class="row" id="ofiNum_{{ $key+1 }}">
                        <div class="col-md-1">
                            {{ $key+1 }}
                        </div>
                        <div class="col-md-6">
                            <textarea name="ofi_immediate_action[]" class="form-control" cols="30" required>{{ $ofiImmediateAction->immediate_action }}</textarea>
                        </div>
                        <div class="col-md-5">
                            Implementation Date :
                            <input type="date" name="ofi_implementation_date[]" class="form-control input-sm" min="{{ date('Y-m-d') }}" value="{{ $ofiImmediateAction->implementation_date }}" {{ $hasReturnedApprover ? 'readonly' : '' }} required>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
            <div id="ofiImmediateAction{{ $ofi->id }}">
                <div class="row" id="ofiNum_1">
                    <div class="col-md-1">
                        1
                    </div>
                    <div class="col-md-6">
                        <textarea name="ofi_immediate_action[]" class="form-control" cols="30" required></textarea>
                    </div>
                    <div class="col-md-5">
                        Implementation Date :
                        <input type="date" name="ofi_implementation_date[]" class="form-control input-sm" min="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
@endcomponent