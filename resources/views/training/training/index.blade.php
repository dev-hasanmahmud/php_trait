@extends('layouts.master')
@section('content')
 
<div class="sub-head header header2">
  <div class="container">
    <div class="row">
  <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
    <div class="procurement-title">
            <h5 class="d-inline">
                <img src="{{ custom_asset('assets/images/icons/training1.png') }}" alt="" /> Training List
            </h5>                
        </div>
  </div>
  <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
    <a class=" btn sub-btn float-right" href="{{ route('training.create') }}">  <i class="fa fa-plus"> </i> Add Training</a>
    <a class=" active btn sub-btn float-right" href="{{ url('training') }}"  >Training</a>
    
  </div>
</div>
</div>
</div>   

<div class="main-content mt-4 ">
    <div class="container">
      @include('sweetalert::alert')
    {{-- <div class="programme-title">
            <h3 class="d-inline">
              <img src="{{custom_asset('assets/images/programme.png')}}" alt="" /> Training List
            </h3>
       
       <a href="{{ route('training.create') }}" type="submit" class="btn btn-success btn-sm d-inline fa fa-plus" title="Add Indicator Data"></a>

     </div> --}}

  <section class="package-table card card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <td width="5%" class="text-left">Id</td>
                <td width="20%">Title</td>
                <td width="20%">Training Category</td>
                <td width="10%">Serial Number</td>
                <td width="10%">Total Event</td>
                <td width="10%">Total Batch</td>
                <td width="10%">Action</td>
              </tr>
            </thead>
            <tbody>
                @foreach ($training as $item)
                <tr>
                  <td>{{ $loop->index+$training->firstItem() }}</td>
                    <td class="text-left" >{{$item->title}}</td>
                    <td class="text-left">{{isset($item->trainingcategory->name)?$item->trainingcategory->name:null}}</td>
                    <td >{{ $item->serial_number }}</td>
                    <td>{{$item->total_event}}</td>
                    <td>{{$item->toatal_batch}}</td>
                    
                    <td>   
                      <a class="edit-service-type-modal btn btn-warning btn-xs"  href="{{route ('training.edit',$item->id)}}" title="Edit"><i class="fa fa-edit"></i>
                      </a> 

                      <a href="javascript:void(0)" id="delete-user" data-id="{{ $item->id }}" class="edit-service-type-modal btn btn-danger btn-xs" title="Delete"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                @endforeach
              
           
            </tbody>
          </table>
          <div class="mt-4 text-center">{{ $training->links() }}</div>
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
        var training_id = $(this).data("id");
        
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
                url: " {{ url('training') }}"+'/'+training_id,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    console.log(data)
                    swal("Deleted!", "Your imaginary file has been deleted.", "success");
                    window.location.assign("/training")
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



