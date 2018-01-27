@extends('layouts.smartadmin.app')

@section('breadcrumb_left')
    <i class="fa-fw fa fa-home"></i> Dashboard <span>> FAQs</span>
@endsection

@section('content')

    @foreach($faq_categories as $faq_category)

        <div class="jarviswidget  jarviswidget-sortable jarviswidget-color-blue" id="wid-id-1" data-widget-editbutton="false" role="widget" data-widget-attstyle="jarviswidget-color-blue">

        <header role="heading">
            <div class="jarviswidget-ctrls" role="menu">
                <a href="javascript:void(0);" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus "></i></a>
                <a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand "></i></a>
                <a href="javascript:void(0);" class="button-icon jarviswidget-delete-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Delete"><i class="fa fa-times"></i></a>
            </div>
            <span class="widget-icon"> <i class="fa fa-table"></i> </span>
            <h2> {{ $faq_category->label }} - ({{ $faq_category->code }}) </h2>
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

                <div class="table-responsive">

                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr>
                            <td>Code</td>
                            <td>Question</td>
                            <td>Answer</td>
                            <td>Action</td>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($faq_category->faqs as $faq)
                                <tr>
                                    <td>
                                        <a href="/admin/faqs/{{ $faq->id }}">
                                            {{ $faq->code }}
                                        </a>
                                    </td>
                                    <td>{{ $faq->question }}</td>
                                    <td>{{ $faq->answer }}</td>
                                    <td>
                                        <a href="/admin/faqs/{{ $faq->id }}/edit">
                                            <button class="btn btn-primary btn-xs">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                        </a>

                                        <form action="/admin/faqs/{{ $faq->id }}" method="POST">
                                            <?= csrf_field() ?>
                                            <input name="_method" type="hidden" value="DELETE">
                                            <input name="faq_id" type="hidden" value="{{ $faq->id }}">
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

    @endforeach

@endsection