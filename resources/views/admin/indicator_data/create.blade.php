@extends('layouts.master')

@push('css')
<link href="{{ custom_asset('assets/plugins/summernote/dist/summernote.css') }}" type="text/css" rel="stylesheet">   <!-- Summernote --> 
@endpush

@section('content')
<div class="sub-head header header2">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
        <div class="procurement-title">
          <h5 class="d-inline">
            <i class="fa fa-window-restore" aria-hidden="true"></i> Create Indicator Wise Progress
          </h5>                
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        <a class="active btn sub-btn float-right" href="{{ route('indicator_data.create') }}" ><i class="fa fa-plus"> </i> Add  Indicator Wise Progress </a>
        
      </div>
    </div>
  </div>
</div>

<div class="main-content form-component mt-4 ">
      <div class="container">
	  		<div class="card mb-4 card-design">
          <div class="card-body">
            <div class="card-title bg-primary text-white">
              <h5>Create Indicator Wise Progress</h5>
            </div>
      @include('sweetalert::alert')
    {{-- <div class="programme-title">
        <h3 class="d-inline">
            <img src="{{custom_asset('assets/images/programme.png')}}" alt="" />Create  Indicator Wise Progress
        </h3>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('indicator_data.index') }}">Index Page</a>
        </div>
    </div>
     <br> --}}
    <form action="{{ route('indicator_data.store') }}"  method="post">
        @csrf
        <div class="form-row">

          <div class="col-md-6 mb-3">
            <label for="component_Id">Package <span class="mendatory">*</span></label>
              <select name="component_id" id="component" class="form-control form-control-sm select2 custom-select2">
                <optgroup>
                  <option value="0"> Select Package </option>
                  @foreach ($component as $item)
                    <option value="{{ $item->id }}">{{ $item->package_no }}-{{ $item->name_en }}</option>
                  @endforeach
                </optgroup>
              </select>
          </div>

          <div class="col-md-6 mb-3">
            <label for="indicator_category_Id">Indicator <span class="mendatory">*</span> </label>
              <select name="indicator_id" id="indicator" class="form-control form-control-sm select2 custom-select2">
                <option value="0"> Select Indicator </option>
              </select>
          </div>

          <div class="col-12 mb-3" id="previous_details">
			     
          </div>

          <div class="col-md-6 mb-3">
            <label for="achievement_quantity">Achievement In Quantity <span class="mendatory">*</span> </label>
            <input type="number" name="achievement_quantity" id="achievement_quantity" class="form-control"  required=""/>
          </div>

          <div class="col-md-6 mb-3">
            <label for="progress_value">Progress Percentage (%) </label>
            <input type="text" name="progress_value" id="progress_value" class="form-control"  required="" />
          </div>

          <div class="col-md-6 mb-3">
            <label for="name_en">Date <span class="mendatory">*</span> </label>
            <div class="input-group datepicker-box">
              <input name="date" id="datepicker" class="form-control datepicker w-100  floating-label" type="text" placeholder="YY-MM-DD" />

            </div>
          </div>

          <div class="col-md-6 mb-3"></div>
          <div class="col-md-12 mb-3">
            <label for="details">Details</label>
            <textarea  id="" cols="10" rows="3" name="details" class="form-control summernote"></textarea>
          </div>

          <div class="text-right col-md-12 mb-3">
            <a class="btn  btn-warning mr-2" href="{{ route('indicator_data.index') }}">Cancel</a>
			      <button class="btn btn-primary" type="submit">Save</button>
          </div>

        </div>
    </form>
    </div>
  </div>
      </div>
  </div>
@endsection

@push('script')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>

$(document).ready(function () {

  var indicator_target=0;
  var remain_target = 0;
  var percentange = 0;
  $("#progress_value").keyup(function(){
    if(this.value > 100-percentange){
      swal("Warning!", "Please, Typing less than or equal to progress value.");
      this.value = 100-percentange
    }
  });

  $("#achievement_quantity").keyup(function(){
    
    if(this.value > remain_target){
      console.log("remain data "+remain_target)
      swal("Warning!", "Please, Typing less than or equal to target value.");
      this.value = remain_target
    }
    var quanty = $("#achievement_quantity").val()
    var percentage = parseFloat((quanty/indicator_target)*100).toFixed(2)
    $("#progress_value").val(percentage)
    console.log(percentage)
  });

  $('#indicator').change(function(){
    console.log('get indicator progress')
    var indicator_id = $('#indicator').val()
    var url =  " {{ url('ajax/get_indicator_progress') }}"+'/'+indicator_id;
    console.log(indicator_id)
    $.ajax({
      method:'GET',
      url: url,
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      success: (data)=>{
        indicator_target = data.data[1]
        remain_target = indicator_target
        show_indicator_details(data.data[0],data.data[2],indicator_target)
      },
      error: function(data){
      }
    });
  });
  function show_indicator_details(data, pending_data, target){
    var html=''
    console.log( data)
    if( data.length==1){
      var progress = data[0].progress
      var qty      = data[0].qty
    }else{
      var progress = 0
      var qty      = 0
    }
    html+=` <label for="indicator_category_Id">Approved Data</label>
      <table class="table table-bordered mb-3" >
              <thead>
                <tr>
                  <td width="20%" class="coustom-tbl text-center" >Target</td>
                  <td width="30%" class="coustom-tbl text-center" >Previous Approved Achievement in Quantity</td>
                  <td width="50%" class="coustom-tbl text-center" >Previous Approved Achievement in %</td>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="text-center" >${target}</td>
                  <td class="text-center" >${qty}</td>
                  <td>
                    <div class="progress">  
                      <div class="progress-bar" role="progressbar" style="width: ${progress}%;" aria-valuenow="50" aria-valuemin="50" aria-valuemax="100">
                        ${progress}
                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>
        </table>`
    remain_target = indicator_target-qty
    percentange   = progress

    if( pending_data.length==1){
      var progress = pending_data[0].progress
      var qty      = pending_data[0].qty
    }else{
      var progress = 0
      var qty      = 0
    }
    html +=`<label for="indicator_category_Id" >Pending Data</label>
    <table class="table table-bordered" >
              <thead>
                <tr>
                  <td width="20%" class="coustom-tbl text-center" >Target</td>
                  <td width="30%" class="coustom-tbl text-center" >Previous Pending Achievement in Quantity</td>
                  <td width="50%" class="coustom-tbl text-center" >Previous Pending Achievement in %</td>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="text-center" >${target}</td>
                  <td class="text-center" >${qty}</td>
                  <td>
                    <div class="progress">  
                      <div class="progress-bar" role="progressbar" style="width: ${progress}%;" aria-valuenow="50" aria-valuemin="50" aria-valuemax="100">
                        ${progress}
                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>
        </table>`
    remain_target -= qty
    percentange   += progress

      $('#previous_details').html(html);
      $('#achievement_quantity').val(0);
      $('#progress_value').val(0);
  }

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

<script src="{{ custom_asset('assets/plugins/summernote/dist/summernote.js') }}"></script>

<script>
	$(document).ready(function() {
		$('.summernote').summernote({
			height: 300
		});

		$('.airmode').summernote({
		  airMode: true
		});
	});
</script>
    

@endpush



