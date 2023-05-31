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
    {{-- @include('procurement.dashboard') --}}
	<div class="container">
		<section style="display: table-cell;" class="procurement-page procurement" id="" >
  
		  <ul class="procur_tab_auto p-tab mt-2" >
    			<li  class="@if( $type_id==0 ) active @endif " ><a href="javascript:void(0)" class="type" data-id="0" >Package Type</a></li>
    			<li class="@if( $type_id==1 ) active @endif " ><a href="javascript:void(0)" class="type" data-id="1" >goods</a></li>
    			<li class="@if( $type_id==2 ) active @endif " ><a href="javascript:void(0)" class="type " data-id="2" >works</a></li>
          <li class="@if( $type_id==3 ) active @endif " ><a href="javascript:void(0)" class="type" data-id="3" >Consulting services</a></li>
          <li class="@if( $type_id==4 ) active @endif "><a href="javascript:void(0)" class="type" data-id="4">Non Consulting services</a></li>
		  </ul>

			<div class="card">
			  <div class="row">
				
        <div class="col-xs-12 col-sm-6 col-md-5 col-lg-4 box">
				  <div class="content-box" id="four_colour_{{ $type_id }}">
					 <h4>Total {{ $packageName }} Package</h4>
					 <div class="count"><h1>{{ $package->total() }}</h1></div>
          
          <div class="p_new_tbl_wrap">

            <div class="procur_new_tbl_box">
              {{-- <label></label>
              <h5>Services</h5> --}}
              {{-- <h5>Consulting Service</h5>
              <h5>Non Consulting Service</h5> --}}
            </div>

            <div class="procur_new_tbl_box">
                <label>Total Estimate Amount</label>
                <h6>{{ number_format(convert_to_lakh($data['estimate']),2,'.', ',')  }}</h6>
                {{-- <h5>{{ number_format(convert_to_lakh($consulting['estimate']),2,'.', ',')  }}</h5> --}}
                {{-- <h5>{{ number_format(convert_to_lakh($nonConsulting['estimate']),2,'.', ',')  }}</h5> --}}
            </div>
            <div class="procur_new_tbl_box">
                <label>Total Contract Amount</label>
                <h6>{{ number_format(convert_to_lakh($data['contact']),2,'.', ',')  }}</h6>
                {{-- <h5>{{ number_format(convert_to_lakh($consulting['estimate']),2,'.', ',')  }}</h5> --}}
                {{-- <h5>{{ number_format(convert_to_lakh($nonConsulting['estimate']),2,'.', ',')  }}</h5> --}}
            </div>
            <div class="procur_new_tbl_box">
                <label>Total Payment Receive</label>
                <h6>{{ number_format(convert_to_lakh($data['payment']),2,'.', ',')  }}</h6>
                {{-- <h5>{{ number_format(convert_to_lakh($consulting['estimate']),2,'.', ',')  }}</h5> --}}
                {{-- <h5>{{ number_format(convert_to_lakh($nonConsulting['estimate']),2,'.', ',')  }}</h5> --}}
            </div>


            <!-- <div class="consul-btn">
              <a class="mt-2 btn sub-btn float-left ml-0" href="">Consulting</a>
              <a class="mt-2 btn sub-btn float-right mr-0" href="">Non Consulting</a>
            </div> -->


          </div>

				  </div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-7 col-lg-8">
				  <div class="table-responsive card-body" style="padding-right: 20px;" id="table_content">
					@include('procurement.new_table_1')
				  </div>			  
				</div>

			  </div>
			</div>
  
		</section>

	  </div>


	
</div>

{{-- <figure class="highcharts-figure">
	<div id="container"></div>
</figure> --}}

<input type="text" hidden="" value="{{ $type_id }}" id="type_id" >

  <!-- ///////////////////////////////////// MODAL ///////////////////////////////////////// -->

  <div class="modal fade package_modal" tabindex="-1" role="dialog" id="package_modal">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal_title"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><i class="fa fa-times"></i></span>

          </button>
        </div>
        <div id="modal_body" class="modal-body">

        </div>
      </div>
    </div>
  </div>

  <!-- ///////////////////////////////////// MODAL ///////////////////////////////////////// -->

@endsection

@push('script')

