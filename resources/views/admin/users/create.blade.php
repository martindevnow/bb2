@extends('layouts.smartadmin.app')

@section('content')

    <div class="jarviswidget jarviswidget-color-blue jarviswidget-sortable" id="wid-id-4" data-widget-editbutton="false" data-widget-colorbutton="false" role="widget">

        <!-- widget options:
        usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

        data-widget-colorbutton="false"
        data-widget-editbutton="false"
        data-widget-togglebutton="false"
        data-widget-deletebutton="false"
        data-widget-fullscreenbutton="false"
        data-widget-custombutton="false"
        data-widget-collapsed="true"
        data-widget-sortable="false"

        -->

        <header role="heading"><div class="jarviswidget-ctrls" role="menu">   <a href="javascript:void(0);" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-delete-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Delete"><i class="fa fa-times"></i></a></div>
            <span class="widget-icon"> <i class="fa fa-check txt-color-white"></i> </span>
            <h2> Users </h2>
            <!-- <div class="widget-toolbar">
            add: non-hidden - to disable auto hide

            </div>-->
            <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span></header>

        <!-- widget div-->
        <div role="content">

            <div class="widget-body no-padding smart-form">


                <form action="/admin/users" method="POST">
                    <header>
                        Create a User:
                    </header>
                    <?= csrf_field() ?>

                    <fieldset>
                        <section class="col col-6">
                            <label class="label" for="name">Name:</label>
                            <label class="input">
                                <input type="text"
                                       name="name"
                                       value="{{ old('name') }}"
                                       class="form-control"
                                       id="name"
                                       aria-describedby="nameHelp"
                                       placeholder="Name"
                                       autocomplete="off">
                            </label>
                            @if ($errors->has('name'))
                                <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                            @endif
                            <small id="nameHelp" class="form-text text-muted">The user's name.</small>
                        </section>

                        <section class="col col-6">
                            <label class="label" for="email">Email:</label>
                            <label class="input">
                                <input type="email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       class="form-control"
                                       id="email"
                                       aria-describedby="emailHelp"
                                       placeholder="you@example.com"
                                       autocomplete="off">
                            </label>
                            @if ($errors->has('email'))
                                <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                            @endif
                            <small id="emailHelp" class="form-text text-muted">The user's email.</small>
                        </section>

                        <section class="col col-6">
                            <label class="label" for="password">Password:</label>
                            <label class="input">
                                <input type="text"
                                       name="password"
                                       value="{{ old('password') }}"
                                       class="form-control"
                                       id="password"
                                       aria-describedby="passwordHelp"
                                       placeholder=""
                                       autocomplete="off">
                            </label>
                            @if ($errors->has('password'))
                                <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                            @endif
                            <small id="passwordHelp" class="form-text text-muted">The user's password.</small>
                        </section>
                    </fieldset>
                    <footer>
                        <button type="submit" class="btn btn-primary">
                            Submit
                        </button>
                        <button type="button" class="btn btn-default" onclick="window.history.back();">
                            Back
                        </button>
                    </footer>
                </form>
            </div>
        </div>
    </div>



@endsection