@extends('layouts.master')
@section('content')
 
<div class="main-content inner-page-content mt-4 mb-4 ">
    <div class="container">
        <section class="package report" >
            <div class="row">
                <div class="col-8">
                    <h4>
                    <i class="fa fa-cubes text-primary"></i> Procurement Report
                    </h4>
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

          
            <div class="table-responsive bg-white" id="tablecontent">

            </div>
                
            
            </div>
        </section>
    </div>
</div>

@endsection

@push('script')
<script>
$('document').ready(function(){


  $('body').on('click','#submit',function(){
    console.log("hello");
    var url =  " {{ url('ajax/report/procurement_monthly_report') }}";
    $.ajax({
      method:'GET',
      url: url,
      success: (data)=>{
        $("#tablecontent").html(data);  
      },
      error: function(data){
      }
    });

   

  })


});

</script>
@endpush




