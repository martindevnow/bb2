@extends('layouts.smartadmin.app')

@section('content')

    <div class="jarviswidget jarviswidget-color-blue jarviswidget-sortable" id="wid-id-4" data-widget-editbutton="false" data-widget-colorbutton="false" role="widget">

        <header role="heading"><div class="jarviswidget-ctrls" role="menu">   <a href="javascript:void(0);" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-delete-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Delete"><i class="fa fa-times"></i></a></div>
            <span class="widget-icon"> <i class="fa fa-check txt-color-white"></i> </span>
            <h2> Packages </h2>
            <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
        </header>

        <!-- widget div-->
        <div role="content">

            <div class="widget-body no-padding smart-form">

                <form action="/admin/packages/{{ $package->id }}" method="POST">
                    <header>
                        Edit the Package: {{ $package->label }}
                    </header>
                    <?= csrf_field() ?>
                    <input name="_method" type="hidden" value="PUT">

                    <fieldset>
                        <section class="col col-6">
                            <label class="label" for="code">Code:</label>
                            <label class="input">
                                <input type="text"
                                       name="code"
                                       value="{{ $package->code }}"
                                       class="form-control"
                                       id="code"
                                       aria-describedby="codeHelp"
                                       placeholder="Code"
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
                            <label class="label" for="label">Label:</label>
                            <label class="input">
                                <input type="text"
                                       name="label"
                                       value="{{ $package->label }}"
                                       class="form-control"
                                       id="label"
                                       aria-describedby="labelHelp"
                                       placeholder="Label"
                                       autocomplete="off">
                            </label>
                            @if ($errors->has('label'))
                                <span class="help-block">
                            <strong>{{ $errors->first('label') }}</strong>
                        </span>
                            @endif
                            <small id="labelHelp" class="form-text text-muted">What appears on the website.</small>
                        </section>

                        <section class="col col-6">
                            <label class="label" for="level">Level:</label>
                            <label class="input">
                                <input type="text"
                                       name="level"
                                       value="{{ $package->level }}"
                                       class="form-control"
                                       id="level"
                                       aria-describedby="levelHelp"
                                       placeholder="level"
                                       autocomplete="off">
                            </label>
                            @if ($errors->has('level'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('level') }}</strong>
                                </span>
                            @endif
                            <small id="levelHelp" class="form-text text-muted">What tier is this?</small>
                        </section>

                        <section class="col col-6">
                            <label class="label">Features</label>
                            <div class="inline-group">
                                <label class="checkbox">
                                    <input type="checkbox"
                                           name="customization"
                                           {{ $package->customization?'checked="checked"':'' }}
                                    />
                                    <i></i>Customization?</label>
                            </div>
                            @if ($errors->has('customization'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('customization') }}</strong>
                                </span>
                            @endif
                            <small id="customizationHelp" class="form-text text-muted">
                                Is this Package a customization on a normal package?</small>
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