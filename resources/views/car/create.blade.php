@component('components.modal', [
    'id' => 'new',
    'size' => 'modal-lg',
    'title' => 'Add new CAR',
    'url' => url('store_car'),
    'has_enctype' => true
])
    <div class="row">
        <div class="col-md-12">
            Standard and Clause :
            <textarea name="standard_and_clause" class="form-control" cols="30" required></textarea>
        </div>
        <div class="col-md-6">
            Department :
            <select data-placeholder="Select department" name="department" class="cat form-control" required onchange="refreshDeptHead(this)">
                <option value=""></option>
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->code .' - '.$department->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            Classification of Nonconformity :
            <select data-placeholder="Select classification of nonconformity" name="classification_of_nonconformity" class="cat form-control" required>
                <option value=""></option>
                <option value="OFI">Opportunities of Improvement (OFI)</option>
                <option value="Minor">Minor</option>
                <option value="Major">Major</option>
                <option value="Critical">Critical</option>
            </select>
        </div>
        <div class="col-md-6">
            Nature of Nonconformity :
            <select data-placeholder="Select nature of nonconformity" name="nature_of_nonconformity" class="cat form-control" required>
                <option value=""></option>
                <option value="Internal Audit Findings (IA)">Internal Audit Findings (IA)</option>
                <option value="External Audit Findings (EA)">External Audit Findings (EA)</option>
                <option value="Legal Compliance (LC)">Legal Compliance (LC)</option>
                <option value="Customer Complaints (CC)">Customer Complaints (CC)</option>
            </select>
        </div>
        <div class="col-md-6">
            Type of Nonconformity :
            <select data-placeholder="Select type of nonconformity" name="type_of_nonconformity" class="cat form-control" required>
                <option value=""></option>
                <option value="Recurrence">Recurrence</option>
                <option value="New">New</option>
            </select>
        </div>
        <div class="col-md-6">
            Issued By :
            <select data-placeholder="Select type of auditor" name="auditor" class="cat form-control" required>
                <option value=""></option>
                @foreach ($users->where('role_id', 1) as $auditor)
                    <option value="{{ $auditor->id }}">{{ $auditor->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            Issued To :
            <select name="auditee" class="form-control" id="auditee" required>
                <option value="">Select type of auditor</option>
                {{-- @foreach ($users->where('role_id', 2) as $auditee)
                    <option value="{{ $auditee->id }}">{{ $auditee->name }}</option>
                @endforeach --}}
            </select>
        </div>
        <div class="col-md-6">
            Evidence :
            <select data-placeholder="If has evidence" id="evidence" name="evidence" class="form-control cat" required>
                <option value=""></option>
                <option value="Yes">Yes</option>
                <option value="N/A">N/A</option>
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
            <textarea name="description_of_nonconformity" class="form-control" cols="30" rows="10" required></textarea>
        </div>
    </div>
@endcomponent