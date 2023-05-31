@extends('layouts.master')
@section('content')
 
    <body>

    <div class="main-content inner-page-content mt-4 mb-4 ">
      <div class="container">
        
        <section class="package report">
          <div class="row">
            <div class="col-8">
              <div class="dropdown">
                <a
                  class="btn"
                  href="#"
                  role="button"
                  id="dropdownMenuLink"
                  data-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                  style="width: 250px;"
                >
                  Dropdown Option <i class="fa fa-angle-down"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                  <a class="dropdown-item" href="#">All</a>
                  <a class="dropdown-item" href="#">Goods</a>
                  <a class="dropdown-item" href="#">Works</a>
                  <a class="dropdown-item" href="#">Service</a>
                </div>
              </div>
            </div>
            <div class="col-4">
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-7 mb-3">
                  <div class="input-group datepicker-box">
                    <input
                      id="datepicker"
                      class="form-control datepicker float-right"
                      type="text"
                    />
                    <button class="btn btn-primary">
                      <i class="fa fa-calendar"></i>
                    </button>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-5 mb-3 text-right">
                  <button class="btn btn-primary show-report w-100" id="submit">
                    Show Report
                  </button>
                </div>
              </div>
            </div>
          </div>

          
         <div class="table-responsive text-center" id="tablecontent">
           
          </div>
        

       
        </section>
      </div>
    </div>

   

    <!-- Initialize Swiper -->
  </body>

@endsection

@push('script')
    <script>
        $('#submit').on('click',function(){
            //alert('ok');
            
            var op = ` <table class="table table-bordered bg-white report-table">
              <thead>
                <tr>
                  <td>SL No.</td>
                  <td>Package No.</td>
                  <td>Description of Procurement as per RDPP</td>
                  <td>Unit</td>
                  <td>Quantity</td>
                  <td>Procurement Method & Type</td>
                  <td>Contract Approving Authority</td>
                  <td>Source of Funds</td>
                  <td>Estd. Cost (Taka in Lac)</td>
                  <td colspan="3">Indicative Dates</td>
                </tr>
                <tr>
                  <td colspan="9"></td>
                  <td>Invitation for Tender</td>
                  <td>Signing of Contract</td>
                  <td>Completion of Contract</td>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td></td>
                  <td>1</td>
                  <td>2</td>
                  <td>3</td>
                  <td>4</td>
                  <td>5</td>
                  <td>6</td>
                  <td>7</td>
                  <td>8</td>
                  <td>9</td>
                  <td>10</td>
                  <td>11</td>
                </tr>
                <tr>
                  <td colspan="12" class="text-left">GOODS :</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td>GD-01</td>
                  <td class="text-left">
                    Truck based mobile water treatment plant with O & M
                  </td>
                  <td>No.</td>
                  <td>4</td>
                  <td>OTM (NCT)</td>
                  <td>PD, DPHE</td>
                  <td></td>
                  <td>1,000.00</td>
                  <td>22-Dec-19</td>
                  <td>19-Feb-20</td>
                  <td>20-Jul-20</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>GD-02</td>
                  <td class="text-left">
                    Truck mounted water carrier with O & M
                  </td>
                  <td>No.</td>
                  <td>5</td>
                  <td>OTM (NCT)</td>
                  <td>PD, DPHE</td>
                  <td>PA (IDA Grant)</td>
                  <td>425.00</td>
                  <td>22-Dec-19</td>
                  <td>19-Feb-20</td>
                  <td>20-Jul-20</td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>GD-03</td>
                  <td class="text-left">Vacutug with O & M</td>
                  <td>No.</td>
                  <td>6</td>
                  <td>OTM (NCT)</td>
                  <td>PD, DPHE</td>
                  <td></td>
                  <td>390.00</td>
                  <td>01-Feb-20</td>
                  <td>03-Apr-20</td>
                  <td>31-Aug-20</td>
                </tr>
              </tbody>
            </table>
               <div class="print-show text-right mt-3">
            <a href="" class="btn btn-success btn-sm">
              <i class="fa fa-print"></i>
            </a>
            <a href="/export/xlsx" class="btn btn-info btn-sm">
              <i class="fa fa-file-excel-o" aria-hidden="true"></i>
            </a>
          </div>`;
             $("#tablecontent").html(op);
        });
    </script>
    <script>
      $(document).ready(function(){
        $( function() {
            $( "#tabs" ).tabs();
        } );
	})

    </script>
@endpush




