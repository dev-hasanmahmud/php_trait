@extends('layouts.master')
@section('content')
    @push('css')
        <link rel="stylesheet" href="{{ custom_asset('assets/css/cdn/swiper.min.css') }}" />
    @endpush

    <div class="main-content mt-0 ">
        @include('sweetalert::alert')
        <section class="new-sec-2">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8 box-height">
                        <!-- Swiper -->
                        <div class="swiper-container new-sec-slider">
                            <div class="swiper-wrapper">

                                @foreach ($dynamic_images as $item)
                                    <div class="swiper-slide">
                                        <h3>জনস্বাস্থ্য প্রকৌশল অধিদপ্তর <br />
                                            <i>গণপ্রজাতন্ত্রী বাংলাদেশ সরকার</i>
                                        </h3>
                                        <img src="{{ asset($item->file_path) }}" alt="">
                                        <h4>জরুরী ভিত্তিতে রোহিঙ্গা সংকট মোকাবেলায় মাল্টি - সেক্টর প্রকল্প ( ডিপিএইচই অংশ )
                                        </h4>

                                    </div>
                                @endforeach
                                {{-- <div class="swiper-slide">
                                    <h3>জনস্বাস্থ্য প্রকৌশল অধিদপ্তর <br />
                                        <i>গণপ্রজাতন্ত্রী বাংলাদেশ সরকার</i>
                                    </h3>
                                    <img src="{{ asset('assets/images/s2.jpg') }}" alt="">
                                    <h4>জরুরী ভিত্তিতে রোহিঙ্গা সংকট মোকাবেলায় মাল্টি - সেক্টর প্রকল্প ( ডিপিএইচই অংশ )
                                    </h4>
                                </div> --}}
                                {{-- <div class="swiper-slide">
                                    <h3>জনস্বাস্থ্য প্রকৌশল অধিদপ্তর <br />
                                        <i>গণপ্রজাতন্ত্রী বাংলাদেশ সরকার</i>
                                    </h3>
                                    <img src="{{ asset('assets/images/s3.jpg') }}" alt="">
                                    <h4>জরুরী ভিত্তিতে রোহিঙ্গা সংকট মোকাবেলায় মাল্টি - সেক্টর প্রকল্প ( ডিপিএইচই অংশ )
                                    </h4>
                                </div> --}}
                            </div>
                            <!-- Add Pagination -->
                            <div class="swiper-pagination"></div>
                            <!-- Add Arrows -->
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                    <div class="res-ab col-xs-12 col-sm-6 col-md-4 col-lg-4 box-height">
                        <div class="card new-sec-box">
                            <h4>About</h4>
                            <p>The Government of the People’s Republic of Bangladesh (GoB) has received a grant from the
                                International Development Association (IDA) towards the cost of Emergency Multi-Sector
                                Rohingya Crisis Response Project (EMRCRP). Component 1A and 3B of the project will be
                                implemented by Department of Public Health Engineering (DPHE) under Ministry of Local
                                Government, Rural Development and Cooperatives (MLGRD&C). The PMU is mandated to manage the
                                project in keeping with the Borrower’s obligation to use the project fund with due regard to
                                economy and efficiency and only for the purpose for which project financing was provided.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <section class="clearfix new-sec-1 pt-3 mb-0">
            <div class="container">
                <ul class="aware-hover">

                    @if (!isset($permission['WorldBankPermission']) || Auth::user()->role ==1)

                        <li class="view_3d">
                            <a class='normal' href='{{ route('project_info.index') }}'>
                                <h4>emcrp project information - dphe part</h4>
                            </a>
                            <div class='info'>
                                <h4>emcrp project information - dphe part</h4>
                            </div>
                        </li>

                        <li class="view_3d">
                            <a class='normal' href="{{ url('procurement-dashboard') }}">
                                <h4>procurement status</h4>
                            </a>
                            <div class='info'>
                                <p>
                                <h4>procurement status</h4>
                                </p>
                            </div>
                        </li>

                        {{-- <li class="view_3d">
                            <a class='normal' href="{{ url('training-module') }}">
                                <h4>Training Status</h4>
                            </a>
                            <div class='info'>
                                <p>
                                <h4>Training Status</h4>
                                </p>
                            </div>
                        </li> --}}

                        <li class="view_3d">
                            <a class='normal' href="{{ route('dd.home') }}">
                                <h4>Drawing & Design</h4>
                            </a>
                            <div class='info'>
                                <p>
                                <h4>Drawing & Design</h4>
                                </p>
                            </div>
                        </li>

                        <li class="view_3d">
                            <a class='normal' href="{{ url('/dashboard/report') }}">
                                <h4>Reports</h4>
                            </a>
                            <div class='info'>
                                <p>
                                <h4>Reports</h4>
                                </p>
                            </div>
                        </li>

                        {{-- <li class="view_3d">
                            <a class='normal' href="{{ url('/dashboard/gis') }}">
                                <h4>GIS</h4>
                            </a>
                            <div class='info'>
                                <p>
                                <h4>GIS</h4>
                                </p>
                            </div>
                        </li> --}}

                        {{-- <li class="view_3d">
                            <a class='normal' href="{{ url('/app-image') }}">
                                <h4>Data Acuqisition</h4>
                            </a>
                            <div class='info'>
                                <p>
                                <h4>Data Acuqisition</h4>
                                </p>
                            </div>
                        </li> --}}

                        <li class="view_3d">
                            <a class='normal' href="{{ url('/monitor-and-suppervision-status') }}">
                                <h4>Monitoring and Supervision Status</h4>
                            </a>
                            <div class='info'>
                                <p>
                                <h4>Monitoring and Supervision Status</h4>
                                </p>
                            </div>
                        </li>
                    @else
                        <li class="view_3d">
                            <a class='normal' href="{{ route('dd.home') }}">
                                <h4>Drawing & Design</h4>
                            </a>
                            <div class='info'>
                                <p>
                                <h4>Drawing & Design</h4>
                                </p>
                            </div>
                        </li>
                        <li class="view_3d">
                            <a class='normal' href="{{ url('dashboard/package-wise-report') }}">
                                <h4>Package Wise Report </h4>
                            </a>
                            <div class='info'>
                                <p>
                                <h4>Package Wise Report </h4>
                                </p>
                            </div>
                        </li>
                    @endif
                </ul>

            </div>
        </section>

        <section class="clearfix new-sec-1 pt-3 mb-5">
            <div class="container">
                <div class="card pt-0 mt-0 mb-4 card-design">
                    <div class="p-0 card-body">
                        <div class="top-part">
                            <p><i class="fa fa-users" aria-hidden="true"></i> Beneficiary (Parent Finance)</p>
                            <p>Total User</p>
                            <p>F (52%)</p>
                            <p>M (48%)</p>
                        </div>

                        <div class="accordion mid-part">

                            <a class="w-100 btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button"
                                aria-expanded="false" aria-controls="collapseExample">
                                <p>Water</p>
                                <p>170000</p>
                                <p>88400</p>
                                <p>81600</p>
                            </a>
                            <div class="collapse" id="collapseExample">
                                <div class="card card-body" style="border-radius:0px 0px 6px 6px; padding: 1.2%;">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6 col-md-7 col-lg-8">
                                            <table class="beni-tbl table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th style="width:25%;">Service/ Option</th>
                                                        <th>Number of Option</th>
                                                        <th>Number of Option User (max)</th>
                                                        {{-- <th>Sub Option user (max)</th>
                                                        <th>sub-Option</th> --}}
                                                        <th>Number of Total Planned User</th>
                                                        <th>F (52%)</th>
                                                        <th>M (48%)</th>
                                                        <th>Actual Handover</th>
                                                        <th>present User</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>DTW</td>
                                                        <td>400</td>
                                                        <td>100</td>
                                                        {{-- <td>100</td>
                                                        <td>1</td> --}}
                                                        <td>40000</td>
                                                        <td>20800</td>
                                                        <td>19200</td>
                                                        <td>52</td>
                                                        <td>5200</td>
                                                    </tr>
                                                    <tr>
                                                        <td>MPWSS</td>
                                                        <td>28</td>
                                                        <td>4643</td>
                                                        {{-- <td>93</td>
                                                        <td>50</td> --}}
                                                        <td>130200</td>
                                                        <td>67704</td>
                                                        <td>62496</td>
                                                        <td>2</td>
                                                        <td>9286</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Mobile Water Treatment</td>
                                                        <td>4</td>
                                                        <td>-</td>
                                                        {{-- <td>-</td>
                                                        <td>-</td> --}}
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>-</td>

                                                    </tr>
                                                    <tr>
                                                        <td>Sub total</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        {{-- <td>-</td>
                                                        <td>-</td> --}}
                                                        <td>170200</td>
                                                        <td>88504</td>
                                                        <td>81696</td>
                                                        <td>-</td>
                                                        <td>14486</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-5 col-lg-4">
                                            <figure class="highcharts-figure_1">
                                                <div id="container_1"></div>
                                            </figure>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <a class="mid-part2 w-100 btn btn-primary" data-toggle="collapse" href="#collapseExample2"
                                role="button" aria-expanded="false" aria-controls="collapseExample2">
                                <p>Sanitation</p>
                                <p>56700</p>
                                <p>29484</p>
                                <p>27216</p>
                            </a>
                            <div class="collapse" id="collapseExample2">
                                <div class="card card-body" style="border-radius:0px 0px 6px 6px; padding: 1.2%;">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6 col-md-7 col-lg-8">
                                            <table class="beni-tbl2 table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th style="width:25%;">Service/ Option</th>
                                                        <th>Number of Option</th>
                                                        <th>Number Option User (max)</th>
                                                        {{-- <th>Sub Option user (max)</th>
                                                        <th>sub-Option</th> --}}
                                                        <th>Number of Total Planned User</th>
                                                        <th>F (52%)</th>
                                                        <th>M (48%)</th>
                                                        <th>Actual Handover</th>
                                                        <th>Present User</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>HH toilet</td>
                                                        <td>3000</td>
                                                        <td>14</td>
                                                        {{-- <td>14</td>
                                                        <td>1</td> --}}
                                                        <td>42000</td>
                                                        <td>21840</td>
                                                        <td>20160</td>
                                                        <td>100</td>
                                                        <td>1400</td>

                                                    </tr>
                                                    <tr>
                                                        <td>Community Toilet</td>
                                                        <td>70</td>
                                                        <td>75</td>
                                                        {{-- <td>77</td>
                                                        <td>1</td> --}}
                                                        <td>5390</td>
                                                        <td>2802.8</td>
                                                        <td>2587.2</td>
                                                        <td>0</td>
                                                        <td>0</td>
                                                    </tr>
                                                    <tr>
                                                        <td>HH bio-fill toilet</td>
                                                        <td>500</td>
                                                        <td>14</td>
                                                        {{-- <td>14</td>
                                                        <td>1</td> --}}
                                                        <td>7000</td>
                                                        <td>3640</td>
                                                        <td>3660</td>
                                                        <td>0</td>
                                                        <td>0</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Composting bio-gas plant including toilet</td>
                                                        <td>30</td>
                                                        <td>75</td>
                                                        {{-- <td>77</td>
                                                        <td>1</td> --}}
                                                        <td>2310</td>
                                                        <td>1201.2</td>
                                                        <td>11080.8</td>
                                                        <td>0</td>
                                                        <td>0</td>

                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-5 col-lg-4">

                                            <figure class="highcharts-figure_2">
                                                <div id="container_2"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <figure class="highcharts-figure " style="margin-top:1%; border:1px solid #eeeded;">
                                <div id="container"></div>

                        </div>

                        <div class="bot-part">
                            <p>Grand Total</p>
                            <p>226700</p>
                            <p>117884</p>
                            <p>108816</p>
                        </div>


                    </div>
                </div>



                </figure>
            </div>
        </section>

        {{-- @include('procurement.dashboard') --}}

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

    <script>
        $('#collapseExample').collapse({
            toggle: false
        })

    </script>

    <script>
        $('#collapseExample2').collapse({
            toggle: false
        })

    </script>

    <script>
        $(document).ready(function() {

            $(document).on('click', '#paginationt1 a', function(event) {
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                var tabid = 1;
                fetch_data(page, tabid);
            });
            $(document).on('click', '#paginationt2 a', function(event) {
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                var tabid = 2;
                fetch_data(page, tabid);
            });
            $(document).on('click', '#paginationt3 a', function(event) {
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                var tabid = 3;
                fetch_data(page, tabid);
            });
            $(document).on('click', '#pagination4 a', function(event) {
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                var tabid = 4;
                fetch_data(page, tabid);
            });

            function fetch_data(page, tabid) {
                $.ajax({
                    data: tabid,
                    url: "/procurement-dashboard-pagination?page=" + page + "&tabid=" + tabid,
                    success: function(data) {
                        if (tabid == 1) {
                            $('#table_data1').html(data);
                        }
                        if (tabid == 2) {
                            $('#table_data2').html(data);
                        }
                        if (tabid == 3) {
                            $('#table_data3').html(data);
                        }
                        if (tabid == 4) {
                            $('#table_data4').html(data);
                        }

                    }
                });
            }

        });

    </script>

    <!--Sanitation   HIGHCHARTS -->
    <script>
        Highcharts.chart('container_2', {
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                type: 'category',
                labels: {
                    rotation: -45,
                    style: {
                        fontSize: '11px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Number of User (Percentage)'
                }
            },
            legend: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            tooltip: {
                pointFormat: '{point.y:.1f} Percent</b>'
            },
            series: [{
                name: 'Population',
                data: [
                    ['<b>Female</b>', 52],
                    ['<b>Male</b>', 48]
                ],
                dataLabels: {
                    enabled: true,
                    rotation: -360,
                    color: '#FFFFFF',
                    align: 'right',
                    format: '{point.y:.1f}', // one decimal
                    y: 10, // 10 pixels down from the top
                    style: {
                        fontSize: '10px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            }]
        });

    </script>

    <!--water   HIGHCHARTS -->
    <script>
        Highcharts.chart('container_1', {
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                type: 'category',
                labels: {
                    rotation: -45,
                    style: {
                        fontSize: '11px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Number of User (Percentage)'
                }
            },
            legend: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            tooltip: {
                pointFormat: '{point.y:.1f} Percent</b>'
            },
            series: [{
                name: 'Population',
                data: [
                    ['<b>Female</b>', 52],
                    ['<b>Male</b>', 48]
                ],
                dataLabels: {
                    enabled: true,
                    rotation: 360,
                    color: '#FFFFFF',
                    align: 'right',
                    format: '{point.y:.1f}', // one decimal
                    y: 10, // 10 pixels down from the top
                    style: {
                        fontSize: '10px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            }]
        });

    </script>

    <!--water and sanitation  HIGHCHARTS -->
    <script>
        Highcharts.chart('container', {
            chart: {
                type: 'bar'
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: ['Water', 'Sanitation'],
                title: {
                    text: null
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Number of User ',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: ''
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -40,
                y: 80,
                floating: true,
                borderWidth: 1,
                backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
                shadow: true
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Female',
                data: [88400, 29484]
            }, {
                name: 'Male',
                data: [81600, 27216]
            }, {
                name: 'Total',
                data: [117884, 108816]
            }]
        });

    </script>

    {{--
    <!-- HIGHCHARTS -->
    <script>
        Highcharts.chart("highchart1", {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: "pie"
            },
            title: {
                text: ""
            },
            tooltip: {
                pointFormat: "{series.name}: <b>{point.percentage:.1f}%</b>"
            },
            accessibility: {
                point: {
                    valueSuffix: "%"
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: "pointer",
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: "Brands",
                colorByPoint: true,
                data: <?php echo $total_package_chart; ?> ,
                credits: {
                    enabled: false
                },
                exporting: {
                    enabled: false
                }
            }]
        });

    </script>
    <script>
        Highcharts.chart("highchart2", {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: "pie"
            },
            title: {
                text: ""
            },
            tooltip: {
                pointFormat: "{series.name}: <b>{point.percentage:.1f}%</b>"
            },
            accessibility: {
                point: {
                    valueSuffix: "%"
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: "pointer",
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: "Brands",
                colorByPoint: true,
                data: <?php echo $total_package_tender_call_chart; ?> ,
                credits: {
                    enabled: false
                },
                exporting: {
                    enabled: false
                }
            }]
        });

    </script>
    <script>
        Highcharts.chart("highchart3", {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: "pie"
            },
            title: {
                text: ""
            },
            tooltip: {
                pointFormat: "{series.name}: <b>{point.percentage:.1f}%</b>"
            },
            accessibility: {
                point: {
                    valueSuffix: "%"
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: "pointer",
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: "Brands",
                colorByPoint: true,
                data: <?php echo $total_package_tender_call_chart; ?> ,
                credits: {
                    enabled: false
                },
                exporting: {
                    enabled: false
                }
            }]
        });

    </script>
    <script>
        Highcharts.chart("highchart4", {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: "pie",
                renderTo: false
            },
            title: {
                text: ""
            },
            tooltip: {
                pointFormat: "{series.name}: <b>{point.percentage:.1f}%</b>"
            },
            accessibility: {
                point: {
                    valueSuffix: "%"
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: "pointer",
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: "Brands",
                colorByPoint: true,
                data: <?php echo $contract_in_progress_chart; ?> ,
                credits: {
                    enabled: false
                },
                exporting: {
                    enabled: false
                }
            }]
        });

    </script> --}}


    <script>
        // - Noel Delgado | @pixelia_me

        var nodes = document.getElementsByClassName('view_3d'),
            //var nodes  = document.querySelector(".aware-hover"),
            _nodes = [].slice.call(nodes, 0);

        console.log(nodes);

        var getDirection = function(ev, obj) {
            var w = obj.offsetWidth,
                h = obj.offsetHeight,
                x = (ev.pageX - obj.offsetLeft - (w / 2) * (w > h ? (h / w) : 1)),
                y = (ev.pageY - obj.offsetTop - (h / 2) * (h > w ? (w / h) : 1)),
                d = Math.round(Math.atan2(y, x) / 1.57079633 + 5) % 4;

            return d;
        };

        var addClass = function(ev, obj, state) {
            var direction = getDirection(ev, obj),
                class_suffix = "";

            obj.className = "";

            switch (direction) {
                case 0:
                    class_suffix = '-top';
                    break;
                case 1:
                    class_suffix = '-right';
                    break;
                case 2:
                    class_suffix = '-bottom';
                    break;
                case 3:
                    class_suffix = '-left';
                    break;
            }

            obj.classList.add(state + class_suffix);
        };

        // bind events
        _nodes.forEach(function(el) {
            el.addEventListener('mouseover', function(ev) {
                addClass(ev, this, 'in');
            }, false);

            el.addEventListener('mouseout', function(ev) {
                addClass(ev, this, 'out');
            }, false);
        });

    </script>
@endpush
