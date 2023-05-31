@extends('layouts.master')
@section('content')

<div class="sub-head header header2">
    <div class="container">
        @include('sweetalert::alert')
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
          <div class="procurement-title">
            <h5 class="d-inline">
                <i class="fa fa-file-text-o" aria-hidden="true"></i> GIS Dashboard
            </h5>                
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
          <a class=" btn sub-btn float-right" href='{{ url("dashboard/gis/create") }}' ><i class="fa fa-plus"> </i> Add  Record </a>
          <a class=" btn sub-btn float-right" href='{{ url("dashboard/gis/manage") }}' ><i class="fa fa-tasks"> </i> Manage Record </a>
          {{-- <a class=" btn sub-btn float-right" href='{{ url("dashboard/drawing-design-report?package_id=").$package_id }}' ><i class="fa fa-dashboard"> </i> Drawing & Design Dashboard</a> --}}
          {{-- <a class=" btn sub-btn float-right" href="{{ route('dd.home') }}" ><i class="fa fa-check"> </i> Choose  Package</a> --}}
        </div>
      </div>
    </div>
  </div>

<div class="main-content mt-0 ">
    
        <section class="new-sec-1 pt-3">
            <div class="container">
                <div class="row">
                    @foreach ($categories as $item)
                     <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 hom-sec-box">
                           <a class="finance-das-box card box report_tab" data-id="{{$item->id}}"> 
                           <div class="d-inline-flex">
                            <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8"><h4>{{ $item->title }}</h4></div>
                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4"><h4>
                             @if(isset($file_count_array[$item->id]))
                            {{ $file_count_array[$item->id] }}
                            @else
                            0
                            @endif
                            </h4></div>
                          </div>
                        </a>
                        </div>
                        {{-- <div class="report-sec col-xs-12 col-sm-6 col-md-3 col-lg-3 hom-sec-box">
                            <a class="card box report_tab" data-id="{{$item->id}}">
                                <h4>{{$item->title}}</h4>
                            </a>
                        </div> --}}
                    @endforeach
					
                </div>
				
            </div>
        </section>
        <section class="new-sec-1">
            <div class="container">
					 <div class="package-table card card-body col-xs-12 col-sm-12 col-md-12 col-lg-12">
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
								<div class="form-group row">
								  <div class="col-sm-12">   
									<select name="fm_category_id" id="category"  class="form-control form-control-sm select2 custom-select2">
									  <option value="0">Select Category</option>
										 @foreach ($categories as $item)
                                            <option value="{{ $item->id }}">{{ $item->title }}</option>
                                         @endforeach
									</select>
								  </div>
								</div>
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
								<button type="submit" id="submit" class="w-100 btn btn-lg btn-outline-secondary">Show File</button>
							</div>
						</div> --}}
					 
						@include('gis.table')
					</div>
				
			</div>
        </section>	  
 
 </div>

@endsection

@push('script')
 <script>
$(document).ready(function(){ 

  $('body').on('click', '.page-link', function () {
      console.log('pagination')
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

     $('.report_tab').on('click',function(){

         $('a').removeClass('active');
         $(this).addClass('active');
        
        var catid = $(this).data("id");
        
        $.ajax({
            method:"get",
            url: " {{ url('ajax/gis-by-category') }}"+'/'+catid,
            success: function(response){
                $('#report_table').html(response);
            },
            error: function(response){
                alert("Error");
            }
        });
     });

     $('body').on('click','#submit',function(){

        var catid= $('#category').val();
        var date = $("input[type='text']").val();
        var url= "{{ url('ajax/gis-by-submit') }}"+'/'+catid+'/'+date;
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
});
 </script>
@endpush