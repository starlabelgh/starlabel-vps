@extends('admin.setting.index')

@section('admin.setting.breadcrumbs')
    {{ Breadcrumbs::render('email-template-setting') }}
@endsection

@section('admin.setting.layout')
    <div class="col-md-9">
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.setting.email-template-update') }}">
                     @csrf
                     <fieldset class="setting-fieldset">
                        <legend class="setting-legend">{{ __('email_template.email_sms_template_setting') }}</legend>
                         <div class="row">
                             <div class="col-md-12">
                                 <div class="form-group">
                                     <label for="comment">{{__('email_template.notifications_templates')}}</label>
                                     <textarea class="summernote" name="notify_templates" id="summernote">{{ setting('notify_templates') }}</textarea>
                                 </div>
                                 <div class="form-group">
                                     <label for="comment">{{__('Invite Templates')}}</label>
                                     <textarea class="summernote" name="invite_templates" id="summernote">{{setting('invite_templates')}}</textarea>
                                 </div>
                             </div>
                         </div>
                    </fieldset>
                     <div class="row">
                        <div class="form-group col-md-6">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <span>{{ __('email_template.update_email_sms_template_setting') }}</span>
                            </button>
                        </div>
                     </div>
                 </form>
            </div>
        </div>
    </div>
@endsection
