@extends('layouts.master')
@section('content')

<div class="main-content form-component mt-4 ">
      <div class="container">
        @include('sweetalert::alert')
        <div class="card mb-4 card-design">
          <div class="card-body">
            <div class="card-title bg-primary text-white">
              <h5>Training Activity</h5>
            </div>

            <form  action="{{ route('training-activity.update',$training_activity->id) }}" method="post" >
              @csrf
              @method('PUT')
              <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Training Category</label>
                <div class="col-sm-10">   
                  <select name="training_category_id" id="training_category"  class="form-control form-control-sm select2 custom-select2">
                    <option value="0">Select Training Category</option>
                    @foreach ($training_categories as $item)
                      <option value="{{ $item->id }}"
                        @if ($item->id==$training_activity->training_category_id)
                        {{'selected= "selected" '}}
                      @endif
                        >{{ $item->serial_no }}- {{ $item->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              
              <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Training Name</label>
                <div class="col-sm-10">
                  <select name="training_id" id="training_name"  class="form-control select2 custom-select2">
                    
                    @foreach ($training as $item)
                      <option value="{{ $item->id }}"
                        @if ($item->id==$training_activity->training_id)
                        {{'selected= "selected" '}}
                        @endif
                        >{{ $item->serial_number }}- {{ $item->title }}</option>
                    @endforeach
                  </select>
                 
                </div>
              </div>

              <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Number Of Event</label>
                <div class="col-sm-10">
                  <input type="text" name="number_of_event" value="{{ $training_activity->number_of_event }}" required="" class="form-control " id="source_of_fund_name_bn"/>
                </div>
              </div>

            

              <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Number of Batches</label>
                <div class="col-sm-10">
                  <input type="text" name="number_of_batch" value="{{ $training_activity->number_of_batch }}" required="" class="form-control " id="source_of_fund_name_bn"/>
                </div>
              </div>

              <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Date</label>
                <div class="col-sm-10">
                  <div class="input-group datepicker-box">
                    <input name="date"  class="form-control datepicker w-100" 
                    value="{{$training_activity->date}}"
                    type="text" placeholder="YY-MM-DD" />
                  </div>
                </div>
              </div>


              <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Reference</label>
                <div class="col-sm-10">
                  <textarea name="reference" id=""  class="form-control" cols="30" rows="2">{{ $training_activity->reference }}</textarea>
                </div>
              </div>

              <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Number of Participants Per Batch </label>
                <div class="col-sm-10">
                  <input type="text" name="number_of_participant_perbatch" value="{{ $training_activity->number_of_participant_perbatch}}" class="form-control " id="source_of_fund_name_bn"/>
                </div>
              </div>

              <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Total Number of Participants Scheduled</label>
                <div class="col-sm-10">
                  <input type="text" name="number_of_benefactor" value="{{ $training_activity->number_of_benefactor}}" class="form-control " id="source_of_fund_name_bn"/>
                </div>
              </div>

              <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Number of Participants Attended </label>
                <div class="col-sm-10">
                  <input type="text" name="number_of_participant_attend"  value="{{ $training_activity->number_of_participant_attend }}" class="form-control " id="source_of_fund_name_bn"/>
                </div>
              </div>

              <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Number of Male Participants Attended</label>
                <div class="col-sm-10">
                  <input type="text" name="male"  value="{{ $training_activity->male }}" class="form-control " id="source_of_fund_name_bn"/>
                </div>
              </div>

              <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Number of Female Participants Attended</label>
                <div class="col-sm-10">
                  <input type="text" name="female" value="{{ $training_activity->female }}" class="form-control " id="source_of_fund_name_bn"/>
                </div>
              </div>

              <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Upload Image </label>
                
                <div class="col-sm-6" id="image_group">
                  @foreach ($image_list as $item)
                    @php
                      $image_file_size = $loop->iteration
                    @endphp
                    <div class="input-group mb-3">
                      <input type="text" class="form-control" placeholder="choose image..." value="{{ $item->file_path }}"
                        id="image_{{ $loop->iteration }}" name="image_{{ $loop->iteration }}" />
                      <div class="input-group-append">
                        <button class="btn btn-outline-primary" type="button" onclick="open_popup('image_{{ $loop->iteration }}',1)">Select</button>
                      </div>
                    </div> 
                    @endforeach
                    <input type="text" id="image_file_size" hidden value="{{ $image_file_size }}">
                </div>
                
                

                <div class="pull-right">
                  <a href="javascript:void(0)"   class="btn btn-outline-success fa fa-plus" id="add_image"></a>
                </div>
              </div>

              <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Upload File </label>

                <div class="col-sm-6" id="file_group">
                  @foreach ($file_list as $item)
                  @php
                    $file_size = $loop->iteration
                  @endphp
                  <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="choose file..." value="{{ $item->file_path }}"
                       id="file_{{ $loop->iteration }}" name="file_{{ $loop->iteration }}" />
                    <div class="input-group-append">
                      <button class="btn btn-outline-primary" type="button" onclick="open_popup('file_{{ $loop->iteration }}',2)">Select</button>
                    </div>
                  </div> 
                  @endforeach
                  
                  <input type="text" id="file_size" hidden  value="{{ $file_size }}">
                </div>
                <div class="pull-right">
                  <a href="javascript:void(0)"   class="btn btn-outline-success fa fa-plus" id="add_file"></a>
                </div>
                
              </div>

              <div class="pull-right">
                <a class="btn  btn-warning" href="{{ route('training-activity.index') }}">Cancel</a>
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

  var image_count=$("#image_file_size").val();
  
  $('body').on('click', '#add_image', function () {
    image_count++;
    console.log(image_count+" ");
    var html=`<div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="choose image..." 
                  id="image_${image_count}" name="image_${image_count}" />
                <div class="input-group-append">
                  <button class="btn btn-outline-primary" type="button" onclick="open_popup('image_${image_count}',1)">Select</button>
                </div>
              </div>`
    $('#image_group').append(html);
  });

  var file_count=$("#file_size").val();
 
  $('body').on('click', '#add_file', function () {
    file_count++;
    console.log(file_count+" ");
    var html=`<div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="choose file..." 
                  id="file_${file_count}" name="file_${file_count}" />
                <div class="input-group-append">
                  <button class="btn btn-outline-primary" type="button" onclick="open_popup('file_${file_count}',2)">Select</button>
                </div>
              </div>`
    $('#file_group').append(html);
      
  });


  function show_training_name(data){
    //console.log(data);   
      var html=''
      $.each(data,function(key,value){
        //console.log(value.name_en)
        html+=`<option value= "${value.id}"> ${value.title}</option>`

      });
    $('#training_name').html(html);
  }


}); 
 
function open_popup(id,type_id){
      
	var url='http://localhost/emcrp/public/filemanager/filemanager/dialog.php?type='+type_id+'&popup=1&multiple=0&field_id='+id;
	var w = 1000;
	var h = 570;
	var l = Math.floor((screen.width-w)/2);
	var t = Math.floor((screen.height-h)/2);
	var win = window.open(url, 'ResponsiveFilemanager', "scrollbars=1,width=" + w + ",height=" + h + ",top=" + t + ",left=" + l);
			
}
                       
 
</script>
    
@endpush