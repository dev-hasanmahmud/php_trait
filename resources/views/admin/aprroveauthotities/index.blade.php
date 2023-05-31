@extends('layouts.master')
@section('content')

<div class="sub-head header header2">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
        <div class="procurement-title">
          <h5 class="d-inline">
            <i class="fa fa-user-plus" aria-hidden="true"></i> Approve Authority 
          </h5>                
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        <a class=" btn sub-btn float-right" href="{{ route('aprroveauthotities.create') }}" ><i class="fa fa-plus"> </i> Add Authority</a>
        
      </div>
    </div>
  </div>
</div>
   
   
    <div class="main-content mt-4 ">
    <div class="container">
     @include('sweetalert::alert')
    {{-- <div class="programme-title">
            <h3 class="d-inline">
              <img src="{{custom_asset('assets/images/programme.png')}}" alt="" /> Approve Authority 
            </h3>
         
      <a href="{{ route('aprroveauthotities.create') }}" type="submit" class="btn btn-success btn-sm d-inline fa fa-plus" title="Add Authority"></a>
    </div> --}}

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
                @foreach ($approve_authorities as $authority)
                <tr>
                    <td>@php echo $i++  @endphp</td>
                    <td>{{$authority->name_en}}</td>
                    <td>{{$authority->name_bn}}</td>
                    <td>   
                        <form class="delete" action="{{ route('aprroveauthotities.destroy',$authority->id) }}" method="POST">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <a class="btn btn-info btn-sm  fa fa-edit " href="{{ route('aprroveauthotities.edit',$authority->id) }}" title="Edit"></a>
                            <button type="submit" class="btn btn-danger btn-sm  fa fa-trash" title="Delete"></button>
                        </form>
                    </td>
                </tr>
                @endforeach
              
           
            </tbody>
          </table>
           <div class="mt-4 text-center">{{ $approve_authorities->links() }}</div>
        </div>
      </section>
  
    </div>
  </div>
@endsection

@push('script')

<script>
    $(".delete").on("submit", function(){
        return confirm("Do you want to delete this Authority?");
    });
</script>
@endpush