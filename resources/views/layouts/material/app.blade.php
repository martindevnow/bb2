<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#333">
    <title>B.A.R.F. Bento</title>
    <meta name="description" content="Raw Dog Food Delivery Service">
    <link rel="shortcut icon" href="/material/img/favicon.png?v=3">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="/material/css/preload.min.css" />
    <link rel="stylesheet" href="/material/css/plugins.min.css" />
    <link rel="stylesheet" href="/material/css/style.light-blue-500.min.css" />
    <link rel="stylesheet" href="/barfbento/css/app.css" />
    <!--[if lt IE 9]>
    <script src="/material/js/html5shiv.min.js"></script>
    <script src="/material/js/respond.min.js"></script>
    <![endif]-->


    <style>
        .ms-hero-img-barfhome {
            background-image: url(/barfbento/img/raw.JPG);
            background-size: cover;
            background-position: bottom center;
            background-repeat: no-repeat;
        }

        .ms-hero-img-farm {
            background-image: url(/barfbento/img/large/farm.jpg);
            background-size: cover;
            background-position: bottom center;
            background-repeat: no-repeat;
        }
    </style>
</head>
<body>
<div id="ms-preload" class="ms-preload">
    <div id="status">
        <div class="spinner">
            <div class="dot1"></div>
            <div class="dot2"></div>
        </div>
    </div>
</div>
<div class="sb-site-container">

    @include('layouts.material.nav.top')

    @yield('content')

{{--    @include('layouts.material.hero-carousel')--}}
    <!-- ms-hero ms-hero-black -->
{{--    @include('layouts.material.features')--}}
    <!-- container -->
{{--    @include('layouts.material.graphic-panel')--}}
    {{--@include('layouts.material.tabbed-panel')--}}
    <!-- container -->
{{--    @include('layouts.material.plans-panel')--}}
    <!--container -->
{{--    @include('layouts.material.testimonial-panel')--}}
    {{--@include('layouts.material.gallery-panel')--}}
    @include('layouts.material.footbar')
    @include('layouts.material.copyright')
    <div class="btn-back-top">
        <a href="#" data-scroll id="back-top" class="btn-circle btn-circle-primary btn-circle-sm btn-circle-raised ">
            <i class="zmdi zmdi-long-arrow-up"></i>
        </a>
    </div>
</div>
<!-- sb-site-container -->
@include('layouts.material.nav.left')
<script src="/material/js/plugins.min.js"></script>
<script src="/material/js/app.min.js"></script>
<script src="/material/js/index.js"></script>
</body>
</html>