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
            <h2> Deliveries </h2>
            <!-- <div class="widget-toolbar">
            add: non-hidden - to disable auto hide

            </div>-->
            <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span></header>

        <!-- widget div-->
        <div role="content">

            <div class="widget-body no-padding smart-form">

                <form action="/admin/deliveries" method="POST">
                    <header>
                        Log a Delivery:
                    </header>
                    <?= csrf_field() ?>

                    <fieldset>
                        <section class="col col-6">
                            <label for="recipient_id">Recipient:</label>
                            <label class="input">
                                <select class="form-control"
                                        name="recipient_id"
                                        id="recipient_id"
                                        aria-describedby="recipient_idHelp">
                                    @foreach($users as $user)
                                        <option {{ old('recipient_id') === $user->id ? 'selected="selected"' : '' }}
                                                value="{{ $user->id }}"
                                        >
                                            {{ $user->name }} ({{ $user->id }})
                                        </option>
                                    @endforeach
                                </select>
                            </label>
                            @if ($errors->has('recipient_id'))
                                <span class="help-block">
                            <strong>{{ $errors->first('recipient_id') }}</strong>
                        </span>
                            @endif
                            <small id="recipient_idHelp" class="form-text text-muted">Who is it for?</small>
                        </section>

                        <section class="col col-6">
                            <label for="order_id">Order:</label>
                            <label class="input">
                                <select class="form-control"
                                        name="order_id"
                                        id="order_id"
                                        aria-describedby="order_idHelp">
                                    @foreach($orders as $order)
                                        <option {{ old('order_id') === $order->id ? 'selected="selected"' : '' }}
                                                value="{{ $order->id }}"
                                        >
                                            {{ $order->id }} for {{ $order->customer->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </label>
                            @if ($errors->has('order_id'))
                                <span class="help-block">
                            <strong>{{ $errors->first('order_id') }}</strong>
                        </span>
                            @endif
                            <small id="order_idHelp" class="form-text text-muted">Which order was shipped?</small>
                        </section>

                        <section class="col col-6">
                            <label for="courier_id">Courier:</label>
                            <label class="input">
                                <select class="form-control"
                                        name="courier_id"
                                        id="courier_id"
                                        aria-describedby="courier_idHelp">
                                    @foreach($couriers as $courier)
                                        <option {{ old('courier_id') === $courier->id ? 'selected="selected"' : '' }}
                                                value="{{ $courier->id }}"
                                        >
                                            {{ $courier->label }}
                                        </option>
                                    @endforeach
                                </select>
                            </label>
                            @if ($errors->has('courier_id'))
                                <span class="help-block">
                            <strong>{{ $errors->first('courier_id') }}</strong>
                        </span>
                            @endif
                            <small id="courier_idHelp" class="form-text text-muted">Who delivered it?</small>
                        </section>

                        <section class="col col-6">
                            <label for="shipped_at">Shipped At:</label>
                            <label class="input">
                                <input type="text"
                                       name="shipped_at"
                                       value="{{ old('shipped_at') }}"
                                       class="form-control"
                                       id="shipped_at"
                                       aria-describedby="shipped_atHelp"
                                       placeholder="YYYY-mm-dd"
                                       autocomplete="off">
                            </label>
                            @if ($errors->has('shipped_at'))
                                <span class="help-block">
                            <strong>{{ $errors->first('shipped_at') }}</strong>
                        </span>
                            @endif
                            <small id="shipped_atHelp" class="form-text text-muted">When was it shipped?</small>
                        </section>

                        <section class="col col-6">
                            <label for="delivered_at">Delivered At:</label>
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
                            <small id="delivered_atHelp" class="form-text text-muted">When was it delivered?</small>
                        </section>

                        <section class="col col-6">
                            <label for="tracking_number">Tracking Number:</label>
                            <label class="input">
                                <input type="text"
                                       name="tracking_number"
                                       value="{{ old('tracking_number') }}"
                                       class="form-control"
                                       id="tracking_number"
                                       aria-describedby="tracking_numberHelp"
                                       placeholder="####"
                                       autocomplete="off">
                            </label>
                            @if ($errors->has('tracking_number'))
                                <span class="help-block">
                            <strong>{{ $errors->first('tracking_number') }}</strong>
                        </span>
                            @endif
                            <small id="tracking_numberHelp" class="form-text text-muted">What is the tracking number?</small>
                        </section>

                        <section class="col col-6">
                            <label for="instructions">Delivery Instructions:</label>
                            <label class="input">
                                <input type="text"
                                       name="instructions"
                                       value="{{ old('instructions') }}"
                                       class="form-control"
                                       id="instructions"
                                       aria-describedby="instructionsHelp"
                                       placeholder="Anything?"
                                       autocomplete="off">
                            </label>
                            @if ($errors->has('instructions'))
                                <span class="help-block">
                            <strong>{{ $errors->first('instructions') }}</strong>
                        </span>
                            @endif
                            <small id="instructionsHelp" class="form-text text-muted">Any special instructions?</small>
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