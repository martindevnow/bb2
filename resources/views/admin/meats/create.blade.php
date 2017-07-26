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
            <h2> Meats </h2>
            <!-- <div class="widget-toolbar">
            add: non-hidden - to disable auto hide

            </div>-->
            <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span></header>

        <!-- widget div-->
        <div role="content">

            <div class="widget-body no-padding smart-form">

                <form action="/admin/meats" method="POST">
                    <header>
                        Create a Meat:
                    </header>

                    <?= csrf_field() ?>

                    <fieldset>
                        <div class="row">
                            <section class="col col-6">
                                <label class="label" for="code">Code:</label>
                                <label class="input">
                                    <input type="text"
                                           name="code"
                                           value="{{ old('code') }}"
                                           class="form-control"
                                           id="code"
                                           aria-describedby="codeHelp"
                                           placeholder="Code of the meat"
                                           autocomplete="off">
                                </label>
                                @if ($errors->has('code'))
                                    <span class="help-block">
                            <strong>{{ $errors->first('code') }}</strong>
                        </span>
                                @endif
                                <small id="codeHelp" class="form-text text-muted">Must be unique</small>
                            </section>

                            <section class="col col-6">
                                <label class="label" for="cost_per_lb">Cost per Pound:</label>
                                <label class="input">
                                    <input type="text"
                                           name="cost_per_lb"
                                           value="{{ old('cost_per_lb') }}"
                                           class="form-control"
                                           id="cost_per_lb"
                                           aria-describedby="cost_per_lbHelp"
                                           placeholder="How much does it cost?"
                                           autocomplete="off">
                                </label>
                                @if ($errors->has('cost_per_lb'))
                                    <span class="help-block">
                            <strong>{{ $errors->first('cost_per_lb') }}</strong>
                        </span>
                                @endif
                                <small id="cost_per_lbHelp" class="form-text text-muted">Cost per pound of meat</small>
                            </section>

                        </div>
                        <div class="row">
                            <section class="col col-6">
                                <label class="label" for="type">Type:</label>
                                <label class="input">
                                    <input type="text"
                                           name="type"
                                           value="{{ old('type') }}"
                                           class="form-control"
                                           id="type"
                                           aria-describedby="typeHelp"
                                           placeholder="Type of meat"
                                           autocomplete="off">
                                </label>
                                @if ($errors->has('type'))
                                    <span class="help-block">
                            <strong>{{ $errors->first('type') }}</strong>
                        </span>
                                @endif
                                <small id="typeHelp" class="form-text text-muted">Species / Animal</small>
                            </section>

                            <section class="col col-6">
                                <label class="label" for="variety">Variety:</label>
                                <label class="input">
                                    <input type="text"
                                           name="variety"
                                           value="{{ old('variety') }}"
                                           class="form-control"
                                           id="variety"
                                           aria-describedby="varietyHelp"
                                           placeholder="Variety of meat"
                                           autocomplete="off">
                                </label>
                                @if ($errors->has('variety'))
                                    <span class="help-block">
                            <strong>{{ $errors->first('variety') }}</strong>
                        </span>
                                @endif
                                <small id="varietyHelp" class="form-text text-muted">Cut or Format</small>
                            </section>
                        </div>
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