@extends('layouts.app')

@section('main-content')
    <section class="section-content padding-y" style="min-height:84vh">
        <div class="card mx-auto" style="max-width: 380px; margin-top:100px;">
            <div class="card-body">
                <h4 class="card-title mb-4">{{ __('Reset Password') }}</h4>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="form-group">
                        <input id="email" type="email" class="form-control @if($errors->has('email')) is-invalid @endif"
                               name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                        @if($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">
                            {{ __('Send Password Reset Link') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <p class="text-center mt-4">{{ __("Don't have account?") }} <a href="{{ route('register') }}">{{ __('Sign up') }}</a></p>
        <br><br>
    </section>
@endsection
