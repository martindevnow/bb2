@extends('layouts.material.app')

@section('configuration')
    <?php $showSlider = true; ?>
@endsection

@section('content')

    <div class="intro-fixed ms-hero-img-barfhome color-white" id="home">
        <div class="intro-fixed-content index-1 ms-hero-bg-primary">
            <div class="container">
                <div class="text-center mb-4">
                    <span class="ms-logo ms-logo-lg ms-logo-white center-block mb-2 mt-2 animated zoomInDown animation-delay-5">BB</span>
                    <h1 class="no-m ms-site-title color-white center-block ms-site-title-lg mt-2 animated zoomInDown animation-delay-5">B.A.R.F.
                        <span>Bento</span>
                    </h1>
                    <p class="lead lead-lg color-white text-center center-block mt-2 mw-800 text-uppercase fw-300 animated fadeInUp animation-delay-7">
                        Discover what your pet's <span class="color-warning">nutritional needs</span> are and how you can give them the <span class="color-warning">healthy lifestyle</span> they deserve.</p>
                </div>
                <div class="text-center mb-2">
                    <a id="go-intro-fixed-next" href="#what-is-barf" class="btn-circle btn-circle-raised btn-circle-white animated zoomInUp animation-delay-12">
                        <i class="zmdi zmdi-long-arrow-down"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="btn-back-top back-show">
        <a href="#" data-scroll="" id="back-top" class="btn-circle btn-circle-primary btn-circle-sm btn-circle-raised ">
            <i class="zmdi zmdi-long-arrow-up"></i>
        </a>
    </div>

    <div class="bg-light index-1 intro-fixed-next pt-6" style="margin-top: 950px;" id="what-is-barf">
        <div class="container mt-4">
            <a name="what-is-barf"></a>
            <h2 class="text-center color-primary mb-2 wow fadeInDown animation-delay-4" style="visibility: visible; animation-name: fadeInDown;">What is B.A.R.F?</h2>
            <p class="lead text-center aco wow fadeInDown animation-delay-5 mw-800 center-block mb-4" style="visibility: visible; animation-name: fadeInDown;">
                B.A.R.F. stands for
                <span class="color-primary">Biologically Appropriate Raw Food</span>. B.A.R.F. is a diet that replicates the eating habits of what dogs and cats would have eaten in the wild.</p>
            <p class="lead text-center aco wow fadeInDown animation-delay-5 mw-800 center-block mb-4" style="visibility: visible; animation-name: fadeInDown;">
                The whole point of "Biologically Appropriate" is to feed dogs and cats food that their bodies are
                <span class="color-primary">biologically</span> and
                <span class="color-primary">evolutionarily</span> predisposed to.
                B.A.R.F. for dogs and cats breaks down into the following categories.</p>
            <div class="ms-feature col-lg-3 col-md-6 col-sm-6 card wow flipInX animation-delay-4" style="visibility: visible; animation-name: flipInX;">
                <div class="text-center card-block">
                <span class="ms-icon ms-icon-circle ms-icon-xxlg color-info">
                  80%
                </span>
                    <h4 class="color-info">Protein</h4>
                    <p class="">This is the bulk of the diet. This is the meat and fish in the Bento. Depending on the Bento package, we supply a variety of meats for your pet.</p>
                </div>
            </div>
            <div class="ms-feature col-lg-3 col-md-6 col-sm-6 card wow flipInX animation-delay-8" style="visibility: visible; animation-name: flipInX;">
                <div class="text-center card-block">
                <span class="ms-icon ms-icon-circle ms-icon-xxlg color-warning">
                  10%
                </span>
                    <h4 class="color-warning">Calcium</h4>
                    <p class="">The primary source of calcium is from eating bones. This can be ground up in the meat, or whole bones gnawed on by your pet. (Never feed cooked bones to your pet!)</p>
                </div>
            </div>
            <div class="ms-feature col-lg-3 col-md-6 col-sm-6 card wow flipInX animation-delay-10" style="visibility: visible; animation-name: flipInX;">
                <div class="text-center card-block">
                <span class="ms-icon ms-icon-circle ms-icon-xxlg color-success">
                  5%
                </span>
                    <h4 class="color-success">Minerals</h4>
                    <p class="">Organ meat (such as liver, lung, heart, kidney, etc) provides many nutrients and minerals for a health pet.</p>
                </div>
            </div>
            <div class="ms-feature col-lg-3 col-md-6 col-sm-6 card wow flipInX animation-delay-6" style="visibility: visible; animation-name: flipInX;">
                <div class="text-center card-block">
                <span class="ms-icon ms-icon-circle ms-icon-xxlg  color-danger">
                  5%
                </span>
                    <h4 class="color-danger">Vitamins</h4>
                    <p class="">Wolves get vitamins from the undigested contents of their prey's stomach. At BARFBento, we include unprocessed tripe and other superfoods and veggies.</p>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 wow flipInX animation-delay-6" style="visibility: visible; animation-name: flipInX;">
                <div class="col-md-12">
                    <a href="/quote" class="btn btn-info btn-raised btn-xl btn-block"
                       style="height: 20rem; padding: 4rem; font-size: 8rem;"
                    >Start Today<div class="ripple-container"></div></a>
                </div>
            </div>
        </div>


        <div class="wrap wrap-mountain mt-6" style="background-image: url('/material/img/skyline2.jpg')">
            <div class="container">
                <h2 class="text-center text-light mb-6 wow fadeInDown animation-delay-5" style="visibility: visible; animation-name: fadeInDown;">What are "<strong>Kibbles</strong>"?</h2>
                <div class="row">
                    <div class="col-md-6 col-md-push-6 mb-4  center-block">
                        <img src="/barfbento/img/kibbles.jpg" alt="" class="img-responsive img-rounded img-thumbnail center-block wow zoomIn animation-delay-12"
                             style="visibility: visible; animation-name: zoomIn;"> </div>
                    <div class="col-md-6 col-md-pull-6 pr-6">
                        <h3 style="text-align: center;">Kibbles are primarily left over meat "by-products" made out of meat unfit for human consumption.</h3>
                        <p class="wow fadeInLeft animation-delay-6" style="visibility: visible; animation-name: fadeInLeft;">
                            In the pet food manufacturing industry, the ingredients and definition of "meat" are loosely defined. Their guidelines include </p>
                        <p class="wow fadeInLeft animation-delay-7" style="visibility: visible; animation-name: fadeInLeft;">
                            Kibbles also often include large amounts of corn, wheat and soy, which dogs and cats do not have the proper enzymes and natural gut flora to breakdown and digest.
                            Additionally, these cause dental issues with pets and the carbohydrates lead to tartar, bad breath and even tooth decay..</p>
                        <p class="wow fadeInLeft animation-delay-8" style="visibility: visible; animation-name: fadeInLeft;">
                            Deceptive labels have been causing an uproar and lead to a decline in consumer confidence.
                            Things like "all-beef" should be just that, but pet food manufacturers are allowed to add water,
                            preservatives and even "seasonings" to their product.
                        3</p>
                        <div class="text-center">
                            <a href="/faq" class="btn btn-warning btn-raised mr-1 wow flipInX animation-delay-14" style="visibility: visible; animation-name: flipInX;">
                                <i class="zmdi zmdi-chart-donut"></i> Learn More </a>
                            <a href="/quote" class="btn btn-info btn-raised wow flipInX animation-delay-16" style="visibility: visible; animation-name: flipInX;">
                                <i class="zmdi zmdi-case"></i> Get a Quote</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <div class="container">
            <div class="card wow fadeInUp mt-6" style="visibility: visible; animation-name: fadeInUp;">
                <div class="card-block card-block-big">
                    <h2 class="text-center fw-500">Benefits of B.A.R.F.</h2>
                    <p class="lead text-center center-block mw-800">Give your pet the healthy, balanced diet they deserve.</p>
                    <div class="row mt-4">
                        <div class="col-md-6 col-md-push-6 text-justify">
                            <h3 class="color-primary">In Summary</h3>
                            <p class="dropcaps">Maintaining a healthy diet is something we take for granted as humans.</p>
                            <p>Explicabo numquam quam amet vel laboriosam odio eaque quos esse cumque, nam deserunt ducimus odit libero asperiores necessitatibus, soluta corporis dignissimos. Delectus temporibus iusto debitis obcaecati accusantium, dolorum ad doloremque
                                maiores optio ut magni praesentium cupiditate dolore.</p>
                            <p>Nulla delectus tempora ab ipsum molestias dolorem explicabo nihil. Officia quia iusto sint, iure nemo vitae aperiam, corrupti aliquid fugit, qui dolore voluptatibus eos quisquam obcaecati, omnis iste illum optio. Maxime atque hic vero.
                                Doloribus eius sit laborum fugiat necessitatibus tempora facilis facere cumque, ipsum nam, temporibus, perferendis non ratione!</p>
                        </div>
                        <div class="col-md-6 col-md-pull-6">
                            <h3 class="color-primary">Our Principles</h3>
                            <ol class="service-list list-unstyled">
                                <li>Lorem ipsum dolor sit amet,
                                    <strong>consectetur adipisicing elit</strong>. Nihil suscipit cupiditate expedita hic earum vero sint, recusandae itaque, rem distinctio.</li>
                                <li>Totam porro sit, obcaecati quos quae iure tenetur, soluta voluptatem sapiente rerum ipsam delectus corporis voluptates voluptate, nulla mollitia pariatur.</li>
                                <li>Enim quas nesciunt sequi odit, ut
                                    <a href="#">quisquam vitae commodi</a> animi placeat nihil saepe magnam aliquam, vero harum quae doloribus aut nostrum veniam alias!</li>
                                <li>Lorem ipsum dolor sit amet,
                                    <strong>consectetur adipisicing elit</strong>. Nihil suscipit cupiditate expedita hic earum vero sint, recusandae itaque, rem distinctio.</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

        </div>




        <section id="services" class="mt-6">
            <div class="wrap ms-hero-img-farm ms-hero-bg-dark-light color-white ms-bg-fixed">
                <div class="container">
                    <div class="text-center mb-4">
                        <h1 class="color-warning wow zoomInDown" style="visibility: visible; animation-name: zoomInDown;">Sourcing</h1>
                        <h3 class="wow zoomInDown" style="visibility: visible; animation-name: zoomInDown;">Where does the
                            <span class="text-normal">Meat</span> come from?</h3>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            {{--<h3 class="wow fadeInUp animation-delay-2" style="visibility: visible; animation-name: fadeInUp;">Description</h3>--}}
                            <p>Providing high quality ingredients is our top priority, and so, all of our meat is sourced
                                locally from Ontario approved farms and butchered at Ontario approved meat packers. This enables us to
                                hold our sources accountable and make sure they adhere to the high standards set for human grade meat packers.
                            </p>
                            <p>Livestock that is butchered for B.A.R.F.Bento are raised without the use of anti-biotics,
                                steroids or hormones to ensure there are no contaminants or additives in the bentos you feed your pets.
                                Many of our customers tell us that they feed their pets better than themselves!</p>
                            <p>All of that being said, please don't eat the meat yourself. It is prepared with ground bones and not intended for human consumption.
                                Let's just say, it's not biologically appropriate for humans!</p>

                            {{--<p class="wow fadeInUp animation-delay-3" style="visibility: visible; animation-name: fadeInUp;">Lorem ipsum dolor sit amet,--}}
                                {{--<strong>consectetur adipisicing elit</strong>. Repellat cum laudantium quos tempora magnam voluptas sint perspiciatis nulla ipsa itaque atque quod incidunt maiores iusto, laborum, magni aliquam. Aut eligendi nesciunt nobis eum dolorum maxime--}}
                                {{--corporis dicta, repudiandae eveniet ab laboriosam minima voluptate quaerat sequi modi suscipit cumque unde rerum.</p>--}}
                            {{--<p class="wow fadeInUp animation-delay-4" style="visibility: visible; animation-name: fadeInUp;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis porro, magni obcaecati cupiditate nulla rem quae, eveniet corrupti reprehenderit maiores nobis doloribus expedita non quasi itaque. Incidunt, delectus quidem vitae laudantium,--}}
                                {{--natus--}}
                                {{--<a href="#" class="color-warning">quibusdam odio eius eligendi</a> tenetur! Ea, repudiandae eveniet ab minima laboriosam minima voluptate quaerat sequi harum.</p>--}}
                        </div>
                        <div class="col-md-6 mb-4 center-block">
                            <img src="/barfbento/img/cow.jpg" alt="" class="img-responsive img-rounded img-thumbnail center-block wow zoomIn animation-delay-12"
                                 style="visibility: visible; animation-name: zoomIn;"> </div>
                    </div>
                </div>
            </div>
        </section>





        <section id="team">
            <div class="container pt-6 ">
                <h1 class="color-primary text-center wow fadeInUp animation-delay-2" style="visibility: visible; animation-name: fadeInUp;">Who We Are</h1>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-4 col-sm-6">
                        <div class="card mt-4 card-danger wow zoomInUp animation-delay-7" style="visibility: visible; animation-name: zoomInUp;">
                            <div class="ms-hero-bg-danger ms-hero-img-city">
                                <img src="/barfbento/img/profile/halley.jpg" alt="..." class="img-avatar-circle"> </div>
                            <div class="card-block pt-6 text-center">
                                <h3 class="color-danger">Halley's Comet</h3>
                                <p>Born Feb 1 2016 in Nippising, ON, I love winter! I am the CEO of B.A.R.F. Bento and don't give me a ball if you ever want it back! My favorite food is lamb and chicken feet for dessert!</p>
                                <a href="https://www.facebook.com/doggiebento/" class="btn-circle btn-circle-raised btn-circle-xs mt-1 mr-1 no-mr-md btn-facebook">
                                    <i class="zmdi zmdi-facebook"></i>
                                </a>
                                <a href="javascript:void(0)" class="btn-circle btn-circle-raised btn-circle-xs mt-1 mr-1 no-mr-md btn-twitter">
                                    <i class="zmdi zmdi-twitter"></i>
                                </a>
                                <a href="https://www.instagram.com/explore/tags/halleyslife/?hl=en" class="btn-circle btn-circle-raised btn-circle-xs mt-1 mr-1 no-mr-md btn-instagram">
                                    <i class="zmdi zmdi-instagram"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="card mt-4 card-royal wow zoomInUp animation-delay-7" style="visibility: visible; animation-name: zoomInUp;">
                            <div class="ms-hero-bg-royal ms-hero-img-city">
                                <img src="/barfbento/img/profile/nova.jpg" alt="..." class="img-avatar-circle"> </div>
                            <div class="card-block pt-6 text-center">
                                <h3 class="color-info">Super Nova</h3>
                                <p>My parents adopted me on Dec 16 2016. I LOVE the food my family feeds me! I can be pretty lazy... but I have a BIG appetite! My favorite food is ANYTHING! Don't leave your food unattended! </p>
                                <a href="https://www.facebook.com/doggiebento/" class="btn-circle btn-circle-raised btn-circle-xs mt-1 mr-1 no-mr-md btn-facebook">
                                    <i class="zmdi zmdi-facebook"></i>
                                </a>
                                <a href="javascript:void(0)" class="btn-circle btn-circle-raised btn-circle-xs mt-1 mr-1 no-mr-md btn-twitter">
                                    <i class="zmdi zmdi-twitter"></i>
                                </a>
                                <a href="https://www.instagram.com/explore/tags/supernovahusky/?hl=en" class="btn-circle btn-circle-raised btn-circle-xs mt-1 mr-1 no-mr-md btn-instagram">
                                    <i class="zmdi zmdi-instagram"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2"></div>
                </div>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-4 col-sm-6">
                        <div class="card mt-4 card-primary wow zoomInUp animation-delay-7" style="visibility: visible; animation-name: zoomInUp;">
                            <div class="ms-hero-bg-primary ms-hero-img-city">
                                <img src="/barfbento/img/profile/vivian.jpg" alt="..." class="img-avatar-circle"> </div>
                            <div class="card-block pt-6 text-center">
                                <h3 class="color-warning">Vivian Wong</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur alter adipisicing elit. Facilis, natuse inse voluptates officia repudiandae beatae magni es magnam autem molestias.</p>
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
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="card mt-4 card-warning wow zoomInUp animation-delay-7" style="visibility: visible; animation-name: zoomInUp;">
                            <div class="ms-hero-bg-warning ms-hero-img-city">
                                <img src="/barfbento/img/profile/ben.jpg" alt="..." class="img-avatar-circle"> </div>
                            <div class="card-block pt-6 text-center">
                                <h3 class="color-royal">Ben Martin</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur alter adipisicing elit. Facilis, natuse inse voluptates officia repudiandae beatae magni es magnam autem molestias.</p>
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
                        </div>
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </div>
        </section>


        <section class="shipping">

            <div class="container pt-6">
                <h1 class="color-primary text-center wow fadeInUp animation-delay-2" style="visibility: visible; animation-name: fadeInUp;">Our Service Area</h1>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary animated fadeInUp animation-delay-7">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="zmdi zmdi-map"></i>Shipping Area</h3>
                            </div>
                            <iframe src="https://www.google.com/maps/d/u/0/embed?mid=12HuD4sUWj4Kk0yhWsp9-ttJcZN4" width="100%" height="480"></iframe>
                        </div>
                    </div>
                </div>
            </div>


        </section>
    </div>
@endsection
