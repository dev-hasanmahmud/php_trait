@extends('layouts.master')
@section('content')
{{-- <div class="container">
    <div class="card-body">
  
    <span class="show_list"> Source of Fund List </span>
     <a class="btn btn-success pull-right" style="float:right; margin-top:-15px" href="{{route("source_of_fund.create")}}" id="add_Book"> Add Source </a><br>
  
      <div class="alert alert-primary" role="alert" hidden="true" id="successmsg">
        
      </div>
      <hr class="m-t-0 margin-border4px">
     
      <table class="table table-hover table-fixed">
          <thead>
              <tr>
                  <th> Book Id </th>
                  <th> First Name </th>
                  <th> Lastname Name </th>
                  <th class="text-center">Action</th>
              </tr>
          </thead>
          <tbody >
              @foreach($source_of_fund as $item)
                  <tr class="">
                      <td> {{$item->id}} </td>
                      <td> {{$item->name_en}} </td>
                      <td> {{$item->name_bn}} </td>
                     
                      <td class="text-center">
                        <a class="edit-service-type-modal btn btn-warning btn-xs" href="{{route('source_of_fund.edit',$item->id)}}" title="Edit"><i class="fa fa-edit"></i>
                        </a> 
                        <button class="delete-service-type-modal btn btn-danger btn-xs" data-id="{{$item->id}}" title="Delete"><i class="fa fa-trash"></i>
                        </button>

                      </td>
                          
                          
                  </tr>
              @endforeach
              
          </tbody>
      </table>
  
      {{ $source_of_fund->links() }}
  
      
  </div>
</div> --}}

<div class="sub-head header header2">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
        <div class="procurement-title">
          <h5 class="d-inline">
            <i class="fa fa-usd" aria-hidden="true"></i> Source Fund
          </h5>                
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        <a class=" btn sub-btn float-right" href="{{ route('source_of_fund.create') }}" ><i class="fa fa-plus"> </i> Add Source</a>
        
      </div>
    </div>
  </div>
</div>

<div class="main-content mt-4 ">
  <div class="container">
    @include('sweetalert::alert')

        <section class="package-table card card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th >ID</th>
                    <th >Name In English</th>
                    <th >Procurement Type</th>
                    <th  class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($source_of_fund as $item)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $item->name_en }}</td>
                        <td>{{ $unit_data[$loop->index]['name'] }}</td>

                        <td class="text-center">
                            <a class="edit-service-type-modal btn btn-warning btn-xs"  
                              href="{{route   ('source_of_fund.edit',$item->id)}}" title="Edit"><i class="fa fa-edit"></i>
                            </a> 
                            
                           <a href="javascript:void(0)" id="delete-user" data-id="{{ $item->id }}" class="delete-service-type-modal btn btn-danger btn-xs button delete-confirm" title="Delete" ><i class="fa fa-trash"></i></a>

                           
                        </td>
                    </tr>
                    @endforeach
                  
                </tbody>
              </table>
              <div class="mt-4 text-center">{{ $source_of_fund->links() }}</div>
          </div>
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
        var fund_id = $(this).data("id");
        
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
                url: " {{ url('source_of_fund') }}"+'/'+fund_id,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    console.log(data)
                    swal("Deleted!", "Your imaginary file has been deleted.", "success");
                    window.location.assign("/source_of_fund")
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

{{-- @push('script')

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
