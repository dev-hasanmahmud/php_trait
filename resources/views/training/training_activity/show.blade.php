@extends('layouts.master')
@section('content')
@push('css')
    <link rel="stylesheet" href="{{custom_asset('assets/css/colorbox.css')}}" />
@endpush
<div class="main-content form-component mt-4">
      <div class="container">
        @include('sweetalert::alert')
        <div class="card mb-4 card-design">
          <div class="card-body">
				<div class="card-title bg-primary text-white text-center">
				  <h5>Training Activity Information</h5>
				</div>
            
			<div class="table-responsive">
			<table class="po-show table table-bordered table-striped">
			  <tbody>
				 <tr>
				  <th>Training Name :</th>
				  <td>{{ $training_activity[0]->title }}</td>
				</tr>
				<tr>
				  <th>Total Number of Participants Scheduled :</th>
				  <td>{{ $training_activity[0]->number_of_benefactor }}</td>
				</tr>
				<tr>
				  <th>Training Category Name :</th>
				  <td>{{ $training_activity[0]->name }}</td>
				</tr>
				<tr>
				  <th>Number of Participants Per Batch :</th>
				  <td>{{ $training_activity[0]->number_of_participant_perbatch }}</td>
				</tr>
				<tr>
				  <th>Number Of Event:</th>
				  <td>{{  $training_activity[0]->number_of_event }}</td>
				</tr>
				<tr>
				  <th>Number of Participants Attended  :</th>
				  <td> {{ $training_activity[0]->number_of_participant_attend }}</td>
				</tr>
				<tr>
				  <th>Date: </th>
				  <td>{{ $training_activity[0]->date }}</td>
				</tr>
				  <tr>
				  <th>Number of Female Participants Attended : </th>
				  <td>{{ $training_activity[0]->female }}</td>
				  </tr>
				  <tr>
				  <th>Reference : </th>
				  <td>{{ $training_activity[0]->reference }}</td>
				  </tr>
				</tbody>
          </table>
          <div class="mt-4 text-center"></div>
        </div>
			  
			<div class="mb-4 col-xs-12 col-sm-12 col-md-12">
				<fieldset class="tra-img-gal scheduler-border">
                    <legend align="center" class="tra-img-gal scheduler-border"><i class="fa fa-picture-o" aria-hidden="true"></i>
 Image Gallery</legend>
					
					<div class="row pt-2">
						@foreach ($image_list as $item)
							
								<a class="gl-box col-xs-12 col-sm-12 col-md-3 group1" href="{{ custom_asset($item->file_path) }}" title="Title : EMCRP" >
								  <img  src="{{ custom_asset($item->file_path) }}" width="100%" height="200" alt="EMCRP" />
								  <div class="overlay"><div class="zoom"><i class="fa fa-expand fa-2x" aria-hidden="true"></i></div></div>
								  <span class="gallery-cap">
									<p>Title : Images title here</p>
									<p>Date : 12 / 05 / 2020</p>
								  </span>
								</a>
							
						@endforeach					
					</div>
                  </fieldset>				  
			</div>


			<div class="mb-4 col-xs-12 col-sm-12 col-md-12">
				<fieldset class="tra-file-gal scheduler-border">
                    <legend align="center" class="tra-file-gal scheduler-border"><i class="fa fa-file-text-o" aria-hidden="true"></i>
 Files Gallery</legend>
					
					<div class="row">
								 @forelse($file_list as $r)
								 @php
									$fileName = explode('-.-',$r->file_path);
								  @endphp
								  <div class="col-xs-12 col-sm-12 col-md-3">
									<a class="btn-outline-popo w-100 mt-2 btn btn-lg btn-outline-secondary" href="{{ url($r->file_path) }}">{{ $fileName[1] }}</a>
								</div>
								  @empty
								  @endforelse
								
					</div>
                  </fieldset>				  
			</div>

          </div>
		  </div>
          </div><!-- container -->
        </div>

@endsection


@push('script')

<script>

$(document).ready(function () {
   
  $('#training_category').change(function(){ 
    console.log('get indicator list')
    var training_category_id = $('#training_category').val()

    var url =  " {{ url('ajax/get_training_by_id') }}"+'/'+training_category_id;
    console.log(training_category_id)
    $.ajax({
      method:'POST',
      url: url,
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      success: (data)=>{
        console.log(data)
        show_training_name(data.data)
      },
      error: function(data){
        var html=''
        
        
        $('#contractor').html(html);
      }
    });
  }); 


  function show_training_name(data){
    //console.log(data);   
      var html=''
      $.each(data,function(key,value){
        //console.log(value.name_en)
        html+=`<option value= "${value.id}"> ${value.serial_number}-${value.title}</option>`

      });
    $('#training_name').html(html);
  }
});                 
</script>
 <!-- Initialize Swiper -->
<script src="{{custom_asset('assets/js/jquery.colorbox.js')}}"></script>
{{-- <script>
      var swiper = new Swiper(".swiper-container-slider", {
        slidesPerView: 3,
        spaceBetween: 10,
        freeMode: true,
        autoplay: {
          delay: 2500,
          disableOnInteraction: false
        },
        // init: false,
        pagination: {
          el: ".swiper-pagination-slider",
          clickable: true
        },
        breakpoints: {
          640: {
            slidesPerView: 2,
            spaceBetween: 20
          },
          768: {
            slidesPerView: 2,
            spaceBetween: 40
          },
          1024: {
            slidesPerView: 3,
            spaceBetween: 50
          }
        }
      });
    </script> --}}
 <script>
      $(document).ready(function() {
        //Examples of how to assign the Colorbox event to elements
        $(".group1").colorbox({ rel: "group1" , width:"90%", height:"90%" });
        $(".non-retina").colorbox({ rel: "group5", transition: "none" });
        $(".retina").colorbox({
          rel: "group5",
          transition: "none",
          retinaImage: true,
          retinaUrl: true
        });
        //Example of preserving a JavaScript event for inline calls.
        $("#click").click(function() {
          $("#click")
            .css({
              "background-color": "#f00",
              color: "#fff",
              cursor: "inherit"
            })
            .text(
              "Open this window again and this message will still be here."
            );
          return false;
        });
      });
 </script>
@endpush