{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}

@extends('layouts.app')

@section('content')
<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">
            <form method="POST" action="{{ route('password.update') }}" class="login100-form validate-form" onsubmit='show()'>
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <span class="login100-form-title p-b-43">
                    {{ config('app.name', 'Laravel') }}
                </span>
                <span class="login100-form-title p-b-43">
                    <h6>Forgot Password</h6>
                </span>

                @if($errors->any())
                <div class="form-group alert alert-danger alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <strong>{{$errors->first()}}</strong>
                </div>
                @endif
                <div class="wrap-input100" data-validate="Valid email is required: ex@abc.xyz">
                    <input type="email" class="input100" name="email" value="" required>
                    <span class="focus-input100"></span>
                    <span class="label-input100">Email</span>
                </div>

                <div class="wrap-input100" data-validate="Valid email is required: ex@abc.xyz">
                    <input id="password" type="password" class="input100" name="password" required>
                    <span class="focus-input100"></span>
                    <span class="label-input100">Password</span>
                </div>

                <div class="wrap-input100" data-validate="Valid email is required: ex@abc.xyz">
                    <input id="password-confirm" type="password" class="input100" name="password_confirmation" required>
                    <span class="focus-input100"></span>
                    <span class="label-input100">Confirm Password</span>
                </div>

                <div class="container-login100-form-btn">
                    <button class="login100-form-btn" type='submit'>
                        Send
                    </button>
                </div>
            </form>

            <div class="login100-more" style="background-image: url('../../images/wfa.jpg');">
            </div>
        </div>
    </div>
</div>

@endsection