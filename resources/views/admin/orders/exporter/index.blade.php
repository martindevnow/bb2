@extends('layouts.smartadmin.app')

@section('breadcrumb_left')
    <i class="fa-fw fa fa-home"></i> Dashboard > Orders <span>> Exporter</span>
@endsection

@section('breadcrumb_right')


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

                <form action="/admin/orders/exporter/prepare" method="POST">
                    {{ csrf_field() }}
                    <fieldset>


                        <div class="form-group">
                            <label class="col-md-2 control-label">Purpose</label>
                            <div class="col-md-10">
                                <label class="radio radio-inline">

                                    <input type="radio" class="radiobox" name="purpose" value="ordering_meat">
                                    <span>Ordering Meat</span>

                                </label>
                                <label class="radio radio-inline">
                                    <input type="radio" class="radiobox" name="purpose" value="packing_orders">
                                    <span>Packing Orders</span>
                                </label>

                            </div>
                        </div>


                        <div class="form-group">
                            <label>Include Orders Shipping Out By....</label>
                            <input type="date" name="shipping_out_by">
                        </div>

                    </fieldset>


                    <button class="btn btn-primary">Prepare</button>
                </form>

            </div>
            <!-- end widget content -->

        </div>
        <!-- end widget div -->

    </div>

@endsection