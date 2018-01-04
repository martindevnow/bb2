<div class="ms-slidebar sb-slidebar sb-left sb-style-overlay" id="ms-slidebar">
    <div class="sb-slidebar-container">
        <header class="ms-slidebar-header">
            @if (Auth::guest())
            <div class="ms-slidebar-login">
                <a href="/login" class="withripple">
                    <i class="zmdi zmdi-account"></i> Login</a>
                {{--<a href="/register" class="withripple">--}}
                    {{--<i class="zmdi zmdi-account-add"></i> Register</a>--}}
            </div>
            @else
            <div class="ms-slidebar-login">
                <a href="{{ route('logout') }}"
                   class="withripple"
                   onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    <i class="zmdi zmdi-account"></i>
                    Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>
            @endif

            <div class="ms-slidebar-title">
                <form class="search-form">
                    <input id="search-box-slidebar" type="text" class="search-input" placeholder="Search..." name="q" />
                    <label for="search-box-slidebar">
                        <i class="zmdi zmdi-search"></i>
                    </label>
                </form>
                <div class="ms-slidebar-t">
                    <span class="ms-logo ms-logo-sm">BB</span>
                    <h3>B.A.R.F.
                        <span>Bento</span>
                    </h3>
                </div>
            </div>
        </header>
        <ul class="ms-slidebar-menu" id="slidebar-menu" role="tablist" aria-multiselectable="true">
            <li>
                <a class="link" href="/">
                    <i class="zmdi zmdi-home"></i> Home</a>
            </li>
            <li>
                <a class="link" href="/quote">
                    <i class="zmdi zmdi-receipt"></i> Quote</a>
            </li>
            <li>
                <a class="link" href="/treats">
                    <i class="zmdi zmdi-shopping-basket"></i> Treats</a>
            </li>
            <li>
                <a class="link" href="/cart">
                    <i class="zmdi zmdi-shopping-cart"></i> Cart</a>
            </li>
            <li>
                <a class="link" href="/packages">
                    <i class="zmdi zmdi-store"></i> Packages</a>
            </li>
            <li>
                <a class="link" href="/about">
                    <i class="zmdi zmdi-info"></i> About</a>
            </li>
            <li>
                <a class="link" href="/contact">
                    <i class="zmdi zmdi-email"></i> Contact</a>
            </li>
            <li>
                <a class="link" href="/faq">
                    <i class="fa fa-question"></i> FAQ</a>
            </li>
            @if (Auth::user() && Auth::user()->isAdmin())
            <li>
                <a class="link" href="/admin">
                    <i class="fa fa-user-circle"></i> Admin</a>
            </li>
            @endif

        </ul>
        <div class="ms-slidebar-social ms-slidebar-block">
            <h4 class="ms-slidebar-block-title">Social Media</h4>
            <div class="ms-slidebar-social">
                <a href="https://www.facebook.com/doggiebento" class="btn-circle btn-circle-raised btn-facebook">
                    <i class="zmdi zmdi-facebook"></i>
                    {{--<span class="badge badge-pink">12</span>--}}
                    <div class="ripple-container"></div>
                </a>
                <a href="https://twitter.com/barfbento" class="btn-circle btn-circle-raised btn-twitter">
                    <i class="zmdi zmdi-twitter"></i>
                    {{--<span class="badge badge-pink">4</span>--}}
                    <div class="ripple-container"></div>
                </a>
                <a href="https://www.instagram.com/b.a.r.f.bento/" class="btn-circle btn-circle-raised btn-instagram">
                    <i class="zmdi zmdi-instagram"></i>
                    <div class="ripple-container"></div>
                </a>
            </div>
        </div>
    </div>
</div>