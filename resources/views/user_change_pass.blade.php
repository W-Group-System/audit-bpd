@component('components.modal', [
    'id' => 'userChangePassword',
    'size' => '',
    'title' => 'Change Password',
    'url' => url('change_password/'. auth()->user()->id)
])
    <div class="row">
        <div class="col-md-12">
            New Password :
            <input type="password" name="password" class="form-control input-sm" required>
        </div>
        <div class="col-md-12">
            Confirm Password :
            <input type="password" name="password_confirmation" class="form-control input-sm" required>
        </div>
    </div>
@endcomponent