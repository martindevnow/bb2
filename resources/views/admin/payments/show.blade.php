@extends('layouts.smartadmin.app')

@section('content')

    <h1>Payments: Details</h1>
    <div class="row">

        <table class="table table-responsive table-striped table-bordered">
            <thead>
            <tr>
                <td>Customer</td>
                <td>Amount Paid</td>
                <td>Format</td>
                <td>Action</td>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $payment->customer->name }}</td>
                    <td>{{ $payment->amount_paid }}</td>
                    <td>{{ $payment->format }}</td>
                    <td>
                        <a href="/admin/payments/{{ $payment->id }}/edit">
                            <button class="btn btn-primary btn-xs">
                                <i class="fa fa-pencil"></i>
                            </button>
                        </a>
                        <form action="/admin/payments/{{ $payment->id }}" method="POST">
                            <?= csrf_field() ?>
                            <input name="_method" type="hidden" value="DELETE">
                            <input name="payment_id" type="hidden" value="{{ $payment->id }}">
                            <button class="btn btn-xs btn-danger">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

@endsection