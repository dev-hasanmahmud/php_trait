@extends('layouts.master')
@section('content')

<div class="main-content form-component mt-4 ">
      <div class="container">
        @include('sweetalert::alert')
        <div class="card mb-4 card-design">
          <div class="card-body">
            <div class="card-title bg-primary text-white">
              <h5>Add Training Activity</h5>
            </div>
            <form  method="POST" action="{{route('training-activity.store')}}" enctype="multipart/form-data"   >
              @csrf
              @method('POST')
                <div class="form-group row">
                  <label for="staticEmail" class="col-sm-2 col-form-label">Training Category</label>
                  <div class="col-sm-10">   
                    <select name="training_category_id" id="training_category"  class="form-control form-control-sm select2 custom-select2">
                      <optgroup>
                        <option value="0">Select Training Category</option>
                        @foreach ($training_categories as $item)
                          <option value="{{ $item->id }}">{{ $item->serial_no }}- {{ $item->name }}</option>
                        @endforeach
                    </optgroup>
                    </select>
                  </div>
                </div>
                
                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Training Name</label>
                  <div class="col-sm-10">
                    <select name="training_id" id="training_name"  class="form-control select2 custom-select2">
                      <option value="">Select Training Name</option>
                    </select>
                   
                  </div>
                </div>
  
                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Number Of Event</label>
                  <div class="col-sm-10">
                    <input type="text" name="number_of_event" value="{{ old('number_of_event') }}" required="" class="form-control " id="source_of_fund_name_bn"/>
                  </div>
                </div>
  
              
  
                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Number of Batches</label>
                  <div class="col-sm-10">
                    <input type="text" name="number_of_batch" value="{{ old('number_of_batch') }}" required="" class="form-control " id="source_of_fund_name_bn"/>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Date</label>
                  <div class="col-sm-10">
                    <div class="input-group datepicker-box">
                      <input name="date"  class="form-control datepicker w-100" 
                      value="{{old('date')}}"
                      type="text" placeholder="YY-MM-DD" />
                    </div>
                  </div>
                </div>
  
                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Reference</label>
                  <div class="col-sm-10">
                    <textarea name="reference" id=""  class="form-control" cols="30" rows="2">{{ old('reference') }}</textarea>
                  </div>
                </div>
              
                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Number of Participants Per Batch </label>
                  <div class="col-sm-10">
                    <input type="text" name="number_of_participant_perbatch" required value="{{ old('number_of_participant_perbatch')}}" class="form-control " id="source_of_fund_name_bn"/>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Total Number of Participants Scheduled</label>
                  <div class="col-sm-10">
                    <input type="text" name="number_of_benefactor" value="{{ old('number_of_benefactor')}}" class="form-control " id="source_of_fund_name_bn"/>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Number of Participants Attended </label>
                  <div class="col-sm-10">
                    <input type="text" name="number_of_participant_attend"  value="{{ old('number_of_participant_attend') }}" class="form-control " id="source_of_fund_name_bn"/>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Number of Male Participants Attended </label>
                  <div class="col-sm-10">
                    <input type="text" name="male"  value="{{ old('male')}}" class="form-control " id="source_of_fund_name_bn"/>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Number of Female Participants Attended </label>
                  <div class="col-sm-10">
                    <input type="text" name="female" value="{{ old('female')}}" class="form-control " id="source_of_fund_name_bn"/>
                  </div>
                </div>

           

                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Upload Image </label>
                  
                  <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9" id="image_group">
                    <div class="float-sm-left col-xs-12 col-sm-12 col-md-4 col-lg-4 mb-3 pl-0">
                        <a href="javascript:void(0)" style="position:relative;z-index:2; border:none;" class="float-right btn btn-outline-danger delete"  id="delete_image"> <i class="fa fa-trash"></i> </a>
                        <img src="{{ asset('assets/images/image-preview.png') }}"
                            alt="preview image"  class="img-thumbnail rounded " id="image_preview_container_1" style="position:relative;z-index:1; margin-top:-30px; height:180px; width:100%;" >

                        <div class="input-group mb-3">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="image_1" onclick="change_image(1)"  id="image_1" accept="image/*" />
                                <label class="my-3 custom-file-label"  for="inputGroupFile02" aria-describedby="inputGroupFileAddon02"  >Choose
                                file</label>
                            </div>
                        </div>
                        {{-- <div class="form-group">
                            <input type="file" name="image_1"   accept="image/*"
                            id="image_1" class="my-2" onclick="change_image(1)">
                        </div> --}}
                    </div>
                  </div>

                  <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1 text-right">
                    <a href="javascript:void(0)"   class="btn btn-outline-success fa fa-plus" id="add_image"></a>
                  </div>
                  
                </div>

                <hr class="mb-3">

                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Upload File </label>

                  <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9" id="file_group">
                    <div class="float-sm-left col-xs-12 col-sm-12 col-md-4 col-lg-4 mb-3 pl-0">
                        <a href="javascript:void(0)" class="float-right btn btn-outline-danger delete"  id="delete_image"> <i class="fa fa-trash"></i> </a>
                        <div id="file_preview_container_1"><p>File Name </p></div>

                        <div class="input-group mb-3">
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" name="file_1" onclick="change_file(1)"  id="file_1"
                              />
                              <label class="my-3 custom-file-label"  for="inputGroupFile02" aria-describedby="inputGroupFileAddon02"  >Choose
                                file</label>
                            </div>
                        </div>
                    </div>
                    
                  </div>

                  <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1 text-right">
                    <a href="javascript:void(0)"   class="btn btn-outline-success fa fa-plus" id="add_file"></a>
                  </div>

                  
                  
                </div>

                <div class="pull-right">
                  <a class="btn btn-lg btn-warning" href="{{ route('training-activity.index') }}">Cancel</a>
                  <button type="submit" id="submit"class="btn btn-lg btn-primary">Submit</button>
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

  var image_count=1;

  $('body').on('click', '#add_image', function () {
    $('#test').val(4);
    image_count++;
    console.log(image_count+" ");
    var html=`<div class="pull-left col-xs-12 col-sm-12 col-md-4 col-lg-4 mb-3 pl-0">
                <a href="javascript:void(0)" style="position:relative;z-index:2; border:none;" class="float-right btn btn-outline-danger delete"  id="delete_image"> <i class="fa fa-trash"></i> </a>
                <img src="{{ asset('assets/images/image-preview.png') }}"
                    alt="preview image" id="image_preview_container_${image_count}" class="img-thumbnail rounded " style="position:relative;z-index:1; margin-top: -30px; height:180px; width:100%;" >
                <div class="input-group mb-3">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="image_${image_count}" onclick="change_image(${image_count})"  id="image_${image_count}" accept="image/*" />
                        <label class="my-3 custom-file-label"  for="inputGroupFile02" aria-describedby="inputGroupFileAddon02"  >Choose
                        file</label>
                    </div>
                </div>
            </div>`
    $('#image_group').append(html);
  });

  var file_count=1;
  $('body').on('click', '#add_file', function () {
    file_count++;
    console.log(file_count+" ");
    var html=`<div class="float-sm-left col-xs-12 col-sm-12 col-md-4 col-lg-4 mb-3 pl-0">
                        <a href="javascript:void(0)"  class="float-right btn btn-outline-danger delete"  id="delete_image"> <i class="fa fa-trash"></i> </a>
                        <div id="file_preview_container_${file_count}"><p>File Name</p></div>

                        <div class="input-group mb-3">
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" name="file_${file_count}" onclick="change_file(${file_count})"  id="file_${file_count}" />
                              <label class="my-3 custom-file-label"  for="inputGroupFile02" aria-describedby="inputGroupFileAddon02"  >Choose
                                file</label>
                            </div>
                        </div>
                    </div>`
    $('#file_group').append(html);
      
  });

//   $("#file_group .delete").click(function () {
//     console.log("delete");
//     $(this).parent().remove();
//     //$(this).parent().remove();
//   });
    $("#file_group").on('click', '.delete', function () {
        console.log("delete");
        $(this).parent().remove(); 
    });

    $("#image_group").on('click', '.delete', function () {
        console.log("image delete");
        $(this).parent().remove(); 
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

function change_image(image_id){
    console.log('preview funcrion start'+image_id)
    $('#image_'+image_id).change(function(e){
        console.log("change "+e.target)
        let reader = new FileReader();
        
        reader.onload = (e) => { 
            $('#image_preview_container_'+image_id).attr('src', e.target.result); 
        }
        reader.readAsDataURL(this.files[0]); 
    });
}
     
function change_file(file_id){
    console.log('preview file start'+file_id)
    $('#file_'+file_id).change(function(e){
        console.log(this.files[0].name)
        html=`<p> ${this.files[0].name}</p>`
        $('#file_preview_container_'+file_id).html(html)
    });
}
                       
 
</script>
    
@endpush