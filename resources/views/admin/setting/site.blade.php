@extends('admin.setting.index')

@section('admin.setting.breadcrumbs')
{{ Breadcrumbs::render('site-setting') }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-social/bootstrap-social.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
@endsection

@section('admin.setting.layout')
<div class="col-md-9">
    <div class="card">
        <div class="card-body">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.setting.site-update') }}"
                enctype="multipart/form-data">
                @csrf
                <fieldset class="setting-fieldset">
                    <legend class="setting-legend">{{ __('site_setting.general_setting') }}</legend>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="site_name">{{ __('levels.site_name') }}</label>
                                <span class="text-danger">*</span>
                                <input name="site_name" id="site_name" type="text"
                                    class="form-control @error('site_name') is-invalid @enderror"
                                    value="{{ old('site_name', setting('site_name')) }}">
                                @error('site_name')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="site_phone_number">{{ __('site_setting.site_phone_number') }}</label>
                                <span class="text-danger">*</span>
                                <input name="site_phone_number" id="site_phone_number" type="text"
                                    class="form-control @error('site_phone_number') is-invalid @enderror"
                                    value="{{ old('site_phone_number', setting('site_phone_number')) }}">
                                @error('site_phone_number')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label for="site_footer">{{ __('levels.site_footer') }}</label> <span
                                    class="text-danger">*</span>
                                <input name="site_footer" id="site_footer"
                                    class="form-control @error('site_footer') is-invalid @enderror"
                                    value="{{ old('site_footer', setting('site_footer')) }}">
                                @error('site_footer')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="site_address">{{ __('site_setting.site_address') }}</label> <span
                                    class="text-danger">*</span>
                                <textarea name="site_address" id="site_address" cols="30" rows="3"
                                    class="form-control small-textarea-height @error('site_address') is-invalid @enderror">{{ old('site_address', setting('site_address')) }}</textarea>
                                @error('site_address')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label for="customFile">{{ __('levels.site_logo') }}</label>
                                <div class="custom-file">
                                    <input name="site_logo" type="file"
                                        class="file-upload-input custom-file-input @error('site_logo') is-invalid @enderror"
                                        id="customFile" onchange="readURL(this);">
                                    <label class="custom-file-label"
                                        for="customFile">{{ __('site_setting.choose_file') }}</label>
                                </div>
                                @error('site_logo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                                @if(setting('site_logo'))
                                <img class="img-thumbnail image-width mt-4 mb-3" id="previewImage"
                                    src="{{ asset('images/'.setting('site_logo')) }}"
                                    alt="{{ __('visitor pass Logo') }}" />
                                @else
                                <img class="img-thumbnail image-width mt-4 mb-3" id="previewImage"
                                    src="{{ asset('images/site_logo.png') }}" alt="{{ __('Visitor pass Logo') }}" />
                                @endif
                            </div>


                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="site_email">{{ __('levels.site_email') }}</label> <span
                                    class="text-danger">*</span>
                                <input name="site_email" id="site_email"
                                    class="form-control @error('site_email') is-invalid @enderror"
                                    value="{{ old('site_email', setting('site_email')) }}">
                                @error('site_email')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="timezone">{{ __('levels.timezone') }}</label> <span
                                    class="text-danger">*</span>
                                <?php
                                        $className = 'form-control';
                                        if($errors->first('timezone')) {
                                            $className = 'form-control is-invalid';
                                        }
                                        echo Timezonelist::create('timezone', setting('timezone') , ['class'=> $className]); ?>
                                @error('timezone')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>{{ __('site_setting.change_language') }}</label> <span
                                    class="text-danger">*</span>
                                <select name="locale" id="locale"
                                    class="form-control select2 @error('locale') is-invalid @enderror">
                                    <option value="">{{ __('language.select_language') }}</option>
                                    @if(!blank($language))
                                    @foreach($language as $lang )
                                    <option value="{{$lang->code }}"
                                        {{ (old('locale', setting('locale')) == $lang->code) ? 'selected' : '' }}> <span
                                            class="flag-icon flag-icon-aw ">{{ $lang->flag_icon == null ? '🇬🇧' : $lang->flag_icon }}&nbsp</span>{{ $lang->name }}</option>
                                    @endforeach
                                    @endif

                                </select>
                                @error('locale')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="site_description">{{ __('levels.description') }}</label> <span
                                    class="text-danger">*</span>
                                <textarea name="site_description" id="site_description" cols="30" rows="3"
                                    class="form-control small-textarea-height @error('site_description') is-invalid @enderror">{{ old('site_description', setting('site_description')) }}</textarea>
                                @error('site_description')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>

                        </div>
                    </div>
                </fieldset>
                <div class="row">
                    <div class="form-group col-md-6">
                        <button class="btn btn-primary">
                            <span>{{ __('site_setting.update_site_setting') }}</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('js/preregister/create.js') }}"></script>
@endsection
