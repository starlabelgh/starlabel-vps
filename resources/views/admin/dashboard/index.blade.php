@extends('admin.layouts.master')

@section('main-content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('dashboard.dashboard') }}</h1>
            {{ Breadcrumbs::render('dashboard') }}
        </div>
        <div class="row">
            <div class="col-md-12">
                @if(!blank($attendance))
                <div class="float-right  d-flex text-center" style="margin-left:auto">
                        <p class="mr-2">
                            <span class="clock-span"><i class="fas fa-4x fa-clock"></i> {{ date('g:i A') }}</span><br>
                            @if($attendance->checkin_time)
                            <span class="text-success">
                                {{ __('dashboard.clock_in_at') }} - {{$attendance->checkin_time}} @if($attendance->checkout_time) <span class="text-danger ml-2">  {{ __('dashboard.clock_out_at') }} - {{$attendance->checkout_time}}</span>@endif
                          </span>
                           @endif
                        </p>
                    @if(!$attendance->checkout_time)
                        <form action="{{ route('admin.attendance.clockout')}}" method="post">
                            {{ csrf_field() }}
                            <button   class="btn  d-flex inputbtnclockout align-items-center btn-dark" type="submit"><i class="fas fa-4x fa-sign-out-alt"></i>{{ __('dashboard.clock_out') }}</button>
                        </form>
                        @endif
                </div>
                    @else
                    <div class="float-right  d-flex text-center" style="margin-left:auto">
                        <p class="mt-2 mr-2">
                            <span class="clock-span"><i class="fas fa-4x fa-clock"></i> {{ date('g:i A') }}</span><br>
                        </p>
                        <button  type="button" class="btn  d-flex inputbtnclockin align-items-center btn-success" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-4x fa-sign-out-alt"></i>{{ __('dashboard.clock_in') }}</button>
                    </div>
                    @endif
            </div>
        </div>

        @if(auth()->user()->getrole->name == 'Employee')
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ __('dashboard.total_visitors') }}</h4>
                        </div>
                        <div class="card-body">
                            {{$totalVisitor}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-user-secret"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ __('dashboard.total_pre_registers') }}</h4>
                        </div>
                        <div class="card-body">
                            {{$totalPrerigister}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="far fa-user"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('dashboard.total_employees') }}</h4>
                            </div>
                            <div class="card-body">
                                {{$totalEmployees}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('dashboard.total_visitors') }}</h4>
                            </div>
                            <div class="card-body">
                                {{$totalVisitor}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-user-secret"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('dashboard.total_pre_registers') }}</h4>
                            </div>
                            <div class="card-body">
                                {{$totalPrerigister}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('dashboard.visitors') }} <span class="badge badge-primary">{{$totalVisitor}}</span></h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive table-invoice">
                            <table class="table table-striped">
                                <tr>
                                    <th>{{ __('dashboard.name') }}</th>
                                    <th>{{ __('dashboard.email') }}</th>
                                    <th>{{ __('dashboard.visitor_id') }}</th>
                                    <th>{{ __('dashboard.employee') }}</th>
                                    <th>{{ __('dashboard.checkin') }}</th>
                                    <th>{{ __('dashboard.action') }}</th>
                                </tr>
                                    @if(!blank($visitors))
                                        @foreach($visitors as $visitor)
                                            @php
                                                if($loop->index > 5) {
                                                    break;
                                                }
                                            @endphp
                                            <tr>
                                                <td>{{ optional($visitor->visitor)->name }}</td>
                                                <td>{{ optional($visitor->visitor)->email }}</td>
                                                <td>{{ $visitor->reg_no }}</td>
                                                <td>{{ optional($visitor->employee->user)->name }}</td>
                                                <td>{{ date('d-M-Y h:i A', strtotime($visitor->checkin_at)) }}</td>
                                                <td>
                                                    <a href="{{ route('admin.visitors.show', $visitor) }}" class="btn btn-sm btn-icon btn-primary"><i class="far fa-eye"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="profile-dashboard bg-maroon-light">
                        <a href="{{ route('admin.profile') }}">
                            <img src="{{ auth()->user()->images }}" alt="">
                        </a>
                        <h1>{{ auth()->user()->name }}</h1>
                        <p>
                            {{ auth()->user()->getrole->name ?? '' }}
                        </p>
                    </div>
                    <div class="list-group">
                        <li class="list-group-item list-group-item-action"><i class="fa fa-user"></i> {{ auth()->user()->username }}</li>
                        <li class="list-group-item list-group-item-action"><i class="fa fa-envelope"></i> {{ auth()->user()->email }}</li>
                        <li class="list-group-item list-group-item-action"><i class="fa fa-phone"></i> {{ auth()->user()->phone }}</li>
                        <li class="list-group-item list-group-item-action"><i class="fa fa-map"></i> {{ auth()->user()->address }}</li>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('dashboard.clock_in') }} - <span class="clock-span"><i class="fas fa-4x fa-clock"></i> {{ date('g:i A') }}</span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.attendance.clockin') }}" method="POST">
                    @csrf
                <div class="modal-body">
                        <div class="form-group">
                            <label>{{ __('dashboard.working_from') }}</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="e.g. Office, Home, etc.">
                            @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('dashboard.close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('dashboard.clock_in') }}</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection

