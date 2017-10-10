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

                <form action="/admin/meats/order" method="POST">
                    <header>Generate a Meat Purchase Order
                    </header>

                    <?= csrf_field() ?>

                    <fieldset>
                        <div class="row">
                            <div class="col-sm-9">
                                Plan (Customer and Package)
                            </div>
                            <div class="col-sm-3">
                                # of Weeks
                            </div>
                        </div>
                        @foreach($plans as $plan)
                            <div class="row">
                                <div class="col-sm-1"></div>
                                <div class="col-sm-7">
                                    <b>{{ $plan->package->label }}</b> Bento for <u>{{ $plan->pet->name }}</u> <em>({{ $plan->customer->name }})</em>
                                </div>
                                <div class="col-sm-2">
                                    <input type="text"
                                           id="plan_id_{{ $plan->id }}"
                                           name="plan_id_{{ $plan->id }}"
                                           value="{{ $plan->weeks_of_food_per_shipment }}"
                                           class="form-control">
                                </div>
                                <div class="col-sm-2"></div>
                            </div>
                        @endforeach

                    </fieldset>

                    <footer>
                        <button type="submit" class="btn btn-primary">
                            Submit
                        </button>
                        <button type="button" class="btn btn-default" onclick="window.history.back();">
                            Back
                        </button>
                    </footer>

                </form>
            </div>
        </div>
    </div>


@endsection