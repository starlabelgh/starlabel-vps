@extends('admin.layouts.master')

@section('main-content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('pre_register_report.pre_register_report') }}</h1>
            {{ Breadcrumbs::render('pre-registers') }}
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <form action="<?=route('admin.admin-pre-registers-report.post')?>" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>{{ __('pre_register_report.from_date') }}</label>
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
                                    <label>{{ __('pre_register_report.to_date') }}</label>
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
                                <button class="btn btn-primary form-control" type="submit">{{ __('pre_register_report.get_report') }}</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

            @if($showView)
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('Pre-Registers Report') }}</h5>
                        <button class="btn btn-success btn-sm report-print-button" onclick="printDiv('printablediv')">{{ __('Print') }}</button>
                    </div>
                    <div class="card-body" id="printablediv">
                        @if(!blank($preRegisters))
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ __('levels.id') }}</th>
                                            <th>{{ __('levels.name') }}</th>
                                            <th>{{ __('levels.email') }}</th>
                                            <th>{{ __('levels.phone') }}</th>
                                            <th>{{ __('pre_register_report.employee') }}</th>
                                            <th>{{ __('pre_register_report.expected_date') }}</th>
                                            <th>{{ __('pre_register_report.expected_time') }}</th>
                                        </tr>
                                        @php $i =0;@endphp
                                        @foreach($preRegisters as $preRegister)
                                            <tr>
                                                <td>{{$i+=1 }}</td>
                                                <td>{{ Str::limit(optional($preRegister->visitor)->name, 50)}}</td>
                                                <td>{{ Str::limit(optional($preRegister->visitor)->email, 50) }}</td>
                                                <td>{{optional($preRegister->visitor)->phone}}</td>
                                                <td>{{optional($preRegister->employee->user)->name}}</td>
                                                @if (optional($preRegister->visitor)->is_pre_register==1)
                                                    <td><p class="text-danger">{{$preRegister->expected_date}}</p></td>
                                                    <td><p class="text-danger">{{$preRegister->expected_time}}</p></td>
                                                @else
                                                    <td><p>{{$preRegister->expected_date}}</p></td>
                                                    <td><p>{{$preRegister->expected_time}}</p></td>
                                                @endif

                                            </tr>
                                        @endforeach
                                    </thead>
                                </table>
                            </div>
                        @else
                            <h4 class="text-danger">{{ __('pre_register_report.data_not_found') }}</h4>
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
