@extends('layouts.smartadmin.app')

@section('content')

    <h1>Payments: Add</h1>
    <form action="/admin/payments" method="POST">
        <?= csrf_field() ?>

            <div class="form-group">
                <div class="input-group">
                    <label for="customer_id">Customer:</label>
                    <select class="form-control"
                            name="customer_id"
                            id="customer_id"
                            aria-describedby="customer_idHelp">
                        @foreach($users as $user)
                        <option
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
                        <option value="cash">Cash</option>
                        <option value="stripe">Stripe</option>
                        <option value="paypal">Paypal</option>
                        <option value="eTransfer">eTransfer</option>
                        <option value="other">Other</option>
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
                           value="{{ old('amount_paid') }}"
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
                <small id="amount_paidHelp" class="form-text text-muted">How much?</small>
            </div>


            <div class="form-group">
                <div class="input-group">
                    <label for="received_at">Received At:</label>
                    <input type="text"
                           name="received_at"
                           value="{{ old('received_at') }}"
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

        <button type="submit" class="btn btn-primary">Add</button>

    </form>


@endsection