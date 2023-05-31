<section class="ho-tab procurement" id="tabs">
	  <div class="container">
          <div class="procurement-title">
            <h3 class="d-inline">
                <img src="{{ asset('assets/images/procurement.png') }}" alt="" /> Package Status
            </h3>
            <span class="d-inline res-time float-right">Till {{ date('d M, Y') }}</span>
          </div>
          <ul class="res-tab-menu">
            <li>
              <a href="#tabs-1" data-id="1">
                <div class="card sub-box">
                  <div class="card-header">
                    <h5>Total Package</h5>
                  </div>
                  <div class="card-body">
                    <h1 class="d-inline">{{ $package->total() }}</h1>
              
                    <span class="d-inline float-right">{{ number_format(convert_to_lakh($total_amount),2,'.', ',')  }} Lakh</span>
                  </div>
                </div>
              </a>
            </li>
            <li>
              <a href="#tabs-2" data-id="2">
                <div class="card sub-box">
                  <div class="card-header">
                    <h5>Total Package Tender Call</h5>
                  </div>
                  <div class="card-body">
                    <h1 class="d-inline">{{ $package_tender_call->total() }}</h1>
                    <span class="d-inline float-right">{{ number_format(convert_to_lakh($total_amount_tender_call),2,'.', ',')  }} Lakh</span>
                  </div>
                </div>
              </a>
            </li>
            <li>
              <a href="#tabs-3" data-id="3">
                <div class="card sub-box">
                  <div class="card-header">
                    <h5>Tender Call</h5>
                  </div>
                  <div class="card-body">
                    <h1 class="d-inline">{{ $tender_call->total() }}</h1>
                    
                    <span class="d-inline float-right">{{ number_format(convert_to_lakh($amount_tender_call),2,'.', ',')  }} Lakh</span>
                  </div>
                </div></a
              >
            </li>
            <li>
              <a href="#tabs-4" data-id="4">
                <div class="card sub-box">
                  <div class="card-header">
                    <h5>Contract Inprogress</h5>
                  </div>
                  <div class="card-body">
                    <h1 class="d-inline">{{ $contract_in_progress->total() }}</h1>
                    <span class="d-inline float-right">{{ number_format(convert_to_lakh($total_amount_contract_in_progress),2,'.', ',')  }} Lakh</span>
                  </div>
                </div></a
              >
            </li>
          </ul>
          <div id="tabs-1" class="res-tab procurement-tab">
            <div class="row">
              <div class="col-xs-12 col-sm-6 col-md-8">
                <div class="table-responsive" id="table_data1">
                    @include('procurement.table1')
                </div>
              </div>
              <div class="res-chart col-xs-12 col-sm-6 col-md-4">
                <figure class="highcharts-figure">
                  <div id="highchart1" class="highcharts-container"></div>
                </figure>
              </div>
            </div>
          </div>
          <div id="tabs-2" class="res-tab procurement-tab">
            <div class="row">
              <div class="col-xs-12 col-sm-6 col-md-8">
                <div class="table-responsive" id="table_data2">
                      @include('procurement.table2')
                </div>
              </div>
              <div class="res-chart col-xs-12 col-sm-6 col-md-4">
                <figure class="highcharts-figure">
                  <div id="highchart2" class="highcharts-container"></div>
                </figure>
              </div>
            </div>
          </div>
          <div id="tabs-3" class="res-tab procurement-tab">
            <div class="row">
              <div class="col-xs-12 col-sm-6 col-md-8">
                <div class="table-responsive"  id="table_data3">
                      @include('procurement.table3')
                </div>
              </div>
              <div class="res-chart col-xs-12 col-sm-6 col-md-4">
                <figure class="highcharts-figure">
                  <div id="highchart3" class="highcharts-container"></div>
                </figure>
              </div>
            </div>
          </div>
          <div id="tabs-4" class="res-tab procurement-tab">
            <div class="row">
              <div class="col-xs-12 col-sm-6 col-md-8">
                <div class="table-responsive"  id="table_data4">
                     @include('procurement.table4')
                </div>
              </div>
              <div class="res-chart col-xs-12 col-sm-6 col-md-4">
                <figure class="highcharts-figure">
                  <div id="highchart4" class="highcharts-container"></div>
                </figure>
              </div>
            </div>
          </div>
       </div>  
	  </section>