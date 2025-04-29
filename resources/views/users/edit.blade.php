@component('components.modal', [
    'id' => 'edit'.$user->id,
    'size' => '',
    'title' => 'Edit user',
    'url' => url('update_user/'. $user->id)
])
    <div class="row">
        <div class="col-md-12">
            Name :
            <input type="text" name="name" class="form-control input-sm" value="{{ $user->name }}" required>
        </div>
        <div class="col-md-12">
            Email :
            <input type="email" name="email" class="form-control input-sm" value="{{ $user->email }}" required>
        </div>
        <div class="col-md-12">
            Company :
            <select data-placeholder="Select company" name="company" class="form-control cat">
                <option value=""></option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}" @if($company->id == $user->company_id) selected @endif>{{ $company->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-12">
            Department :
            <select data-placeholder="Select department" name="department" class="form-control cat">
                <option value=""></option>
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}" @if($department->id == $user->department_id) selected @endif>{{ $department->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-12">
            Role :
            <select data-placeholder="Select role" name="role" class="form-control cat">
                <option value=""></option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" @if($role->id == $user->role_id) selected @endif>{{ $role->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
@endcomponent