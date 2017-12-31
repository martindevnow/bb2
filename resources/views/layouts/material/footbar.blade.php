<aside class="ms-footbar">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-8 ms-footer-col">
                <div class="ms-footbar-block">
                    <h3 class="ms-footbar-title">Sitemap</h3>
                    <ul class="list-unstyled ms-icon-list three_cols">
                        <li>
                            <a href="/">
                                <i class="zmdi zmdi-home"></i> Home</a>
                        </li>
                        <li>
                            <a href="/quote">
                                <i class="zmdi zmdi-edit"></i> Quote</a>
                        </li>
                        <li>
                            <a href="/treats">
                                <i class="zmdi zmdi-image-o"></i> Treats</a>
                        </li>
                        <li>
                            <a href="/packages">
                                <i class="zmdi zmdi-case"></i> Packages</a>
                        </li>
                        <li>
                            <a href="/about">
                                <i class="zmdi zmdi-favorite-outline"></i> About</a>
                        </li>
                        <li>
                            <a href="/contact">
                                <i class="zmdi zmdi-email"></i> Contact</a>
                        </li>
                        <li>
                            <a href="/faq">
                                <i class="zmdi zmdi-help"></i> FAQ</a>
                        </li>
                        <li>
                            <a href="/shipping">
                                <i class="zmdi zmdi-truck"></i> Shipping</a>
                        </li>
                        @if (Auth::guest())
                        <li>
                            <a href="/login">
                                <i class="zmdi zmdi-lock color-danger"></i> Login</a>
                        </li>
                        @endif
                        @if (Auth::user() && Auth::user()->isAdmin())
                        <li>
                            <a href="/admin">
                                <i class="zmdi zmdi-account-circle color-danger"></i> Admin</a>
                        </li>
                        @endif
                    </ul>
                </div>
                {{--<div class="ms-footbar-block">--}}
                    {{--<h3 class="ms-footbar-title">Subscribe</h3>--}}
                    {{--<p class="">Stay up to date with the latest offerings from BARFBento by filling in your email below and joining our mailing list.--}}
                        {{--You can opt out at anytime.</p>--}}
                    {{--<form>--}}
                        {{--<div class="form-group label-floating mt-2 mb-1">--}}
                            {{--<div class="input-group ms-input-subscribe">--}}
                                {{--<label class="control-label" for="ms-subscribe">--}}
                                    {{--<i class="zmdi zmdi-email"></i> Email Address</label>--}}
                                {{--<input type="email" id="ms-subscribe" class="form-control"> </div>--}}
                        {{--</div>--}}
                        {{--<button class="ms-subscribre-btn" type="button">Subscribe</button>--}}
                    {{--</form>--}}
                {{--</div>--}}
            </div>
            <div class="col-md-4 col-sm-4 ms-footer-col ms-footer-text-right ms-footer-alt-color">
                <div class="ms-footbar-block">
                    <div class="ms-footbar-title">
                        <span class="ms-logo ms-logo-white ms-logo-sm mr-1">BB</span>
                        <h3 class="no-m ms-site-title">BARF
                            <span>Bento</span>
                        </h3>
                    </div>
                    <address class="no-mb">
                        <p>
                            <i class="color-danger-light zmdi zmdi-pin mr-1"></i> 503 Beecroft Road</p>
                        <p>
                            <i class="color-warning-light zmdi zmdi-map mr-1"></i> Toronto, ON, M2N 0A2</p>
                        <p>
                            <i class="color-info-light zmdi zmdi-email mr-1"></i>
                            <a href="mailto:info@barfbento.com">info@barfbento.com</a>
                        </p>
                        <p>
                            <i class="color-royal-light zmdi zmdi-phone mr-1"></i>
                            <a href="tel:+16478801136">+1 647 880 1136 </a>
                        </p>
                    </address>
                </div>
                <div class="ms-footbar-block">
                    <h3 class="ms-footbar-title">Social Media</h3>
                    <div class="ms-footbar-social">
                        <a href="https://www.facebook.com/doggiebento/" class="btn-circle btn-facebook">
                            <i class="zmdi zmdi-facebook"></i>
                        </a>
                        <a href="https://twitter.com/barfbento" class="btn-circle btn-twitter">
                            <i class="zmdi zmdi-twitter"></i>
                        </a>
                        <a href="https://www.instagram.com/b.a.r.f.bento/" class="btn-circle btn-instagram">
                            <i class="zmdi zmdi-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</aside>