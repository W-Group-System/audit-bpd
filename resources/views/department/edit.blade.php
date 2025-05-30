@component('components.modal', [
    'id' => 'edit'. $department->id,
    'size' => 'modal-md',
    'title' => 'Edit department',
    'url' => url('update_department/'.$department->id),
    'has_enctype' => false
])
    <div class="row">
        <div class="col-md-12">
            Code :
            <input type="text" name="code" class="form-control" value="{{ $department->code }}" required>
        </div>
        <div class="col-md-12">
            Name :
            <input type="text" name="name" class="form-control" value="{{ $department->name }}" required>
        </div>
        <div class="col-md-12">
            Head :
            <select data-placeholder="Select department head" name="department_head" class="cat form-control" required>
                <option value=""></option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" @if($user->id == $department->user_id) selected @endif>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        
    </div>
@endcomponent