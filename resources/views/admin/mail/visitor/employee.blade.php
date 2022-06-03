@component('mail::message')
# {{ __('Hello') }} {{ Str::ucfirst($visitor['name']) }},<br>
@component('mail::panel')
{{ __('New Visitor Register please Approved your visitor') }}
<h4 style="">{{ __('Visitor Information') }}</h4>

<p>{{ __('Name:') }} {{ Str::ucfirst($visitor['visitor_name']) }} </p>
<p>{{ __('Email:') }} {{ Str::ucfirst($visitor['visitor_email']) }} </p>
<p>{{ __('Phone:') }} {{ Str::ucfirst($visitor['visitor_phone']) }} </p>

@endcomponent

<p>
    {!! setting('notify_templates') !!}
</p>
<div style="display: flex; justify-content:center">
    <div style="margin-right: 10px">
        @component('mail::button', ['url' => $visitor['acceptedUrl'], 'color' => 'green','display'=>'inline'])
        {{ __('Accept')}}
        @endcomponent
    </div>
    <div>
        @component('mail::button', ['url' => $visitor['rejectUrl'], 'color' => 'red','display'=>'inline'])
        {{ __('Decline') }}
        @endcomponent
    </div>

</div>

<br>

{{ __('Thank you for using our application!') }} {{ setting('site_name') }}<br>

{{ config('app.name') }}
@endcomponent
