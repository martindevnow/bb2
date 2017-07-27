<!DOCTYPE html>
<html lang="en-us">
<head>
    <meta charset="utf-8">
    <!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

    <title> B.A.R.F.Admin </title>
    <meta name="description" content="">
    <meta name="author" content="">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Basic Styles -->
    <link rel="stylesheet" type="text/css" media="screen" href="/smartadmin/css/bootstrap.min.css">
    <!-- Font Awesome 4 -->
    <link rel="stylesheet" type="text/css" media="screen" href="/smartadmin/css/font-awesome.min.css">

    {{--<!-- Font Awesome 5 -->--}}
    {{--<link rel="stylesheet" type="text/css" media="screen" href="/css/font-awesome-core.css">--}}
    {{--<link rel="stylesheet" type="text/css" media="screen" href="/css/font-awesome-solid.css">--}}

    <!-- SmartAdmin Styles : Caution! DO NOT change the order -->
    <link rel="stylesheet" type="text/css" media="screen" href="/smartadmin/css/smartadmin-production-plugins.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="/smartadmin/css/smartadmin-production.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="/smartadmin/css/smartadmin-skins.min.css">

    <!-- SmartAdmin RTL Support  -->
    <link rel="stylesheet" type="text/css" media="screen" href="/smartadmin/css/smartadmin-rtl.min.css">

    <!-- We recommend you use "your_style.css" to override SmartAdmin
         specific styles this will also ensure you retrain your customization with each SmartAdmin update.
    <link rel="stylesheet" type="text/css" media="screen" href="/smartadmin/css/your_style.css"> -->

    <!-- FAVICONS -->
    <link rel="shortcut icon" href="/smartadmin/img/favicon/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/smartadmin/img/favicon/favicon.ico" type="image/x-icon">

    <!-- GOOGLE FONT -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

    <!-- Specifying a Webpage Icon for Web Clip
         Ref: https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
    <link rel="apple-touch-icon" href="/smartadmin/img/splash/sptouch-icon-iphone.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/smartadmin/img/splash/touch-icon-ipad.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/smartadmin/img/splash/touch-icon-iphone-retina.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/smartadmin/img/splash/touch-icon-ipad-retina.png">

    <!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <!-- Startup image for web apps -->
    <link rel="apple-touch-startup-image" href="/smartadmin/img/splash/ipad-landscape.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
    <link rel="apple-touch-startup-image" href="/smartadmin/img/splash/ipad-portrait.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
    <link rel="apple-touch-startup-image" href="/smartadmin/img/splash/iphone.png" media="screen and (max-device-width: 320px)">


    {{--<!-- new for FontAwesome 5 -->--}}
    {{--<script defer src="/js/packs/solid.js"></script>--}}
    {{--<script defer src="/js/fontawesome.js"></script>--}}

    <style>
        @media (min-width: 768px){
            .seven-cols .col-md-1,
            .seven-cols .col-sm-1,
            .seven-cols .col-lg-1  {
                width: 100%;
                *width: 100%;
            }
        }


        @media (min-width: 992px) {
            .seven-cols .col-md-1,
            .seven-cols .col-sm-1,
            .seven-cols .col-lg-1 {
                width: 14.285714285714285714285714285714%;
                *width: 14.285714285714285714285714285714%;
            }
        }


        @media (min-width: 1200px) {
            .seven-cols .col-md-1,
            .seven-cols .col-sm-1,
            .seven-cols .col-lg-1 {
                width: 14.285714285714285714285714285714%;
                *width: 14.285714285714285714285714285714%;
            }
        }

        td > form {
            display: inline-block;
        }

        .schedule-day {
            border: 1px solid dimgrey;
            /*border-right: 1px solid dimgrey;*/
        }

        .schedule-day-title {
            text-align: center;
            font-size: 2rem;


        }
    </style>

</head>

<!--

TABLE OF CONTENTS.

Use search to find needed section.

===================================================================

