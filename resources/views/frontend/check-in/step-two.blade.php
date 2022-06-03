@extends('frontend.layouts.frontend')
@section('style')
    <style>
        #myOnlineCamera video{width:320px;height:240px;margin:15px;float:left;}
        #myOnlineCamera canvas{width:320px;height:240px;margin:15px;float:left;}
        #myOnlineCamera button{clear:both;margin:30px;}
    </style>
@endsection
@section('content')
    <!-- Default Page -->
    <section id="pm-banner-1" class="custom-css-step">
        <div class="container">
            <div class="card"  style="margin-top:40px;">
                <div class="card-header" id="Details" align="center">
                    @if(setting('photo_capture_enable'))
                    <h4 style="color: #111570;font-weight: bold">{{__('Take Visitor Photo')}}</h4>
                    @else
                    <h4 style="color: #111570;font-weight: bold">{{__('Visitor Card Information')}}</h4>
                    @endif
                </div>
                {!! Form::open(['route' => 'check-in.step-two.next', 'class' => 'form-horizontal', 'files' => true]) !!}
                <div class="card-body">
                    <div class="row">
                        @if(setting('photo_capture_enable'))
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="video-options mb-4">
                                        <select name="" id="" class="custom-select">
                                            <option value="">Select camera</option>
                                        </select>
                                    </div>
                                    <div class="row">
                                        <div style="margin: auto" align="center">
                                            <video width="180" height="140" id="videos" style="border:5px solid #d3d3d3;float: left" autoplay></video>
                                            <canvas class="d-none" style="border:5px solid #d3d3d3; display: none"></canvas>
                                            <div style="border:5px solid #d3d3d3;width: 180px;height: 140px; margin-left: 5px; float: left">
                                                <img style="width: 160px;height: 126px;margin: 3px;" class="screenshot-image" alt="">
                                            </div>
                                            <input type="hidden" id="image" name="photo" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="col-md-12">
                                        <button type="button" title="Play" id="playvideo" class='retakephoto btn btn-md btn-dark float-left'>
                                            <img src="{{ asset('website/img/retake.png')}}" style="height: 60px">
                                        </button>
                                        <button type="button" id="screenshot" title="ScreenShot" class='retakephoto btn btn-md btn-danger float-right'>
                                            <img class="img" src="{{ asset('website/img/cemara1.png')}}" style="height: 60px">
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <span class="text-center">{!! $errors->first('photo', '<p class="text-danger">:message</p>') !!}</span>
                        </div>

                        <div class="col-md-4">
                            <div class="img-cards" id="printidcard">
                                <div class="id-card-holder">
                                    <div class="id-card">
                                        <div class="id-card-photo">
                                            <img id="card-img" style="width: 80px;height: 70px;margin: 3px;" class="screenshot-image" alt="">
                                        </div>
                                        <h2>{{$visitingDetails['first_name']}} {{$visitingDetails['last_name']}}</h2>
                                        <h2>{{$visitingDetails['phone']}}</h2>
                                        <h2>{{$visitingDetails['email']}}</h2>
                                        <h2>{{$visitingDetails['address']}}</h2>
                                        <h2>{{$visitingDetails['company_name']}}</h2>
                                        <h2>{{__('VISITED TO')}}</h2>
                                        @if($employee)
                                        <h3>{{__('Host:')}} {{$employee->name}}</h3>
                                        @endif
                                        <hr>
                                        <p><strong>{{ setting('site_name') }} </strong></p>
                                        <p><strong>{{ setting('site_address') }} </strong></p>
                                        <p>{{__('Ph:')}}{{ setting('site_phone') }} | E-mail: {{ setting('site_email') }} </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="col-md-12">
                            <div class="img-cards" id="printidcard">
                                <div class="id-card-holder">
                                    <div class="id-card">
                                        <div class="id-card-photo">
                                            <img id="card-img" style="width: 80px;height: 70px;margin: 3px;" src="{{ asset('images/'.setting('site_logo')) }}" class="screenshot-image" alt="">
                                        </div>
                                        <h2>{{$visitingDetails['first_name']}} {{$visitingDetails['last_name']}}</h2>
                                        <h2>{{$visitingDetails['phone']}}</h2>
                                        <h2>{{$visitingDetails['email']}}</h2>
                                        <h2>{{$visitingDetails['address']}}</h2>
                                        <h2>{{$visitingDetails['company_name']}}</h2>
                                        <h2>{{__('VISITED TO')}}</h2>
                                        @if($employee)
                                        <h3>{{__('Host:')}} {{$employee->name}}</h3>
                                        @endif
                                        <hr>
                                        <p><strong>{{ setting('site_name') }} </strong></p>
                                        <p><strong>{{ setting('site_address') }} </strong></p>
                                        <p>{{__('Ph:')}}{{ setting('site_phone') }} | E-mail: {{ setting('site_email') }} </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('check-in.step-one') }}" class="btn btn-primary float-left text-white">
                                <i class="fa fa-arrow-left" aria-hidden="true"></i> back
                            </a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-success float-right" id="hide">
                                Continue <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">{{__('Terms & condition')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{strip_tags(setting('terms_condition'))}}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="{{ asset('js/photo.js') }}"></script>
@endsection
