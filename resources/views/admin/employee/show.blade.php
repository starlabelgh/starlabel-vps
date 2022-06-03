@extends('admin.layouts.master')

@section('main-content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('employee.employees') }}</h1>
            {{ Breadcrumbs::render('employees/show') }}
        </div>

        <div class="section-body">
            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="card">
                        <div class="profile-dashboard bg-maroon-light">
                            <img src="{{ $employee->user->images }}" alt="">
                            <h1>{{ $employee->user->name }}</h1>
                            <p>
                                {{ $employee->user->getrole->name ?? '' }}
                            </p>
                        </div>
                        <div class="profile-widget-description profile-widget-employee">
                            <dl class="row">
                                <dt class="col-sm-4">{{ __('employee.name') }}</dt>
                                <dd class="col-sm-8">{{ $employee->user->name }}</dd>
                                <dt class="col-sm-4">{{ __('employee.phone') }}</dt>
                                <dd class="col-sm-8">{{ $employee->user->phone }}</dd>
                                <dt class="col-sm-4">{{ __('employee.email') }}</dt>
                                <dd class="col-sm-8">{{ $employee->user->email }}</dd>
                                <dt class="col-sm-4">{{ __('employee.joining_date') }}</dt>
                                <dd class="col-sm-8">{{ $employee->date_of_joining }}</dd>
                                <dt class="col-sm-4">{{ __('employee.gender') }}</dt>
                                <dd class="col-sm-8">{{ $employee->mygender }}</dd>
                                <dt class="col-sm-4">{{ __('employee.department') }}</dt>
                                <dd class="col-sm-8">{{ $employee->department->name }}</dd>
                                <dt class="col-sm-4">{{ __('employee.designation') }}</dt>
                                <dd class="col-sm-8">{{ $employee->designation->name }}</dd>
                                <dt class="col-sm-4">{{ __('employee.status') }}</dt>
                                <dd class="col-sm-8">{{ $employee->mystatus }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-8">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-visitor-tab" data-toggle="tab"
                               href="#nav-visitor" role="tab" aria-controls="nav-visitor"
                               aria-selected="true">{{ __('employee.visitors') }}</a>
                            <a class="nav-item nav-link" id="nav-register-tab" data-toggle="tab" href="#nav-register"
                               role="tab" aria-controls="nav-register" aria-selected="false">{{ __('employee.pre_registers') }}</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-visitor" role="tabpanel"
                             aria-labelledby="nav-visitor-tab">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="visitortable"
                                               data-url="{{ route('admin.employees.get-visitors',$employee) }}"
                                               data-status="{{ \App\Enums\Status::ACTIVE }}"
                                               data-hidecolumn="{{ auth()->user()->can('visitors_show') || auth()->user()->can('visitors_edit') || auth()->user()->can('visitors_delete') }}">
                                            <thead>
                                            <tr>
                                                <th>{{ __('levels.id') }}</th>
                                                <th>{{ __('levels.image') }}</th>
                                                <th>{{ __('levels.name') }}</th>
                                                <th>{{ __('levels.email') }}</th>
                                                <th>{{ __('employee.checkin') }}</th>
                                                <th>{{ __('levels.actions') }}</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-register" role="tabpanel" aria-labelledby="nav-register-tab">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="preregistertable"
                                               data-url="{{ route('admin.employees.get-pre-registers',$employee) }}"
                                               data-status="{{ \App\Enums\Status::ACTIVE }}"
                                               data-hidecolumn="{{ auth()->user()->can('pre-registers_show') || auth()->user()->can('pre-registers_edit') || auth()->user()->can('pre-registers_delete') }}">
                                            <thead>
                                            <tr>
                                                <th scope="col">{{ __('levels.id') }}</th>
                                                <th scope="col">{{ __('levels.name') }}</th>
                                                <th scope="col">{{ __('levels.email') }}</th>
                                                <th scope="col">{{ __('levels.phone') }}</th>
                                                <th scope="col">{{ __('employee.expected_date') }}</th>
                                                <th scope="col">{{ __('employee.expected_time') }}</th>
                                                <th scope="col">{{ __('levels.actions') }}</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/employee/view.js') }}"></script>
@endsection
