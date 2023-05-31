@extends('layouts.master')
@section('content')

<div class="main-content form-component mt-4 ">
      <div class="container">
        @include('sweetalert::alert')
        <div class="card mb-4 card-design">
          <div class="card-body">
            <div class="card-title bg-primary text-white">
              <h5>Add Financial Item</h5>
            </div>
            <form  method="POST" action="{{route('financialitem.update',$item->id)}}" >
              @csrf
              @method('PUt')
                
                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Economic Code</label>
                  <div class="col-sm-10">
                     <input type="text" name="economic_code" value="{{ $item->economic_code }}" required="" class="form-control "/>
                  </div>
                </div>

                 <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Item Name</label>
                  <div class="col-sm-10">
                     <input type="text" name="item_name" value="{{ $item->item_name }}" required="" class="form-control "/>
                  </div>
                </div>
  
                 <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Quantity</label>
                  <div class="col-sm-10">
                     <input type="text" name="quantity" value="{{ $item->quantity }}" required="" class="form-control "/>
                  </div>
                </div>

                 <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">PA Budget</label>
                  <div class="col-sm-10">
                     <input type="text" name="pa_budget" value="{{ $item->pa_budget }}" required="" class="form-control "/>
                  </div>
                </div>

                 <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">GOB Budget</label>
                  <div class="col-sm-10">
                     <input type="text" name="gob_budget" value="{{ $item->gob_budget }}" required="" class="form-control "/>
                  </div>
                </div>
               

                <div class="pull-right">
                  <button type="submit" id="submit"class="btn btn-primary">Update</button>
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