@extends('layouts.master')
@section('content')
<div class="sub-head header header2">
      <div class="container">
        <div class="row">
			<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
				<div class="procurement-title">
                <h5 class="d-inline">
                    <img src="{{ asset('assets/images/procurement.png') }}" alt="" /> Procurement
                </h5>                
            </div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
				<a class="btn sub-btn float-right" href="{{ url('package') }}" >Package</a>
				<a class="btn sub-btn float-right" href="{{ url('financial-target') }}" >Package Target</a>
				<a class=" btn sub-btn float-right" href="{{ url('payment') }}">Payment</a>
				<a class="btn sub-btn float-right" href="{{ url('package_settings') }}" >Package Settigns</a>
				<a class="btn sub-btn float-right" href="{{ url('report/procurement-monthly-report') }}" >Monthly Procurement Report</a>
			</div>
		</div>
	  </div>
	</div>
	
	
	
	
<div class="main-content mt-4">
    @include('procurement.dashboard')
 
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
      $(document).ready(function(){

      $(document).on('click', '#paginationt1 a', function(event){
        event.preventDefault(); 
        var page = $(this).attr('href').split('page=')[1];
        var tabid =1;
        fetch_data(page,tabid);
      });
        $(document).on('click', '#paginationt2 a', function(event){
        event.preventDefault(); 
        var page = $(this).attr('href').split('page=')[1];
        var tabid =2;
        fetch_data(page,tabid);
      });
        $(document).on('click', '#paginationt3 a', function(event){
        event.preventDefault(); 
        var page = $(this).attr('href').split('page=')[1];
        var tabid =3;
        fetch_data(page,tabid);
      });
        $(document).on('click', '#pagination4 a', function(event){
        event.preventDefault(); 
        var page = $(this).attr('href').split('page=')[1];
        var tabid =4;
        fetch_data(page,tabid);
      });

      function fetch_data(page,tabid)
      {
        $.ajax({
        data: tabid,
        url:"/procurement-dashboard-pagination?page="+page+"&tabid="+tabid,
        success:function(data)
        {
          if(tabid==1){
             $('#table_data1').html(data);
          }
          if(tabid==2)
          {
             $('#table_data2').html(data);
          }
          if(tabid==3){
             $('#table_data3').html(data);
          }
          if(tabid==4)
          {
             $('#table_data4').html(data);
          }
         
        }
        });
      }
      
      });
  </script>
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
        series: [
          {
            name: "Brands",
            colorByPoint: true,
            data: <?php echo $total_package_chart; ?>,
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
        series: [
          {
            name: "Brands",
            colorByPoint: true,
            data: <?php echo $total_package_tender_call_chart; ?>,
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
        series: [
          {
            name: "Brands",
            colorByPoint: true,
            data: <?php echo $total_package_tender_call_chart; ?>,
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
            data: <?php echo $contract_in_progress_chart; ?>,
        credits: {
          enabled: false
        },
        exporting: {
          enabled: false
        }
       }]
     });
  </script>

@endpush

