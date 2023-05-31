@extends('layouts.master')
@section('content')

<div class="main-content form-component mt-4 ">
      <div class="container">
        @include('sweetalert::alert')
        <div class="card mb-4 card-design">
          <div class="card-body">
            <div class="card-title bg-primary text-white">
              <h5>Financial Report Upload</h5>
            </div>
            <form  method="POST" action="{{route('report.store')}}" enctype="multipart/form-data"   >
              @csrf
              @method('POST')
                <div class="form-group row">
                  <label for="category" class="col-sm-2 col-form-label">Category</label>
                  <div class="col-sm-10">   
                    <select name="fm_category_id" id="category"  class="form-control form-control-sm select2 custom-select2">
                      <optgroup>
                        <option value="0">Select Category</option>
                        @foreach ($categories as $item)
                          <option value="{{ $item->id }}">{{ $item->title }}</option>
                        @endforeach
                    </optgroup>
                    </select>
                  </div>
                </div>
                
                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Report Name</label>
                  <div class="col-sm-10">
                     <input type="text" name="name" value="{{ old('name') }}" required="" class="form-control "/>
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
  
                {{-- <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Reference</label>
                  <div class="col-sm-10">
                    <textarea name="description" id=""  class="form-control" cols="30" rows="2">{{ old('description') }}</textarea>
                  </div>
                </div> --}}
              
                
                <hr class="mb-3">

                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Upload File </label>

                  <div class="col-sm-9" id="file_group">
                    <div class="float-sm-left mr-2 ml-0">
                        <a href="javascript:void(0)"  class="float-right btn btn-outline-danger delete"  id="delete_image"> X </a>
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

                  <div class="pull-right">
                    <a href="javascript:void(0)"   class="btn btn-outline-success fa fa-plus" id="add_file"></a>
                  </div>

                  
                  
                </div>

                <div class="pull-right">
                  <button type="submit" id="submit"class="btn btn-primary">Submit</button>
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

  var file_count=1;
  $('body').on('click', '#add_file', function () {
    file_count++;
    console.log(file_count+" ");
    var html=`<div class="float-sm-left mr-2 ml-0">
                        <a href="javascript:void(0)"  class="float-right btn btn-outline-danger delete"  id="delete_image"> X </a>
                        <div id="file_preview_container_${file_count}"><p>file name </p></div>

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


}); 
     
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