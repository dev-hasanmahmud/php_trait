<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EMCRP</title>

    <!-- FONTAWESOME -->
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <link rel="stylesheet" href="{{ custom_asset('assets/css/cdn/font-awesome.min.css') }}" />
    <!-- FONTAWESOME -->

    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="{{ custom_asset('assets/css/cdn/bootstrap.min.css') }}" />
    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="{{ custom_asset('assets/css/cdn/jquery-ui.css') }}" />
    <link rel="stylesheet" href="{{ custom_asset('assets/css/main.css') }}" />
    <link rel="stylesheet" href="{{ custom_asset('assets/css/cdn/select2.min.css') }}" />


  @stack('css')
  </head>

  <body class="home-bg">
    <div class="header">
      <div class="container">
        <div class="row">
          <nav class="navbar navbar-expand-lg w-100">
            <a class="logo navbar-brand" href="#"></a>

            <ul class="navbar-nav ml-auto">
              <li class="nav-item dropdown user-avator">
                <a
                  class="nav-link dropdown-toggle"
                  href="#"
                  id="navbarDropdown"
                  role="button"
                  data-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                >
                  <img
                    src="{{ custom_asset('assets/images/avator.png') }}"
                    class="avator mr-2"
                    alt="avator"
                  />
                  {{ isset(Auth::user()->name) ? Auth::user()->name : '' }}
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="inner_page.html">Profile</a>
                  <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                    Logout</a>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                      </form>

                </div>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>

    <div class="header header2">
      <div class="container">
        <div class="row">
          <nav class="pt-0 pb-0 navbar navbar-expand-lg">
            <button
              class="navbar-toggler"
              type="button"
              data-toggle="collapse"
              data-target="#navbarSupportedContent"
              aria-controls="navbarSupportedContent"
              aria-expanded="false"
              aria-label="Toggle navigation"
            >
              <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav mr-auto">
                <li class="nav-item active"><a class="pl-0 nav-link" href="{{ url('dashboard') }}">Dashboard</a></li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Programme</a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    @foreach(@App\Common::get_menu_item_for_package() as  $id=>$r )
                  <a class="dropdown-item" href="{{ url("package_dashboard").'/'.$id }}">{{ $r['name'] }}</a>
                    @endforeach
                 </div>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="procurement.html">Procurement</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="gis.html">GIS</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="gallery.html">Gallery</a>
                </li>
                <li class="nav-item dropdown">
                  <a
                    class="nav-link dropdown-toggle"
                    href="#"
                    id="navbarDropdown"
                    role="button"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    Report
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="report.html"
                      >Procurement Report 1</a
                    >
                    <a class="dropdown-item" href="report_3.html"
                      >Financial Report 1</a
                    >
                    <a class="dropdown-item" href="report_1.html"
                      >Daily Hydrogeological Report(Test Tubewell)</a
                    >
                    <a class="dropdown-item" href="report_2.html">Report 3</a>
                  </div>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Settings</a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ url('package') }}">Package</a>
                    <a class="dropdown-item" href="{{ url('package_settigns') }}">Package Settings</a>
                  <a class="dropdown-item" href="{{ url('indicator') }}">Indicator</a>
                  <a class="dropdown-item" href="{{ url('indicator_category') }}">Indicator Category</a>
                  <a class="dropdown-item" href="indicator_data">Indicator Data</a>

                    <a class="dropdown-item" href="">User List </a>
                    <a class="dropdown-item" href="user_permission.html">Access List</a>
                  </div>
                </li>
              </ul>
            </div>
          </nav>
        </div>
      </div>
    </div>
	@yield('content')




    <div class="footer">
      <div class="container">
        <div class="row">
          <div class="col-xs-12 col-sm-6 col-md-4">
            <h5>Contact</h5>
            <p>
              01687863379, 01841226136<br />
              Email : info@gmail.com<br />
              dphe@gmail.com
            </p>
          </div>
          <div class="col-xs-12 col-sm-6 col-md-4">
            <h5>EMCRP</h5>
            <p>
              The Government of the People’s Republic of Bangladesh (GoB) has
              received a grant from the International Development Association
              (IDA) towards the cost of Emergency Multi-Sector Rohingya Crisis
              Response Project (EMRCRP).
            </p>
          </div>
          <div class="text-right col-xs-12 col-sm-6 col-md-4">
            <h5>Address</h5>
            <p>
              DPHE Bhaban 9th Floor 14,<br />
              Shaheed Caption Monsur Ali Sarani<br />
              Kakrail, Dhaka-1000
            </p>
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
    <script src="{{ custom_asset('assets/js/cdn/popper.min.js') }}"></script>
    <script src="{{ custom_asset('assets/js/cdn/bootstrap.min.js') }}"></script>

    <script src="{{ custom_asset('assets/js/cdn/jquery-ui.min.js') }}"></script>

    <!-- HIGHCHARTS -->
    <script src="{{ custom_asset('assets/js/cdn/highchart/highcharts.js') }}"></script>
    <script src="{{ custom_asset('assets/js/cdn/highchart/exporting.js') }}"></script>
    <script src="{{ custom_asset('assets/js/cdn/highchart/export-data.js') }}"></script>
    <script src="{{ custom_asset('assets/js/cdn/highchart/accessibility.js') }}"></script>
    <!-- HIGHCHARTS -->

    <!-- ////////////////// Select 2 /////////////////// -->
    <script src="js/cdn/select2.min.js"></script>

    <!-- ///////////////////////////////////// CDN ///////////////////////////////////////// -->
    <script src="{{ custom_asset('assets/js/main.js') }}"></script>
    <script src="{{ custom_asset('assets/js/cdn/select2.min.js') }}"></script>
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
        $.each(data.children, function (idx, child) {
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

      $(".select2").select2({
        matcher: matchStart
      });
    </script>
     <!-- end select2 function -->
    <!-- end date time function -->
     <script>
      $(function () {
        $(".datepicker").datepicker({
          dateFormat: "yy-mm-dd"
        });
      });
    </script>



    <script>
      $(function() {
        $("#tabs").tabs();
      });
    </script>

    <!-- HIGHCHARTS -->
    <script>
      // Build the chart
      Highcharts.chart("highchart", {
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
        series: [
          {
            name: "Brands",
            colorByPoint: true,
            data: [
              {
                name: "GD-01",
                y: 61.41,
                sliced: true,
                selected: true
              },
              {
                name: "GD-02",
                y: 11.84
              },
              {
                name: "GD-03",
                y: 10.85
              },
              {
                name: "GD-04",
                y: 4.67
              },
              {
                name: "GD-05",
                y: 4.18
              },
              {
                name: "GD-06",
                y: 7.05
              }
            ]
          }
        ],
        credits: {
          enabled: false
        },
        exporting: {
          enabled: false
        }
      });
    </script>
	@stack('script')
    <!-- HIGHCHARTS -->
  </body>
</html>
