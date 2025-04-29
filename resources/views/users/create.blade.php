@component('components.modal', [
    'id' => 'new',
    'size' => '',
    'title' => 'Add new user',
    'url' => url('store_user')
])
    <div class="row">
        <div class="col-md-12">
            Name :
            <input type="text" name="name" class="form-control input-sm" required>
        </div>
        <div class="col-md-12">
            Email :
            <input type="email" name="email" class="form-control input-sm" required>
        </div>
        <div class="col-md-12">
            Company :
            <select data-placeholder="Select company" name="company" class="form-control cat">
                <option value=""></option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-12">
            Department :
            <select data-placeholder="Select department" name="department" class="form-control cat">
                <option value=""></option>
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-12">
            Role :
            <select data-placeholder="Select role" name="role" class="form-control cat">
                <option value=""></option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
@endcomponent