<script>
$(document).ready(function(){

	$('body').on('click', '.pop_up', function () {
		
		var id = $(this).data('id')
		console.log('pop up  '+id)
		var url = ""
		$.ajax({
        type: "GET",
        url:  " {{ url('ajax/procurement/package_details_by_id') }}",
        data:{"id":id},
        //dataType:'JSON',
        //headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function (data) {
          console.log('fff' +data.data)
          show_modal(data.data)
        },
        error: function (data) {
			console.log('e')
         // console.log(data.responseText)
          //$('#table_content').html(data.responseText)
        }
      });
	});

	function show_modal(data){
		var remark = data.remark ? data.remark : '';
		var html=`          <ul>
            <li><span> <i class="fa fa-snowflake-o" aria-hidden="true"></i> Package No. : </span> ${data.package_no }</li>
            <li>
              <span> <i class="fa fa-snowflake-o" aria-hidden="true"></i> Description of Procurement as per RDPP :
              </span> ${data.name_en}</li>
            <li>
              <span> <i class="fa fa-snowflake-o" aria-hidden="true"></i> Unit : </span> ${data.unit.name_en} </li>
            <li>
              <span> <i class="fa fa-snowflake-o" aria-hidden="true"></i> Quantity : </span>${data.quantity}</li>
            <li>
              <span> <i class="fa fa-snowflake-o" aria-hidden="true"></i> Procurement Method & Type : </span> ${data.proc_method.name_en}
            </li>
            <li>
              <span> <i class="fa fa-snowflake-o" aria-hidden="true"></i> Contract Approving Authority : </span>${data.approving_authority.name_en} </li>
            <li>
              <span> <i class="fa fa-snowflake-o" aria-hidden="true"></i> Contract Amount (BDT) : </span> ${data.contract_price_act_bdt}
            </li>
            <li>
              <span> <i class="fa fa-snowflake-o" aria-hidden="true"></i> Remarks : </span> ${remark}
            </li>
            <li>
              <fieldset class="scheduler-border">
                <legend class="scheduler-border">Indicative Dates :
                </legend>
                
                  <p>
                    <span>Signing of Contract: </span> ${ data.signing_of_contact_act }
                    <p>
                      <span>Completion of Contract: </span> ${ data.complition_of_contact_act }
                    </p>
              </fieldset>
            <li>
		  </ul>`
		  $('#modal_title').html(data.package_no+' : '+data.name_en)
		  $('#modal_body').html(html)
		  $('#package_modal').modal("show");
	}

	$('body').on('click', '.type', function () {
		console.log('fun')
		var type_id = $(this).data("id");
		window.location.assign("procurement-dashboard?type_id="+type_id)
	});

	$('body').on('click', '.page-link', function () {
		event.preventDefault()
		console.log('pagination')
		var type_id = $('#type_id').val()
		var url = $(this).attr('href')
		var url = $(this).attr('href')+'&type_id='+type_id
		console.log(url)
		//window.location.assign("procurement-dashboard?type_id="+type_id)
		$.ajax({
        type: "GET",
        url: url,
        //data:{"type_id":type_id},
        //dataType:'JSON',
        //headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function (data) {
          //console.log('fff' +data)
          $('#table_content').html(data)
        },
        error: function (data) {
			console.log('e')
         // console.log(data.responseText)
          //$('#table_content').html(data.responseText)
        }
      });
	});



});

</script>

<script>
	var colors = Highcharts.getOptions().colors,
  categories = [
    'Works',
    'Goods',
    'Service',
    
  ],
  data =<?php echo $s; ?>,
  
  browserData = [],
  versionsData = [],
  i,
  j,
  dataLen = data.length,
  drillDataLen,
  brightness;


// Build the data arrays
for (i = 0; i < dataLen; i += 1) {

  // add browser data
  browserData.push({
    name: categories[i],
    y: data[i].y,
    color: data[i].color
  });

  // add version data
  drillDataLen = data[i].drilldown.data.length;
  for (j = 0; j < drillDataLen; j += 1) {
    brightness = 0.2 - (j / drillDataLen) / 5;
    versionsData.push({
      name: data[i].drilldown.categories[j],
      y: data[i].drilldown.data[j],
      color: Highcharts.color(data[i].color).brighten(brightness).get()
    });
  }
}

// Create the chart
Highcharts.chart('container', {
  chart: {
    plotBackgroundColor: null,
		plotBorderWidth: null,
		plotShadow: false,
    type: 'pie'
  },
  title: {
    text: ''
  },
  subtitle: {
    text: ''
  },
  plotOptions: {
    pie: {
      allowPointSelect: true,
			cursor: "pointer",
			dataLabels: {
				enabled: true
			},
			showInLegend: false,
    }
  },
  tooltip: {
    pointFormat: "{series.name}: <b>{point.percentage:.1f}%</b>"
  },
  series: [{
    name: '',
    data: browserData,
    size: '60%',
    dataLabels: {
      formatter: function () {
        return this.y > 1 ? this.point.name : null;
      },
      color: '#ffffff',
      distance: -30
    },
    exporting: {
			 enabled: false
		   }
  }, {
    name: '',
    data: versionsData,
    size: '80%',
    innerSize: '60%',
    dataLabels: {
      formatter: function () {
        // display only if larger than 1
        return this.y > 1 ? '<b>' + this.point.name + ':</b> ' +
          this.y + '%' : null;
      }
    },
    id: 'versions'
  }],
  responsive: {
    rules: [{
      condition: {
        maxWidth: 400
      },
      chartOptions: {
        series: [{
        }, {
          id: 'versions',
          dataLabels: {
            enabled: false
          }
        }]
      }
    }]
  }
});

</script>
	 <!-- HIGHCHARTS -->
	  <!-- HIGHCHARTS -->
	  <script>
		Highcharts.chart("highchart_1", {
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
@endpush