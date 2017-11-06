@extends('layouts.smartadmin.print')

@section('header')
    <style>
        @if ($perPage == 2)
            html { font-size: 90%; }
        @endif
        .order-pick-sheet {
            border: 1px solid black;
            padding-top: 1rem;
            display: inline-block;
            height: 100%;
        @if ($perPage == 2)
            width: 98%;
            margin: 0 1%;
        @else
            width: 48%;
            margin: 0 1%;
        @endif
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
            width: 24%;
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
            width: 54%;
            margin-right: 1%;
            color: darkorange;
        }


        .label {
            color: black;
            position: relative;
            top: -10px;
            left: -10px;
            font-size: 1.2rem;
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
            border: 1px solid black;
        }

        .package-name {
            color: blue;
            font-size: 2rem;
            font-weight: 800;
        }

        .table > tbody > tr > td {
            padding: 0.5rem;
            font-size: 1.5rem;
            border: 1px solid black;
        }
        .table > thead > tr > td {
            padding: 0.75rem;
            font-size: 1.7rem;
            border: 1px solid black;
        }

    </style>
@endsection


@section('content')
    @foreach($orders->chunk($perPage / 2) as $orderRow)
        <div class="row">
            @foreach($orderRow as $order)
            <div class="col-sm-{{ 24 / $perPage }} order-pick-sheet">
                <div class="row header">
                    <div class="customer-name col-sm-4">
                        <div class="label label-top">Name</div>
                        <div class="value">{{ $order->plan->pet->name }}</div>
                    </div>

                    <div class="meal-weight col-sm-3">
                        <div class="label label-top">Meal Size (g)</div>
                        <div class="value">{{ round($order->plan->pet->mealSizeInGrams()) }} (x {{ $order->plan->pet->daily_meals }} daily meals)</div>
                    </div>

                    <div class="delivery-date col-sm-5">
                        <div class="label label-top">Delivery Date</div>
                        <div class="value">{{ $order->deliver_by->format('D, M jS') }} [{{ $order->plan->weeks_of_food_per_shipment }} wk(s) of food]</div>
                    </div>
                </div>
                <div class="body">
                    <table class="table table-bordered table-striped table-responsive">
                        <thead>
                        <tr>
                            <td><span class="package-name">{{ $order->plan->package->label }}</span> <i>Toppings</i> -- [{{ $order->plan->weeks_of_food_per_shipment * 7 * $order->plan->pet->daily_meals }} total meals]</td>
                            <td>#</td>
                            <td>M</td>
                            <td>T</td>
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
                            <ul>
                            @forelse($order->plan->notes as $note)
                            <li><em>{{ $note->content }}</em></li>
                            @empty
                                @if ($order->plan->comment)
                                    <li><em>{{ $order->plan->comment }}</em></li>
                                @else
                                    <li><em>-</em></li>
                                @endif
                            @endforelse
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            @endforeach
        </div>
    @endforeach
@endsection