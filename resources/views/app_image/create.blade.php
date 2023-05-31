@extends('layouts.master')
@section('content')

<div class="main-content form-component mt-4 ">
      <div class="container">
        @include('sweetalert::alert')
        <div class="card mb-4 card-design">
          <div class="card-body">
            <div class="card-title bg-primary text-white">
              <h5>Create Android Data Acquisition </h5>
            </div>

            <form  action="{{ route('app-image.store') }}" method="post" enctype="multipart/form-data"  >
              @csrf
              @method('POST')
              <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Package</label>
                <div class="col-sm-10">   
                  <select name="component_id" id="component"  class="form-control form-control-sm select2 custom-select2">
                    <optgroup>
                    @foreach ($package as $item)
                      <option value="{{ $item->id }}">
                        {{ $item->package_no }}- {{ $item->name_en }}</option>
                    @endforeach
                  </optgroup>
                  </select>
                </div>
              </div>
              
              <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Activity </label>
                <div class="col-sm-10">
                  <select name="data_input_title_id" id="data_input_title"  class="form-control select2 custom-select2">
                  <optgroup>
                    @foreach ($title as $item)
                      <option value="{{ $item->id }}"
                        >{{ $item->title }}</option>
                    @endforeach
                  </optgroup>
                  </select>
                </div>
              </div>

              <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Upazila</label>
                <div class="col-sm-10">   
                  <select name="upazila_id" id="upazila"  class="form-control form-control-sm select2 custom-select2">
                    <optgroup>
                    @foreach ($upazila as $item)
                      <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                  </optgroup>
                  </select>
                </div>
              </div>
              
              <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Camp / Union </label>
                <div class="col-sm-10">
                  <select name="area_id" id="union"  class="form-control select2 custom-select2">
                  <optgroup>
                    @foreach ($unions as $item)
                      <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                  </optgroup>
                  </select>
                 
                </div>
              </div>

              <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10">
                  {{-- <input type="text" name="number_of_event" value="{{  }}" required="" class="form-control " id="source_of_fund_name_bn"/> --}}
                  <textarea name="description" id="" cols="30" rows="5" class="form-control "  > </textarea>
                </div>
              </div>

{{-- 
              <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">GPS Point</label>
                <div class="col-sm-10">
                  <input type="text" name="location" value="{{ $data->location }}" required="" class="form-control " readonly="" id="source_of_fund_name_bn"/>
      
                </div>
              </div> --}}

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
                <label for="inputPassword" class="col-sm-2 col-form-label">Upload Image </label>
				          <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9" id="image_group">
                    @php 
                        $id_array = array();
                        $index = 0; 
                    @endphp
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

                    </div>
                </div>
				
                <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1 text-right">
                    <a href="javascript:void(0)"   class="btn btn-outline-success fa fa-plus" id="add_image"></a>
                </div>
				  
              </div>

              <hr class="mb-3">
              <div class="pull-right">
                <a class="btn  btn-warning" href="{{ route('app-image.index') }}">Cancel</a>
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
            </form>
            {{-- @php
                echo '<pre>'; print_r($id_array);
              @endphp --}}
          </div>
        </div>
      </div>
    </div>
@endsection



@push('script')


<script>

$(document).ready(function () {

  $('#component').change(function(){ 
    console.log('get component list')
    var component_id = $('#component').val()
    var url =  " {{ url('ajax/get_activity_list') }}"+'/'+component_id;
    console.log(component_id)
    $.ajax({
      method:'GET',
      url: url,
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      success: (data)=>{
        console.log(data.data)
        data_input_title(data.data)
      },
      error: function(data){
        var html=''
        $('#data_input_title').html(html);
      }
    });
  });

  $('#upazila').change(function(){ 
    console.log('get upazila list')
    var upazila_id = $('#upazila').val()
    var url =  " {{ url('ajax/get_union_list') }}"+'/'+upazila_id;
    console.log(upazila_id)
    $.ajax({
      method:'GET',
      url: url,
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      success: (data)=>{
        console.log(data.data)
        show_union_data(data.data)
      },
      error: function(data){
        var html=''
        $('#union').html(html);
      }
    });
  });
  
   
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
    console.log('add image')
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

  $("#image_group").on('click', '.delete', function () {
        console.log("image delete");
        $(this).parent().remove(); 
    });


  var file_count=$("#file_size").val();
 
  $('body').on('click', '#add_file', function () {
    file_count++;
    console.log(file_count+" ");
    var html=`<div class="float-sm-left col-xs-12 col-sm-12 col-md-4 col-lg-4 mb-3 pl-0">
				<a href="javascript:void(0)"  class="float-right btn btn-outline-danger delete"  id="delete_image"> <i class="fa fa-trash"></i> </a>
				<div id="file_preview_container_${file_count}"><p>File Name </p></div>

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

  $("#file_group").on('click', '.delete', function () {
        console.log("delete");
        $(this).parent().remove(); 
    });



  function data_input_title(data){
    //console.log(data);   
      var html=''
      $.each(data,function(key,value){
        //console.log(value.name_en)
        html+=`<option value= "${value.id}"> ${value.title}</option>`
      });
    $('#data_input_title').html(html);
  }

  function show_union_data(data){
    //console.log(data);   
      var html=''
      $.each(data,function(key,value){
        //console.log(value.name_en)
        html+=`<option value= "${value.id}"> ${value.name}</option>`
      });
    $('#union').html(html);
  }


}); 
 


function change_image(image_id){
    console.log('preview funcrion start'+image_id)
    $('#image_'+image_id).change(function(e){
      //  console.log("change "+e.target)
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