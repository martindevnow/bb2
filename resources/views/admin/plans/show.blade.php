@extends('layouts.smartadmin.app')

@section('breadcrumb_left')
    <i class="fa-fw fa fa-home"></i> Dashboard <span>> Plans</span>
@endsection

@section('breadcrumb_right')

    <ul id="sparks" class="">
        <li class="sparks-info">
            <a href="/admin/plans/create">
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
            <h2> Plan: For {{ $plan->customer->name }} </h2>
            <span class="jarviswidget-loader" style="display: none;"><i class="fa fa-refresh fa-spin"></i></span></header>

        <!-- widget div-->
        <div role="content">

            <!-- widget content -->
            <div class="widget-body no-padding">

                <div class="table-responsive">

                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr>
                            <td>Field</td>
                            <td>Value</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Customer</td>
                            <td>{{ $plan->customer->name }}</td>
                        </tr>
                        <tr>
                            <td>Pet</td>
                            <td>{{ $plan->pet->name }}</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>{{ $plan->deliveryAddress->toString() }}</td>
                        </tr>
                        <tr>
                            <td>Shipping Cost</td>
                            <td>$ {{ $plan->shipping_cost }}</td>
                        </tr>
                        <tr>
                            <td>Pet Weight</td>
                            <td>{{ $plan->pet_weight }} lb</td>
                        </tr>
                        <tr>
                            <td>Pet Activity Level</td>
                            <td>{{ $plan->pet_activity_level }} %</td>
                        </tr>
                        <tr>
                            <td>Package</td>
                            <td>{{ $plan->package->label }}</td>
                        </tr>
                        <tr>
                            <td>Package Base</td>
                            <td>$ {{ $plan->package_base }}</td>
                        </tr>
                        <tr>
                            <td>Weekly Cost</td>
                            <td>$ {{ $plan->weekly_cost }}</td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
            <!-- end widget content -->

        </div>
        <!-- end widget div -->

    </div>

@endsection