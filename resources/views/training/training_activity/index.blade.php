@extends('layouts.master')
@section('content')

<div class="sub-head header header2">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
        <div class="procurement-title">
                <h5 class="d-inline">
                    <img src="{{ custom_asset('assets/images/icons/training1.png') }}" alt="" /> Training Activity
                </h5>                
            </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        <a class="  btn sub-btn float-right" href="{{ route('training-activity.create') }}"  > <i class="fa fa-plus"> </i> Add Training Activity</a>
        <a class="active btn sub-btn float-right" href="{{ url('training-activity') }}" > Training Activities</a>
      </div>
    </div>
  </div>
</div>   
   
<div class="main-content mt-4 ">
  <div class="container">
    @include('sweetalert::alert')
    {{-- <div class="programme-title">
      <h3 class="d-inline">
      <img src="{{custom_asset('assets/images/programme.png')}}" alt="" /> Training Activity List</h3>

      <a href="{{ route('training-activity.create') }}" type="submit" class="btn btn-success btn-sm d-inline fa fa-plus" title="Add Indicator Data"></a>
    </div> --}}
    

  <section class="package-table card card-body">
    <form  method="GET" action="{{ url('training-activity') }}"  >
     
      <div class="form-row mb-3 mr-0 mt-0">
        <div class="col">
          <input type="text" name="training_name" class="form-control" placeholder="Training Name" value="{{ $search[0] }}">
        </div>
        
        <div class="col">
          <select name="training_category_id" class="form-control form-control-sm select2 custom-select2">
            {{-- <option value="">Select Training Category</option> --}}
            <optgroup>
            @foreach ($training_category as $item)
              <option value="{{ $item->id }}"
                @if ($item->id == $search[1])
                {{'selected= "selected" '}}
                @endif
                >{{$item->serial_no  }}-{{ $item->name }}</option>
            @endforeach
            </optgroup>
          </select>
        </div>
        <button type="submit" class="btn btn-info fa fa-search" title="Search"></button>
      </div>
    </form>
        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <td width="5%" class="text-left">Id</td>
                <td width="30%" class="text-left" >Training Category</td>
                <td width="20%" class="text-left">Training Name</td>
                <td width="30%" class="text-left">Reference</td>
                <td width="15%" class="text-left" > Action</td>
              </tr>
            </thead>
            <tbody>
                @foreach ($training_activity as $item)
                <tr>
                    <td class="text-left" >{{ $loop->index+$training_activity->firstItem() }}</td>
                    <td  class="text-left" ><a href="{{route ('training-activity.show',$item->id)}}">
                      {{isset($item->trainingcategory->name)?$item->trainingcategory->serial_no.'-'.$item->trainingcategory->name:$item->serial_no.'-'.$item->name}}</a>
                    </td>
                    <td  class="text-left" ><a href="{{route ('training-activity.show',$item->id)}}">
                      {{isset($item->training->title)?$item->training->title:$item->title}}</a>
                    </td>
                    <td  class="text-left">{{$item->reference}}</td>
                    <td>   
                      <a class="edit-service-type-modal btn btn-info btn-xs"  href="{{route ('training-activity.show',$item->id)}}" title="Show"><i class="fa fa-eye"></i>
                      </a> 

                      <a class="edit-service-type-modal btn btn-warning btn-xs"  href="{{route ('training-activity.edit',$item->id)}}" title="Edit"><i class="fa fa-edit"></i>
                      </a> 

                      <a href="javascript:void(0)" id="delete-user" data-id="{{ $item->id }}" class="edit-service-type-modal btn btn-danger btn-xs" title="Delete"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                @endforeach
              
           
            </tbody>
          </table>
          <div class="mt-4 text-center">{{ $training_activity->links() }}</div>
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
        var payment_id = $(this).data("id");
        
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
                url: " {{ url('training-activity') }}"+'/'+payment_id,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    console.log(data)
                    swal("Deleted!", "Your imaginary file has been deleted.", "success");
                    window.location.assign("/training-activity")
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



