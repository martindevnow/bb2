@extends('layouts.smartadmin.app')

@section('breadcrumb_left')
    <i class="fa-fw fa fa-home"></i> Dashboard <span>> Meals</span>
@endsection

@section('breadcrumb_right')

    <ul id="sparks" class="">
        <li class="sparks-info">
            <a href="/admin/meals/create">
                <button class="btn btn-block btn-primary">
                    <i class="fa fa-wrench"></i> Create New
                </button>
            </a>
        </li>
    </ul>

@endsection

@section('content')

    <div class="jarviswidget  jarviswidget-sortable jarviswidget-color-blue" id="wid-id-1" data-widget-editbutton="false" role="widget" data-widget-attstyle="jarviswidget-color-blue">
        <!-- widget options:
        usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

        data-widget-colorbutton="false"
        data-widget-editbutton="false"
        data-widget-togglebutton="false"
        data-widget-deletebutton="false"
        data-widget-fullscreenbutton="false"
        data-widget-custombutton="false"
        data-widget-collapsed="true"
        data-widget-sortable="false"

        -->
        <header role="heading">
            <div class="jarviswidget-ctrls" role="menu">
                <a href="javascript:void(0);" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus "></i></a>
                <a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand "></i></a>
                <a href="javascript:void(0);" class="button-icon jarviswidget-delete-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Delete"><i class="fa fa-times"></i></a>
            </div>
            <span class="widget-icon"> <i class="fa fa-table"></i> </span>
            <h2> Meals </h2>
            <span class="jarviswidget-loader" style="display: none;"><i class="fa fa-refresh fa-spin"></i></span></header>

        <!-- widget div-->
        <div role="content">

            <!-- widget edit box -->
            <div class="jarviswidget-editbox">
                <!-- This area used as dropdown edit box -->

            </div>
            <!-- end widget edit box -->

            <!-- widget content -->
            <div class="widget-body">

                {{--<div class="alert alert-info no-margin fade in">--}}
                {{--<button class="close" data-dismiss="alert">--}}
                {{--×--}}
                {{--</button>--}}
                {{--<i class="fa-fw fa fa-info"></i>--}}
                {{--Adds zebra-striping to table row within <code>&lt;table&gt;</code> by adding the <code>.table-striped</code> with the base class--}}
                {{--</div>--}}

                <div class="table-responsive">

                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr>
                            <td>Code</td>
                            <td>Label</td>
                            <td>Meal Value</td>
                            <td>Average Cost Per Pound</td>
                            <td>Action</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{ $meal->code }}</td>
                            <td>{{ $meal->label }}</td>
                            <td>{{ $meal->meal_value }}</td>
                            <td>{{ $meal->costPerLb() }}</td>
                            <td>
                                <a href="/admin/meals/{{ $meal->id }}/edit">
                                    <button class="btn btn-primary btn-xs">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                </a>
                                <form action="/admin/meals/{{ $meal->id }}" method="POST">
                                    <?= csrf_field() ?>
                                    <input name="_method" type="hidden" value="DELETE">
                                    <input name="meal_id" type="hidden" value="{{ $meal->id }}">
                                    <button class="btn btn-xs btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
            <!-- end widget content -->

        </div>
        <!-- end widget div -->

    </div>


    <div class="row">
        <div class="col-md-6">

            <div class="jarviswidget  jarviswidget-sortable jarviswidget-color-blue" id="wid-id-1" data-widget-editbutton="false" role="widget" data-widget-attstyle="jarviswidget-color-blue">
                <!-- widget options:
                usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

                data-widget-colorbutton="false"
                data-widget-editbutton="false"
                data-widget-togglebutton="false"
                data-widget-deletebutton="false"
                data-widget-fullscreenbutton="false"
                data-widget-custombutton="false"
                data-widget-collapsed="true"
                data-widget-sortable="false"

                -->
                <header role="heading">
                    <div class="jarviswidget-ctrls" role="menu">
                        <a href="javascript:void(0);" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus "></i></a>
                        <a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand "></i></a>
                        <a href="javascript:void(0);" class="button-icon jarviswidget-delete-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Delete"><i class="fa fa-times"></i></a>
                    </div>
                    <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                    <h2> Meals </h2>
                    <span class="jarviswidget-loader" style="display: none;"><i class="fa fa-refresh fa-spin"></i></span></header>

                <!-- widget div-->
                <div role="content">

                    <!-- widget edit box -->
                    <div class="jarviswidget-editbox">
                        <!-- This area used as dropdown edit box -->

                    </div>
                    <!-- end widget edit box -->

                    <!-- widget content -->
                    <div class="widget-body no-padding">

                        {{--<div class="alert alert-info no-margin fade in">--}}
                        {{--<button class="close" data-dismiss="alert">--}}
                        {{--×--}}
                        {{--</button>--}}
                        {{--<i class="fa-fw fa fa-info"></i>--}}
                        {{--Adds zebra-striping to table row within <code>&lt;table&gt;</code> by adding the <code>.table-striped</code> with the base class--}}
                        {{--</div>--}}

                        <div class="table-responsive">

                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <td>Meat</td>
                                    <td>Cost per lb</td>
                                    <td>Action</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($meats as $meat)
                                    <tr>
                                        <td>{{ $meat->type }} {{ $meat->variety }} [{{ $meat->code }}]</td>
                                        <td>{{ $meat->cost_per_lb }}</td>
                                        <td>
                                            @if ( ! $meal->hasMeat($meat))
                                                <form action="/admin/meals/{{ $meal->id }}/addMeat" method="POST">
                                                    <?= csrf_field() ?>
                                                    <input name="_method" type="hidden" value="POST">
                                                    <input name="meat_id" type="hidden" value="{{ $meat->id }}">
                                                    <button class="btn btn-xs btn-primary"
                                                            id="add-meat-id-{{ $meat->id }}"
                                                    >
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <form action="/admin/meals/{{ $meal->id }}/removeMeat" method="POST">
                                                    <?= csrf_field() ?>
                                                    <input name="_method" type="hidden" value="POST">
                                                    <input name="meat_id" type="hidden" value="{{ $meat->id }}">
                                                    <button class="btn btn-xs btn-danger"
                                                            id="remove-meat-id-{{ $meat->id }}"
                                                    >
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                </form>
                                            @endif

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

        </div>
        <div class="col-md-6">
            <div class="jarviswidget  jarviswidget-sortable jarviswidget-color-blue" id="wid-id-1" data-widget-editbutton="false" role="widget" data-widget-attstyle="jarviswidget-color-blue">
                <!-- widget options:
                usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

                data-widget-colorbutton="false"
                data-widget-editbutton="false"
                data-widget-togglebutton="false"
                data-widget-deletebutton="false"
                data-widget-fullscreenbutton="false"
                data-widget-custombutton="false"
                data-widget-collapsed="true"
                data-widget-sortable="false"

                -->
                <header role="heading">
                    <div class="jarviswidget-ctrls" role="menu">
                        <a href="javascript:void(0);" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus "></i></a>
                        <a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand "></i></a>
                        <a href="javascript:void(0);" class="button-icon jarviswidget-delete-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Delete"><i class="fa fa-times"></i></a>
                    </div>
                    <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                    <h2> Meals </h2>
                    <span class="jarviswidget-loader" style="display: none;"><i class="fa fa-refresh fa-spin"></i></span></header>

                <!-- widget div-->
                <div role="content">

                    <!-- widget edit box -->
                    <div class="jarviswidget-editbox">
                        <!-- This area used as dropdown edit box -->

                    </div>
                    <!-- end widget edit box -->

                    <!-- widget content -->
                    <div class="widget-body no-padding">

                        {{--<div class="alert alert-info no-margin fade in">--}}
                        {{--<button class="close" data-dismiss="alert">--}}
                        {{--×--}}
                        {{--</button>--}}
                        {{--<i class="fa-fw fa fa-info"></i>--}}
                        {{--Adds zebra-striping to table row within <code>&lt;table&gt;</code> by adding the <code>.table-striped</code> with the base class--}}
                        {{--</div>--}}

                        <div class="table-responsive">

                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <td>Topping</td>
                                    <td>Cost Per Kg</td>
                                    <td>Action</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($toppings as $topping)
                                    <tr>
                                        <td>{{ $topping->label }} [{{ $topping->code }}]</td>
                                        <td>{{ $topping->cost_per_kg }}</td>
                                        <td>
                                            @if (! $meal->hasTopping($topping))
                                                <form action="/admin/meals/{{ $meal->id }}/addTopping" method="POST">
                                                    <?= csrf_field() ?>
                                                    <input name="_method" type="hidden" value="POST">
                                                    <input name="topping_id" type="hidden" value="{{ $topping->id }}">
                                                    <button class="btn btn-xs btn-primary"
                                                            id="add-topping-id-{{ $topping->id }}"
                                                    >
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <form action="/admin/meals/{{ $meal->id }}/removeTopping" method="POST">
                                                    <?= csrf_field() ?>
                                                    <input name="_method" type="hidden" value="POST">
                                                    <input name="topping_id" type="hidden" value="{{ $topping->id }}">
                                                    <button class="btn btn-xs btn-danger"
                                                            id="remove-topping-id-{{ $topping->id }}"
                                                    >
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                </form>
                                            @endif
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
        </div>

    </div>



@endsection