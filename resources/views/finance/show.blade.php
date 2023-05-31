@extends('layouts.master')
@section('content')
<div class="sub-head header header2">
      <div class="container">
        <div class="row">
			<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
				<div class="procurement-title">
                <h5 class="d-inline">
                    <img src="{{ custom_asset('assets/images/icons/training1.png') }}" alt="" /> Finance Status
                </h5>
            </div>
            </div>
            {{-- <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                <a class=" btn sub-btn float-right" href="{{ route('financialitem.create') }}" ><i class="fa fa-plus"> </i> Add Record </a>
                <a class=" btn sub-btn float-right" href="{{ route('report') }}" ><i class="fa fa-eye"> </i> Show Report </a>
            </div> --}}
			<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
				<a class="btn sub-btn float-right" href="{{ url('financial-report-upload') }}"  ><i class="fa fa-cloud"></i> Finance Report Upload</a>
               <a class="btn sub-btn float-right" href="{{ url('manage-financial-report') }}"  ><i class="fa fa-tasks"></i> Manage Report</a>
                <a class="btn sub-btn float-right" href="{{route('dashboard')}}"> <i class="fa fa-dashboard"></i> Financial Dashboard</a>
			</div>
		</div>
	  </div>
</div>
<div class="main-content form-component mt-4 ">
      <div class="container">
	  <div class="package-table card card-body col-xs-12 col-sm-12 col-md-12 col-lg-12">
           @include('sweetalert::alert')
        <section class="package report">
          <form action="javascript:void(0)">
            <div class="form-row mb-2 row">

              <div class="col-xs-12 col-sm-12 col-md-4 col-lg-6">
                <select name="fm_category_id" id="category" class="form-control form-control-sm select2 custom-select2">
                  <option value="0">Select Category</option>
                    @foreach ($categories as $item)
                    <option value="{{ $item->id }}">{{ $item->title }}</option>
                    @endforeach
                </select>
              </div>

              <div class="col-xs-12 col-sm-12 col-md-1 col-lg-5">
                <div class="input-group datepicker-box">
                  <input name="date"  class="form-control datepicker w-100" 
                  value="{{old('date')}}"
                  type="text" placeholder="YY-MM-DD" />
                </div>
              </div>

              <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1">
                <button type="submit" id="submit"   class="btn btn-lg w-100 btn-info ">Find</button>
              </div>
            </div>
          </form>	
          {{-- <div class="row">
		  
           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">  
                <select name="fm_category_id" id="category"  class="form-control form-control-sm select2 custom-select2">
                        <option value="0">Select Financial Category</option>
                        @foreach ($categories as $item)
                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                        @endforeach
                </select>
            </div>
           
            <div class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-1">OR</div>
			
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
					<div class="form-group row">
					  <div class="col-sm-12">
						<div class="input-group datepicker-box">
						  <input name="date"  class="form-control datepicker w-100" 
						  value="{{old('date')}}"
						  type="text" placeholder="YY-MM-DD" />
						</div>
					  </div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
					<button type="submit" id="submit" class="w-100 btn btn-lg btn-outline-success">Show File</button>
				</div>
			
			
          </div> --}}
        </section>
        <div class="table-responsive text-center" id="report_table">
        @include('finance.table')
        </div>
        </div>
      </div>
    </div>
@endsection


@push('script')
<script>
$('document').ready(function(){

  $('body').on('click', '.page-link', function () {
      event.preventDefault(); 
      var url = $(this).attr('href')
      console.log(url)
      $.ajax({
        method:"GET",
        url: url,
        success: function(data){
          console.log(data)
          $('#report_table').html(data)
        },
        error: function(data){
          alert("Error");
        }
      });

    });

    $('body').on('click','#submit',function(){

      var catid= $('#category').val();
      var date = $("input[type='text']").val();
      var url= "{{ url('ajax/finance-report-by-submit') }}" + '/'+catid+'/'+date;
      console.log(url)
      $.ajax({
          method: "get",
          url: url,
          data: {
              'catid': catid,
              'date': date
            // 'package_id': package_id
          },
          success: function(response){
              $('#report_table').html(response);
          },
          error: function(response){
              alert("Error");
          }
      });
    });

  // $('body').on('click','#submit',function(){
      
  //       var catid= $('#category').val();
  //       var date = $("input[type='text']").val();
  //       var url= "{{ url('ajax/finance-report-by-submit') }}";
  //       $.ajax({
  //           method: "get",
  //           url: url,
  //           data: {
  //               'catid': catid,
  //               'date': date
  //              // 'package_id': package_id
  //           },
  //           success: function(response){
  //               $('#report_table').html(response);
  //           },
  //           error: function(response){
  //               alert("Error");
  //           }
  //       });
  // });

});
</script>
@endpush