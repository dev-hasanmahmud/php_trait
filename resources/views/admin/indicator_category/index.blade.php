@extends('layouts.master')
@section('content')

<div class="sub-head header header2">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
        <div class="procurement-title">
          <h5 class="d-inline">
            <i class="fa fa-window-restore" aria-hidden="true"></i> Indicator Category
          </h5>                
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        <a class=" btn sub-btn float-right" href="{{ route('indicator_category.create') }}" ><i class="fa fa-plus"> </i> Add Indicator Category </a>
        
      </div>
    </div>
  </div>
</div>
   
    <div class="main-content mt-4 ">
    <div class="container">
      @include('sweetalert::alert')
    {{-- <div class="programme-title">
            <h3 class="d-inline">
              <img src="{{custom_asset('assets/images/programme.png')}}" alt="" /> Indicator Category
            </h3>
       
       <a href="{{ route('indicator_category.create') }}" type="submit" class="btn btn-success btn-sm d-inline fa fa-plus" title="Add Indicator Category"></a>

     </div> --}}

  <section class="package-table card card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <td width="5%" class="text-left">Id</td>
                <td width="25%">Name (English)</td>
                <td width="25%">Name (Bangla)</td>
                <td width="30%">Description</td>
                <td width="15%">Action</td>
              </tr>
            </thead>
            <tbody>
                @foreach ($indicator_category as $item)
                <tr>
                  <td class="text-center" >{{ $loop->index+$indicator_category->firstItem() }}</td>
                    <td class="text-left" >{{$item->name_en}}</td>
                    <td class="text-left" >{{$item->name_bn}}</td>
                    <td class="text-left" >{{$item->description}}</td>
                    <td>   
                      <form action="{{ route('indicator_category.destroy', $item->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <a class="edit-service-type-modal btn btn-warning btn-xs"  href="{{route ('indicator_category.edit',$item->id)}}" title="Edit"><i class="fa fa-edit"></i>
                        </a> 

                        <button class="delete-service-type-modal btn btn-danger btn-xs" id="delete" title="Delete"><i class="fa fa-trash"></i> 
                        </button>
                      </form>
                    </td>
                </tr>
                @endforeach
              
           
            </tbody>
          </table>
          <div class=" text-center">{{ $indicator_category->links() }}</div>
        </div>
      </section>
  
    </div>
  </div>
@endsection

@push('script')
<script>
    $("#delete").on("click", function(){

        return confirm("Do you want to delete this Indicator Category?");
    });
</script>
@endpush