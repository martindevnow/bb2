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

                <form action="/admin/orders/{{ $order->id }}/shipped" method="POST">
                    <header>
                        Log a Shipment against this order:
                    </header>
                    <?= csrf_field() ?>

                    <fieldset>

                        <section class="col col-6">
                            <label for="courier_id">Courier:</label>
                            <label class="input">
                                <select class="form-control"
                                        name="courier_id"
                                        id="courier_id"
                                        aria-describedby="courier_idHelp">
                                    @foreach ($couriers as $courier)
                                    <option {{ old('courier_id') === $courier->id ? 'selected="selected"' : '' }} value="{{ $courier->id }}">{{ $courier->label }}</option>
                                    @endforeach
                                </select>
                            </label>
                            @if ($errors->has('courier_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('courier_id') }}</strong>
                                </span>
                            @endif
                            <small id="courier_idHelp" class="form-text text-muted">Who shipped it?</small>
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
                                       placeholder="Tracking Number..."
                                       autocomplete="off">
                            </label>
                            @if ($errors->has('tracking_number'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('tracking_number') }}</strong>
                                </span>
                            @endif
                            <small id="tracking_numberHelp" class="form-text text-muted">Tracking?</small>
                        </section>


                        <section class="col col-6">
                            <label for="instructions">Instructions:</label>
                            <label class="input">
                                <input type="text"
                                       name="instructions"
                                       value="{{ old('instructions') }}"
                                       class="form-control"
                                       id="instructions"
                                       aria-describedby="instructionsHelp"
                                       placeholder="Instructions for the courier..."
                                       autocomplete="off">
                            </label>
                            @if ($errors->has('instructions'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('instructions') }}</strong>
                                </span>
                            @endif
                            <small id="instructionsHelp" class="form-text text-muted">Anything special?</small>
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
                            <small id="shipped_atHelp" class="form-text text-muted">When?</small>
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