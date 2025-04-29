@component('components.modal', [
    'id' => 'edit'.$car->id,
    'size' => 'modal-lg',
    'title' => 'Edit CAR',
    // 'is_view' => true
    'url' => url('update_car/'.$car->id),
    'has_enctype' => true
])
    <div class="row">
        <div class="col-md-12">
            Correction / Immediate Action :
            <textarea name="immediate_action" class="form-control input-sm" cols="30" rows="10" required></textarea>
        </div>
        <div class="col-md-6">
            Action Date :
            <input type="date" name="action_date_immediate_action" class="form-control input-sm" required>
        </div>
        <div class="col-md-6">
            Verification :
            <select data-placeholder="Select verification" name="verification_correction" class="form-control input-sm cat">
                <option value=""></option>
                <option value="D">Done</option>
                <option value="ND">Not Done</option>
                <option value="OG">On-going</option>
            </select>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            Root Cause Analysis :
            <textarea name="root_cause_analysis" class="form-control" cols="30" rows="10" required></textarea>
        </div>
        <div class="col-md-6">
            Action Date :
            <input type="date" name="action_date_root_cause" class="form-control input-sm" required>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            Corrective Action :
            <textarea name="corrective_action" class="form-control input-sm" cols="30" rows="10" required></textarea>
        </div>
        <div class="col-md-6">
            Action Date :
            <input type="date" name="action_date_corrective_action" class="form-control input-sm" required>
        </div>
        <div class="col-md-6">
            Verification :
            <select data-placeholder="Select verification" name="verification_corrective_action" class="form-control input-sm cat">
                <option value=""></option>
                <option value="D">Done</option>
                <option value="ND">Not Done</option>
                <option value="OG">On-going</option>
            </select>
        </div>

        <div class="col-md-6">
            Upload Attachment :
            <input type="file" name="attachment[]" class="form-control" multiple required>
        </div>
    </div>
@endcomponent