<!-- Head -->

<head>
    <meta charset="UTF-8">
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, maximum-scale=1, shrink-to-fit=no">
    <title>Visitor Pass Management - @yield('title')</title>

    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/frontend/css/fontawesome-all.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/frontend/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/frontend/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/frontend/css/jquery.fancybox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/frontend/css/odometer-theme-default.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/frontend/css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/frontend/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/id-card-print.css') }}">

    <!-- Template core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Epilogue font CDN -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Epilogue&display=swap" rel="stylesheet">

    <!--Red Hat Display Font CDN-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Red+Hat+Display&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/modules/izitoast/dist/css/iziToast.min.css') }}">


    @yield('css')
    @stack('css')
</head>
<!-- Head -->
