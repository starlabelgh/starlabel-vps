<!DOCTYPE >
<html>

@include('frontend.layouts.partials.head._head')

<body class="pm-home pm-home-css-custom">
{{-- <div class="pm-preloader" id="preloader"></div> --}}

<header id="pm-header" class="pm-main-header  header-type-one">
    <div class="container">
        <div class="pm-main-header-content clearfix">
            <div class="pm-logo float-left">
                @if(setting('site_logo'))
                <a href="{{route('/')}}">
                    <img src="{{ asset('images/'.setting('site_logo')) }}" data-inject-svg="" alt="" style="height: 40px;">
                </a>
                @endif
            </div>

            <div class="pm-main-menu-item float-right">
                <div class="pm-header-btn text-center text-capitalize float-right">
                    @if(auth()->user())
                        <a href="{{route('admin.dashboard.index')}}">{{__('frontend.go_to_dashboard')}}</a>
                    @else
                        <a href="{{route('login')}}">{{__('frontend.login')}}</a>
                    @endif
                </div>

                <nav class="pm-main-navigation float-right clearfix ul-li">
                    <ul id="main-nav" class="navbar-nav text-capitalize clearfix">
                        <li><a href="{{route('check-in.return')}}">{{__('frontend.have_appointment')}}</a></li>
                        <li><a href="{{route('check-in.pre.registered')}}">{{__('frontend.been_here_before')}}</a> </li>
                        @if(auth()->user())
                        <li>
                            <a href="{{route('checkout.index')}}">{{__('frontend.check_out')}}</a>
                        </li>
                         @endif
                    </ul>
                </nav>
            </div>
        </div>
        <!-- /desktop menu -->
        <div class="pm-mobile_menu relative-position">
            <div class="pm-mobile_menu_button pm-open_mobile_menu">
                <i class="fas fa-bars"></i>
            </div>
            <div class="pm-mobile_menu_wrap">
                <div class="mobile_menu_overlay pm-open_mobile_menu"></div>
                <div class="pm-mobile_menu_content">
                    <div class="pm-mobile_menu_close pm-open_mobile_menu">
                        <i class="far fa-times-circle"></i>
                    </div>
                    <div class="m-brand-logo text-center">
                        <a href="{{route('/')}}"><img src="{{ asset('images/'.setting('site_logo')) }}" alt="logo"></a>
                    </div>
                    <nav class="pm-mobile-main-navigation  clearfix ul-li">
                        <ul id="m-main-nav" class="navbar-nav text-capitalize clearfix">
                            <li><a href="{{route('check-in.return')}}">{{__('frontend.have_appointment')}}</a></li>
                            <li><a href="{{route('check-in.pre.registered')}}">{{__('frontend.been_here_before')}}</a> </li>
                            @if(auth()->user())
                                <li> <a href="{{route('checkout.index')}}">{{__('frontend.check_out')}}</a></li>
                            <li><a href="{{route('admin.dashboard.index')}}">{{__('frontend.go_to_dashboard')}}</a></li>
                            @else
                                <li>
                                    <a href="{{route('login')}}">{{__('frontend.login')}}</a>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /Mobile-Menu -->
        </div>
    </div>
</header>

<!-- Main Content -->
    <div class="main" data-mobile-height="">
        @yield('content')
    </div>
    <!-- Main Content -->

@yield('extras')

@stack('modals')

@include('frontend.layouts.partials.script._scripts')

</body>
</html>
