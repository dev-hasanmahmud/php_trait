@extends('layouts.master')
@section('content')
@push('css')
<link rel="stylesheet" href="{{ custom_asset('assets/css/cdn/swiper.min.css') }}" />
@endpush

<div class="main-content mt-4 ">
        <section class="new-sec-1">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 new-sec-box">
                        <a class="card box" href="#">
                            <h4>emcrp project information - dphe part</h4>
                            <span class="icons">
                                <img src="{{ custom_asset('assets/images/icons/info.png') }}" alt="">
                            </span>
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 new-sec-box">
                        <a class="card box" href="#">
                            <h4>procurement status</h4>
                            <span class="icons">
                                <img src="{{ custom_asset('assets/images/icons/procurement.png') }}" alt="">
                            </span>
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 new-sec-box">
                        <a class="card box" href="#">
                            <h4>physical work status</h4>
                            <span class="icons">
                                <img src="{{ custom_asset('assets/images/icons/physical.png') }}" alt="">
                            </span>
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 new-sec-box">
                        <a class="card box" href="#">
                            <h4>fecal sludge & solid waste management status</h4>
                            <span class="icons">
                                <img src="{{ custom_asset('assets/images/icons/fecal.png') }}" alt="">
                            </span>
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 new-sec-box">
                    <a class="card box" href="{{ url('training-module') }}">

                            <h4>training status</h4>
                            <span class="icons">
                                <img src="{{ custom_asset('assets/images/icons/training.png') }}" alt="">
                            </span>
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 new-sec-box">
                        <a class="card box" href="#">
                            <h4>o & m status</h4>
                            <span class="icons">
                                <img src="{{ custom_asset('assets/images/icons/O&M.png') }}" alt="">
                            </span>
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 new-sec-box">
                        <a class="card box" href="#">
                            <h4>monitoring and supervision status</h4>
                            <span class="icons monitoring">
                                <img src="{{ custom_asset('assets/images/icons/monitoring.png') }}" alt="">
                            </span>
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 new-sec-box">
                        <a class="card box" href="#">
                            <h4>social status</h4>
                            <span class="icons social">
                                <img src="{{ custom_asset('assets/images/icons/social.png') }}" alt="">
                            </span>
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 new-sec-box">
                        <a class="card box" href="#">
                            <h4>training on O & M, caretaker, awarness program status</h4>
                            <span class="icons">
                                <img src="{{ custom_asset('assets/images/icons/training1.png') }}" alt="">
                            </span>
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 new-sec-box">
                        <a class="card box" href="#">
                            <h4>database & report</h4>
                            <span class="icons db">
                                <img src="{{ custom_asset('assets/images/icons/db.png') }}" alt="">
                            </span>
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 new-sec-box">
                        <a class="card box" href="#">
                            <h4>gallery</h4>
                            <span class="icons gallery">
                                <img src="{{ custom_asset('assets/images/icons/gallery.png') }}" alt="">
                            </span>
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 new-sec-box">
                        <a class="card box" href="#">
                            <h4>maps</h4>
                            <span class="icons">
                                <img src="{{ custom_asset('assets/images/icons/map.png') }}" alt="">
                            </span>
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 new-sec-box">
                        <a class="card box" href="#">
                            <h4>drawing & design</h4>
                            <span class="icons">
                                <img src="{{ custom_asset('assets/images/icons/drawing.png') }}" alt="">
                            </span>
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 new-sec-box">
                        <a class="card box" href="#">
                            <h4>grm status</h4>
                            <span class="icons">
                                <img src="{{ custom_asset('assets/images/icons/grm.png') }}" alt="">
                            </span>
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 new-sec-box">
                        <a class="card box" href="{{ url('finance-dashboard') }}">
                            <h4>Financial status</h4>
                            <span class="icons finance">
                                <img src="{{ custom_asset('assets/images/icons/finance.png') }}" alt="">
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <section class="new-sec-2">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8 box-height">
                        <!-- Swiper -->
                        <div class="swiper-container new-sec-slider">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="{{ asset('assets/images/s1.jpg') }}" alt="">
                                    <h4>The Government of the People’s Republic of Bangladesh</h4>
                                </div>
                                <div class="swiper-slide">
                                    <img src="{{ asset('assets/images/s2.jpg') }}" alt="">
                                    <h4>The Government of the People’s Republic of Bangladesh</h4>
                                </div>
                                <div class="swiper-slide">
                                    <img src="{{ asset('assets/images/s3.jpg') }}" alt="">
                                    <h4>The Government of the People’s Republic of Bangladesh</h4>
                                </div>
                            </div>
                            <!-- Add Pagination -->
                            <div class="swiper-pagination"></div>
                            <!-- Add Arrows -->
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 box-height">
                        <div class="card new-sec-box">
                            <h4>typographic hierarchy </h4>
                            <p>
                                Typeface Selection :
                                More interesting typefaces can appear larger and draw the eye faster than ones with less
                                visual intrigue. When using novelty, script or elaborate typefaces be aware of
                                readability concerns and make sure the type is plenty big.
                                Size :
                                It almost goes without saying, but the bigger the type, the quicker the eye will be
                                drawn to it. Type sizing should correlate to the order of importance in reading the
                                text.

                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection

@push('script')
<script src="{{ custom_asset('assets/js/cdn/swiper.min.js') }}"></script>
<script>
    var swiper = new Swiper(".new-sec-slider", {
        autoplay: {
            delay: 4000,
            disableOnInteraction: false
        },
        direction: 'vertical',
        pagination: {
            el: ".swiper-pagination-slider",
            clickable: true
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev"
        }
    });
</script>
    
@endpush

