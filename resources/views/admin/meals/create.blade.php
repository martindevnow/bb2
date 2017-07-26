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
            <h2> Meals </h2>
            <!-- <div class="widget-toolbar">
            add: non-hidden - to disable auto hide

            </div>-->
            <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span></header>

        <!-- widget div-->
        <div role="content">

            <div class="widget-body no-padding smart-form">




                <form action="/admin/meals" method="POST">
                    <header>
                        Create a Meal:
                    </header>
                    <?= csrf_field() ?>

                    <fieldset>

                        <section class="col col-4">
                            <label class="label" for="code">Code:</label>
                            <label class="input">
                                <input type="text"
                                       name="code"
                                       value="{{ old('code') }}"
                                       class="form-control"
                                       id="code"
                                       aria-describedby="codeHelp"
                                       placeholder="Code of the meal"
                                       autocomplete="off">
                            </label>
                            @if ($errors->has('code'))
                                <span class="help-block">
                            <strong>{{ $errors->first('code') }}</strong>
                        </span>
                            @endif
                            <small id="codeHelp" class="form-text text-muted">Must be unique</small>
                        </section>

                        <section class="col col-4">
                            <label class="label" for="label">Label:</label>
                            <label class="input">
                                <input type="text"
                                       name="label"
                                       value="{{ old('label') }}"
                                       class="form-control"
                                       id="label"
                                       aria-describedby="labelHelp"
                                       placeholder="Label of meal"
                                       autocomplete="off">
                            </label>
                            @if ($errors->has('label'))
                                <span class="help-block">
                            <strong>{{ $errors->first('label') }}</strong>
                        </span>
                            @endif
                            <small id="labelHelp" class="form-text text-muted">What will appear on the website.</small>
                        </section>

                        <section class="col col-4">
                            <label class="label" for="meal_value">Meal Value:</label>
                            <label class="input">
                                <input type="text"
                                       name="meal_value"
                                       value="{{ old('meal_value') }}"
                                       class="form-control"
                                       id="meal_value"
                                       aria-describedby="meal_valueHelp"
                                       placeholder="1 or 2"
                                       autocomplete="off">
                            </label>
                            @if ($errors->has('meal_value'))
                                <span class="help-block">
                            <strong>{{ $errors->first('meal_value') }}</strong>
                        </span>
                            @endif
                            <small id="meal_valueHelp" class="form-text text-muted">1 = one meal, 2 = one day's worth of food</small>
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