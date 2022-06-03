@extends('frontend.layouts.frontend')

@section('content')
    <section id="pm-banner-1" class="custom-css-step">
        <div class="container">
                <div class="card border-0" style="margin-top:40px;">
                    <div class="card-body">
                            @if(isset($visitingDetails))
                                    <div class="card" style="border: 0;">
                                        <div class="card-body">
                                            <div class="id-card-hook"></div>
                                            <div class="img-cards" id="printidcard">
                                                <div class="id-card-holder">
                                                    <div class="id-card">
                                                        <div class="id-card-photo">
                                                            @if($visitingDetails->getFirstMediaUrl('visitor'))
                                                                <img src="{{ asset($visitingDetails->getFirstMediaUrl('visitor')) }}" alt="">
                                                                @else
                                                                <img src="{{ asset('images/'.setting('site_logo')) }}" alt="">
                                                            @endif
                                                        </div>
                                                        <h2>{{$visitingDetails->visitor->name}}</h2>
                                                        <h3>{{__('Ph: ')}}{{$visitingDetails->visitor->phone}}</h3>
                                                        <h3>{{__('ID#')}}{{$visitingDetails->reg_no}}</h3>
                                                        <h3>{{$visitingDetails->company_name}}</h3>
                                                        <h3>{{$visitingDetails->visitor->address}}</h3>
                                                        <h2>{{__('VISITED TO')}}</h2>
                                                        <h3>{{__('Host:')}} {{$visitingDetails->employee->name}}</h3>
                                                        <hr>
                                                        <p><strong>{{ setting('site_name') }} </strong></p>
                                                        <p><strong>{{ setting('site_address') }} </strong></p>
                                                        <p>{{__('Ph:')}} {{ setting('site_phone') }} | {{__('E-mail:')}} {{ setting('site_email') }} </p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row justify-content-md-center">
                                                <div class="col-md-3">
                                                    <div style="margin-top: 10px;" class="justify-content-center">
                                                        <div class="btn-group btn-group-justified">
                                                            <a href="{{ route('check-in') }}" class="btn btn-primary text-white">
                                                                <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
                                                            </a>
                                                            @if($visitingDetails->visitor)
                                                            <a href="#" id="print" class="btn btn-success text-white">
                                                                <i class="fa fa-print" aria-hidden="true"></i> Print
                                                            </a>
                                                            @endif
                                                            <a href="{{ route('check-in') }}" class="btn btn-danger text-white ">
                                                                <i class="fa fa-home" aria-hidden="true"></i> Home
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                            <div>
                                <p align="center" class="not-data">{{__('ID Not Available')}}</p>
                            </div>
                                @endif
                    </div>
                </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        function printData(data)
        {
            var frame1 = $('<iframe />');
            var css = "{{ asset('css/id-card-print.css') }}";
            frame1[0].name = "frame1";
            frame1.css({ "position": "absolute", "top": "-1000000px" });
            $("body").append(frame1);
            var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
            frameDoc.document.open();
            //Create a new HTML document.
            frameDoc.document.write('<html><head><title>visitor ID Card</title>');
            frameDoc.document.write('<link href="'+css+'" rel="stylesheet" type="text/css" />');
            frameDoc.document.write('</head><body>');
            //Append the external CSS file.
            //Append the DIV contents.
            frameDoc.document.write(data);
            frameDoc.document.write('</body></html>');
            frameDoc.document.close();
            setTimeout(function () {
                window.frames["frame1"].focus();
                window.frames["frame1"].print();
                frame1.remove();
            }, 500);
        }

        $('#print').on('click',function(){
            var data = $("#printidcard").html();
            printData(data);
        });
    </script>

@endsection

