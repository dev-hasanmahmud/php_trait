@extends('layouts.master')
@section('content')
 
   
    <div class="main-content mt-4 ">
    <div class="container">
      @include('sweetalert::alert')
    <div class="programme-title">
            <h3 class="d-inline">
              <img src="{{custom_asset('assets/images/programme.png')}}" alt="" />All Departments
            </h3>
       
       <a href="{{ route('department.create') }}" type="submit" class="btn btn-success btn-sm d-inline fa fa-plus" title="Add Department"></a>

     </div>

  <section class="package-table card card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <td width="5%" class="text-left"></td>
                <td width="20%">Name</td>
                <td width="20%">Address</td>
                <td width="20%">Contact Number</td>
                <td width="20">Type</td>
                <td width="15%">Action</td>
              </tr>
            </thead>
            <tbody>
              @php
                  $i=1;
              @endphp
                @foreach ($departments as $item)
                <tr>
                    <td>@php  echo $i++  @endphp </td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->address}}</td>
                    <td>{{$item->contact_no}}</td>
                    <td>
                      @if ($item->is_department==1)
                          <span>Department</span>
                      @else 
                          <span>Organization</span>
                      @endif
                    
                    </td>
                    <td>   
                      <form action="{{ route('department.destroy', $item->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                      <a class="edit-service-type-modal btn btn-warning btn-xs"  href="{{route ('department.edit',$item->id)}}" title="Edit"><i class="fa fa-edit"></i>
                      </a> 

                      <button class="delete-service-type-modal btn btn-danger btn-xs" id="delete" title="Delete"><i class="fa fa-trash"></i> 
                        </button>
                   </form>
                    </td>
                </tr>
                @endforeach
              
           
            </tbody>
          </table>
          <div class="mt-4 text-center">{{ $departments->links() }}</div>
        </div>
      </section>
  
    </div>
  </div>
@endsection

@push('script')
<script>
    $("#delete").on("click", function(){

        return confirm("Do you want to delete this Department?");
    });
</script>
@endpush





