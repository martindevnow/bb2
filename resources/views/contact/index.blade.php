@extends('layouts.material.app')

@section('content')

    <div class="ms-hero-page-override ms-hero-img-team" style="background-image: url('/barfbento/img/lie-down.jpg')">
        <div class="container">
            <div class="text-center">
                <h1>&nbsp;</h1>
            </div>
        </div>
    </div>

    <div class="container container-full">
        <div class="card card-hero">
            <div class="card-block-big">
                <h2 class="color-primary">Contact Us</h2>
                <form class="form-horizontal" action="/contact/send" method="POST">
                    {!! csrf_field() !!}
                    <fieldset>
                        <div class="form-group is-empty">
                            <label for="inputName" class="col-md-2 control-label">Name</label>
                            <div class="col-md-9">
                                <input type="text"
                                       class="form-control"
                                       id="inputName"
                                       placeholder="Name"
                                       name="name"
                                       value="{{ old('name') }}"
                                > </div>
                        </div>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                        <div class="form-group is-empty">
                            <label for="inputEmail" class="col-md-2 control-label">Email</label>
                            <div class="col-md-9">
                                <input type="email"
                                       class="form-control"
                                       id="inputEmail"
                                       placeholder="Email"
                                       name="email"
                                       value="{{ old('email') }}"
                                > </div>
                        </div>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                        <div class="form-group is-empty">
                            <label for="inputSubject" class="col-md-2 control-label">Subject</label>
                            <div class="col-md-9">
                                <input type="text"
                                       class="form-control"
                                       id="inputSubject"
                                       placeholder="Subject"
                                       name="subject"
                                       value="{{ old('subject') }}"
                                > </div>
                        </div>
                        @if ($errors->has('subject'))
                            <span class="help-block">
                                <strong>{{ $errors->first('subject') }}</strong>
                            </span>
                        @endif
                        <div class="form-group is-empty">
                            <label for="textArea" class="col-md-2 control-label">Message</label>
                            <div class="col-md-9">
                                <textarea class="form-control"
                                          rows="5"
                                          id="textArea"
                                          placeholder="Your message..."
                                          name="body"
                                >
                                    {{ old('body') }}
                                </textarea>
                            </div>
                        </div>
                        @if ($errors->has('body'))
                            <span class="help-block">
                                <strong>{{ $errors->first('body') }}</strong>
                            </span>
                        @endif
                        <div class="form-group">
                            <div class="col-md-9 col-md-offset-2">
                                <button type="submit" class="btn btn-raised btn-primary">Submit</button>
                                <button type="button" class="btn btn-danger">Cancel</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
        <div class="card card-primary">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-5">
                    <div class="card-block wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                        <div class="mb-2">
                            <span class="ms-logo ms-logo-sm mr-1">BB</span>
                            <h3 class="no-m ms-site-title">B.A.R.F.
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
                                <i class="color-royal-light zmdi zmdi-phone mr-1"></i>+1 647 202 0692 </p>
                        </address>
                    </div>
                </div>
                <div class="col-lg-9 col-md-8 col-sm-7">
                    <iframe width="100%" height="340" src="https://www.google.com/maps/d/u/0/embed?mid=12HuD4sUWj4Kk0yhWsp9-ttJcZN4"></iframe>
                </div>
            </div>
        </div>
    </div>

@endsection