|  01. #CSS Links                |  all CSS links and file paths  |
|  02. #FAVICONS                 |  Favicon links and file paths  |
|  03. #GOOGLE FONT              |  Google font link              |
|  04. #APP SCREEN / ICONS       |  app icons, screen backdrops   |
|  05. #BODY                     |  body tag                      |
|  06. #HEADER                   |  header tag                    |
|  07. #PROJECTS                 |  project lists                 |
|  08. #TOGGLE LAYOUT BUTTONS    |  layout buttons and actions    |
|  09. #MOBILE                   |  mobile view dropdown          |
|  10. #SEARCH                   |  search field                  |
|  11. #NAVIGATION               |  left panel & navigation       |
|  12. #RIGHT PANEL              |  right panel userlist          |
|  13. #MAIN PANEL               |  main panel                    |
|  14. #MAIN CONTENT             |  content holder                |
|  15. #PAGE FOOTER              |  page footer                   |
|  16. #SHORTCUT AREA            |  dropdown shortcuts area       |
|  17. #PLUGINS                  |  all scripts and plugins       |

===================================================================

-->

<!-- #BODY -->
<!-- Possible Classes

    * 'smart-style-{SKIN#}'
    * 'smart-rtl'         - Switch theme mode to RTL
    * 'menu-on-top'       - Switch to top navigation (no DOM change required)
    * 'no-menu'			  - Hides the menu completely
    * 'hidden-menu'       - Hides the main menu but still accessable by hovering over left edge
    * 'fixed-header'      - Fixes the header
    * 'fixed-navigation'  - Fixes the main menu
    * 'fixed-ribbon'      - Fixes breadcrumb
    * 'fixed-page-footer' - Fixes footer
    * 'container'         - boxed layout mode (non-responsive: will not work with fixed-navigation & fixed-ribbon)
-->
<body class="">

@include('layouts.smartadmin.header')

@include('layouts.smartadmin.nav.left')

<!-- MAIN PANEL -->
<div id="main" role="main">

    <!-- RIBBON -->
    @include('layouts.smartadmin.ribbon')
    <!-- END RIBBON -->

    <!-- MAIN CONTENT -->
    <div id="content">

        <div class="row">
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
                <h1 class="page-title txt-color-blueDark">
                    @yield('breadcrumb_left')
                </h1>
            </div>
            <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
                @yield('breadcrumb_right')
            </div>
        </div>
        <!-- widget grid -->
        <section id="widget-grid" class="">

            @include('flash::message')

            @yield('content')

            <!-- end row -->

        </section>
        <!-- end widget grid -->

    </div>
    <!-- END MAIN CONTENT -->

</div>
<!-- END MAIN PANEL -->

@include('layouts.smartadmin.copyright')

<!-- SHORTCUT AREA : With large tiles (activated via clicking user name tag)
Note: These tiles are completely responsive,
you can add as many as you like
-->
<div id="shortcut">
    <ul>
        <li>
            <a href="inbox.html" class="jarvismetro-tile big-cubes bg-color-blue"> <span class="iconbox"> <i class="fa fa-envelope fa-4x"></i> <span>Mail <span class="label pull-right bg-color-darken">14</span></span> </span> </a>
        </li>
        <li>
            <a href="calendar.html" class="jarvismetro-tile big-cubes bg-color-orangeDark"> <span class="iconbox"> <i class="fa fa-calendar fa-4x"></i> <span>Calendar</span> </span> </a>
        </li>
        <li>
            <a href="gmap-xml.html" class="jarvismetro-tile big-cubes bg-color-purple"> <span class="iconbox"> <i class="fa fa-map-marker fa-4x"></i> <span>Maps</span> </span> </a>
        </li>
        <li>
            <a href="invoice.html" class="jarvismetro-tile big-cubes bg-color-blueDark"> <span class="iconbox"> <i class="fa fa-book fa-4x"></i> <span>Invoice <span class="label pull-right bg-color-darken">99</span></span> </span> </a>
        </li>
        <li>
            <a href="gallery.html" class="jarvismetro-tile big-cubes bg-color-greenLight"> <span class="iconbox"> <i class="fa fa-picture-o fa-4x"></i> <span>Gallery </span> </span> </a>
        </li>
        <li>
            <a href="profile.html" class="jarvismetro-tile big-cubes selected bg-color-pinkDark"> <span class="iconbox"> <i class="fa fa-user fa-4x"></i> <span>My Profile </span> </span> </a>
        </li>
    </ul>
</div>
<!-- END SHORTCUT AREA -->

<!--================================================== -->

<!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
<script data-pace-options='{ "restartOnRequestAfter": true }' src="/smartadmin/js/plugin/pace/pace.min.js"></script>

<!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
    if (!window.jQuery) {
        document.write('<script src="/smartadmin/js/libs/jquery-2.1.1.min.js"><\/script>');
    }
