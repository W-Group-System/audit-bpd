@component('components.modal', [
'id' => 'editAdmin'.$car->id,
'size' => 'modal-lg',
'title' => 'Edit CAR',
// 'is_view' => true
'url' => url('update_admin/'.$car->id),
'has_enctype' => true
])
<div class="row">
    <div class="col-md-12">
        Standard and Clause :
        <textarea name="standard_and_clause" class="form-control" cols="30" required>{{ $car->standard_and_clause }}</textarea>
    </div>
    <div class="col-md-6">
        Department :
        <select data-placeholder="Select department" name="department" class="cat form-control" required
            onchange="refreshDeptHead(this)">
            <option value=""></option>
            @foreach ($departments as $department)
            <option value="{{ $department->id }}" @if($car->department_id == $department->id) selected @endif>{{ $department->code .' - '.$department->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        Classification of Nonconformity :
        <select data-placeholder="Select classification of nonconformity" name="classification_of_nonconformity"
            class="cat form-control" required>
            <option value=""></option>
            <option value="OFI" @if($car->classification_of_nonconformity == "OFI") selected @endif>Opportunities of Improvement (OFI)</option>
            <option value="Minor" @if($car->classification_of_nonconformity == "Minor") selected @endif>Minor</option>
            <option value="Major" @if($car->classification_of_nonconformity == "Major") selected @endif>Major</option>
            <option value="Critical" @if($car->classification_of_nonconformity == "Critical") selected @endif>Critical</option>
        </select>
    </div>
    <div class="col-md-6">
        Nature of Nonconformity :
        <select data-placeholder="Select nature of nonconformity" name="nature_of_nonconformity"
            class="cat form-control" required>
            <option value=""></option>
            <option value="Internal Audit Findings (IA)" @if($car->nature_of_nonconformity == "Internal Audit Findings (IA)") selected @endif>Internal Audit Findings (IA)</option>
            <option value="External Audit Findings (EA)" @if($car->nature_of_nonconformity == "External Audit Findings (EA)") selected @endif>External Audit Findings (EA)</option>
            <option value="Legal Compliance (LC)" @if($car->nature_of_nonconformity == "Legal Compliance (LC)") selected @endif>Legal Compliance (LC)</option>
            <option value="Customer Complaints (CC)" @if($car->nature_of_nonconformity == "Customer Complaints (CC)") selected @endif>Customer Complaints (CC)</option>
        </select>
    </div>
    <div class="col-md-6">
        Type of Nonconformity :
        <select data-placeholder="Select type of nonconformity" name="type_of_nonconformity" class="cat form-control"
            required>
            <option value=""></option>
            <option value="Recurrence" @if($car->type_of_nonconformity == "Recurrence") selected @endif>Recurrence</option>
            <option value="New" @if($car->type_of_nonconformity == "New") selected @endif>New</option>
        </select>
    </div>
    <div class="col-md-6">
        Issued By :
        <select data-placeholder="Select type of auditor" name="auditor" class="cat form-control" required>
            <option value=""></option>
            @foreach ($users->where('role_id', 1) as $auditor)
            <option value="{{ $auditor->id }}" @if($auditor->id == $car->auditor_id) selected @endif>{{ $auditor->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        Issued To :
        <select name="auditee" class="form-control cat" required>
            <option value="">Select type of auditor</option>
            @foreach ($users->where('role_id', 2) as $auditee)
            <option value="{{ $auditee->id }}" @if($car->auditee_id == $auditee->id) selected @endif>{{ $auditee->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        Evidence :
        <select data-placeholder="If has evidence" id="evidence" name="evidence" class="form-control cat" required>
            <option value=""></option>
            <option value="Yes" @if($car->evidence == "Yes") selected @endif>Yes</option>
            <option value="N/A" @if($car->evidence == "N/A") selected @endif>N/A</option>
        </select>
    </div>
    <div class="col-md-6" id="uploadEvidence" hidden>
        Upload Evidence :
        <input type="file" name="upload_evidence" class="form-control">
    </div>
    {{-- <div class="col-md-12">
        Reference document, if any
        <textarea name="reference_document" class="form-control" cols="30" rows="10" required></textarea>
    </div> --}}
    <div class="col-md-12">
        Description of Nonconformity
        <textarea name="description_of_nonconformity" class="form-control" cols="30" rows="10" required>{{ $car->description_of_nonconformity }}</textarea>
    </div>
</div>
@endcomponent