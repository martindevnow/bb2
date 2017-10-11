@extends('layouts.smartadmin.app')

@section('breadcrumb_left')
    <i class="fa-fw fa fa-home"></i> Dashboard <span>> Pets</span>
@endsection

@section('breadcrumb_right')

    <ul id="sparks" class="">
        <li class="sparks-info">
            <a href="/admin/pets/create">
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

            <span class="widget-icon"> <i class="fa fa-table"></i> </span>
            <h2> Pets </h2>
            <span class="jarviswidget-loader" style="display: none;"><i class="fa fa-refresh fa-spin"></i></span></header>

        <!-- widget div-->
        <div role="content">

            <!-- widget content -->
            <div class="widget-body no-padding">

                <admin-pets-dashboard></admin-pets-dashboard>

            </div>
            <!-- end widget content -->

        </div>
        <!-- end widget div -->

    </div>

@endsection