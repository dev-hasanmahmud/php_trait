@extends('layouts.master')
@section('content')

<div class="sub-head header header2">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
        <div class="procurement-title">
          <h5 class="d-inline">
            <i class="fa fa-window-restore" aria-hidden="true"></i> Add Activity Indicator
          </h5>
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        <a class=" btn sub-btn float-right" href="{{ route('activityindicator.create') }}"><i class="fa fa-plus"> </i>
          Add Activity Indicator </a>

      </div>
    </div>
  </div>
</div>


<div class="main-content mt-4 ">
  <div class="container">
    @include('sweetalert::alert')
    {{-- <div class="programme-title">
            <h3 class="d-inline">
              <img src="{{custom_asset('assets/images/programme.png')}}" alt="" /> Activity Indicators
    </h3>

    <a href="{{ route('activityindicator.create') }}" type="submit" class="btn btn-success btn-sm d-inline fa fa-plus"
      title="Add Activity Indicator"></a>
  </div> --}}

  <section class="package-table card card-body">
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <td class="text-center">SL</td>
            <td>Activity Name (English)</td>
            <td>Component Name</td>
            <td width="10%">Action</td>
          </tr>
        </thead>
        <tbody>
          @php
          $i=1;
          @endphp
          @foreach ($data_input_titles as $item)
          <tr>

            <td class="text-center">{{ $loop->index+$data_input_titles->firstItem() }}</td>
            <td class="text-left">{{$item->title}}</td>

            <td class="text-left">{{@$item->component->package_no.'-'.@$item->component->name_en}}</td>
            <td>
              <form class="delete" action="{{ route('activityindicator.destroy',$item->id) }}" method="POST">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <a class="btn btn-info btn-sm  fa fa-edit " href="{{ route('activityindicator.edit',$item->id) }}"
                  title="Edit"></a>
                <button type="submit" class="btn btn-danger btn-sm  fa fa-trash" title="Delete"></button>
              </form>
            </td>
          </tr>
          @endforeach


        </tbody>
      </table>
      <div class="mt-4 text-center">{{ $data_input_titles->links() }}</div>
    </div>
  </section>

</div>
</div>
@endsection

@push('script')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
  $(".delete").on("submit", function(){
        return confirm("Do you want to delete this Activity Category?");
    });
</script>
@endpush
