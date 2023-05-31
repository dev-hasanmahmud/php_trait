@extends('layouts.master')
@section('content')
<div class="sub-head header header2">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
        <div class="procurement-title">
          <h5 class="d-inline">
            <i class="fa fa-window-restore" aria-hidden="true"></i> Indicator List
          </h5>                
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        <a class=" btn sub-btn float-right" href="{{ route('indicator.create') }}" ><i class="fa fa-plus"> </i> Add Indicator </a>
        
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
    <form  method="GET" action="{{ url('indicator') }}"  >
      <div class="form-row mb-2 row">
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-11">
          <select name="package_id" class="form-control form-control-sm select2 custom-select2">
            <optgroup label="Select Package Type">
              @foreach ($package as $item)
                <option value="{{ $item->id }}" 
                  @if ($item->id == $search[1])
                    {{'selected= "selected" '}}
                  @endif
                  >{{ $item->package_no }}-{{ $item->name_en }}</option>
              @endforeach
            </optgroup>
          </select>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1">
        <button type="submit" class="btn btn-lg w-70 btn-info "><i class="fa fa-search" title="Search"></i></button>
		</div>
      </div>
    </form>
        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <td width="3%" class="text-center">Id</td>
                <td width="18%"  class="text-left"  >Indicator Name(English)</td>
                <td width="10%"  class="text-left"  >Indicator category(English)</td>
                <td width="20%" class="text-left"  >Package Name</td>
                <td width="8%"  class="text-left" >Target Quantity</td>
                <td width="7%"  class="text-left" >Ave Weightage</td>
                <td width="10%"  class="text-left" >Action</td>
              </tr>
            </thead>
            <tbody>
                @foreach ($indicator as $item)
                <tr>
                    <td class="text-center">{{ $loop->index+$indicator->firstItem() }}</td>
                    <td class="text-left" >{{$item->name_en}}</td>
                  
                     @if ($is_filter)
                      <td class="text-left" > {{ $item->category }} </td>
                      <td class="text-left" >{{$item->package_no.'-'.$item->package_name}}</td>
                    @else 
                    
                      <td class="text-left" >{{ isset($item->indicator_category->name_en) ?$item->indicator_category->name_en : null}}</td>
                      <td class="text-left" >{{ isset($item->component->name_en)?$item->component->package_no.'-'.$item->component->name_en:null }}</td>
                    @endif
                    
                    <td>{{$item->target}}</td>
                    <td>{{$item->ave_weightage}}</td>
                    <td>
                      <form action="{{ route('indicator.destroy', $item->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <a class="edit-service-type-modal btn btn-warning btn-xs"  href="{{route ('indicator.edit',$item->id)}}" title="Edit"><i class="fa fa-edit"></i>
                        </a>

                        <button class="delete-service-type-modal btn btn-danger btn-xs" id="delete" title="Delete"><i class="fa fa-trash"></i>
                        </button>
                      </form>
                    </td>
                </tr>
                @endforeach


            </tbody>
          </table>
          <div class="text-center">{{ $indicator->links() }}</div>
        </div>
      </section>

    </div>
  </div>
@endsection

@push('script')
<script>
    $("#delete").on("click", function(){
      console.log('fun')
      return confirm("Do you want to delete this Indicator?");
    });
</script>
@endpush
