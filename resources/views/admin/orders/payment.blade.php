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

                <form action="/admin/orders/{{ $order->id }}/paid" method="POST">
                    <header>
                        Log a Payment against this order:
                    </header>
                    <?= csrf_field() ?>

                    <fieldset>

                        <section class="col col-6">
                            <label for="format">Method:</label>
                            <label class="input">
                                <select class="form-control"
                                        name="format"
                                        id="format"
                                        aria-describedby="formatHelp">
                                    <option {{ old('format') === 'cash' ? 'selected="selected"' : '' }} value="cash">Cash</option>
                                    <option {{ old('format') === 'stripe' ? 'selected="selected"' : '' }} value="stripe">Stripe</option>
                                    <option {{ old('format') === 'paypal' ? 'selected="selected"' : '' }} value="paypal">Paypal</option>
                                    <option {{ old('format') === 'e-transfer' ? 'selected="selected"' : '' }} value="e-transfer">eTransfer</option>
                                    <option {{ old('format') === 'interac' ? 'selected="selected"' : '' }} value="interac">Interac</option>
                                </select>
                            </label>
                            @if ($errors->has('format'))
                                <span class="help-block">
                            <strong>{{ $errors->first('format') }}</strong>
                        </span>
                            @endif
                            <small id="formatHelp" class="form-text text-muted">How?</small>
                        </section>


                        <section class="col col-6">
                            <label for="amount_paid">Amount Paid:</label>
                            <label class="input">
                                <input type="text"
                                       name="amount_paid"
                                       value="{{ old('amount_paid') }}"
                                       class="form-control"
                                       id="amount_paid"
                                       aria-describedby="amount_paidHelp"
                                       placeholder="Amount Paid"
                                       autocomplete="off">
                            </label>
                            @if ($errors->has('amount_paid'))
                                <span class="help-block">
                            <strong>{{ $errors->first('amount_paid') }}</strong>
                        </span>
                            @endif
                            <small id="amount_paidHelp" class="form-text text-muted">How much?</small>
                        </section>


                        <section class="col col-6">
                            <label for="received_at">Received At:</label>
                            <label class="input">
                                <input type="text"
                                       name="received_at"
                                       value="{{ old('received_at') }}"
                                       class="form-control"
                                       id="received_at"
                                       aria-describedby="received_atHelp"
                                       placeholder="YYYY-mm-dd"
                                       autocomplete="off">
                            </label>
                            @if ($errors->has('received_at'))
                                <span class="help-block">
                            <strong>{{ $errors->first('received_at') }}</strong>
                        </span>
                            @endif
                            <small id="received_atHelp" class="form-text text-muted">When?</small>
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