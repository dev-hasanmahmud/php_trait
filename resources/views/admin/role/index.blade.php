@extends('layouts.master')
@section('content')
   <div class="sub-head header header2">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
        <div class="procurement-title">
          <h5 class="d-inline">
            <i class="fa fa-users" aria-hidden="true"></i> Roles
          </h5>                
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        <a class=" btn sub-btn float-right" href="{{ route('role.create') }}" ><i class="fa fa-plus"> </i> Add  Role </a>
        
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
                <td class="text-left">Serial No.</td>
                <td>Name</td>
                <td>Display Name</td>
                <td>Description</td>
                <td>Action</td>
              </tr>
            </thead>
            <tbody>
                @php
                    $i=1;
                @endphp
                @foreach ($roles as $role)
                <tr>
                    <td class="text-center">@php echo $i++  @endphp</td>
                    <td class="text-left" >{{$role->name}}</td>
                    <td class="text-left" >{{$role->display_name}}</td>
                    <td class="text-left" >{{$role->description}}</td>
                    <td>
							
                        <form class="delete" action="{{ route('role.destroy',$role->id) }}" method="POST">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <a class="btn btn-info btn-sm  fa fa-edit " href="{{ route('role.edit',$role->id) }}" title="Edit"></a>
                            <button type="submit" class="btn btn-danger btn-sm  fa fa-trash" title="Delete"></button>
							<a class="btn btn-info btn-sm  fa fa-unlock " href="{{ url('user-permision').'?role_id='.$role->id }}" title="Role Permission"></a>
						</form>
                    </td>
                </tr>
                @endforeach
              
           
            </tbody>
          </table>
           <div class="mt-0 text-center">{{ $roles->links() }}</div>
        </div>
      </section>
  
    </div>
  </div>
@endsection

@push('script')

<script>
    $(".delete").on("submit", function(){
        return confirm("Do you want to delete this Role?");
    });
</script>
@endpush