@extends('admin.layouts.master')

@section('main-content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('attendance_report.attendance_report') }}</h1>
            {{ Breadcrumbs::render('attendance') }}
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <form action="<?=route('admin.attendance-report.post')?>" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>{{ __('attendance_report.from_date') }}</label>
                                    <input type="text" name="from_date" class="form-control @error('from_date') is-invalid @enderror datepicker" value="{{ old('from_date', $set_from_date) }}">
                                    @error('from_date')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>{{ __('attendance_report.to_date') }}</label>
                                    <input type="text" name="to_date" class="form-control @error('to_date') is-invalid @enderror datepicker" value="{{ old('to_date', $set_to_date) }}">
                                    @error('to_date')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label for="">&nbsp;</label>
                                <button class="btn btn-primary form-control" type="submit">{{ __('attendance_report.get_report') }}</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

            @if($showView)
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('attendance_report.attendance_report') }}</h5>
                        <button class="btn btn-success btn-sm report-print-button" onclick="printDiv('printablediv')">{{ __('attendance_report.print') }}</button>
                    </div>
                    <div class="card-body" id="printablediv">
                        @if(!blank($attendances))
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ __('levels.id') }}</th>
                                            <th>{{ __('levels.image') }}</th>
                                            <th>{{ __('attendance_report.user') }}</th>
                                            <th>{{ __('attendance_report.working') }}</th>
                                            <th>{{ __('attendance_report.date') }}</th>
                                            <th>{{ __('attendance_report.clock_in') }}</th>
                                            <th>{{ __('attendance_report.clock_out') }}</th>
                                        </tr>
                                        @php $i =0;@endphp
                                        @foreach($attendances as $attendance)
                                            <tr>
                                                <td>{{$i+=1 }}</td>
                                                <td><figure class="avatar mr-2"><img src="{{$attendance->user->images}}" alt=""></figure></td>
                                                <td>{{ Str::limit(optional($attendance->user)->name, 50)}}</td>
                                                <td>{{ Str::limit($attendance->title, 30) }}</td>
                                                <td>{{$attendance->date}}</td>
                                                @if ($attendance->checkin_time)
                                                    <td>{{$attendance->checkin_time}}</td>
                                                @else
                                                    <td>{{ __('attendance_report.n/a') }}</td>
                                                @endif
                                                @if ($attendance->checkout_time	)
                                                    <td>{{$attendance->checkout_time}}</td>
                                                @else
                                                    <td>{{ __('attendance_report.n/a') }}</td>
                                                @endif

                                            </tr>
                                        @endforeach
                                    </thead>
                                </table>
                            </div>
                        @else
                            <h4 class="text-danger">{{ __('attendance_report.data_not_found') }}</h4>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </section>

@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/modules/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/report/pre-registers/index.js') }}"></script>
@endsection
