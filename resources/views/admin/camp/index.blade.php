@extends('layouts.master')
@section('content')

<div class="sub-head header header2">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
        <div class="procurement-title">
          <h5 class="d-inline">
            <i class="fa fa-window-restore" aria-hidden="true"></i> Area List
          </h5>                
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        <a class=" btn sub-btn float-right" href="{{ route('camp.create') }}" ><i class="fa fa-plus"> </i> Add  Area </a>
        
      </div>
    </div>
  </div>
</div>

    <div class="main-content mt-4 ">
    <div class="container">
      @include('sweetalert::alert')
    {{-- <div class="programme-title">
            <h3 class="d-inline">
              <img src="{{custom_asset('assets/images/programme.png')}}" alt="" /> Area List
            </h3>

       <a href="{{ route('camp.create') }}" type="submit" class="btn btn-success btn-sm d-inline fa fa-plus" title="Add Camp"></a>

     </div> --}}

  <section class="package-table card card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <td width="10%" class="text-center">Id</td>
                <td width="15%">Area Code</td>
                <td width="30%">Area Name (English)</td>
                <td width="30%">Area Name (Bangli)</td>
                <td width="15%">Action</td>
              </tr>
            </thead>
            <tbody>
                @foreach ($camp as $item)
                <tr>
                    <td class="text-center" >{{ $loop->index+$camp->firstItem() }}</td>
                    <td>{{$item->code}}</td>
                    <td>{{$item->name_en}}</td>
                    <td>{{$item->name_bn}}</td>
                    <td>
                      <a class="edit-service-type-modal btn btn-warning btn-xs"  href="{{route ('camp.edit',$item->id)}}" title="Edit"><i class="fa fa-edit"></i>
                      </a>

                      <a href="javascript:void(0)" id="delete-camp" data-id="{{ $item->id }}" class="edit-service-type-modal btn btn-danger btn-xs" title="Delete"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                @endforeach


            </tbody>
          </table>
          <div class="text-center">{{ $camp->links() }}</div>
        </div>
      </section>

    </div>
  </div>
@endsection

@push('script')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
$(document).ready(function () {

    $('body').on('click', '#delete-camp', function () {
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
                url: " {{ url('camp') }}"+'/'+user_id,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    console.log(data)
                    swal("Deleted!", "Your imaginary file has been deleted.", "success");
                    window.location.assign("/camp")
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



