@extends('layouts.smartadmin.app')

@section('content')

    <div class="jarviswidget jarviswidget-color-blue jarviswidget-sortable" id="wid-id-4" data-widget-editbutton="false" data-widget-colorbutton="false" role="widget">

        <header role="heading"><div class="jarviswidget-ctrls" role="menu">   <a href="javascript:void(0);" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-delete-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Delete"><i class="fa fa-times"></i></a></div>
            <span class="widget-icon"> <i class="fa fa-check txt-color-white"></i> </span>
            <h2> Meats - Purchase Order </h2>
            <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span></header>

        <!-- widget div-->
        <div role="content">

            <div class="widget-body smart-form">


                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-6">
                        <table class="table table-responsive table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Meat</th>
                                <th>Weight in Lbs</th>
                                <th>Cost per LB</th>
                                <th>Extended Cost</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($total = 0)
                            @foreach($po->details as $detail)
                                @php($meat = $detail->purchasable)
                                <tr>
                                    <td>{{ $meat->type }} ({{ $meat->variety }})</td>
                                    <td>{{ round($detail->quantity / 454, 2) }} lbs</td>
                                    <td>${{ round($meat->cost_per_lb, 2) }}</td>
                                    <td>${{ round($detail->quantity / 454 * $meat->cost_per_lb, 2) }}</td>
                                </tr>
                                @php($total += $detail->quantity / 454 * $meat->cost_per_lb)
                            @endforeach
                            <tr>
                                <td colspan="4">Total: ${{ round($total, 2) }}</td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-3"></div>
                </div>



            </div>
        </div>
    </div>


@endsection