@extends('layouts.smartadmin.app')

@section('breadcrumb_right')

<ul id="sparks" class="">
    <li class="sparks-info">
        <a href="/admin/purchase-orders/create">
            <button class="btn btn-block btn-primary">
                <i class="fa fa-wrench"></i> Create New
            </button>
        </a>
    </li>
</ul>

@endsection

@section('content')

    <div class="jarviswidget jarviswidget-color-blue jarviswidget-sortable" id="wid-id-4" data-widget-editbutton="false" data-widget-colorbutton="false" role="widget">

        <header role="heading"><div class="jarviswidget-ctrls" role="menu">   <a href="javascript:void(0);" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-delete-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Delete"><i class="fa fa-times"></i></a></div>
            <span class="widget-icon"> <i class="fa fa-check txt-color-white"></i> </span>
            <h2> Meats - Purchase Order </h2>
            <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span></header>

        <!-- widget div-->
        <div role="content">

            <div class="widget-body no-padding smart-form">

                <table class="table table-bordered table-striped table-responsive">
                    <thead>
                    <tr>
                        <th>PO ID#</th>
                        <th>Date</th>
                        <th>Vendor</th>
                        <th>Total Cost</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pos as $po)
                    <tr>
                        <td>{{ $po->id }}</td>
                        <td>{{ $po->created_at }}</td>
                        <td>{{ optional($po->vendor)->name }}</td>
                        <td>${{ round($po->totalCost(),2) }}</td>
                        <td>
                            <button class="btn">Ordered</button>
                            <button class="btn">Received</button>
                            <button class="btn btn-xs btn-primary">Edit</button>
                            <button class="btn btn-xs btn-primary">Delete</button>
                        </td>
                    </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>


@endsection