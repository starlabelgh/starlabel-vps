@extends('admin.setting.index')

@section('admin.setting.breadcrumbs')
    {{ Breadcrumbs::render('front-end-setting') }}
@endsection

@section('admin.setting.layout')
    <div class="col-md-9">
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.setting.homepage-update') }}">
                     @csrf
                     <fieldset class="setting-fieldset">
                        <legend class="setting-legend">{{ __('frontend_setting.front_end_enable_disable') }}</legend>
                         <div class="row">
                             <div class="col-md-6">
                                 <div class="form-group" id="">
                                     <label class="control-label" for="defaultUnchecked">{{__('frontend_setting.front_end_enable_disable')}}</label>
                                     <div class="form-check">
                                         <label class="form-check-label">
                                             <input type="radio" class="form-check-input" name="front_end_enable_disable" {{ setting('front_end_enable_disable') == true ? "checked":"" }} value="1">{{__('frontend_setting.enable')}}
                                         </label>
                                     </div>
                                     <div class="form-check">
                                         <label class="form-check-label">
                                             <input type="radio" class="form-check-input" name="front_end_enable_disable" {{ setting('front_end_enable_disable') == false ? "checked":"" }} value="0">{{__('frontend_setting.disable')}}
                                         </label>
                                     </div>
                                 </div>
                             </div>
                         </div>
                    </fieldset>

                    <fieldset class="setting-fieldset">
                        <legend class="setting-legend">{{ __('frontend_setting.photo_capture_enable_disable') }}</legend>
                         <div class="row">
                             <div class="col-md-6">
                                 <div class="form-group" id="">
                                     <label class="control-label" for="defaultUnchecked">{{__('frontend_setting.photo_capture_enable_disable')}}</label>
                                     <div class="form-check">
                                         <label class="form-check-label">
                                             <input type="radio" class="form-check-input" name="photo_capture_enable" {{ setting('photo_capture_enable') == true ? "checked":"" }} value="1">{{__('frontend_setting.enable')}}
                                         </label>
                                     </div>
                                     <div class="form-check">
                                         <label class="form-check-label">
                                             <input type="radio" class="form-check-input" name="photo_capture_enable" {{ setting('photo_capture_enable') == false ? "checked":"" }} value="0">{{__('frontend_setting.disable')}}
                                         </label>
                                     </div>
                                 </div>
                             </div>

                         </div>
                    </fieldset>

                    <fieldset class="setting-fieldset">
                        <legend class="setting-legend">{{ __('frontend_setting.welcome_screen_setting') }}</legend>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea class="summernote" name="welcome_screen" id="comment">{{setting('welcome_screen')}}</textarea>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="setting-fieldset">
                        <legend class="setting-legend">{{ __('frontend_setting.terms_condition_setting') }}</legend>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea class="summernote" name="terms_condition" id="terms_condition">{{setting('terms_condition')}}</textarea>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                     <div class="row">
                         <div class="form-group col-md-6">
                            <button type="submit" class="btn btn-primary">
                                <span>{{ __('frontend_setting.update_front_end_setting') }}</span>
                            </button>
                         </div>
                     </div>
                </form>
            </div>
        </div>
    </div>
@endsection
