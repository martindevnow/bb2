@extends('layouts.smartadmin.app')

@section('content')

    <div class="jarviswidget jarviswidget-color-blue jarviswidget-sortable" id="wid-id-4" data-widget-editbutton="false" data-widget-colorbutton="false" role="widget">

        <header role="heading"><div class="jarviswidget-ctrls" role="menu">   <a href="javascript:void(0);" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-delete-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Delete"><i class="fa fa-times"></i></a></div>
            <span class="widget-icon"> <i class="fa fa-check txt-color-white"></i> </span>
            <h2> Payments </h2>
            <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span></header>

        <!-- widget div-->
        <div role="content">

            <div class="widget-body no-padding smart-form">

                <form action="/admin/orders/{{ $order->id }}/delivered" method="POST">
                    <header>
                        Log a Delivery against this order:
                    </header>
                    <?= csrf_field() ?>

                    <fieldset>

                        <section class="col col-6">
                            <label for="delivered_at">Delivered On:</label>
                            <label class="input">
                                <input type="text"
                                       name="delivered_at"
                                       value="{{ old('delivered_at') }}"
                                       class="form-control"
                                       id="delivered_at"
                                       aria-describedby="delivered_atHelp"
                                       placeholder="YYYY-mm-dd"
                                       autocomplete="off">
                            </label>
                            @if ($errors->has('delivered_at'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('delivered_at') }}</strong>
                                </span>
                            @endif
                            <small id="delivered_atHelp" class="form-text text-muted">When?</small>
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