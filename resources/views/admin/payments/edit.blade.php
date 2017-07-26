@extends('layouts.smartadmin.app')

@section('content')

    <h1>Payments: Edit</h1>
    <form action="/admin/payments/{{ $payment->id }}" method="POST">
        <?= csrf_field() ?>
            <input name="_method" type="hidden" value="PUT">


            <div class="form-group">
                <div class="input-group">
                    <label for="customer_id">Customer:</label>
                    <select class="form-control"
                            name="customer_id"
                            id="customer_id"
                            aria-describedby="customer_idHelp">
                        @foreach($users as $user)
                            <option {{ $payment->customer->id === $user->id ? 'selected="selected"' : '' }}
                                    value="{{ $user->id }}"
                            >
                                {{ $user->name }} ({{ $user->id }})
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('customer_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('customer_id') }}</strong>
                        </span>
                    @endif
                </div>
                <small id="customer_idHelp" class="form-text text-muted">Who paid you?</small>
            </div>

            {{--TODO: Need to add the paymentable type in here--}}


            <div class="form-group">
                <div class="input-group">
                    <label for="format">Method:</label>
                    <select class="form-control"
                            name="format"
                            id="format"
                            aria-describedby="formatHelp">
                        <option {{ $payment->format === 'cash' ? 'selected="selected"' : '' }} value="cash">Cash</option>
                        <option {{ $payment->format === 'stripe' ? 'selected="selected"' : '' }}value="stripe">Stripe</option>
                        <option {{ $payment->format === 'paypal' ? 'selected="selected"' : '' }}value="paypal">Paypal</option>
                        <option {{ $payment->format === 'eTransfer' ? 'selected="selected"' : '' }}value="eTransfer">eTransfer</option>
                        <option {{ $payment->format === 'other' ? 'selected="selected"' : '' }}value="other">Other</option>
                    </select>
                    @if ($errors->has('format'))
                        <span class="help-block">
                            <strong>{{ $errors->first('format') }}</strong>
                        </span>
                    @endif
                </div>
                <small id="formatHelp" class="form-text text-muted">How?</small>
            </div>


            <div class="form-group">
                <div class="input-group">
                    <label for="amount_paid">Amount Paid:</label>
                    <input type="text"
                           name="amount_paid"
                           value="{{ $payment->amount_paid }}"
                           class="form-control"
                           id="amount_paid"
                           aria-describedby="amount_paidHelp"
                           placeholder="Amount Paid"
                           autocomplete="off">
                    @if ($errors->has('amount_paid'))
                        <span class="help-block">
                            <strong>{{ $errors->first('amount_paid') }}</strong>
                        </span>
                    @endif
                </div>
                <small id="amount_paidHelp" class="form-text text-muted">What appears on the website.</small>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <label for="received_at">Received At:</label>
                    <input type="text"
                           name="received_at"
                           value="{{ $payment->received_at->format('Y-m-d') }}"
                           class="form-control"
                           id="received_at"
                           aria-describedby="received_atHelp"
                           placeholder="YYYY-mm-dd"
                           autocomplete="off">
                    @if ($errors->has('received_at'))
                        <span class="help-block">
                            <strong>{{ $errors->first('received_at') }}</strong>
                        </span>
                    @endif
                </div>
                <small id="received_atHelp" class="form-text text-muted">When?</small>
            </div>


        <button type="submit" class="btn btn-primary" >Update</button>

    </form>


@endsection