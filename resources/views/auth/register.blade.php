@extends('layouts.app')

@section('main-content')
    <section class="section-content padding-y bg">
        <div class="col-sm-6 offset-sm-3">
            <div class="card mx-auto">
                <article class="card-body">
                    <header class="mb-4">
                        <h4 class="card-title">{{ __('Sign up') }}</h4>
                    </header>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-row">
                            <div class="col form-group">
                                <label class="js-check box {{ old('roles', 2)== 2 ? 'active' : ''}}">
                                    <input type="radio" name="roles" value="2" {{ old('roles', 2)== 2 ? 'checked' : ''}}>
                                    <h6 class="title">{{ __('Customer') }}</h6>
                                </label>
                            </div>
                            <div class="col form-group">
                                <label class="js-check box {{ old('roles')== 3 ? 'active' : ''}}">
                                    <input type="radio" name="roles" value="3" {{ old('roles')== 3 ? 'checked' : ''}}>
                                    <h6 class="title">{{ __('Shop Owner') }}</h6>
                                </label>
                            </div>
                            <div class="col form-group">
                                <label class="js-check box {{ old('roles')== 4 ? 'active' : ''}}">
                                    <input type="radio" name="roles" value="4" {{ old('roles')== 4 ? 'checked' : ''}}>
                                    <h6 class="title">{{ __('Delivery') }}</h6>
                                </label>
                            </div>
                        </div> <!-- row.// -->
                        <div class="form-row">
                            <div class="col form-group">
                                <label>{{ __('First name') }}</label><span class="text-danger">*</span>
                                <input name="first_name" value="{{ old('first_name') }}" type="text"
                                    class="form-control @if($errors->has('first_name')) is-invalid @endif" placeholder="John">
                                @if($errors->has('first_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                                @endif
                            </div> <!-- form-group end.// -->
                            <div class="col form-group">
                                <label>{{ __('Last name') }}</label><span class="text-danger">*</span>
                                <input name="last_name" value="{{ old('last_name') }}" type="text"
                                    class="form-control @if($errors->has('last_name')) is-invalid @endif" placeholder="Doe">
                                @if($errors->has('last_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                                @endif
                            </div> <!-- form-group end.// -->
                        </div>
                        <div class="form-row">
                            <div class="col form-group">
                                <label>{{ __('Email') }}</label><span class="text-danger">*</span>
                                <input name="email" value="{{ old('email') }}" type="email"
                                    class="form-control @if($errors->has('email')) is-invalid @endif"
                                    placeholder="johndoe@example.com">
                                <small class="form-text text-muted">{{ __('We\'ll never share your email with anyone else.') }}</small>
                                @if($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col form-group">
                                <label>{{ __('Username') }}</label>
                                <input name="username" value="{{ old('username') }}" type="text"
                                    class="form-control @if($errors->has('username')) is-invalid @endif" placeholder="john">
                                @if($errors->has('username'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('username') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Phone') }}</label><span class="text-danger">*</span>
                            <input name="phone" value="{{ old('phone') }}" type="text" class="form-control @if($errors->has('phone')) is-invalid @endif"
                                placeholder="+18 91 298 882">
                            @if($errors->has('phone'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('phone') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>{{ __('Address') }}</label>
                            <input name="address" value="{{ old('address') }}" type="text"
                                class="form-control @if($errors->has('address')) is-invalid @endif"
                                placeholder="House#10, Section#1, Dhaka 1216, Bangladesh">
                            @if($errors->has('address'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('address') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="password">{{ __('Create password') }}</label><span class="text-danger">*</span>
                                <input name="password" class="form-control @if($errors->has('password')) is-invalid @endif"
                                    type="password" placeholder="Create password">
                                @if($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div> <!-- form-group end.// -->
                            <div class="form-group col-md-6">
                                <label>{{ __('Repeat password') }}</label><span class="text-danger">*</span>
                                <input name="password_confirmation"
                                    class="form-control @if($errors->has('password_confirmation')) is-invalid @endif"
                                    type="password" placeholder="repeat password">
                                @if($errors->has('password_confirmation'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                                @endif
                            </div> <!-- form-group end.// -->
                        </div>
                        <div class="form-group">
                            <label  class="custom-control custom-checkbox">
                                <input name="terms_and_conditions" class="custom-control-input @if($errors->has('terms_and_conditions')) is-invalid @endif" type="checkbox" {{  (old('terms_and_conditions') == 1 ? ' checked' : '') }} value="1">
                                <span class="custom-control-label" id="terms_and_condition_color"> {{ __('I am agree with') }}</span> <a href="{{ route('page', 'terms-and-condition') }}">{{ __('terms and conditions') }}</a> <span class="text-danger">*</span>
                                @if($errors->has('terms_and_conditions'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('terms_and_conditions') }}</strong>
                                    </span>
                                @endif

                            </label>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block"> {{ __('Register') }} </button>
                        </div>
                    </form>
                </article>
            </div>
            <p class="text-center mt-4">
                {{ __('Have an account?') }} <a href="{{ route('login') }}">{{ __('Log In') }}</a>
            </p>
        </div>
    </section>
@endsection
