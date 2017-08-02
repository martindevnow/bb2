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
            <h2> Plans </h2>
            <span class="jarviswidget-loader" style="display: none;"><i class="fa fa-refresh fa-spin"></i></span></header>

        <!-- widget div-->
        <div role="content">

            <!-- widget content -->
            <div class="widget-body no-padding">

                <div class="table-responsive">

                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr>
                            <td>ID</td>
                            <td>Pet</td>
                            <td>Package</td>
                            <td>Weeks</td>
                            <td>Meat Cost</td>
                            <td>Packing Cost</td>
                            <td>Weekly Cost</td>
                            <td>Cost / lb of Dog</td>
                            <td>Profit</td>
                            <td>Action</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($plans as $plan)
                            <tr class="{{ $plan->active ? '' : 'danger' }}">
                                <td><a href="/admin/plans/{{ $plan->id }}">{{ $plan->id }}</a></td>
                                <td>{{ $plan->pet->name }} ({{ $plan->pet_weight }} lb)</td>
                                <td>{{ $plan->package->label }}</td>
                                <td>{{ $plan->weeks_at_a_time }}</td>
                                <td>${{ round($plan->costPerWeek(), 2) }}</td>
                                <td>${{ round($plan->totalPackingCost(), 2) }}</td>
                                <td>${{ $plan->weekly_cost }}</td>
                                <td>${{ round($plan->costPerPoundOfDog(), 2) }}</td>
                                <td>${{ round($plan->profit(), 2) }}</td>
                                <td>
                                    <a href="/admin/plans/{{ $plan->id }}/edit">
                                        <button class="btn btn-primary btn-xs">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                    </a>

                                    <form action="/admin/plans/{{ $plan->id }}" method="POST">
                                        <?= csrf_field() ?>
                                        <input name="_method" type="hidden" value="DELETE">
                                        <input name="plan_id" type="hidden" value="{{ $plan->id }}">
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