@extends('layouts.material.app')

@section('content')









    <div class="ms-hero-page-override ms-hero-img-city ms-hero-bg-primary">
        <div class="container">
            <div class="text-center">
                <span class="ms-logo ms-logo-lg ms-logo-white center-block mb-2 mt-2 animated zoomInDown animation-delay-5">BB</span>
                <h1 class="no-m ms-site-title color-white center-block ms-site-title-lg mt-2 animated zoomInDown animation-delay-5">B.A.R.F.
                    <span>Bento</span>
                </h1>
                <p class="lead lead-lg color-white text-center center-block mt-2 mw-800 text-uppercase fw-300 animated fadeInUp animation-delay-7">Enter the compelling
                    <span class="color-warning">motto</span> of B.A.R.F. Bento here!</p>
            </div>
        </div>
    </div>







    <div class="container">
        <div class="card wow slideInUp" style="visibility: visible; animation-name: slideInUp; position: relative; top: -100px;">
            <div class="card-block-big">
                <h1 class="color-primary">About Us</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Necessitatibus sequi illo labore eaque eveniet porro in, molestias deleniti corporis ea repellendus
                    <strong>laborum dolores veniam nam</strong> mollitia culpa accusamus non voluptates corrupti? A inventore et veniam dignissimos, animi suscipit magnam nihil sed repellendus placeat eveniet vitae est impedit alias aliquid eius?</p>
                <p>Perferendis, blanditiis unde fugiat voluptas molestias velit asperiores rerum ipsam animi eum temporibus at numquam, nobis voluptates minus maxime cum obcaecati! Tenetur sit corporis laudantium inventore officia officiis odio repellat dolore
                    quos
                    <a href="#">repudiandae voluptas ad facere</a>, amet placeat animi voluptatem distinctio beatae.</p>

                <!-- FAQ -->
                <div class="card nav-tabs-ver-container">
                    <div class="row">
                        <div class="col-md-3">
                            <ul class="nav nav-tabs-ver nav-tabs-ver-primary" role="tablist">
                                <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><i class="zmdi zmdi-home"></i> Home</a></li>
                                <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><i class="zmdi zmdi-account"></i> Profile</a></li>
                                <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab"><i class="zmdi zmdi-email"></i> Messages</a></li>
                                <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab"><i class="zmdi zmdi-settings"></i> Settings</a></li>
                            </ul>
                        </div>
                        <div class="col-md-9 nav-tabs-ver-container-content">
                            <div class="card-block">
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="home">



                                        <div class="panel-group ms-collapse" id="accordion" role="tablist" aria-multiselectable="true">
                                            <div class="panel panel-default">
                                                <div class="panel-heading" role="tab" id="headingOne">
                                                    <h4 class="panel-title ms-rotate-icon">
                                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                            <i class="zmdi zmdi-attachment-alt"></i> Collapsible Group Item
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                                    <div class="panel-body">
                                                        ...
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default">
                                                <div class="panel-heading" role="tab" id="headingTwo">
                                                    <h4 class="panel-title ms-rotate-icon">
                                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                            <i class="zmdi zmdi-attachment-alt"></i> Collapsible Group Item
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                                    <div class="panel-body">
                                                        ...
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default">
                                                <div class="panel-heading" role="tab" id="headingThree">
                                                    <h4 class="panel-title ms-rotate-icon">
                                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                            <i class="zmdi zmdi-attachment-alt"></i> Collapsible Group Item
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                                    <div class="panel-body">
                                                        ...
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="profile">
                                        ...
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="messages">
                                        ...
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="settings">
                                        ...
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>






            </div>
        </div>
    </div>






    <div class="container">
        <h1 class="color-primary text-center wow fadeInUp animation-delay-4" style="visibility: visible; animation-name: fadeInUp;">Our Team</h1>
        <p class="lead text-center wow fadeInUp animation-delay-4" style="visibility: visible; animation-name: fadeInUp;">We are a team of professionals, our illusion is your project.</p>
        <div class="row">
            <div class="col-md-6">
                <div class="card card-warning wow zoomInUp animation-delay-5" style="visibility: visible; animation-name: zoomInUp;">
                    <div class="withripple zoom-img">
                        <a href="javascript:void()" class="">
                            <img src="/material/img/demo/p2.jpg" alt="..." class="img-responsive">
                        </a>
                    </div>
                    <div class="card-block">
                        <span class="label label-warning pull-right">CEO</span>
                        <h3 class="color-warning">Antonie Smith</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur alter adipisicing elit. Facilis, natuse inse voluptates officia repudiandae beatae magni es magnam autem molestias.</p>
                        <div class="row">
                            <div class="col-xs-6">
                                <a href="javascript:void(0)" class="btn-circle btn-circle-raised btn-circle-xs mt-1 mr-1 no-mr-md btn-facebook">
                                    <i class="zmdi zmdi-facebook"></i>
                                </a>
                                <a href="javascript:void(0)" class="btn-circle btn-circle-raised btn-circle-xs mt-1 mr-1 no-mr-md btn-twitter">
                                    <i class="zmdi zmdi-twitter"></i>
                                </a>
                                <a href="javascript:void(0)" class="btn-circle btn-circle-raised btn-circle-xs mt-1 mr-1 no-mr-md btn-instagram">
                                    <i class="zmdi zmdi-instagram"></i>
                                </a>
                            </div>
                            <div class="col-xs-6 text-right">
                                <a href="javascript:void(0)" class="btn btn-raised btn-sm btn-warning">
                                    <i class="zmdi zmdi-account"></i> Perfil</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-success wow zoomInUp animation-delay-7" style="visibility: visible; animation-name: zoomInUp;">
                    <div class="withripple zoom-img">
                        <a href="javascript:void()" class="">
                            <img src="/material/img/demo/p1.jpg" alt="..." class="img-responsive">
                        </a>
                    </div>
                    <div class="card-block">
                        <span class="label label-success pull-right">Marketing</span>
                        <h3 class="color-success">Sophie Austin</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur alter adipisicing elit. Facilis, natuse inse voluptates officia repudiandae beatae magni es magnam autem molestias.</p>
                        <div class="row">
                            <div class="col-xs-6">
                                <a href="javascript:void(0)" class="btn-circle btn-circle-raised btn-circle-xs mt-1 mr-1 no-mr-md btn-facebook">
                                    <i class="zmdi zmdi-facebook"></i>
                                </a>
                                <a href="javascript:void(0)" class="btn-circle btn-circle-raised btn-circle-xs mt-1 mr-1 no-mr-md btn-twitter">
                                    <i class="zmdi zmdi-twitter"></i>
                                </a>
                                <a href="javascript:void(0)" class="btn-circle btn-circle-raised btn-circle-xs mt-1 mr-1 no-mr-md btn-instagram">
                                    <i class="zmdi zmdi-instagram"></i>
                                </a>
                            </div>
                            <div class="col-xs-6 text-right">
                                <a href="javascript:void(0)" class="btn btn-raised btn-sm btn-success">
                                    <i class="zmdi zmdi-account"></i> Perfil</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <section class="mt-6">
        <div class="container">
            <div class="text-center">
                <h1 class="color-primary">Dogs of B.A.R.F. Bento</h1>
                <p class="lead lead-lg color-medium">Get inspired with our best work</p>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="ms-thumbnail-container wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                        <figure class="ms-thumbnail">
                            <img src="/material/img/demo/port9.jpg" alt="" class="img-responsive">
                            <figcaption class="ms-thumbnail-caption text-center">
                                <div class="ms-thumbnail-caption-content">
                                    <h3 class="ms-thumbnail-caption-title">Lorem ipsum dolor sit</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                    <a href="javascript:void(0)" class="btn btn-white btn-raised color-primary">
                                        <i class="zmdi zmdi-eye"></i> View more</a>
                                </div>
                            </figcaption>
                        </figure>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="ms-thumbnail-container wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                        <figure class="ms-thumbnail">
                            <img src="/material/img/demo/port11.jpg" alt="" class="img-responsive">
                            <figcaption class="ms-thumbnail-caption text-center">
                                <div class="ms-thumbnail-caption-content">
                                    <h3 class="ms-thumbnail-caption-title">Lorem ipsum dolor sit</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                    <a href="javascript:void(0)" class="btn btn-white btn-raised color-primary">
                                        <i class="zmdi zmdi-eye"></i> View more</a>
                                </div>
                            </figcaption>
                        </figure>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="ms-thumbnail-container wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                        <figure class="ms-thumbnail">
                            <img src="/material/img/demo/port23.jpg" alt="" class="img-responsive">
                            <figcaption class="ms-thumbnail-caption text-center">
                                <div class="ms-thumbnail-caption-content">
                                    <h3 class="ms-thumbnail-caption-title">Lorem ipsum dolor sit</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                    <a href="javascript:void(0)" class="btn btn-white btn-raised color-primary">
                                        <i class="zmdi zmdi-eye"></i> View more</a>
                                </div>
                            </figcaption>
                        </figure>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="ms-thumbnail-container wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                        <figure class="ms-thumbnail">
                            <img src="/material/img/demo/port7.jpg" alt="" class="img-responsive">
                            <figcaption class="ms-thumbnail-caption text-center">
                                <div class="ms-thumbnail-caption-content">
                                    <h3 class="ms-thumbnail-caption-title">Lorem ipsum dolor sit</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                    <a href="javascript:void(0)" class="btn btn-white btn-raised color-primary">
                                        <i class="zmdi zmdi-eye"></i> View more</a>
                                </div>
                            </figcaption>
                        </figure>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="ms-thumbnail-container wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                        <figure class="ms-thumbnail">
                            <img src="/material/img/demo/port4.jpg" alt="" class="img-responsive">
                            <figcaption class="ms-thumbnail-caption text-center">
                                <div class="ms-thumbnail-caption-content">
                                    <h3 class="ms-thumbnail-caption-title">Lorem ipsum dolor sit</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                    <a href="javascript:void(0)" class="btn btn-white btn-raised color-primary">
                                        <i class="zmdi zmdi-eye"></i> View more</a>
                                </div>
                            </figcaption>
                        </figure>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="ms-thumbnail-container wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                        <figure class="ms-thumbnail">
                            <img src="/material/img/demo/port2.jpg" alt="" class="img-responsive">
                            <figcaption class="ms-thumbnail-caption text-center">
                                <div class="ms-thumbnail-caption-content">
                                    <h3 class="ms-thumbnail-caption-title">Lorem ipsum dolor sit</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                    <a href="javascript:void(0)" class="btn btn-white btn-raised color-primary">
                                        <i class="zmdi zmdi-eye"></i> View more</a>
                                </div>
                            </figcaption>
                        </figure>
                    </div>
                </div>
            </div>
        </div>
    </section>








    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li class="active">About Us</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 col-sm-8">
                    <h3>Lorem ipsum dolor sit amet</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus quis lectus metus, at posuere neque. Sed pharetra nibh eget orci convallis at posuere leo convallis. Sed blandit augue vitae augue scelerisque bibendum. Vivamus sit amet libero turpis, non venenatis urna. In blandit, odio convallis suscipit venenatis, ante ipsum cursus augue.</p>
                </div>
                <div class="col-md-4 col-sm-4">
                    <img src="/barfbento/img/about us.jpg" class="img-responsive img-rounded" alt="dodolan manuk catalog template">
                </div>
            </div>

            <div class="row padd20-top-btm">
                <div class="col-md-4 col-sm-4">
                    <img src="/barfbento/img/about us more.jpg" class="img-responsive img-rounded" alt="dodolan manuk barfbento template">
                </div>
                <div class="col-md-8 col-sm-8">
                    <h3>Lorem ipsum dolor sit amet</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus quis lectus metus, at posuere neque. Sed pharetra nibh eget orci convallis at posuere leo convallis. Sed blandit augue vitae augue scelerisque bibendum. Vivamus sit amet libero turpis, non venenatis urna. In blandit, odio convallis suscipit venenatis, ante ipsum cursus augue.</p>
                </div>
            </div>

            <div class="row padd20-top-btm">
                <div class="col-md-8 col-sm-8">
                    <h3>Lorem ipsum dolor sit amet</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus quis lectus metus, at posuere neque. Sed pharetra nibh eget orci convallis at posuere leo convallis. Sed blandit augue vitae augue scelerisque bibendum. Vivamus sit amet libero turpis, non venenatis urna. In blandit, odio convallis suscipit venenatis, ante ipsum cursus augue.</p>
                </div>
                <div class="col-md-4 col-sm-4">
                    <img src="/barfbento/img/about us pic.jpg" class="img-responsive img-rounded" alt="dodolan manuk barfbento template">
                </div>
            </div>


            <div class="row padd20-top-btm">
                <div class="col-md-12 text-center">
                    <h3>Lorem ipsum dolor sit amet</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus quis lectus metus, at posuere neque. Sed pharetra nibh eget orci convallis at posuere leo convallis. Sed blandit augue vitae augue scelerisque bibendum. Vivamus sit amet libero turpis, non venenatis urna. In blandit, odio convallis suscipit venenatis, ante ipsum cursus augue.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus quis lectus metus, at posuere neque.</p>
                </div>
            </div>
        </div>
    </div>
@endsection