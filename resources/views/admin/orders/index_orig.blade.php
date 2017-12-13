@extends('layouts.smartadmin.app')

@section('breadcrumb_left')
    <i class="fa-fw fa fa-home"></i> Dashboard <span>> Orders</span>
@endsection

@section('breadcrumb_right')

    <ul id="sparks" class="">
        <li class="sparks-info">
            <a href="/admin/orders/create">
                <button class="btn btn-block btn-primary">
                    <i class="fa fa-wrench"></i> Create New
                </button>
            </a>
        </li>
        <li class="sparks-info">
            <a href="/admin/orders/export/packing/2">
                <button class="btn btn-block btn-primary btn-lg">
                    <i class="fa fa-wrench"></i> Export Packing (Big)
                </button>
            </a>
        </li>
        <li class="sparks-info">
            <a href="/admin/orders/export/packing/4">
                <button class="btn btn-block btn-primary btn-sm">
                    <i class="fa fa-wrench"></i> Export Packing (Small)
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
            <h2> Orders </h2>
            <span class="jarviswidget-loader" style="display: none;"><i class="fa fa-refresh fa-spin"></i></span></header>

        <!-- widget div-->
        <div role="content">

            <!-- widget content -->
            <div class="widget-body no-padding">

                <div class="table-responsive">

                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr>
                            <td>Order Date</td>
                            <td>Customer</td>
                            <td>Meal Size</td>
                            <td>Package</td>
                            <td>Address</td>
                            <td># of Weeks</td>
                            <td>Total</td>
                            <td>Action</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>
                                    <a href="/admin/orders/{{ $order->id }}">
                                        {{ $order->created_at->format('Y-m-d') }}
                                    </a>
                                </td>
                                <td>({{ $order->plan->pet->name }}) {{ $order->customer->name }}</td>
                                <td>{{ round($order->plan->pet->mealSizeInGrams()) }} g</td>
                                <td>{{ $order->plan->package->label }}</td>
                                <td>{{ $order->deliveryAddress->toString() }}</td>
                                <td>{{ $order->plan->weeks_of_food_per_shipment }}</td>
                                <td>${{ $order->total_cost }}</td>
                                <td>
                                    @if($order->paid)
                                        <a href="/admin/payments/{{ $order->payments->first()->id }}">
                                            <button class="btn btn-success btn-xs">Paid</button>
                                        </a>
                                    @else
                                        {{--# TODO: make this open a modal... ?--}}
                                        <a href="/admin/orders/{{$order->id}}/paid">
                                            <button class="btn btn-danger btn-xs">Paid</button>
                                        </a>
                                    @endif

                                    @if($order->packed)
                                        <a href="#">
                                            <button class="btn btn-success btn-xs">Packed</button>
                                        </a>
                                    @else
                                        <a href="/admin/orders/{{ $order->id }}/packed">
                                            <button class="btn btn-danger btn-xs">Packed</button>
                                        </a>
                                    @endif

                                    @if($order->picked)
                                        <a href="#">
                                            <button class="btn btn-success btn-xs">Picked</button>
                                        </a>
                                    @else
                                        <a href="/admin/orders/{{ $order->id }}/picked">
                                            <button class="btn btn-danger btn-xs">Picked</button>
                                        </a>
                                    @endif

                                    @if($order->shipped)
                                        <a href="#">
                                            <button class="btn btn-success btn-xs">Shipped</button>
                                        </a>
                                    @else
                                        <a href="/admin/orders/{{ $order->id }}/shipped">
                                            <button class="btn btn-danger btn-xs">Shipped</button>
                                        </a>
                                    @endif

                                    @if($order->delivered)
                                        <a href="#">
                                            <button class="btn btn-success btn-xs">Delivered</button>
                                        </a>
                                    @else
                                        <a href="/admin/orders/{{ $order->id }}/delivered">
                                            <button class="btn btn-danger btn-xs">Delivered</button>
                                        </a>
                                    @endif

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