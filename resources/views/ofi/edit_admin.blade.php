@component('components.modal', [
    'id' => 'admin_edit'.$ofi->id,
    'size' => 'modal-lg',
    'title' => 'Admin Edit OFI',
    'url' => url('/ofi/update_admin/'.$ofi->id),
    'has_enctype' => false
])
    <div class="row">
        <div class="col-md-6">
            Department :
            <select data-placeholder="Select department" name="department" class="cat form-control" required onchange="refreshDeptHead(this)">
                <option value=""></option>
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}" @if($ofi->department_id == $department->id) selected @endif>{{ $department->code .' - '.$department->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            Issued By :
            <select data-placeholder="Select auditor" name="auditor" class="cat form-control" required>
                <option value=""></option>
                @foreach ($users->where('role_id', 1) as $auditor)
                    <option value="{{ $auditor->id }}"  @if($auditor->id == $ofi->issued_by) selected @endif>{{ $auditor->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            Issued To :
            <select data-placeholder="Select auditee" name="auditee" class="cat form-control" required>
                <option value=""></option>
                @foreach ($users->where('role_id', 2) as $auditee)
                    <option value="{{ $auditee->id }}"  @if($auditee->id == $ofi->issued_to) selected @endif>{{ $auditee->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-12">
            Description :
            <textarea name="description" class="form-control" cols="30" rows="8" required>{{ $ofi->description }}</textarea>
        </div>
        <div class="col-md-12">
            Recommendation :
            <textarea name="recommendation" class="form-control" cols="30" rows="8" required>{{ $ofi->recommendation }}</textarea>
        </div>
    </div>
@endcomponent