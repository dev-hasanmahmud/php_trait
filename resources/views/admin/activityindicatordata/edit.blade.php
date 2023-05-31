@extends('layouts.master')
@section('content')
<div class="sub-head header header2">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
        <div class="procurement-title">
          <h5 class="d-inline">
            <i class="fa fa-database" aria-hidden="true"></i> Edit Activity Indicator Data
          </h5>                
        </div>
      </div>
   
    </div>
  </div>
</div>
    <div class="main-content mt-4 ">
    <div class="container">
      @include('sweetalert::alert')
    {{-- <div class="programme-title">
        <h3 class="d-inline">
            <img src="{{custom_asset('assets/images/programme.png')}}" alt="" />Edit Activity Indicator Data
        </h3>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('activity-indicator-data.index') }}">All Activity Indicators Data</a>
        </div>
    </div>
     <br> --}}
    <form  action="{{ route('activity-indicator-data.update',$activity_indicator_data->id) }}" method="post">
        @csrf
        @method('PUT')
        <div class="form-row">

          <div class="col-md-6 mb-3">
            <label for="component_Id">Package</label>
              <select name="component_id" id="component"class="form-control form-control-sm select2 custom-select2">
                <optgroup>
                  @foreach ($components as $item)
                    <option value="{{ $item->id }}"
                      @if ($item->id==$activity_indicator_data->component_id)
                        {{'selected= "selected" '}}
                      @endif
                      >{{ $item->name_en }}</option>
                  @endforeach
                </optgroup>
              </select>
          </div>

          <div class="col-md-6 mb-3">
            <label for="indicator_category_Id">Activity Indicator</label>
              <select name="activity_indicator_id" id="activity_indicator" class="form-control form-control-sm select2 custom-select2">
                <optgroup>
                <option value="">Select Package</option>  
                @foreach ($activity_indicators as $item)
                    <option value="{{ $item->id }}"
                      @if ($item->id==$activity_indicator_data->activity_indicator_id)
                        {{'selected= "selected" '}}
                      @endif
                      >{{ $item->name_en }}</option>
                  @endforeach
                </optgroup>
              </select>
          </div>

          <div class="col-md-6 mb-3">
            <label for="value"> Value </label>
            <input type="text" name="value" value="{{ $activity_indicator_data->value }}" class="form-control"  required />
          </div>

           <div class="col-md-6 mb-3">
            
          </div>
          

          <button class="btn btn-primary" type="submit">Update</button>
      
        </div>
      </form>
     

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

