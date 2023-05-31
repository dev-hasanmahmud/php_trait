<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EMCRP</title>


    <!-- FONTAWESOME -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    {{--
    <link rel="stylesheet" href="{{ custom_asset('assets/css/cdn/font-awesome.min.css') }}" />
    --}}
    <!-- FONTAWESOME -->
    <link rel="stylesheet" href="{{ custom_asset('assets/css/fonts/solaimanLipi/fonts.css') }}">
    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="{{ custom_asset('assets/css/cdn/bootstrap.min.css') }}" />
    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="{{ custom_asset('assets/datetimepicker/bootstrap-material-datetimepicker.css') }}">
    @if (!isset($jquery_css))
        {{--
        <link rel="stylesheet" href="{{ custom_asset('assets/css/cdn/jquery-ui.css') }}" />
        --}}
    @endif



    <link rel="stylesheet" href="{{ custom_asset('assets/css/cdn/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ custom_asset('assets/css/main.css') }}" />
    <link rel="stylesheet" href="{{ custom_asset('assets/css/responsive.css') }}" />
    @stack('css')
</head>

<body class="@if (Request::is('dashboard')) home-bg @endif " >


  @php
  $url = Request::url() ;
  $url = explode('/',$url);
  // $settingArray = array('package','package_settings','indicator','indicator_category','indicator_data','activitycategory','activityindicator','activity-indicator-data','payment','camp','contactor');
  // $ln = count($settingArray);
  // for($i = 0; $i < $ln; $i++) {

  //   if($settingArray[$i]){

  //   }
  // }
  @endphp

  <div class=" respo-head header">
    <div class="container">
        <div class="row">
            <nav class=" pr-0 navbar navbar-expand-lg w-100">
                <div class="row w-100" style="line-height: 0;">
                    <div class="devi-0-575 col-sm-4 col-md-3 col-lg-3">
                        <a class="logo navbar-brand pb-0 pt-0" href="{{ url('/dashboard') }}"></a>
                    </div>

                    <div style="position:relative!important; z-index:10;"
                        class="pr-0 devi-575 col-sm-8 col-md-9 col-lg-9">
                        <ul class="pull-right pomenu tab-login navbar-nav ml-auto">

                            <!-- Notifications -->
                            <li class="noti nav-item dropdown">
                                <a class="noti-sup noti-toggle nav-link dropdown-toggle waves-effect"
                                    alt="Notifications" id="navbarNotification" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="true">
                                    <span id="navbarNotificationCounter" class="rounded" alt="Notifications"
                                        style="display:back;">
                                        <i style="font-size:14px;margin-left: 4px;" class="fa fa-bell"
                                            alt="Notifications"></i>
                                        <!--i class="fa fa-exclamation" aria-hidden="true"></i-->
                                    </span>

                                </a>

                                <div class="noti-drop-menu dropdown-menu dropdown-menu-right"
                                    id="navbarNotificationContent" aria-labelledby="navbarDropdownMenuLink"
                                    style="    max-height: 300px; overflow-y: scroll; min-width: 300px; overflow-x: hidden;">

                                </div>

                            </li> <!-- Notifications -->

                            <li class="nav-item dropdown user-avator">
                                <a class="mt-1 nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="{{ custom_asset('assets/images/avator.png') }}" class="avator mr-1"
                                        alt="avator" />
                                    {{ isset(Auth::user()->name) ? Auth::user()->name : '' }}
                                </a>
                                <div style="position:absolute!important;" class="dropdown-menu dropdown-menu-right"
                                    aria-labelledby="navbarDropdown">
                                    <a class="us-drop dropdown-item" href="{{ url('change-password') }}"><i
                                            class="fa fa-key" aria-hidden="true"></i> Change Password</a>
                                    <a class="us-drop dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                            class="fa fa-sign-out" aria-hidden="true"></i> Logout </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>

                </div>
            </nav>
        </div>
    </div>
    </div>
    <div class="@if (Request::is('dashboard')) home-me-bor @endif header
        header2">
        <div class="container">
            <div class="row">
                <nav class="col-md-12 col-lg-12 pt-0 pb-0 navbar navbar-expand-lg" id="main_navbar">
                    <button class="navbar-toggler res-m-i pl-0" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class=" respo-manu navbar-toggler-icon"><i class="fa pobar-i fa-bars"
                                aria-hidden="true"></i></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">

                        <ul class="po-nav navbar-nav mr-auto">
                            <li class="nav-item  @if (Request::is('dashboard')) active @endif " >
           <a class=" nav-link" href="{{ url('dashboard') }}">Dashboard</a>
                            </li>
                            @if (isset($permission['PackageDashboardController@index']))
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Packages
                                    </a>
                                    <ul class="dropdown-menu m-sub" aria-labelledby="navbarDropdown">
                                        @foreach (@App\Type::all() as $type)


                                            <li class="nav-item dropdown">
                                                <a class="dropdown-item dropdown-toggle" href="#" id="navbarDropdown1"
                                                    role="button" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    {{ $type->name_en }}
                                                </a>
                                                @php
                                                $packages = @App\Component::whereType_id($type->id
                                                )->orderBy('package_no')->get();
                                                @endphp

                                                @if (!$packages->isEmpty())
                                                    <ul class="lolo-nav dropdown-menu"
                                                        aria-labelledby="navbarDropdown1">
                                                        @forelse($packages as $key=>$package )
                                                            <li class="nav-item"><a class="nav-link dropdown-item"
                                                                    href="{{ url('package_dashboard') . '/' . $package->id }}">{{ $package->package_no }}</a>
                                                            </li>
                                                        @empty
                                                        @endforelse
                                                    </ul>
                                                @endif

                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endif

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Reports</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                                <a class="dropdown-item @if (in_array('finance-dashboard', $url)) active @endif " href="{{ url('finance-dashboard') }}">Progress Reports (GOB)</a>

                                <a class="dropdown-item" href="{{ url('dashboard/report?reportId=1') }}">Training Reports</a>

                                <a class="dropdown-item" href="{{ url('dashboard/report?reportId=40') }}">Reports (World Bank)</a>

                                <a class="dropdown-item" href="{{ url('dashboard/report?reportId=43') }}">Others</a>
                            </div>
                        </li>




                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Package Wise     Reports
                            </a>

                            <ul class="dropdown-menu m-sub" aria-labelledby="navbarDropdown">

                                @foreach (@App\Type::all() as $type)
                                    <li class="nav-item dropdown">
                                        <a class="dropdown-item dropdown-toggle" href="#" id="navbarDropdown1"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $type->name_en }} </a>


                                        @php
                                            $packages = @App\Component::whereType_id($type->id)->orderBy('package_no')->get();
                                        @endphp

                                        @if (!$packages->isEmpty())
                                            <ul class="lolo-nav dropdown-menu" aria-labelledby="navbarDropdown1">
                                            @forelse($packages as $key=>$package )
                                                <li class="nav-item">
                                                    <a class="nav-link dropdown-item"
                                                    href="{{ url('dashboard/package-report?package_id='). $package->id }}">{{ $package->package_no }}</a>
                                                </li>
                                            @empty

                                            @endforelse
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </li>





                        {{-- < class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Component</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @foreach (@App\Common::get_menu_item_for_package() as $id => $r)
                                    <a class="dropdown-item"
                                        href="{{ url('package_dashboard') . '/' . $id }}">{{ $r['name'] }}</a>
                                @endforeach
                            </div>
                        </> --}}

                        {{-- <li class="nav-item">
                            <a class="nav-link" href="">Procurement</a>
                        </li> --}}
                        {{-- @if (isset($permission['GisController@index']))
                            <li class="nav-item">
                            <li class="nav-item @if (Request::is('dashboard/gis')) active @endif">
                                <a class="nav-link" href="{{ url('dashboard/gis') }}">GIS</a>
                            </li>
                        @endif --}}

                        @if (isset($permission['AppImageController@index']))
                            <li class="nav-item @if (Request::is('app-image')) active @endif">
                                <a class="nav-link" href="{{ url('app-image') }}">Data Acquisition</a>
                            </li>
                        @endif

                        @if (isset($permission['DashboardController@gallery']))
                            <li class="nav-item @if (Request::is('gallery')) active @endif">
                                <a class="nav-link" href="{{ url('gallery') }}">Gallery</a>
                            </li>
                        @endif
                        {{-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Report
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="">Procurement Report 1</a>
                                <a class="dropdown-item" href="">Financial Report 1</a>
                                <a class="dropdown-item" href="">Daily Hydrogeological Report(Test Tubewell)</a>
                                <a class="dropdown-item" href="">Report 3</a>
                            </div>
                        </li> --}}

                        @if (isset($permission['MenuBarSettingButton']))
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Settings</a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    @if (isset($permission['PackageController@index']))
                                        <a class="dropdown-item @if (in_array('package', $url)) active @endif " href="
                                            {{ url('package') }}">Package</a>@endif
                                    @if (isset($permission['PackageController@package_settings']))<a
                                            class="dropdown-item @if (in_array('package_settings',
                                            $url)) active @endif " href="
                                            {{ url('package_settings') }}">Package Settings</a>@endif
                                    @if (isset($permission['IndicatorController@index']))<a
                                            class="dropdown-item @if (in_array('indicator',
                                            $url)) active @endif " href="
                                            {{ url('indicator') }}">Indicator List</a>@endif
                                    @if (isset($permission['IndicatorCategoryController@index']))<a
                                            class="dropdown-item @if (in_array('indicator_category', $url)) active @endif " href=" {{ url('indicator_category') }}">Indicator Category</a>
                                    @endif
                                    @if (isset($permission['IndicatorDataController@index']))<a
                                            class="dropdown-item @if (in_array('indicator_data',
                                            $url)) active @endif " href="
                                            {{ url('indicator_data') }}">Indicator Wise Progress</a>@endif

                                    @if (isset($permission['ActivityCategoryController@index']))<a
                                            class="dropdown-item @if (in_array('activitycategory',
                                            $url)) active @endif " href="
                                            {{ url('activitycategory') }}">Activity Category</a>@endif
                                    @if (isset($permission['ActivityIndicatorController@index']))<a
                                            class="dropdown-item @if (in_array('activityindicator', $url)) active @endif " href=" {{ url('activityindicator') }}">Activity Indicator</a>
                                    @endif

                                    {{-- @if (isset($permission['ActivityIndicatordataControlller@index']))<a
                                            class="dropdown-item @if (in_array('activity-indicator-data', $url)) active @endif " href=" {{ url('activity-indicator-data') }}">Activity
                                            Indicator Data</a>@endif
                                    --}}

                                    @if (isset($permission['ApprovalController@index']) && (Auth::user()->role == 1 || Auth::user()->role == 6))
                                        <a class="dropdown-item @if (in_array('approval',
                                            $url)) active @endif " href="
                                            {{ url('approval') }}">
                                            Recommend Indicator Data
                                        </a>

                                    @elseif( isset($permission['ApprovalController@index']) )
                                        <a class="dropdown-item @if (in_array('approval',
                                            $url)) active @endif " href="
                                            {{ url('approval') }}">
                                            Approval
                                        </a>
                                    @endif

                                    @if (isset($permission['ApprovalController@report_file_approve_index']) && (Auth::user()->role == 1 || Auth::user()->role == 6))
                                        <a class="dropdown-item @if (in_array('report-file-approve', $url)) active @endif " href=" {{ url('report-file-approve') }}">
                                            Recommend Report
                                        </a>

                                    @elseif(isset($permission['ApprovalController@report_file_approve_index']) )
                                        <a class="dropdown-item @if (in_array('report-file-approve', $url)) active @endif " href=" {{ url('report-file-approve') }}">
                                            Report Approval
                                        </a>
                                    @endif

                                    @if (isset($permission['PaymentController@index']))
                                        <a class="dropdown-item @if (in_array('payment', $url)) active @endif " href="
                                            {{ url('payment') }}">Payment</a>@endif

                                    @if (isset($permission['CampController@index']))<a
                                            class="dropdown-item @if (in_array('camp', $url)) active @endif " href=" {{ url('camp') }}">Area
                                            List</a>@endif
                                    @if (isset($permission['ContactsController@index']))<a
                                            class="dropdown-item @if (in_array('contactor',
                                            $url)) active @endif " href="
                                            {{ url('contactor') }}">Contractor / Consultant / Supplier List</a>
                                    @endif

                                    @if (isset($permission['UserController@index']))<a
                                            class="dropdown-item @if (Request::is('')) active @endif " href=" {{ url('user') }}">User List
                                        </a>@endif
                                    {{-- <a class="dropdown-item @if (Request::is('')) active @endif " href="">Access List</a> --}}

                             @if (isset($permission['DashboardDynamicImageController@index']))<a
                                            class="dropdown-item @if (in_array('dashboard_dynamic_image', $url)) active @endif " href=" {{ url('dashboard_dynamic_image') }}">Home Page
                                            Banner Image</a>
                        @endif

                        {{-- @if (isset($permission['AppImageController@index']))<a
                                class="dropdown-item @if (in_array('app-image', $url)) active @endif " href=" {{ url('app-image') }}">Data
                                Acquisition</a>@endif --}}

                    </div>
                    </li>
                    @endif
                    </ul>

            </div>
            @if (!Request::is('dashboard'))
                <a class="btn back-btn float-right" onclick="goBack()">
                    <i class="fa fa-angle-double-left" aria-hidden="true"></i> Back
                </a>
            @endif

            </nav>

        </div>
    </div>
    </div>
    @yield('content')




    <div class="respons-footer footer">
        <div class="container">
            <div class="row">
                <div class="text-left col-xs-12 col-sm-5 col-md-3">
                    <img src="{{ asset('assets/images/DPHE_logo.png') }}" alt="">
                </div>
                <div class="text-right col-xs-12 col-sm-7 col-md-9">
                    <p class="pb-0 pt-0">pddphe.emcrp@gmail.com<i class="fa fa-envelope-o" aria-hidden="true"></i></p>
                    <p class="pb-0 pt-0">14, Captain Mansur Ali Sarani, Kakrail, Dhaka-1000<i class="fa fa-map-marker"
                            aria-hidden="true"></i></p>

                </div>


                <!-- <div class="copyright col-xs-12 col-sm-12 col-md-12">
                <div class="row">
                  <div class="col-xs-12 col-sm-6 col-md-6">
                    <img src="images/logo.png" width="252" height="40" />
                  </div>
                  <div class="cst text-right col-xs-12 col-sm-6 col-md-6">
                    Technical assistance -
                    <a href="http://creativesofttechnology.com">CST</a>
                  </div>
                </div>
              </div> -->
            </div>
        </div>
    </div>

    <!-- ///////////////////////////////////// CDN ///////////////////////////////////////// -->

    <script src="{{ custom_asset('assets/js/cdn/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ custom_asset('assets/js/cdn/select2.min.js') }}"></script>
    <script src="{{ custom_asset('assets/js/cdn/cleave.min.js') }}"></script>

    <script src="{{ custom_asset('assets/js/cdn/popper.min.js') }}"></script>

    <script src="{{ custom_asset('assets/js/cdn/bootstrap.min.js') }}"></script>

    <script src="{{ custom_asset('assets/js/cdn/jquery-ui.min.js') }}"></script>

    <!-- HIGHCHARTS -->
    <script src="{{ custom_asset('assets/js/cdn/highchart/highcharts.js') }}"></script>
    <script src="{{ custom_asset('assets/js/cdn/highchart/exporting.js') }}"></script>
    <script src="{{ custom_asset('assets/js/cdn/highchart/export-data.js') }}"></script>
    <script src="{{ custom_asset('assets/js/cdn/highchart/accessibility.js') }}"></script>

    <!-- HIGHCHARTS -->

    <!-- ////////////////// time  /////////////////// -->


    <!-- ///////////////////////////////////// CDN ///////////////////////////////////////// -->
    <script src="{{ custom_asset('assets/js/main.js') }}"></script>


    <!-- sub menu js  start-->

    <script>
        $(function() {
            $('#main_navbar').bootnavbar();
        })

    </script>
    <script type="text/javascript">
        (function($) {
            var defaults = {
                sm: 540,
                md: 720,
                lg: 960,
                xl: 1140,
                navbar_expand: 'lg'
            };
            $.fn.bootnavbar = function() {

                var screen_width = $(document).width();

                if (screen_width >= defaults.lg) {
                    $(this).find('.dropdown').hover(function() {
                        $(this).addClass('show');
                        $(this).find('.dropdown-menu').first().addClass('show').addClass(
                            'animated fadeIn').one(
                            'animationend oAnimationEnd mozAnimationEnd webkitAnimationEnd',
                            function() {
                                $(this).removeClass('animated fadeIn');
                            });
                    }, function() {
                        $(this).removeClass('show');
                        $(this).find('.dropdown-menu').first().removeClass('show');
                    });
                }

                $('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
                    if (!$(this).next().hasClass('show')) {
                        $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
                    }
                    var $subMenu = $(this).next(".dropdown-menu");
                    $subMenu.toggleClass('show');

                    $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
                        $('.dropdown-submenu .show').removeClass("show");
                    });

                    return false;
                });
            };
        })(jQuery);

    </script>
    <!-- sub menu js end -->
    <!-- start select2 function -->
    <script>
        function matchStart(params, data) {
            // If there are no search terms, return all of the data
            if ($.trim(params.term) === '') {
                return data;
            }

            // Skip if there is no 'children' property
            if (typeof data.children === 'undefined') {
                return null;
            }

            // `data.children` contains the actual options that we are matching against
            var filteredChildren = [];
            $.each(data.children, function(idx, child) {
                if (child.text.toUpperCase().indexOf(params.term.toUpperCase()) == 0) {
                    filteredChildren.push(child);
                }
            });

            // If we matched any of the timezone group's children, then set the matched children on the group
            // and return the group object
            if (filteredChildren.length) {
                var modifiedData = $.extend({}, data, true);
                modifiedData.children = filteredChildren;

                // You can return modified objects from here
                // This includes matching the `children` how you want in nested data sets
                return modifiedData;
            }

            // Return `null` if the term should not be displayed
            return null;
        }

        $(".select2").select2();

    </script>
    <!-- end select2 function -->

    <!-- end date time function -->
    <script>
        function goBack() {
            window.history.back();
        }

    </script>


    <!-- Date Time Picker JS -->

    <script>
        function currentTime() {
            var date = new Date(); /* creating object of Date class */
            var hour = date.getHours();
            var min = date.getMinutes();
            var sec = date.getSeconds();
            hour = updateTime(hour);
            min = updateTime(min);
            sec = updateTime(sec);
            //document.getElementById("clock").innerText = hour + " : " + min + " : " + sec; /* adding time to the div */
            var t = setTimeout(function() {
                currentTime()
            }, 1000); /* setting timer */
        }

        function updateTime(k) {
            if (k < 10) {
                return "0" + k;
            } else {
                return k;
            }
        }
        currentTime(); /* calling currentTime() function to initiate the process */

    </script>

    <script src="{{ custom_asset('assets/datetimepicker/moment-with-locales.min.js') }}"></script>
    <script src="{{ custom_asset('assets/datetimepicker/bootstrap-material-datetimepicker.js') }}"></script>

    <!--notification-->
    <script src="https://www.gstatic.com/firebasejs/6.4.2/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/6.4.2/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/6.4.2/firebase-database.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>

    {{-- <script>
        /*show console.log function disable for production server*/
        console.log('Sorry , developers tools are blocked here....');
        var DEBUG = false; // ENABLE/DISABLE  for DEBUG true/false Console Logs
        if (!DEBUG) {
            console.log = function() {}
        }

    </script> --}}

    <script>
        var notification_count = 0;
        var base_url = "{{ url('/') }}";
        // Initialize Firebase
        // Your web app's Firebase configuration
        var firebaseConfig = {
            apiKey: "AIzaSyDmmPHrkyTMzs1_FbSLrushWcKN-T25jLc",
            authDomain: "a2i-dashboard.firebaseapp.com",
            databaseURL: "https://a2i-dashboard.firebaseio.com",
            projectId: "a2i-dashboard",
            storageBucket: "a2i-dashboard.appspot.com",
            messagingSenderId: "776154843459",
            appId: "1:776154843459:web:487b86e1a35d323b"
        };
        firebase.initializeApp(firebaseConfig);
        firebase.database().ref("emcrp/").orderByChild("to_user_id").equalTo({{Auth::user()->id}})
            .on("value", function(snapshot) {
                // Read the value using foreach
                var notification = snapshot.val()
                //console.log(noti['-MKnyockd1haelQ_II_i'].link)
                data = "";
                var index = 0;
                array = new Array();
                snapshot.forEach(function(childSnapshot) {
                    // key will be "unique child name generated by firebase"
                    var key = childSnapshot.key;
                    // childData will be the actual contents of the child
                    var childData = childSnapshot.val();
                    if (childData.executed == 0) {
                        notification_count = 1;
                        //console.log('Executed: ' + JSON.stringify(childData.messege));
                        //update_notification_statu();
                        // show the notfication in the div
                        // console.log(childData)
                        // var now = new Date(childData.created_at);
                        // var dateString = moment(now).format('LLLL');
                        array.push(key);

                        // data +='<a class="dropdown-item text-wrap" data-notification-date="06/23/2020 12:49" href="'+childData.link+'" >';
                        // data +='  <p class="small no-da text-muted text-uppercase mb-1"><i class="fa fa-calendar" aria-hidden="true"></i>'+dateString+'</p>';
                        // data +='  <p class="noti-text mb-0">'+childData.messege+'</p>';
                        // data +='</a>';

                    } else {
                        //console.log('Not Executed: ' + JSON.stringify(childData));
                    }

                });

                for (i = array.length - 1; i > 0; i--) {
                    var key = array[i];
                    var childData = notification[key];
                    var now = new Date(childData.created_at);
                    var dateString = moment(now).format('LLLL');
                    data += '<a class="dropdown-item text-wrap" data-notification-date="06/23/2020 12:49" href="' +
                        childData.link + '" >';
                    data +=
                        '  <p class="small no-da text-muted text-uppercase mb-1"><i class="fa fa-calendar" aria-hidden="true"></i>' +
                        dateString + '</p>';
                    data += '  <p class="noti-text mb-0">' + childData.messege + '</p>';
                    data += '</a>';
                }
                //console.log(i)

                if (data != "") {
                    $("#notification-buble").show();
                } else {
                    $("#notification-buble").hide();
                    $("#notification").html(data);
                }

                $("#navbarNotificationContent").html(data);

                if (notification_count == 1) {
                    $("#navbarNotificationCounter").last().addClass("noti-act");
                }
            });

        //update data in firebase
        function update_notification_statu() {
            var childId = "-LnS-UAMI22dFIAY3x86"; // we can get this value from  html hidden element

            try {
                firebase.database().ref("emcrp/").child(childId).update({
                    'executed': 1
                })
                //console.log('hello');
            } catch (error) {
                console.log(error.message);
            }

        }

    </script>



    <script type="text/javascript">
        $(document).ready(function() {
            $('#date-format').bootstrapMaterialDatePicker({
                weekStart: 0,
                time: false,
                format: 'YYYY-DD-MM'
            });

            $('.datepicker, #date-format3').bootstrapMaterialDatePicker({
                weekStart: 0,
                time: false,
                format: 'YYYY-MM-DD'
            });
        });

    </script>

    <script>
        $(function() {
            $("#tabs").tabs();
        });

    </script>
    @stack('script')
    <!-- HIGHCHARTS -->

    <script>
        // if(window.location.host.indexOf('localhost:9000') < 0) {
        //     console.log = function(){};
        // }
        const style = [
            'color: powderBlue',

            'background:red',
            'font-size: 3em',
           ' border:1px solid purple',
           'padding: 20px'
        ].join(';');
        console.log('%cWelcome To EMCRP!',style)
        var DEBUG = false;
        if(!DEBUG){
            if(!window.console) window.console = {};
            var methods = ["log", "debug", "warn", "info"];
            for(var i=0;i<methods.length;i++){
                console[methods[i]] = function(){};
            }
        }
    </script>

</body>

</html>
