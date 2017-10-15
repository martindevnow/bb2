<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#333">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BARF Bento - Raw dog food delivery service</title>
    <meta name="description" content="BARF Bento raw dog food is a Toronto based company specializing in high-quality catered, portioned and delivered meals for your dog. Our nutritional raw dog food meals focus on the BARF diet and biologically appropriate raw food guidelines.">
    <meta property="og:description" content="BARF Bento - Raw dog food delivery service">
    <meta property="og:description" content="BARF Bento raw dog food is a Toronto based company specializing in high-quality catered, portioned and delivered meals for your dog. Our nutritional raw dog food meals focus on the BARF diet and biologically appropriate raw food guidelines.">

    <meta property="og:url" content="http://barfbento.com/">
    <meta property="og:site_name" content="BARFBento - Raw Dog Food Delivery Service">

    <link rel="shortcut icon" href="/material/img/favicon.png?v=3">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="/material/css/preload.min.css" />
    <link rel="stylesheet" href="/material/css/plugins.min.css" />
    <link rel="stylesheet" href="/material/css/style.light-blue-500.min.css" />
    <link rel="stylesheet" href="/barfbento/css/app.css" />
    <link rel="stylesheet" href="/barfbento/css/barf.css" />
    <link rel="stylesheet" href="/css/sweetalert2.min.css" />

    <!--[if lt IE 9]>
    <script src="/material/js/html5shiv.min.js"></script>
    <script src="/material/js/respond.min.js"></script>
    <![endif]-->

    <script>
        window.BarfBento = <?php echo json_encode([
            'csrfToken' => csrf_token(),
            'stripeKey' => config('services.stripe.key'),
//            'user' => auth()->user()
        ]); ?>
    </script>

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
<div class="sb-site-container" id="content">

    @include('layouts.material.nav.top')

    @yield('content')

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
<script src="https://checkout.stripe.com/checkout.js"></script>
<script src="/js/app.js"></script>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-91894131-1', 'auto');
    ga('send', 'pageview');

</script>

</body>
</html>