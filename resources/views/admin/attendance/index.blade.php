@extends('admin.layouts.master')

@section('main-content')

<section class="section">
    <div class="section-header">
        <h1>{{ __('attendance.attendance') }}</h1>
        {{ Breadcrumbs::render('attendance') }}
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12">
                            @if(!blank($attendance))
                            <div class="float-right  d-flex text-center" style="margin-left:auto">
                                <p class="mr-2">
                                    <span class="clock-span"><i class="fas fa-4x fa-clock"></i>
                                        {{ date('g:i A') }}</span><br>
                                    @if($attendance->checkin_time)
                                    <span class="text-success">
                                        {{ __('attendance.clock_in_at') }}- {{$attendance->checkin_time}}
                                        @if($attendance->checkout_time) <span class="text-danger ml-2">  {{ __('attendance.clock_out_at') }} -
                                            {{$attendance->checkout_time}}</span>@endif
                                    </span>
                                    @endif
                                </p>
                                @if(!$attendance->checkout_time)
                                <form action="{{ route('admin.attendance.clockout')}}" method="post">
                                    {{ csrf_field() }}
                                    <button class="btn  d-flex inputbtnclockout align-items-center btn-dark"
                                        type="submit"><i class="fas fa-4x fa-sign-out-alt"></i>{{ __('attendance.clock_out') }}</button>
                                </form>
                                @endif
                            </div>
                            @else
                            <div class="float-right  d-flex text-center" style="margin-left:auto">
                                <p class="mt-2 mr-2">
                                    <span class="clock-span"><i class="fas fa-4x fa-clock"></i>
                                        {{ date('g:i A') }}</span><br>
                                </p>
                                <button type="button" class="btn  d-flex inputbtnclockin align-items-center btn-success"
                                    data-toggle="modal" data-target="#exampleModal"><i
                                        class="fas fa-4x fa-sign-out-alt"></i>{{ __('attendance.clock_in') }}</button>
                            </div>
                            @endif
                        </div>
                    </div>

                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="maintable"
                                data-url="{{ route('admin.attendance.get-attendance') }}">
                                <thead>
                                    <tr>
                                        <th>{{ __('levels.id') }}</th>
                                        <th>{{ __('levels.image') }}</th>
                                        <th>{{ __('attendance.user') }}</th>
                                        <th>{{ __('attendance.working') }}</th>
                                        <th>{{ __('attendance.date') }}</th>
                                        <th>{{ __('attendance.clock_in') }}</th>
                                        <th>{{ __('attendance.clock_out') }}</th>
                                        <th>{{ __('levels.actions') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('attendance.clock_in') }} - <span class="clock-span"><i
                            class="fas fa-4x fa-clock"></i> {{ date('g:i A') }}</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.attendance.clockin') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ __('attendance.working_from') }}</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title') }}" placeholder="{{ __('attendance.eg_office_home_etc') }}">
                        @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('attendance.close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('attendance.clock_in') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection



@section('css')
<link rel="stylesheet" href="{{ asset('assets/modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('assets/modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/modules/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/attendance/index.js') }}"></script>
@endsection
