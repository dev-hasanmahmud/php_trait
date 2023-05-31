@extends('layouts.master')
@section('content')

<div class="sub-head header header2">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
        <div class="procurement-title">
          <h5 class="d-inline">
            <i class="fa fa-database" aria-hidden="true"></i> Activity Indicator Data
          </h5>                
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        <a class=" btn sub-btn float-right" href="{{ route('activity-indicator-data.create') }}" ><i class="fa fa-plus"> </i> Add Activity Indicator Data </a>
        
      </div>
    </div>
  </div>
</div>
   
    <div class="main-content mt-4 ">
    <div class="container">
      @include('sweetalert::alert')
    {{-- <div class="programme-title">
            <h3 class="d-inline">
              <img src="{{custom_asset('assets/images/programme.png')}}" alt="" />Activity Indicator Data
            </h3>
       
       <a href="{{ route('activity-indicator-data.create') }}" type="submit" class="btn btn-success btn-sm d-inline fa fa-plus" title="Add Activity Indicator Data"></a>

     </div> --}}

  <section class="package-table card card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <td width="5%" class="text-center" >SL</td>
                <td width="30%">Package Name</td>
                <td width="25%">Activity Indicator Name</td>
                <td width="25%">Value</td>
                <td width="15%">Action</td>
              </tr>
            </thead>
            <tbody>
              @php
                  $i=1;
              @endphp
                @foreach ($activity_indicators_data as $item)
                <tr>
                    <td class="text-center" >{{ $loop->index+$activity_indicators_data->firstItem() }}</td>
                    <td class="text-left" > {{ isset($item->component->name_en)?$item->component->name_en:null}}</td>
                    <td class="text-left" > {{ isset($item->activityindicator->name_en)?$item->activityindicator->name_en:null}}</td>
                    <td >{{$item->value}}</td>
                    <td>   
                      <form action="{{ route('activity-indicator-data.destroy', $item->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                      <a class="edit-service-type-modal btn btn-warning btn-xs"  href="{{route ('activity-indicator-data.edit',$item->id)}}" title="Edit"><i class="fa fa-edit"></i>
                      </a> 

                      <button class="delete-service-type-modal btn btn-danger btn-xs" id="delete" title="Delete"><i class="fa fa-trash"></i> 
                        </button>
                   </form>
                    </td>
                </tr>
                @endforeach
              
           
            </tbody>
          </table>
          <div class="mt-4 text-center">{{ $activity_indicators_data->links() }}</div>
        </div>
      </section>
  
    </div>
  </div>
@endsection

@push('script')
<script>
    $("#delete").on("click", function(){

        return confirm("Do you want to delete this Activity Indicator Data?");
    });
</script>
@endpush