</script>

<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script>
    if (!window.jQuery.ui) {
        document.write('<script src="/smartadmin/js/libs/jquery-ui-1.10.3.min.js"><\/script>');
    }
</script>

<!-- IMPORTANT: APP CONFIG -->
<script src="/smartadmin/js/app.config.js"></script>

<!-- JS TOUCH : include this plugin for mobile drag / drop touch events-->
<script src="/smartadmin/js/plugin/jquery-touch/jquery.ui.touch-punch.min.js"></script>

<!-- BOOTSTRAP JS -->
<script src="/smartadmin/js/bootstrap/bootstrap.min.js"></script>

<!-- CUSTOM NOTIFICATION -->
<script src="/smartadmin/js/notification/SmartNotification.min.js"></script>

<!-- JARVIS WIDGETS -->
<script src="/smartadmin/js/smartwidgets/jarvis.widget.min.js"></script>

<!-- EASY PIE CHARTS -->
<script src="/smartadmin/js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js"></script>

<!-- SPARKLINES -->
<script src="/smartadmin/js/plugin/sparkline/jquery.sparkline.min.js"></script>

<!-- JQUERY VALIDATE -->
<script src="/smartadmin/js/plugin/jquery-validate/jquery.validate.min.js"></script>

<!-- JQUERY MASKED INPUT -->
<script src="/smartadmin/js/plugin/masked-input/jquery.maskedinput.min.js"></script>

<!-- JQUERY SELECT2 INPUT -->
<script src="/smartadmin/js/plugin/select2/select2.min.js"></script>

<!-- JQUERY UI + Bootstrap Slider -->
<script src="/smartadmin/js/plugin/bootstrap-slider/bootstrap-slider.min.js"></script>

<!-- browser msie issue fix -->
<script src="/smartadmin/js/plugin/msie-fix/jquery.mb.browser.min.js"></script>

<!-- FastClick: For mobile devices -->
<script src="/smartadmin/js/plugin/fastclick/fastclick.min.js"></script>

<!--[if IE 8]>

<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>

<![endif]-->

<!-- MAIN APP JS FILE -->
<script src="/smartadmin/js/app.min.js"></script>

<!-- ENHANCEMENT PLUGINS : NOT A REQUIREMENT -->
<!-- Voice command : plugin -->
{{--<script src="/smartadmin/js/speech/voicecommand.min.js"></script>--}}

<!-- SmartChat UI : plugin -->
{{--<script src="/smartadmin/js/smart-chat-ui/smart.chat.ui.min.js"></script>--}}
{{--<script src="/smartadmin/js/smart-chat-ui/smart.chat.manager.min.js"></script>--}}

<!-- PAGE RELATED PLUGIN(S) -->

<!-- Flot Chart Plugin: Flot Engine, Flot Resizer, Flot Tooltip -->
{{--<script src="/smartadmin/js/plugin/flot/jquery.flot.cust.min.js"></script>--}}
{{--<script src="/smartadmin/js/plugin/flot/jquery.flot.resize.min.js"></script>--}}
{{--<script src="/smartadmin/js/plugin/flot/jquery.flot.time.min.js"></script>--}}
{{--<script src="/smartadmin/js/plugin/flot/jquery.flot.tooltip.min.js"></script>--}}

<!-- Vector Maps Plugin: Vectormap engine, Vectormap language -->
{{--<script src="/smartadmin/js/plugin/vectormap/jquery-jvectormap-1.2.2.min.js"></script>--}}
{{--<script src="/smartadmin/js/plugin/vectormap/jquery-jvectormap-world-mill-en.js"></script>--}}

<!-- Full Calendar -->
{{--<script src="/smartadmin/js/plugin/moment/moment.min.js"></script>--}}
{{--<script src="/smartadmin/js/plugin/fullcalendar/jquery.fullcalendar.min.js"></script>--}}


<script src="/js/app.js"></script>

<script>
    $('#flash-overlay-modal').modal();
    $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
</script>


@yield('scripts')


{{--@include('layouts.smartadmin.js.random')--}}

<!-- Your GOOGLE ANALYTICS CODE Below -->
<script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-XXXXXXXX-X']);
    _gaq.push(['_trackPageview']);

    (function() {
        var ga = document.createElement('script');
        ga.type = 'text/javascript';
        ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(ga, s);
    })();
</script>

</body>

</html>