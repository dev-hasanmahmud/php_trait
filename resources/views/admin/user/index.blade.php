@extends('layouts.master')
@section('content')
  <div class="sub-head header header2">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
        <div class="procurement-title">
          <h5 class="d-inline">
            <i class="fa fa-users" aria-hidden="true"></i> User List
          </h5>                
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        <a class=" btn sub-btn float-right" href="{{ route('user.create') }}" ><i class="fa fa-plus"> </i> Add  User </a>
        
      </div>
    </div>
  </div>
</div>
    <div class="main-content mt-4 ">
    <div class="container">
    @include('sweetalert::alert')
    {{-- <div class="programme-title">
            <h3 class="d-inline">
              <img src="{{custom_asset('assets/images/programme.png')}}" alt="" /> All Users
            </h3>
       
        <a href="{{ route('user.create') }}" type="submit" class="btn btn-success btn-sm d-inline fa fa-plus" title="Add User"></a>

     </div> --}}

  <section class="package-table card card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <td class="text-center">SL</td>
                <td>Name</td>
                <td>Email</td>
                <td>Designation</td>
                <td>Address</td>
                <td>Role</td>
                <td>Status</td>
                <td style="width:9%;">Action</td>
              </tr>
            </thead>
            <tbody>
                @php
                    $i=1;
                @endphp
                @foreach ($users as $user)
                <tr>
                  <td class="text-center" >{{ $loop->index+$users->firstItem() }}</td>
                    <td class="text-left" >{{$user->name}}</td>
                    <td class="text-left" >{{$user->email}}</td>
                    <td class="text-left" >{{$user->userDesignation->name_en}}</td>
                    <td class="text-left" >{{$user->address}}</td>
                    <td class="text-left" > {{ $user->userRole->name }} </td>
                    <td class="text-left" >
                       @if ($user->status==0)
                          <span>Inactive</span>
                       @else
                           <span>Active</span>
                      @endif
                     </td>
                    <td>   
                        <form class="delete" action="{{ route('user.destroy',$user->id) }}" method="POST">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <a class="btn btn-info btn-sm  fa fa-edit " href="{{ route('user.edit',$user->id) }}" title="Edit"></a>
                            <button type="submit" class="btn btn-danger btn-sm  fa fa-trash" title="Delete"></button>
                        </form>
                    </td>
                </tr>
                @endforeach
              
           
            </tbody>
          </table>
          <div class="text-center">{{ $users->links() }}</div>
        </div>
      </section>
  
    </div>
  </div>
@endsection

@push('script')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(".delete").on("submit", function(){
        return confirm("Do you want to delete this User?");
    });
</script>
@endpush