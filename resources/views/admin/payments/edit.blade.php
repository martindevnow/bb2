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
            <h2> Pets </h2>
            <!-- <div class="widget-toolbar">
            add: non-hidden - to disable auto hide

            </div>-->
            <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span></header>

        <!-- widget div-->
        <div role="content">

            <div class="widget-body no-padding smart-form">


                <form action="/admin/payments/{{ $payment->id }}" method="POST">
                    <header>
                        Modify a Payment: (ID: {{ $payment->id }})
                    </header>
                    <?= csrf_field() ?>
                    <input name="_method" type="hidden" value="PUT">
                    <fieldset>
                        <section class="col col-6">
                            <label for="customer_id">Customer:</label>
                            <label class="input">
                                <select class="form-control"
                                        name="customer_id"
                                        id="customer_id"
                                        aria-describedby="customer_idHelp">
                                    @foreach($users as $user)
                                        <option {{ $payment->customer_id === $user->id ? 'selected="selected"' : '' }}
                                                value="{{ $user->id }}"
                                        >
                                            {{ $user->name }} ({{ $user->id }})
                                        </option>
                                    @endforeach
                                </select>
                            </label>
                            @if ($errors->has('customer_id'))
                                <span class="help-block">
                            <strong>{{ $errors->first('customer_id') }}</strong>
                        </span>
                            @endif
                            <small id="customer_idHelp" class="form-text text-muted">Who paid you?</small>
                        </section>

                        {{--TODO: Need to add the paymentable type in here--}}


                        <section class="col col-6">
                            <label for="format">Method:</label>
                            <label class="input">
                                <select class="form-control"
                                        name="format"
                                        id="format"
                                        aria-describedby="formatHelp">
                                    <option {{ $payment->format === 'cash' ? 'selected="selected"' : '' }} value="cash">Cash</option>
                                    <option {{ $payment->format === 'stripe' ? 'selected="selected"' : '' }} value="stripe">Stripe</option>
                                    <option {{ $payment->format === 'paypal' ? 'selected="selected"' : '' }} value="paypal">Paypal</option>
                                    <option {{ $payment->format === 'eTransfer' ? 'selected="selected"' : '' }} value="eTransfer">eTransfer</option>
                                    <option {{ $payment->format === 'other' ? 'selected="selected"' : '' }} value="other">Other</option>
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
                                       value="{{ $payment->amount_paid }}"
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
                                       value="{{ $payment->received_at->format('Y-m-d') }}"
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