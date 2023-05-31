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
            <i class="fa fa-window-restore" aria-hidden="true"></i> Edit Indicator Wise Progress
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
            <img src="{{custom_asset('assets/images/programme.png')}}" alt="" />Edit  Indicator Wise Progress
        </h3>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('indicator_data.index') }}">Index Page</a>
        </div>
    </div>
     <br> --}}
     <div class="main-content form-component mt-4 ">
      <div class="container">
	  		<div class="card mb-4 card-design">
          <div class="card-body">
            <div class="card-title bg-primary text-white">
              <h5>Create Indicator Wise Progress</h5>
            </div>
    <form  action="{{ route('indicator_data.update',$indicator_data->id) }}" method="post">
        @csrf
        @method('PUT')
        <div class="form-row">

          <div class="col-md-6 mb-3">
            <label for="component_Id">Package <span class="mendatory">*</span></label>
              {{-- <select name="component_id" id="component"class="form-control form-control-sm select2 custom-select2">
                  @foreach ($component as $item)
                    <option value="{{ $item->id }}"
                      @if ($item->id==$indicator_data->component_id)
                        {{'selected= "selected" '}}
                      @endif
                      >{{ $item->name_en }}</option>
                  @endforeach
              </select> --}}

              <select name="component_id" id="component" class="form-control form-control-sm select2 custom-select2">
                <optgroup>
                    @foreach ($component as $item)
                      <option value="{{ $item->id }}"
                        @if ($item->id==$indicator_data->component_id)
                          {{'selected= "selected" '}}
                        @endif
                        >{{ $item->package_no }}-{{ $item->name_en }}
                      </option>
                    @endforeach
                  </optgroup>
              </select>

              
          </div>

          <div class="col-md-6 mb-3">
            <label for="indicator_category_Id">Indicator <span class="mendatory">*</span>  </label>
              <select name="indicator_id" id="indicator" class="form-control form-control-sm select2 custom-select2">
                <optgroup>
                    @foreach ($indicator as $item)
                      <option value="{{ $item->id }}"
                        @if ($item->id==$indicator_data->indicator_id)
                          {{'selected= "selected" '}}
                        @endif
                        >{{ $item->name_en }}
                      </option>
                    @endforeach
                  </optgroup>
              </select>
              
          </div>

          <div class="col-12 mb-3" id="previous_details">
            <label for="indicator_category_Id">Approved Data</label>
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
                  <td class="text-center" >{{ $target }}</td>
                  <td class="text-center" >{{ isset($approve_data[0]->qty)? $approve_data[0]->qty: 0}}</td>
                  <td>
                    <div class="progress">  
                      <div class="progress-bar" role="progressbar" style="width: {{ isset($approve_data[0]->progress) ? $approve_data[0]->progress : 0 }}%;" aria-valuenow="50" aria-valuemin="50" aria-valuemax="100">
                        {{ isset($approve_data[0]->progress) ? $approve_data[0]->progress : 0 }}
                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
            @php
                
            @endphp
            <label for="indicator_category_Id" >Pending Data</label>
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
                  <td class="text-center" >{{ $target }}</td>
                  <td class="text-center" >{{ isset($pending_data[0]->qty)? $pending_data[0]->qty: 0}}</td>
                  <td>
                    <div class="progress">  
                      <div class="progress-bar" role="progressbar" style="width: {{ isset($pending_data[0]->progress) ? $pending_data[0]->progress : 0 }}%;" aria-valuenow="50" aria-valuemin="50" aria-valuemax="100">
                        {{ isset($pending_data[0]->progress) ? $pending_data[0]->progress : 0 }}
                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="col-md-6 mb-3">
            <label for="achievement_quantity">Achievement In Quantity <span class="mendatory">*</span> </label>
            <input type="text" name="achievement_quantity"  id="achievement_quantity"
            value="{{ $indicator_data->achievement_quantity }}" class="form-control"  required="" />
          </div>

          <div class="col-md-6 mb-3">
            <label for="progress_value">Progress Percentage (%) </label>
            <input type="text" name="progress_value" id="progress_value" value="{{ $indicator_data->progress_value }}" class="form-control"  required="" />
          </div>

          {{-- <div class="col-md-6 mb-3">
            <label for="details">Description</label>
            <textarea  id="" cols="30" rows="5" name="details" class="form-control">
              
            </textarea>
          </div> --}}

          <div class="col-md-6 mb-3">
            <label for="name_en">Date <span class="mendatory">*</span> </label>
            <div class="input-group datepicker-box">
              <input name="date" id="datepicker" class="form-control datepicker w-100" type="text" value="{{ $indicator_data->date }}"placeholder="YY-MM-DD"/>
            </div>
          </div>

          <div class="col-md-6 mb-3"></div>
          <div class="col-md-12 mb-3">
            <label for="details">Details</label>
            <textarea  id="" cols="10" rows="3" name="details" class="form-control summernote">{{ $indicator_data->details }}</textarea>
          </div>

          <div class="text-right col-md-12 mb-3">
            <a class="btn  btn-warning mr-2" href="{{ route('indicator_data.index') }}">Cancel</a>
			      <button class="btn btn-primary" type="submit">Update</button>
          </div>

        </div>
      </form>


    </div>
  </div>
@endsection


@push('script')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>

$(document).ready(function () {

  var indicator_target= {{ $target }};
  var remain_target = {{ $remain_target }};
  var percentange = {{ $percentange }};
  $("#progress_value").keyup(function(){
    if(this.value > 100-percentange){
      swal("Warning!", "you can not insert progress value more than total 100 percent.")
      this.value = 100-percentange
    }
  });

  $("#achievement_quantity").keyup(function(){
    
    if(this.value > remain_target){
      swal("Warning!", "Please, Typing less than or equal to target value.")
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
        show_indicator_details(data.data[0],indicator_target)
      },
      error: function(data){
      }
    });
  });
  function show_indicator_details(data,target){
    var html=''
    if( data.length==1){
      var progress = data[0].progress
      var qty      = data[0].qty
    }else{
      var progress = 0
      var qty      = 0
    }
        html+=`<table class="table table-bordered " >
              <thead>
                <tr>
                  <td width="20%" class="coustom-tbl text-center" >Target</td>
                  <td width="30%" class="coustom-tbl text-center" >Previous Achievement in Quantity</td>
                  <td width="50%" class="coustom-tbl text-center" >Previous Achievement in %</td>
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
        percentange = progress
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



