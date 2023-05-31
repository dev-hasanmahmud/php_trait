@extends('layouts.master')
@section('content')
 
   
   
    <div class="main-content mt-4 ">
    <div class="container">
   @include('sweetalert::alert')
    <div class="programme-title">
            <h3 class="d-inline">
              <img src="{{custom_asset('assets/images/programme.png')}}" alt="" /> Designation 
            </h3>
         
      <a href="{{ route('designation.create') }}" type="submit" class="btn btn-success btn-sm d-inline fa fa-plus" title="Add Designation"></a>
    </div>

  <section class="package-table card card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <td width="20%" class="text-left">Serial No.</td>
                <td width="15%">Name (English)</td>
                <td width="30%">Name (Bangla)</td>
                <td width="35%">Action</td>
              </tr>
            </thead>
            <tbody>
                @php
                    $i=1;
                @endphp
                @foreach ($designations as $designation)
                <tr>
                    <td>@php echo $i++  @endphp</td>
                    <td>{{$designation->name_en}}</td>
                    <td>{{$designation->name_bn}}</td>
                    <td>   
                        <form class="delete" action="{{ route('designation.destroy',$designation->id) }}" method="POST">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <a class="btn btn-info btn-sm  fa fa-edit " href="{{ route('designation.edit',$designation->id) }}" title="Edit"></a>
                            <button type="submit" class="btn btn-danger btn-sm  fa fa-trash" title="Delete"></button>
                        </form>
                    </td>
                </tr>
                @endforeach
              
           
            </tbody>
          </table>
           <div class="mt-4 text-center">{{ $designations->links() }}</div>
        </div>
      </section>
  
    </div>
  </div>
@endsection

@push('script')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(".delete").on("submit", function(){
        return confirm("Do you want to delete this Designation?");
    });
</script>
@endpush