@extends('layouts.master')
@section('content')
<div class="sub-head header header2">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
        <div class="procurement-title">
          <h5 class="d-inline">
            <i class="fa fa-window-restore" aria-hidden="true"></i> Settings
          </h5>                
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        <a class=" btn sub-btn float-right" href="{{ route('settings.create') }}" ><i class="fa fa-plus"> </i> Add Record </a>
        
      </div>
    </div>
  </div>
</div>

    <div class="main-content mt-4 ">
    <div class="container">
      @include('sweetalert::alert')
    {{-- <div class="programme-title">
            <h3 class="d-inline">
              <img src="{{custom_asset('assets/images/programme.png')}}" alt="" /> Indicator List
            </h3>
       <a href="{{ route('indicator.create') }}" type="submit" class="btn btn-success btn-sm d-inline fa fa-plus" title="Add Indicator"></a>

     </div> --}}


  <section class="package-table card card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <td width="5%" class="text-left">Id</td>
                <td width="18%">Type</td>
                <td width="18%">Procurement Method</td>
                <td width="18%">Label Name</td>
                <td width="18%">Identifier</td>
                <td width="8%">Is Mendatory</td>
                <td width="15%">Action</td>
              </tr>
            </thead>
            <tbody>
                @foreach ($records as $item)
                <tr>
                  <td class="text-center" >{{ $loop->index+$records->firstItem() }}</td>
                    <td>{{$item->types->name_en}}</td>
                    <td>{{$item->procurement->name_en}}</td>
                    <td>{{ $item->label_name }}</td>
                    <td>{{ $item->identifier }}</td>
                    <td>
                        @if ($item->is_mendatory==1)
                          <span>Yes</span>
                        @else 
                          <span>No</span>
                        @endif
                        
                    </td>
                    <td>
                      <form class="delete" action="{{ route('settings.destroy', $item->id)}}" method="post">
                       <input type="hidden" name="_method" value="DELETE">
                       <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <a class="btn btn-info btn-sm  fa fa-edit "  href="{{route ('settings.edit',$item->id)}}" title="Edit"></a>
                         <button item="submit" class="btn btn-danger btn-sm  fa fa-trash" title="Delete"></button>
                      </form>
                    </td>
                </tr>
                @endforeach


            </tbody>
          </table>
        <div class="mt-4 text-center">{{ $records->links() }}</div>
        </div>
      </section>

    </div>
  </div>
@endsection

@push('script')
<script>
    $(".delete").on("submit", function(){
        return confirm("Do you want to delete this Record?");
    });
</script>
@endpush
