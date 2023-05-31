@extends('layouts.master')
@section('content')

<div class="main-content form-component mt-4 ">
      <div class="container">
        @include('sweetalert::alert')
        <div class="card mb-4 card-design">
          <div class="card-body">
            <div class="card-title bg-primary text-white">
              <h5>Training</h5>
            </div>

            <form  action="{{ route('training.update',$training->id) }}" method="post" >
              @csrf
              @method('PUT')
              <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Title</label>
                <div class="col-sm-10">
                 <input type="text"name="title" value="{{ $training->title }}" class="form-control"/>
                </div>
              </div>

              <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Training Category</label>
                <div class="col-sm-10">   
                    {!! Form::select('training_category_id', \App\TrainingCategory::select(DB::raw('CONCAT(serial_no, " - ", name) AS name, id'))->pluck('name', 'id'), old('area_of_activities',
                    isset($training->training_category_id) ? json_decode($training->training_category_id):null), [ 'class' => 'form-control custom-select select2 full-width', 'data-init-plugin'=>'select2', 'id' => '']) !!}
                </div>
              </div>
                
               
  
              <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Serial Number</label>
                <div class="col-sm-10">
                  <input type="text" name="serial_number" value="{{ $training->serial_number }}" required="" class="form-control " id="source_of_fund_name_bn"/>
                </div>
              </div>
  
  
  
              <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Total Number of Events</label>
                <div class="col-sm-10">
                  <input type="text" name="total_event" required="" value="{{ $training->total_event}}" class="form-control"/>
                </div>
              </div>

               

              <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Total Number of Training Batches</label>
                <div class="col-sm-10">
                  <input type="text" name="toatal_batch" required="" value="{{ $training->toatal_batch}}" class="form-control"/>
                </div>
              </div>

              <div class="pull-right">
                <a class="btn  btn-warning" href="{{ route('training.index') }}">Cancel</a>
                <button type="submit" class="btn btn-primary">Update</button>
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
    $("#package_id").val(component_id);
    var url =  " {{ url('ajax/get_contractor_by_package_id') }}"+'/'+component_id;
    console.log(component_id)
    $.ajax({
      method:'POST',
      url: url,
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      success: (data)=>{
        console.log(data)
        show_contractor(data.data.contractor)
        show_source(data.data.source)
        //console.log(data.data.package)
        $('#economic_code').val(data.data.package.economic_head);
      },
      error: function(data){
        var html=''
        
        $('#economic_code').val(data.responseJSON.data.economic_head);
        $('#contractor').html(html);
      }
    });
  }); 


  function show_contractor(data){
    //console.log(data);   
      var html=''
      $.each(data,function(key,value){
        //console.log(value.name_en)
        html+=`<option value= "${value.id}"> ${value.name_en}</option>`

      });
    $('#contractor').html(html);
  }

  function show_source(data){
    //console.log(data);   
      var html=''
      $.each(data,function(key,value){
        //console.log(value.name_en)
        html+=`<option value= "${value.id}"> ${value.name_en}</option>`

      });
    $('#source').html(html);
  }

}); 
 
                       
 
</script>
    
@endpush