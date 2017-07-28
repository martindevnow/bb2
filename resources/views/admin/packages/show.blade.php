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
            <h2> Packages </h2>
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
                            <td>Code</td>
                            <td>Label</td>
                            <td>Cost Per Lb</td>
                            <td>Action</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{ $package->code }}</td>
                            <td>{{ $package->label }}</td>
                            <td>{{ $package->costPerLb() }}</td>
                            <td>
                                <a href="/admin/packages/{{ $package->id }}/edit">
                                    <button class="btn btn-primary btn-xs">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                </a>
                                <form action="/admin/packages/{{ $package->id }}" method="POST">
                                    <?= csrf_field() ?>
                                    <input name="_method" type="hidden" value="DELETE">
                                    <input name="package_id" type="hidden" value="{{ $package->id }}">
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
            <h2> Packages </h2>
            <span class="jarviswidget-loader" style="display: none;"><i class="fa fa-refresh fa-spin"></i></span></header>

        <!-- widget div-->
        <div role="content">

            <!-- widget content -->
            <div class="widget-body">

                {{--<div class="alert alert-info no-margin fade in">--}}
                {{--<button class="close" data-dismiss="alert">--}}
                {{--×--}}
                {{--</button>--}}
                {{--<i class="fa-fw fa fa-info"></i>--}}
                {{--Adds zebra-striping to table row within <code>&lt;table&gt;</code> by adding the <code>.table-striped</code> with the base class--}}
                {{--</div>--}}

                <form action="/admin/packages/{{ $package->id }}/updateCalendar" method="POST">
                    <div class="row seven-cols">
                        {!! csrf_field() !!}
                        <input type="hidden" name="_method" value="PUT" />
                        <div class="col-md-1 schedule-day">
                            @include('admin.partials.schedule.day', [
                                'day' => 1,
                            ])
                        </div>
                        <div class="col-md-1 schedule-day">
                            @include('admin.partials.schedule.day', [
                                'day' => 2,
                            ])
                        </div>
                        <div class="col-md-1 schedule-day">
                            @include('admin.partials.schedule.day', [
                                'day' => 3,
                            ])
                        </div>
                        <div class="col-md-1 schedule-day">
                            @include('admin.partials.schedule.day', [
                                'day' => 4,
                            ])
                        </div>
                        <div class="col-md-1 schedule-day">
                            @include('admin.partials.schedule.day', [
                                'day' => 5,
                            ])
                        </div>
                        <div class="col-md-1 schedule-day">
                            @include('admin.partials.schedule.day', [
                                'day' => 6,
                            ])
                        </div>
                        <div class="col-md-1 schedule-day">
                            @include('admin.partials.schedule.day', [
                                'day' => 7,
                            ])
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-block btn-primary"
                                    type="submit"
                            >
                                <i class="fa fa-document"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </form>

            </div>
            <!-- end widget content -->

        </div>
        <!-- end widget div -->

    </div>

@endsection