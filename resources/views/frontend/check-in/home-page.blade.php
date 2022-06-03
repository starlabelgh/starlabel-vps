@extends('frontend.layouts.frontend')

@section('content')
    <section id="pm-banner-1" class="pm-banner-section-1 position-relative custom-css">
        <div class="container">
            <div class="pm-banner-content position-relative">
                <div class="pm-banner-text pm-headline pera-content">
                    <span class="pm-title-tag">&nbsp;&nbsp;&nbsp;&nbsp;{{setting('site_name')}}</span>
                    <br><br>
                    <h2>{{setting('site_description')}}</h2>
                    <p> {{strip_tags(setting('welcome_screen'))}}</p>
                    <div class="ei-banner-btn">
                    <a href="{{ route('check-in.step-one') }}">
                        <span>{{__('frontend.check_in')}}</span>
                    </a>
                    <br>
                    </div>
                </div>
                <div class="pm-banenr-img position-absolute d-flex justify-content-end">
                    <img src="{{asset('images/quick-pass.png')}}" alt="">
                </div>
            </div>
            <hr class="hr-line">
            <div class="d-flex justify-content-center footer-text pb-3">
                <span> {{setting('site_footer')}}</span>
            </div>
        </div>
    </section>
@endsection

