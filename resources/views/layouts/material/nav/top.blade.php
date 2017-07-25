<nav class="navbar navbar-static-top yamm ms-navbar ms-navbar-primary navbar-mode">
    <div class="container container-full" style="display: flex;">

        <div id="navbar" class="navbar-collapse collapse navbar-left" style="position: absolute; left: 1rem;">
            <ul class="nav navbar-nav">
                <li class="{{ app('request')->is('/') ? 'active' : '' }}">
                    <a href="/" data-name="home">Home</a>
                </li>
                <li class="{{ app('request')->is('quote') ? 'active' : '' }}">
                    <a href="/quote" data-name="quote">Quote
                    </a>
                </li>
                <li class="{{ app('request')->is('treats') ? 'active' : '' }}">
                    <a href="/treats" data-name="treats">Treats
                    </a>
                </li>

                <!-- <li class="btn-navbar-menu"><a href="javascript:void(0)" class="sb-toggle-left"><i class="zmdi zmdi-menu"></i></a></li> -->
            </ul>
        </div>
        <div class="navbar-header" style="margin-right: auto; margin-left: auto;">
            <a class="navbar-brand" href="/">
                <!-- <img src="/material/img/demo/logo-navbar.png" alt=""> -->
                <span class="ms-logo ms-logo-sm">BB</span>
                <span class="ms-title">B.A.R.F.
                <strong>Bento</strong>
              </span>
            </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse navbar-right" style="position: absolute; right: 1rem;">
            <ul class="nav navbar-nav">
                <li class="{{ app('request')->is('packages') ? 'active' : '' }}">
                    <a href="/packages" data-name="packages">Packages
                    </a>
                </li>
                <li class="{{ app('request')->is('about') ? 'active' : '' }}">
                    <a href="/about" data-name="about">About
                    </a>
                </li>
                <li class="{{ app('request')->is('contact') ? 'active' : '' }}">
                    <a href="/contact" data-name="contact">Contact
                    </a>
                </li>
                <!-- <li class="btn-navbar-menu"><a href="javascript:void(0)" class="sb-toggle-left"><i class="zmdi zmdi-menu"></i></a></li> -->
            </ul>
        </div>
        <!-- navbar-collapse collapse -->
        <a href="javascript:void(0)" class="sb-toggle-left btn-navbar-menu">
            <i class="zmdi zmdi-menu"></i>
        </a>
    </div>
    <!-- container -->
</nav>