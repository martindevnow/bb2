@extends('layouts.smartadmin.app')

@section('breadcrumb_left')
    <i class="fa-fw fa fa-home"></i> Dashboard <span>> Packages</span>
@endsection

@section('breadcrumb_right')

    <ul id="sparks" class="">
        <li class="sparks-info">
            <a href="/admin/packages/create">
                <button class="btn btn-block btn-primary">
                    <i class="fa fa-wrench"></i> Create New
                </button>
            </a>
        </li>
    </ul>

@endsection

@section('content')

    <div class="jarviswidget  jarviswidget-sortable jarviswidget-color-blue" id="wid-id-1" data-widget-editbutton="false" role="widget" data-widget-attstyle="jarviswidget-color-blue">

        <header role="heading">
            <div class="jarviswidget-ctrls" role="menu">
                <a href="javascript:void(0);" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus "></i></a>
                <a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand "></i></a>
                <a href="javascript:void(0);" class="button-icon jarviswidget-delete-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Delete"><i class="fa fa-times"></i></a>
            </div>
            <span class="widget-icon"> <i class="fa fa-table"></i> </span>
            <h2> Packages </h2>
            <span class="jarviswidget-loader" style="display: none;"><i class="fa fa-refresh fa-spin"></i></span></header>

        <!-- widget div-->
        <div role="content">

            <!-- widget content -->
            <div class="widget-body">

                <div class="table-responsive">

                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr>
                            <td>ID</td>
                            <td>Customer</td>
                            <td>Plan (Package)</td>
                            <td>Address</td>
                            <td>Total</td>
                            <td>Action</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <a href="/admin/orders/{{ $order->id }}">
                                    {{ $order->id }}
                                </a>
                            </td>
                            <td>{{ $order->customer->name }}</td>
                            <td>{{ $order->plan->id }} ({{ $order->plan->package->label }})</td>
                            <td>{{ $order->deliveryAddress
                                ? $order->deliveryAddress->toString()
                                : '' }}</td>
                            <td>$ {{ $order->total_cost }}</td>
                            <td>
                                <a href="/admin/orders/{{ $order->id }}/edit">
                                    <button class="btn btn-primary btn-xs">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                </a>

                                <form action="/admin/orders/{{ $order->id }}" method="POST">
                                    <?= csrf_field() ?>
                                    <input name="_method" type="hidden" value="DELETE">
                                    <input name="order_id" type="hidden" value="{{ $order->id }}">
                                    <button class="btn btn-xs btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        </tbody>
                    </table>


                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr>
                            <td>Meals to Pack ({{ $order->plan->pet->mealSizeInGrams() }} g) (Total Meals: {{ $order->plan->weeks_of_food_per_shipment * 14 }})</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($meals as $meal)
                            <tr>
                                <td>{{ $meal->label }} x {{ $meal->count }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
            <!-- end widget content -->

        </div>
        <!-- end widget div -->

    </div>

@endsection