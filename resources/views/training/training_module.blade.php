@extends('layouts.master')
@section('content')
    <div class="sub-head header header2">
      <div class="container">
        <div class="row">
			<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
				<div class="procurement-title">
                <h5 class="d-inline">
                    <img src="{{ custom_asset('assets/images/icons/training1.png') }}" alt="" /> Training Status
                </h5>                
            </div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
				<a class=" btn sub-btn float-right" href="{{ url('training-category') }}">Training Category</a>
				<a class="btn sub-btn float-right" href="{{ url('training') }}"  >Training</a>
				<a class="btn sub-btn float-right" href="{{ url('training-activity') }}" >Training Activities</a>
			</div>
		</div>
	  </div>
	</div>
<div class="main-content mt-4 ">
    <div class="container">
        
		
		
		<section class="procurement" id="tabs">
            <!--div class="procurement-title">
                <h3 class="d-inline">
                    <img src="{{ custom_asset('assets/images/procurement.png') }}" alt="" /> Training Status
                </h3>
                
            </div-->
            <ul class="tran_box">
                @foreach ($training_categories as $item)
                <li>
                    <a href="#tabs-1" >
                    <div class="card sub-box training_cate_id" data-id={{ $item->id }}>
                        <div class="card-header">
                            <h5 class="text-center">{{ $item->serial_no }}</h5>
                        </div>
                        
                        <div class="card-body">
                            <p class="">{{ $item->name }}</p>
                            
                        </div>
                    </div>
                    </a>
                </li>
                @endforeach
            </ul>
            <div id="tabs-1" class="procurement-tab">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="table-responsive" >
                            <table class="table table-bordered table-striped" id="training_details"  >
                                <thead class="t-blue">
                                    <tr>
                                        <td><strong>Sub-no.</strong></td>
                                        <td><strong>Name of the Item</strong></td>
                                        <td><strong>No. of total Training Events</strong></td>
                                        <td><strong>No. of Total Training Batches</strong></td>
                                        <td><strong>No. of total Training Events Actual</strong></td>
                                        <td><strong>No. of Total Training Batches Actual</strong></td>
                                    </tr>
                                </thead >
                                <tbody>
                                    @foreach ($training as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><a href="{{ url('training-activity?training_id=') }}">{{ $item->title }}</a></td>
                                        <td>{{ $item->total_event }}</td>
                                        <td>{{ $item->toatal_batch  }}</td>
                                        <td>{{ $item->number_of_event  }}</td>
                                        <td>{{ $item->number_of_batch  }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                  
                </div>
            </div>
        </section>
    </div>
</div>
@endsection

@push('script')

<script>

$(document).ready(function () {
   

    $('body').on('click', '.training_cate_id', function () {
        var id = $(this).data("id");
        console.log('function'+id); 
        $.ajax({
            type: "get",
            url: " {{ url('ajax/training_module_deatails_by_t_cat_id') }}"+'/'+id,
            success: function (data) {
                show_details(data.data)
            },
            error: function (data) {
                console.log('Error:', data);
                
            }
        });
    });
    function show_details(data){
        console.log(data);
        var html=`
                    <thead class="t-blue">
                        <tr>
                            <td><strong>Sub-no.</strong></td>
                            <td><strong>Name of the Item</strong></td>
                            <td><strong>No. of total Training Events</strong></td>
                            <td><strong>No. of Total Training Batches</strong></td>
                            <td><strong>No. of total Training Events Actual</strong></td>
                            <td><strong>No. of Total Training Batches Actual</strong></td>
                        </tr>
                    </thead >
               `
        $.each(data,function(key,value){
            var title = value.title?value.title:'-';
            var total_event = value.total_event?value.total_event:'-';
            var toatal_batch = value.toatal_batch?value.toatal_batch:'-';
            var number_of_event = value.number_of_event?value.number_of_event:'-';
            var number_of_batch = value.number_of_batch?value.number_of_batch:'-';
            html+=`<tbody>
                        <tr>
                            <td>${key+1}</td>
                            <td><a href="{{ url('training-activity?training_id=')."$item->id" }}">${title}</a></td>
                            <td>${total_event}</td>
                            <td>${toatal_batch}</td>
                            <td>${number_of_event}</td>
                            <td>${number_of_batch}</td>
                        </tr>
                    </tbody>`

            });
        $('#training_details').html(html);

    }

}); 
             
 
</script>
    
@endpush