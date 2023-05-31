@extends('layouts.master')
@section('content')

<div class="sub-head header header2">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
        <div class="procurement-title">
          <h5 class="d-inline">
            Home Page Banner Image
          </h5>                
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        <a class=" btn sub-btn float-right" href="{{ route('dashboard_dynamic_image.create') }}" ><i class="fa fa-plus"> </i> Add Image</a>
        
      </div>
    </div>
  </div>
</div>
<div class="main-content mt-4 ">
  <div class="container">
          
    @include('sweetalert::alert')

        {{-- <a href="{{route("procurement_method.create")}}">
        <button type="button" class="btn mb-2 btn-primary" >Add Method</button>
        </a> --}}

       
     

    <section class="package-table card card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                  <tr class="text-center">
                    <td scope="col" >SL</td>
                    <td scope="col">Title In English</td>
                    <td scope="col">Tile In Bangli</td>
                    <td scope="col">Image </td>
                    <td scope="col">Status </td>
                    <td scope="col" class="text-center">Action</td>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($images as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-left" >{{ $item->name }}</td>
                        <td class="text-left" >{{ $item->description}}</td>

                        @php
                          $previous = $item->name;
                          $fileName = explode('-.-',$item->file_path);
                        @endphp

                        <td class="text-left" ><p>{{ isset($fileName[1])?$fileName[1]:null }}</p></td>
                        @if ($item->is_approve)
                        <td>Active</td>
                        @else
                        <td>In-Active</td>
                        @endif
                        <td class="text-center">
                          <a class="edit-service-type-modal btn btn-warning btn-xs" href="{{route('dashboard_dynamic_image.edit',$item->id)}}" title="Edit"><i class="fa fa-edit"></i></a> 
                          <a href="javascript:void(0)" id="delete-user" data-id="{{ $item->id }}"  class="delete-service-type-modal btn btn-danger btn-xs button delete-confirm" title="Delete" ><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                  
                </tbody>
              </table>
        <div class="mt-4 text-center">{{ $images->links() }}</div>
    </section>
  </div>
      
</div> 


@endsection


@push('script')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
$(document).ready(function () {
   
    $('body').on('click', '#delete-user', function () {
        console.log('fuunfsa')
        var method_id = $(this).data("id");
        
        swal({
            title: 'Are you sure?',
            text: 'This record and it`s details will be permanantly deleted!',
            icon: 'warning',
            buttons: ["Cancel", "Yes!"],
        }).then(function(value) {
            if (value) {
              console.log('succes method')
              $.ajax({
                type: "DELETE",
                url: " {{ url('dashboard_dynamic_image') }}"+'/'+method_id,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    console.log(data)
                    swal("Deleted!", "Your imaginary file has been deleted.", "success");
                    window.location.assign("/dashboard_dynamic_image")
                },
                error: function (data) {
                    console.log('Error:', data);
                    swal("Cancelled", "Something went wrong :)", "error");
                }
              });
            }
        });   
    });  
  }); 
  
</script>
@endpush
{{-- 
@push('script')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
  
    $('.delete-confirm').on('click', function (event) {
        event.preventDefault();
        var url = $(this).attr('href');
        console.log(url)
        swal({
            title: 'Are you sure?',
            text: 'This record and it`s details will be permanantly deleted!',
            icon: 'warning',
            buttons: ["Cancel", "Yes!"],
        }).then(function(value) {
            if (value) {
              console.log('succes method')
              
              window.location.href = url;
            }
        });
    });
</script>
@endpush --}}