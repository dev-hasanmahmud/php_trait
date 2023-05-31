@extends('layouts.master')
@section('content')
@push('css')
    <link rel="stylesheet" href="{{custom_asset('assets/css/colorbox.css')}}" />
@endpush
  <div class="main-content inner-page-content mt-4 mb-4 ">
      <div class="container">
        <section class="pl-2 pr-2 package-table card card-body package gallery">
        <form method="get"action="{{url('gallery')}}" role="search"  >
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="row">
					<div class="mb-3 col-xs-12 col-sm-12 col-md-12 col-lg-5">
						<select name="fm_category_id" id="category"  class="w-100 form-control form-control-sm select2 custom-select2">

								<option value="0">Select Category</option>
								 @foreach ($category as $item)
                <option value="{{ $item->id }}"
                  {{--
                    @if ($item->id==$search_id)
                    {{'selected= "selected" '}}
                  @endif
                  --}}
                  >{{ $item->title }}</option>
                @endforeach

						</select>
					</div>
					<div class="mb-3 col-xs-12 col-sm-12 col-md-12 col-lg-5">
						<div class="input-group datepicker-box">
							<div class="input-group datepicker-box">
							  <input name="date"  class="form-control datepicker w-100"
							  value=""
							  type="text" placeholder="YY-MM-DD" />
							</div>
						  </div>
					</div>
					<div class="mb-3 col-xs-12 col-sm-12 col-md-12 col-lg-2">
						<button class="w-100 btn btn-lg btn-outline-success">Show Image</button>
					</div>
				</div>
			</div>
			</form>
            <div class="col-xs-12 col-sm-12 col-md-12">
              <div class="row">
                  @php
                      $chk=0;
                  @endphp
                @foreach ($images as $item)
            <a class="gl-box col-xs-12 col-sm-12 col-md-3 group1" href="{{ custom_asset($item->file_path) }}" title="Title : {{ $item->name }}" >
                  <img
                    src="{{ custom_asset($item->file_path) }}"
                    width="100%"
                    height="200"
                    alt="EMCRP"
                  />
				  <div class="overlay"><div class="zoom"><i class="fa fa-expand fa-2x" aria-hidden="true"></i></div></div>
                  <span class="gallery-cap">
                    <p>Title : {{ $item->name }}</p>
                    <p>Date : {{ $item->date }}</p>
                  </span>
                </a>
                @php
                    $chk=1;
                @endphp
                @endforeach
                @if ($chk==0)
                    <div style="margin:0 auto;">
                    <img src="{{ asset('assets/images/no-image-found.jpg') }}" alt="preview image"  class="" style="" >
                    </div>
                @endif

              </div>
            </div>
             <div style="width:200; margin:0 auto;" class="mt-4">{{ $images->links() }}</div>
          </div>
        </section>

      </div>
    </div>
@endsection

@push('script')
     <!-- Initialize Swiper -->
<script src="{{custom_asset('assets/js/jquery.colorbox.js')}}"></script>
<script>
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
    </script>
 <script>
      $(document).ready(function() {
        //Examples of how to assign the Colorbox event to elements
        $(".group1").colorbox({ rel: "group1" , width:"90%", height:"90%" });
        $(".non-retina").colorbox({ rel: "group5", transition:"none" });
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
