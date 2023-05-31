@extends('layouts.master')
@section('content')

<div class="sub-head header header2">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
        <div class="procurement-title">
          <h5 class="d-inline">
            <i class="fa fa-window-restore" aria-hidden="true"></i> Add Area
          </h5>                
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        <a class="active btn sub-btn float-right" href="{{ route('camp.create') }}" ><i class="fa fa-plus"> </i> Add  Area </a>
        
      </div>
    </div>
  </div>
</div>

<div class="main-content form-component mt-4 ">
      <div class="container">
	  		<div class="card mb-4 card-design">
          <div class="card-body">
            <div class="card-title bg-primary text-white">
              <h5>Create Area</h5>
            </div>
      @include('sweetalert::alert')
    {{-- <div class="clearfix programme-title">
        <h3 class=" d-inline">
            <img src="{{custom_asset('assets/images/programme.png')}}" alt="" />Create  Area
        </h3>
        <a class="pull-right btn btn-success" href="{{ route('camp.index') }}">Index Page</a>
        
    </div> --}}

      <form action="{{ route('camp.store') }}"  method="post">
        @csrf
        <div class="form-row">

          <div class="col-md-6 mb-3">
            <label for="code">Area Code</label>
            <input type="text" name="code" class="form-control"  required />
          </div>

          <div class="col-md-6 mb-3">
            <label for="Name_en">Area Name (English) </label>
            <input type="text" name="name_en" class="form-control"  required />
          </div>

          <div class="col-md-6 mb-3">
            <label for="name_bn">Area Name (Bangli) </label>
            <input type="text" name="name_bn" class="form-control" />
          </div>

          <div class="col-md-6 mb-3">

          </div>

          <div class="text-right col-md-12 mb-3">
			<button type="button" class="btn-lg btn btn-warning">Cancel</button>
			<button class="btn-lg btn btn-primary" type="submit">Save</button>
          </div>

        </div>
    </form>
    
    </div>
  </div>
      </div>
  </div>
@endsection

@push('script')

<script>

$(document).ready(function () {

  $('#component').change(function(){
    console.log('get indicator list')
    var component_id = $('#component').val()
    var url =  " {{ url('ajax/get_indicator') }}"+'/'+component_id;
    console.log(component_id)
    $.ajax({
      method:'POST',
      url: url,
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      success: (data)=>{
        show_indicator(data.data)
        //console.log(data.data);
      },
      error: function(data){

      }
    });
  });

  function show_indicator(data){
    console.log(data);
      var html='<option value="0"> Select Indicator </option>'
      $.each(data,function(key,value){
        //console.log(value.name_en)
        html+=`<option value= "${value.id}"> ${value.name_en}</option>`

      });
    $('#indicator').html(html);

  }

});

//  $('#component_id').change(function(){

//   console.log("outside")
//  })

</script>

@endpush

