@component('components.modal', [
    'id' => 'new',
    'size' => 'modal-lg',
    'title' => 'Add new CAR',
    'url' => url('/ofi/store'),
    'has_enctype' => false
])
    <div class="row">
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
                <option value="">Select auditee</option>
                {{-- @foreach ($users->where('role_id', 2) as $auditee)
                    <option value="{{ $auditee->id }}">{{ $auditee->name }}</option>
                @endforeach --}}
            </select>
        </div>
        <div class="col-md-12">
            Recommendation :
            <textarea name="recommendation" class="form-control" cols="30" rows="10" required></textarea>
        </div>
    </div>
@endcomponent