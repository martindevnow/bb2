@extends('layouts.smartadmin.print')

@section('header')
    <style>
        .order-pick-sheet {
            border: 1px solid black;
            margin-left: 1%;
            margin-right: 1%;
            width: 47%;
            padding-top: 1rem;
            display: inline-block;
            margin-top: 0;
            margin-bottom: auto;
            height: 100%;
        }

        .header {
            /*border: 1px dashed lightgrey;*/
        }
        .body {
            /*border: 1px dashed lightgrey;*/
        }
        .notes {
            /*border: 1px dashed lightgrey;*/
        }

        .col-sm-4 {
            display: inline-block;
        }


        .customer-name {
            display: inline-block;
            /*border: 1px dashed grey;*/
            width: 28%;
            margin-left: 1%;
            color: darkred;
        }

        .meal-weight {
            display: inline-block;
            /*border: 1px dashed grey;*/
            width: 18%;
            font-weight: 800;
        }

        .delivery-date {
            display: inline-block;
            /*border: 1px dashed grey;*/
            width: 48%;
            margin-right: 1%;
            color: darkorange;
        }


        .label {
            color: black;
            position: relative;
            top: -10px;
            left: -10px;
        }

        .label-top {
            color: black;
            position: relative;
            top: 0;
            left: -10px;
        }

        .value {
            position: relative;
            font-size: 3rem;
            margin-bottom: -12px;
            top: -8px;
        }
        .value-sm {
            font-size: 1.5rem;
        }
        .notes {
            padding-bottom: 1rem;
        }
        .table {
            margin-bottom: 0.5rem;
        }

        .package-name {
            color: blue;
            font-size: 2rem;
            font-weight: 800;
        }

        .table > tbody > tr > td {
            padding: 2px;
        }
        .table > thead > tr > td {
            padding: 4px;
        }

    </style>
@endsection


@section('content')
    @foreach($orders->chunk(2) as $orderRow)
        <div class="row">
            @foreach($orderRow as $order)
            <div class="col-sm-6 order-pick-sheet">
                <div class="row header">
                    <div class="customer-name col-sm-4">
                        <div class="label label-top">Name</div>
                        <div class="value">{{ $order->plan->pet->name }}</div>
                    </div>

                    <div class="meal-weight col-sm-3">
                        <div class="label label-top">Meal Size (g)</div>
                        <div class="value">{{ round($order->plan->pet->mealSizeInGrams()) }}</div>
                    </div>

                    <div class="delivery-date col-sm-5">
                        <div class="label label-top">Delivery Date</div>
                        <div class="value">{{ $order->deliver_by->format('D, M jS') }}</div>
                    </div>
                </div>
                <div class="body">
                    <table class="table table-bordered table-striped table-responsive">
                        <thead>
                        <tr>
                            <td><span class="package-name">{{ $order->plan->package->label }}</span> <i>Toppings</i></td>
                            <td># of Meals</td>
                            <td>Meat</td>
                            <td>Topp</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order->mealCounts() as $meal)
                            <tr>
                                <td><b>{{ $meal->meatsToString() }}</b> (<i>{{ $meal->toppingsToString() }}</i>)</td>
                                <td style="text-align: center">{{ $meal->count }}</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                    <div class="col-sm-12">
                        <div class="notes">

                        <div class="label label-top">Notes</div>
                        <div class="value value-sm">
                            @forelse($order->plan->notes as $note)
                            <em>{{ $note->content }}</em><br/>
                            @empty
                            <em>None</em>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>
            @endforeach
        </div>
    @endforeach
@endsection