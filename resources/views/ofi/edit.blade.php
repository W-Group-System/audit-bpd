@component('components.modal', [
    'id' => 'edit'.$ofi->id,
    'size' => 'modal-md',
    'title' => 'Edit CAR',
    // 'is_view' => true
    'url' => url('/ofi/update/'.$ofi->id),
    'has_enctype' => true
])
    <div class="row">
        <div class="col-md-12">
            Action Date :
            <input type="date" name="action_date" class="form-control" min="{{ date('Y-m-d') }}" required>
        </div>
        <div class="col-md-12">
            Proof of attachment :
            <input type="file" name="files[]" class="form-control" required multiple accept=".pdf">
        </div>
    </div>
@endcomponent