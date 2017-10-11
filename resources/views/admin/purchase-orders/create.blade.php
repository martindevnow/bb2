@extends('layouts.smartadmin.app')

@section('content')

    <div class="jarviswidget jarviswidget-color-blue jarviswidget-sortable" id="wid-id-4" data-widget-editbutton="false" data-widget-colorbutton="false" role="widget">

        <header role="heading"><div class="jarviswidget-ctrls" role="menu">   <a href="javascript:void(0);" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-delete-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Delete"><i class="fa fa-times"></i></a></div>
            <span class="widget-icon"> <i class="fa fa-check txt-color-white"></i> </span>
            <h2> Meats - Purchase Order </h2>
            <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span></header>

        <!-- widget div-->
        <div role="content">

            <div class="widget-body no-padding smart-form">

                <form action="/admin/purchase-orders" method="POST">
                    <header>Generate a Meat Purchase Order</header>

                    <?= csrf_field() ?>

                    <fieldset>
                        <table class="table table-bordered table-striped table-responsive">
                            <thead>
                            <tr>
                                <th>Plan</th>
                                <th>Dog (Weight)</th>
                                <th># of Weeks</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($plans as $plan)

                                <tr>
                                <td><b>{{ $plan->package->label }}</b> Bento (<em>{{ $plan->customer->name }}</em>)</td>
                                <td><u>{{ $plan->pet->name }}</u> ({{ $plan->pet_weight }} lb)</td>
                                <td>
                                    <div class="col-sm-2">
                                        <input type="text"
                                               id="plan_id_{{ $plan->id }}"
                                               name="plan_id[{{ $plan->id }}]"
                                               value="{{ $plan->weeks_of_food_per_shipment }}"
                                               class="form-control">
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>

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