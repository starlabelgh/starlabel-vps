@extends('admin.layouts.master')

@section('main-content')

<section class="section">
    <div class="section-header">
        <h1>{{ __('pre_register.pre_register') }}</h1>
        {{ Breadcrumbs::render('pre-registers') }}
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    @can('pre-registers_create')
                        <div class="card-header">
                            <a href="{{ route('admin.pre-registers.create') }}" class="btn btn-icon icon-left btn-primary"><i
                                    class="fas fa-plus"></i> {{ __('Add Pre-register') }}</a>
                        </div>
                    @endcan

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="maintable"
                                data-url="{{ route('admin.pre-registers.get-pre-registers') }}"
                                data-status="{{ \App\Enums\Status::ACTIVE }}" data-hidecolumn="{{ auth()->user()->can('pre-registers_show') || auth()->user()->can('pre-registers_edit') || auth()->user()->can('pre-registers_delete') }}">
                                <thead>
                                    <tr>
                                        <th width="5%">{{ __('levels.id') }}</th>
                                        <th width="10%">{{ __('levels.name') }}</th>
                                        <th width="5%">{{ __('levels.email') }}</th>
                                        <th width="5%">{{ __('levels.phone') }}</th>
                                        <th width="10%">{{ __('pre_register.employee') }}</th>
                                        <th width="15%">{{ __('pre_register.expected_date') }}</th>
                                        <th width="15%">{{ __('pre_register.expected_time') }}</th>
                                        <th width="15%">{{ __('levels.actions') }}</th>
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

@endsection



@section('css')
<link rel="stylesheet" href="{{ asset('assets/modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('assets/modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/modules/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/preregister/index.js') }}"></script>
@endsection
