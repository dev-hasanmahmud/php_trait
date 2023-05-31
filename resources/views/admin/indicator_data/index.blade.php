@extends('layouts.master')
@section('content')
<div class="sub-head header header2">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
        <div class="procurement-title">
          <h5 class="d-inline">
            <i class="fa fa-window-restore" aria-hidden="true"></i> Indicator Wise Progress
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

    <form  method="GET" action="{{ url('indicator_data') }}"  >
      <div class="form-row mb-2 row">
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-5">
          <input type="text" id="package_name" name="indicator_name" class="form-control" placeholder="Indicator Name" value="{{ $search[0] }}">
        </div>
        {{-- <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
          <input type="text" name="name_en" class="form-control" placeholder="Package name">
        </div> --}}
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-6">
          <select name="package_id" id="package" class="form-control form-control-sm select2 custom-select2">
              <option value="0">Select package type</option>
              @foreach ($package as $item)
                <option value="{{ $item->id }}" 
                  @if ($item->id == $search[1])
                    {{'selected= "selected" '}}
                  @endif
                  >{{ $item->package_no }}-{{ $item->name_en }}</option>
              @endforeach
            
          </select>
        </div>
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
                <td width="26%" class="text-left">Package Name</td>
                <td width="22%" class="text-left">Indicator Name</td>
                <td width="7%" class="text-left" >Progress Value</td>
                <td width="9%" class="text-left">Achievement Quantity</td>
                <td width="10%" class="text-left" >Date</td>
                {{-- <td width="13%" class="text-left" >Details</td> --}}
                <td width="7%" class="text-left" >Status</td>
                <td width="16%">Action</td>
              </tr>
            </thead>
            <tbody>
                @foreach ($indicator_data as $item)
                <tr>
                    <td class="text-center">{{ $loop->index+$indicator_data->firstItem()	}}</td>
                    @if ($is_filter)
                    <td class="text-left" >{{$item->package_no.'-'.$item->package_name}}</td>
                    <td class="text-left" >{{$item->indicator_name}}</td>
                    @else
                    <td class="text-left" >{{isset($item->component->name_en)?$item->component->package_no.'-'.$item->component->name_en:null}}</td>
                    <td class="text-left" >{{isset($item->indicator->name_en)?$item->indicator->name_en:null}}</td>
                    @endif
                    
                    <td>{{$item->progress_value}}</td>
                    <td>{{$item->achievement_quantity}}</td>
                    <td>{{$item->date}}</td>
                    {{-- <td class="text-left" >{!! $item->details !!}</td> --}}
                    {{-- <td class="text-left"  >{!! substr(strip_tags($item->details),0, 20) !!}</td> --}}
                    @if ($item->is_approve==0)
                      <td class="text-left" > Pending </td>
                    @elseif( $item->is_approve==1 && (Auth::user()->role == 1 || Auth::user()->role == 6) )
                      <td class="text-left" > Recommended </td>

                    @elseif( $item->is_approve==1 )
                      <td class="text-left" > Approved </td>
                    @else
                      <td class="text-left" > Disapprove </td>
                    @endif
                    
                    <td class="text-left" >   
                      <a class="edit-service-type-modal btn btn-info btn-xs mr-1" href="{{route ('indicator_data.show',$item->id)}}" title="Show"><i class="fa fa-eye"></i> </a>
                      @if ( ! $item->is_approve || (Auth::user()->role == 1 ||Auth::user()->role == 6) )
                      <a class="edit-service-type-modal btn btn-warning btn-xs"  href="{{route ('indicator_data.edit',$item->id)}}" title="Edit"><i class="fa fa-edit"></i>
                      </a> 
                      <a href="javascript:void(0)" id="delete-user" data-id="{{ $item->id }}" class="edit-service-type-modal btn btn-danger btn-xs" title="Delete"><i class="fa fa-trash"></i></a>

                      @endif
                      
                    </td>
                </tr>
                @endforeach
              
           
            </tbody>
          </table>
          <div class="mt-4 text-center">{{ $indicator_data->links() }}</div>
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
        var user_id = $(this).data("id");
        var package_id = $("#package").val();
        var name = $("#package_name").val();
        //console.log("package_id " + package_id)
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
                url: " {{ url('indicator_data') }}"+'/'+user_id,
                data:{ package_id: package_id},
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    console.log(data)
                    swal("Deleted!", "Your imaginary file has been deleted.", "success");
                    if(package_id==0){
                      window.location.assign("/indicator_data")
                    }else{
                      window.location.assign("/indicator_data?indicator_name="+name  +"&package_id="+package_id)
                    }
                    
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



