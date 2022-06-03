@extends('admin.layouts.master')

@section('main-content')

	<section class="section">
        <div class="section-header">
            <h1>{{ __('pre_register.pre_register') }}</h1>
            {{ Breadcrumbs::render('pre-registers/show') }}
        </div>

        <div class="section-body">
        	<div class="row">
	   			<div class="col-4 col-md-4 col-lg-4">
			    	<div class="card">
					    <div class="card-body card-profile">
					        <img class="profile-user-img img-responsive img-circle" src="{{ $preregister->visitor->images }}" alt="User profile picture">
					        <h3 class="text-center">{{ $preregister->visitor->name }}</h3>
					        <p class="text-center">
					        	{{__('pre_register.pre_register')}}
					        </p>
					    </div>
					    <!-- /.box-body -->
					</div>
				</div>
	   			<div class="col-8 col-md-8 col-lg-8">
			    	<div class="card">
			    		<div class="card-body">
			    			<div class="profile-desc">
			    				<div class="single-profile">
			    					<p><b>{{ __('pre_register.first_name') }}: </b> {{ $preregister->visitor->first_name}}</p>
			    				</div>
			    				<div class="single-profile">
			    					<p><b>{{ __('pre_register.last_name') }}: </b> {{ $preregister->visitor->last_name}}</p>
			    				</div>
			    				<div class="single-profile">
			    					<p><b>{{ __('pre_register.email_address') }}: </b> {{ $preregister->visitor->email}}</p>
			    				</div>
			    				<div class="single-profile">
			    					<p><b>{{ __('pre_register.phone') }}: </b> {{ $preregister->visitor->phone}}</p>
			    				</div>
                                <div class="single-profile">
			    					<p><b>{{ __('pre_register.employee') }}: </b> {{ $preregister->employee->user->name}}</p>
			    				</div>
			    				<div class="single-profile">
			    					<p><b>{{ __('pre_register.expected_date') }}: </b> {{$preregister->expected_date }}</p>
			    				</div>
                                <div class="single-profile">
			    					<p><b>{{ __('pre_register.expected_time') }}: </b> {{ date('h:i A', strtotime($preregister->expected_time))}}</p>
			    				</div>
                                <div class="single-profile">
                                    <p><b>{{ __('pre_register.address') }}: </b> {{ $preregister->visitor->address}}</p>
                                </div>
                                <div class="single-full-profile">
                                    <p><b>{{ __('pre_register.comment') }}: </b> {{ $preregister->comment}}</p>
                                </div>
                                <div class="single-profile">
                                    <p><b>{{ __('levels.status') }}: </b> {{ $preregister->visitor->my_status}}</p>
                                </div>
			    			</div>
			    		</div>
			    	</div>
				</div>
        	</div>
        </div>
    </section>

@endsection
