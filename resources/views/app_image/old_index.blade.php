@extends('layouts.master')
@section('content')
<div class="sub-head header header2">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
        <div class="procurement-title">
          <h5 class="d-inline">
            <i class="fa fa-window-restore" aria-hidden="true"></i> App-Image Details
          </h5>                
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        <a class=" btn sub-btn float-right" href="{{ route('indicator_data.create') }}" ><i class="fa fa-plus"> </i> Add  Indicator Wise Progress </a>
        
      </div>
    </div>
  </div>
</div>
   
    <div class="main-content mt-4 ">
    <div class="container">
      @include('sweetalert::alert')
    {{-- <div class="programme-title">
            <h3 class="d-inline">
              <img src="{{custom_asset('assets/images/programme.png')}}" alt="" /> Indicator Wise Progress
            </h3>
       
       <a href="{{ route('indicator_data.create') }}" type="submit" class="btn btn-success btn-sm d-inline fa fa-plus" title="Add Indicator Data"></a>

     </div> --}}

  <section class="package-table card card-body">

    <form  method="GET" action="{{ url('app-image') }}"  >
      <div class="form-row mb-2 row">
        @if(auth()->user()->role != 14 )
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-6">
        @else 
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-11">
        @endif
          <select name="package_id" class="form-control form-control-sm select2 custom-select2">
            <option value="0">Select Package </option>
              @foreach ($package as $item)
                
                <option value="{{ $item->id }}" 
                  @if ($item->id == $search[0])
                    {{'selected= "selected" '}}
                  @endif
                  >{{ $item->package_no }}-{{ $item->name_en }}</option>
              @endforeach
            
          </select>
        </div>
        @if(auth()->user()->role != 14 )
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-5">
          <select name="user_id" class="form-control form-control-sm select2 custom-select2">
            <option value="0">Select User</option>
              @foreach ($user as $item)
                <option value="{{ $item->id }}" 
                  @if ($item->id == $search[1])
                    {{'selected= "selected" '}}
                  @endif
                  >{{ $item->name }}</option>
              @endforeach
            
          </select>
        </div>
        @endif
        <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1">
          <button type="submit" class="btn btn-lg w-100 btn-info ">Find</button>
		    </div>
      </div>
    </form>
        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <td width="3%" class="text-center">Id</td>
                <td width="27%" class="text-left">Package Name</td>
                <td width="20%" class="text-left">Title</td>
                <td width="10%" class="text-left" >Date</td>
                <td width="13%" class="text-left" >Data Added By</td>
                <td width="7%" class="text-left" >Status</td>
                <td width="20%">Action</td>
              </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                <tr>
                    <td class="text-center">{{ $loop->index+$data->firstItem()	}}</td>
                    
                    <td class="text-left" >{{$item->package_no.'-'.$item->name_en}}</td>
                    <td class="text-left" >{{$item->title}}</td>
                    @php
                    $date = explode(' ',$data[0]->date);
                    @endphp
                    <td>{{$date[0]}}</td>
                    <td>{{$item->created}}</td>
                   
                    @if ($item->is_approve==0)
                      <td class="text-left" > Pending </td>
                    @elseif($item->is_approve==1)
                      <td class="text-left" > Approve </td>    
                    @else
                      <td class="text-left" > Disapprove </td>
                    @endif
                    
                    <td class="text-left" >   
                      <a class="edit-service-type-modal btn btn-info btn-xs mr-1" href="{{route ('app-image.show',$item->id)}}" title="Show"><i class="fa fa-eye"></i> </a>
                      
                      <a class="edit-service-type-modal btn btn-warning btn-xs"  href="{{route ('app-image.edit',$item->id)}}" title="Edit"><i class="fa fa-edit"></i>
                      </a> 

                      @if(isset($permission['AppImageController@image_approve']))
                      <a href="javascript:void(0)" id="approve" data-id="{{ $item->id }}" class="edit-service-type-modal btn btn-info btn-xs" title="Approved"><i class="fa fa-check" aria-hidden="true"></i> </a> 
                      @endif
                      
                      <a href="javascript:void(0)" id="delete-user" data-id="{{ $item->id }}" class="edit-service-type-modal btn btn-danger btn-xs" title="Delete"><i class="fa fa-trash"></i></a> 
                    </td>
                </tr>
                @endforeach
              
           
            </tbody>
          </table>
          <div class="mt-4 text-center">{{ $data->links() }}</div>
        </div>
      </section>
  
    </div>
  </div>
@endsection

@push('script')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
$(document).ready(function () {

  $('body').on('click', '#approve', function () {
        
        var approve_data_id   = $(this).data("id");

        console.log('fuunfsa  '+approve_data_id)

        swal({
            title: 'Are you sure?',
            text: 'Are you sure approve this data!',
            icon: 'warning',
            buttons: ["Cancel", "Yes!"],
        }).then(function(value) {
            if (value) {
              console.log('succes method')
              $.ajax({
                type: "GET",
                url: " {{ url('ajax/app_image_approve') }}"+'/'+approve_data_id,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    console.log(data)
                    swal("Approved !", "Your imaginary file has been approved", "success");
                    //var url = "/approval?component_id="+component_id+"&status="+status
                   // window.location.assign('/app-image')
                },
                error: function (data) {
                    console.log('Error:', data);
                    swal("Cancelled", "Something went wrong :)", "error");
                }
              });
            }
        });   
    });  
   
    $('body').on('click', '#delete-user', function () {
        console.log('fuunfsa')
        var user_id = $(this).data("id");
        
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
                url: " {{ url('app-image') }}"+'/'+user_id,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    console.log(data)
                    swal("Deleted!", "Your imaginary file has been deleted.", "success");
                    window.location.assign("/app-image")
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


{{-- <form action="{{ route('indicator_data.destroy', $item->id)}}" method="post" class="delete">
  @csrf
  @method('DELETE')
  <a class="edit-service-type-modal btn btn-warning btn-xs"  href="{{route ('indicator_data.edit',$item->id)}}" title="Edit"><i class="fa fa-edit"></i>
  </a> 

  <button class="delete-service-type-modal btn btn-danger btn-xs" id="delete" title="Delete"><i class="fa fa-trash"></i> 
  </button>
</form>  --}}



