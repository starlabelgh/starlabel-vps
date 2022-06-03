<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <div class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        </ul>
    </div>
    <ul class="navbar-nav navbar-right">
        <li class=" hidecheck "  >
            <form action="{{ route('admin.visitor.search')}}" method="post">
            {{ csrf_field() }}
                <div class="d-flex form-group  {{ $errors->has('first_name') ? 'has-error' : ''}}" style="margin-bottom: -24px;margin-left:auto"    >
                    <input  class="form-control inputid"  style="margin-right: 5px;" type="text" name="visitorID"  placeholder="{{ __('topbar_menu.enter_Visitor_id') }}">
                    <button   class="btn  d-flex inputbtn align-items-center" type="submit"><i class="fas fa-4x fa-sign-out-alt"></i>{{ __('topbar_menu.check_out') }}</button>
                </div>
            </form>
        </li>
        @if(setting('front_end_enable_disable') == 1)
        <li class="dropdown">
            <a data-toggle="tooltip" data-placement="bottom" title="Go to Frontend" href="{{ route('/') }}" class="nav-link nav-link-lg beep" target="_blank"><i class="fa fa-globe"></i></a>
        </li>
        @endif
        <li class="dropdown">
            <a href="{{ route('admin.profile') }}" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ auth()->user()->images }}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">{{ __('topbar_menu.hi') }}, {{ auth()->user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="{{ route('admin.profile') }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> {{ __('topbar_menu.profile') }}
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> {{ __('topbar_menu.logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="display-none">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
