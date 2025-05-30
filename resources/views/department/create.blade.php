@component('components.modal', [
    'id' => 'new',
    'size' => 'modal-md',
    'title' => 'Add new department',
    'url' => url('store_department'),
    'has_enctype' => false
])
    <div class="row">
        <div class="col-md-12">
            Code :
            <input type="text" name="code" class="form-control" required>
        </div>
        <div class="col-md-12">
            Name :
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="col-md-12">
            Head :
            <select data-placeholder="Select department head" name="department_head" class="cat form-control" required>
                <option value=""></option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        
    </div>
@endcomponent