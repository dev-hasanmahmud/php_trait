@extends('layouts.master')
@section('content')
 
<div class="sub-head header header2">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
        <div class="procurement-title">
          <h5 class="d-inline">
            <i class="fa fa-database" aria-hidden="true"></i> Add Activity Indicator Data
          </h5>                
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        <a class="active btn sub-btn float-right" href="{{ route('activity-indicator-data.create') }}" ><i class="fa fa-plus"> </i> Add Activity Indicator Data </a>
        
      </div>
    </div>
  </div>
</div>

<div class="main-content form-component mt-4 ">
      <div class="container">
	  		<div class="card mb-4 card-design">
          <div class="card-body">
            <div class="card-title bg-primary text-white">
              <h5>Create Activity Indicator Data</h5>
            </div>
      @include('sweetalert::alert')
    {{-- <div class="programme-title">
        <h3 class="d-inline">
            <img src="{{custom_asset('assets/images/programme.png')}}" alt="" />Create Activity Indicator Data
        </h3> 
        <div class="pull-right">
            <a class="btn btn-info" href="{{ route('activity-indicator-data.index') }}">All Activity Indicators Data</a>
        </div>
    </div>
     <br> --}}
    <form action="{{ route('activity-indicator-data.store') }}"  method="post">
        @csrf
        <div class="form-row">

          <div class="col-md-6 mb-3">
            <label for="component_Id">Package <span class="mendatory">*</span>
            </label>
              <select name="component_id" id="component"class="form-control form-control-sm select2 custom-select2">
                <optgroup>
                  <option value="">Select package</option>
                  @foreach ($components as $item)
                    <option value="{{ $item->id }}">{{ $item->name_en }}</option>
                  @endforeach
                </optgroup>
              </select>
          </div>

          <div class="col-md-6 mb-3">
            <label for="indicator_category_Id">Activity Indicator <span class="mendatory">*</span>
            </label>
            <select name="activity_indicator_id" id="activity_indicator" class="form-control form-control-sm select2 custom-select2">
                 <option value="">Select the package list</option>
            </select>
          </div>
          

          <div class="col-md-6 mb-3">
            <label for="progress_value"> Value 
              <span class="mendatory">*</span>
            </label>
            <input type="text" name="value" class="form-control"  required />
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
    var url =  " {{ url('ajax/get_active_indicator') }}"+'/'+component_id;
    console.log(component_id)
    $.ajax({
      method:'POST',
      url: url,
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      success: (data)=>{
        show_indicator(data.data)
        console.log(data.data);        
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
    $('#activity_indicator').html(html);

  }

}); 
 
//  $('#component_id').change(function(){ 

//   console.log("outside")
//  })
 
</script>
    
@endpush


