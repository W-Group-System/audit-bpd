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
@endcomponent