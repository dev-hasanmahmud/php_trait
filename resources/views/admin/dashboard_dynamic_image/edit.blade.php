@extends('layouts.master')
@section('content')

<div class="main-content form-component mt-4 ">
      <div class="container">
        @include('sweetalert::alert')
        <div class="card mb-4 card-design">
          <div class="card-body">
            <div class="card-title bg-primary text-white">
              <h5>Add Dashboard Dynamic image</h5>
            </div>
            <form  method="POST" action="{{route('dashboard_dynamic_image.update',$image->id)}}" enctype="multipart/form-data"   >
            
              @csrf
              {{method_field("PATCH")}}

                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Image Title In English</label>
                  <div class="col-sm-10">
                    <input type="text" name="name_en" value="{{ $image->name }}"  class="form-control "/>
                  </div>
                </div>
  
                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Image Title In Bangali</label>
                  <div class="col-sm-10">
                    <input type="text" name="name_bn" value="{{ $image->description }}"  class="form-control " id="source_of_fund_name_bn"/>
                  </div>
                </div>
            
  

                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Upload Image </label>
                  
                  <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 mt-4" id="image_group">
                    <div class="float-sm-left col-xs-12 col-sm-12 col-md-4 col-lg-4 mb-3 pl-0">
                        
                        <img src="{{ asset($image->file_path) }}"
                            alt="preview image"  class="img-thumbnail rounded " id="image_preview_container_1" style="position:relative;z-index:1; margin-top:-30px; height:180px; width:100%;" >

                        <div class="input-group mb-3">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="image" onclick="change_image(1)"  id="image_1" accept="image/*" />
                                <label class="my-3 custom-file-label"  for="inputGroupFile02" aria-describedby="inputGroupFileAddon02"  >Choose
                                file</label>
                            </div>
                        </div>
                        
                    </div>
                  </div>
                </div>

                <div class="form-group row mt-0">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Is Active Image</label>
                  <div class="col-sm-10">
                    <select name="status" class="form-control form-control-sm select2 custom-select2"  required="">
                      <option value="1"
                     @if ('1'==$image->is_approve)
                     {{'selected= "selected"'}}
                     @endif
                     >Active</option>

                     <option value="0"
                     @if ('0'==$image->is_approve)
                     {{'selected= "selected"'}}
                     @endif
                     >Inactive</option>
                   </select>
                  </div>
                </div>

                <hr class="mb-3">

       

                <div class="pull-right">
                  <a class="btn btn-lg btn-warning" href="{{ route('dashboard_dynamic_image.index') }}">Cancel</a>
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
     

                       
 
</script>
    
@endpush