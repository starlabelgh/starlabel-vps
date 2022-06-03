@extends('frontend.layouts.frontend')

@section('content')
    <section id="pm-banner-1" class="custom-css-step">
        <div class="container">
            <div class="card" style="margin-top:40px;">
                <div class="card-header" id="Details" align="center">
                    <h4 style="color: #111570;font-weight: bold">{{__('frontend.visitor_details')}}</h4>
                </div>
                <div class="card-body">
                    <div style="margin: 10px;">
                        {!! Form::open(['route' => 'check-in.step-one.next', 'class' => 'form-horizontal', 'files' => true]) !!}
                        <div class="save">
                            <div class="visitor" id="visitor">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div
                                            class="form-group {{ $errors->has('first_name') ? 'has-error' : ''}}">
                                            {!! Html::decode(Form::label('first_name', trans('visitor.first_name').'<span class="text-danger">*</span>', ['class' => 'control-label'])) !!}
                                            {!! Form::text('first_name', isset($visitor->first_name) ? $visitor->first_name : null, ('' == 'required') ? ['class' => 'form-control input','id '=>'first_name'] : ['class' => 'form-control input','id '=>'first_name']) !!}
                                            {!! $errors->first('first_name', '<p class="text-danger">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div
                                            class="form-group {{ $errors->has('last_name') ? 'has-error' : ''}}">
                                            {!! Html::decode(Form::label('last_name', trans('visitor.last_name').'<span class="text-danger">*</span>', ['class' => 'control-label'])) !!}
                                            {!! Form::text('last_name', isset($visitor->last_name) ? $visitor->last_name : null, ('' == 'required') ? ['class' => 'form-control input', 'id '=>'last_name'] : ['class' => 'form-control input','id '=>'last_name']) !!}
                                            {!! $errors->first('last_name', '<p class="text-danger">:message</p>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
                                            {!! Html::decode(Form::label('email', trans('visitor.email').'<span class="text-danger">*</span>', ['class' => 'control-label'])) !!}
                                            {!! Form::email('email', isset($visitor->email) ? $visitor->email : null, ('required' == 'required') ? ['class' => 'form-control input', 'id '=>'email'] : ['class' => 'form-control input','id '=>'email']) !!}
                                            {!! $errors->first('email', '<p class="text-danger">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group {{ $errors->has('phone') ? 'has-error' : ''}}">
                                            {!! Html::decode(Form::label('phone', trans('visitor.phone').'<span class="text-danger">*</span>', ['class' => 'control-label'])) !!}
                                            {!! Form::text('phone', isset($visitor->phone) ? $visitor->phone : null, ('required' == 'required') ? ['class' => 'form-control input', 'id '=>'phone'] : ['class' => 'form-control input','id '=>'phone']) !!}
                                            {!! $errors->first('phone', '<p class="text-danger">:message</p>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group {{ $errors->has('employee_id') ? 'has-error' : ''}}">
                                            <label for="employee_id">{{ __('visitor.select_employee') }}</label> <span class="text-danger">*</span>
                                            <select id="employee_id" name="employee_id" class="form-control  @error('employee_id') is-invalid @enderror">
                                                <option value="">{{ __('Select Employee') }}</option>
                                                @foreach($employees as $key => $employee)
                                                        <option value="{{ $employee->id }}" value="{{ $employee->id }}" {{ isset($visitor->invitation->employee_id) && $visitor->invitation->employee_id == $employee->id ? "selected" : '' }}>{{ $employee->name }} ( {{$employee->department->name}} )</option>
                                                    @endforeach
                                            </select>
                                            {!! $errors->first('employee_id', '<p class="text-danger">:message</p>') !!}
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group {{ $errors->has('gender') ? 'has-error' : ''}}">
                                            <label for="gender">{{ __('visitor.gender') }}</label> <span class="text-danger">*</span>
                                            <select id="gender" name="gender" class="form-control @error('gender') is-invalid @enderror">
                                                @foreach(trans('genders') as $key => $gender)
                                                    <option value="{{ $key }}" {{ (old('gender') == $key) ? 'selected' : '' }}>{{ $gender }}</option>
                                                @endforeach
                                            </select>
                                            @error('gender')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group {{ $errors->has('company_name') ? 'has-error' : ''}}">
                                            {!! Form::label('company_name', trans('visitor.company_name'), ['class' => 'control-label']) !!}
                                            {!! Form::text('company_name', isset($visitor->company_name) ? $visitor->company_name : null, ('' == 'required') ? ['class' => 'form-control input', 'id '=>'company_name'] : ['class' => 'form-control input','id '=>'company_name']) !!}
                                            {!! $errors->first('company_name', '<p class="text-danger">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group {{ $errors->has('national_identification_no') ? 'has-error' : ''}}">
                                            {!! Form::label('national_identification_no', trans('visitor.national_identification_no'), ['class' => 'control-label']) !!}
                                            {!! Form::text('national_identification_no', isset($visitor->national_identification_no) ? $visitor->national_identification_no : null, ('' == 'required') ? ['class' => 'form-control input', 'id '=>'national_identification_no'] : ['class' => 'form-control input','id '=>'national_identification_no']) !!}
                                            {!! $errors->first('national_identification_no', '<p class="text-danger">:message</p>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group {{ $errors->has('purpose') ? 'has-error' : ''}}">
                                            <label for="purpose">{{ __('visitor.purpose') }}</label> <span class="text-danger">*</span>
                                            <textarea name="purpose" class="summernote-simple form-control height-textarea-css @error('purpose')is-invalid @enderror" id="purpose">{{old('purpose')}}</textarea>
                                            @error('purpose')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group {{ $errors->has('address') ? 'has-error' : ''}}">
                                            <label for="address">{{ __('visitor.address') }}</label>
                                            <textarea name="address" class="summernote-simple form-control height-textarea-css @error('address') is-invalid @enderror" id="address">{{ old('address') }}</textarea>
                                            @error('address')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <a href="{{ route('check-in') }}"
                                           class="btn btn-danger float-left text-white">
                                            <i class="fa fa-arrow-left" aria-hidden="true"></i> {{__('frontend.cancel')}}
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-success float-right" id="continue">
                                            <i class="fa fa-arrow-right" aria-hidden="true"></i> {{__('frontend.continue')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
<script>
    $(document).ready(function () {
        $('.select2').select2();
    })
</script>
@endsection
