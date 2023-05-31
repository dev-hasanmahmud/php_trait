@extends('layouts.master')
@section('content')
<div class="sub-head header header2">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
        <div class="procurement-title">
          <h5 class="d-inline">
            <i class="fa fa-user" aria-hidden="true"></i> Contractors List
          </h5>
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        <a class=" btn sub-btn float-right" href="{{ route('contactor.create','type=1') }}"><i class="fa fa-plus"> </i> Add
          Contractor </a>
        <a class=" btn sub-btn float-right" href="{{ route('contactor.create','type=4') }}"><i class="fa fa-plus"> </i> Add
         Supplier
        </a>
        <a class=" btn sub-btn float-right" href="{{ route('contactor.create','type=3') }}"><i class="fa fa-plus"> </i> Add
          Consulting Firm
        </a>
        <a class=" btn sub-btn float-right" href="{{ route('contactor.create','type=2') }}"><i class="fa fa-plus"> </i> Add
          Consultant
        </a>
      </div>
    </div>
  </div>
</div>

<div class="main-content mt-4 ">
  <div class="container">
    @include('sweetalert::alert')
    {{-- <div class="programme-title">
            <h3 class="d-inline">
              <img src="{{custom_asset('assets/images/programme.png')}}" alt="" /> All Contactors
    </h3>

    <a href="{{ route('contactor.create') }}" type="submit" class="btn btn-success btn-sm d-inline fa fa-plus"
      title="Add Contactor"></a>

  </div> --}}

  <section class="package-table card card-body">
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <td width="5%" class="text-center">SL</td>
            <td width="15%">Name (English)</td>
            {{-- <td width="15%">Name (Bangla)</td> --}}
            <td width="11%">Contact Number</td>
            <td width="14%">Address</td>
            <td width="10%">Type</td>
            {{-- <td width="20%">Details</td> --}}
            <td width="15%">Action</td>
          </tr>
        </thead>
        <tbody>
          @php
          $i=1;
          @endphp
          @foreach ($contactors as $contactor)
          <tr>
            <td class="text-center">{{ $loop->index+$contactors->firstItem() }}</td>
            <td class="text-left">{{$contactor->name_en}}</td>
            {{-- <td class="text-left" >{{$contactor->name_bn}}</td> --}}
            <td class="text-left">{{$contactor->contact_number}}</td>
            <td class="text-left">{{$contactor->address}}</td>
            <td class="text-left">{{$contactor->type}}</td>
            {{-- <td class="text-left" >{{$contactor->details}}</td> --}}
            <td>
              <form action="{{ route('contactor.destroy', $contactor->id)}}" method="post">
                @csrf
                @method('DELETE')
                <a class="edit-service-type-modal btn btn-warning btn-xs"
                  href="{{route ('contactor.edit',$contactor->id)}}" title="Edit"><i class="fa fa-edit"></i>
                </a>

                <button class="delete-service-type-modal btn btn-danger btn-xs" id="delete" title="Delete"><i
                    class="fa fa-trash"></i>
                </button>
              </form>
            </td>
          </tr>
          @endforeach


        </tbody>
      </table>
      <div class="text-center">{{ $contactors->links() }}</div>
    </div>
  </section>

</div>
</div>
@endsection

@push('script')
<script>
  $("#delete").on("click", function(){

        return confirm("Do you want to delete this Contactor?");
    });
</script>
@endpush