@extends('layouts.master')
@section('content')
<div class="sub-head header header2">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
        <div class="procurement-title">
          <h5 class="d-inline">
            <i class="fa fa-window-restore" aria-hidden="true"></i> Financial Item
          </h5>                
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        <a class=" btn sub-btn float-right" href="{{ route('financialitem.create') }}" ><i class="fa fa-plus"> </i> Add Record </a>
        <a class=" btn sub-btn float-right" href="{{ route('report') }}" ><i class="fa fa-eye"> </i> Show Report </a>
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
                <td width="5%" class="text-left"></td>
                <td width="18%">Economic Code</td>
                <td width="18%">Item Name</td>
                <td width="18%">Quantity</td>
                <td width="18%">PA Budget</td>
                <td width="8%">GOB Budget</td>
                <td width="15%">Action</td>
              </tr>
            </thead>
            <tbody>
                @foreach ($financial_items as $item)
                <tr>
                  <td class="text-center" >{{ $loop->index+$financial_items->firstItem() }}</td>
                    <td>{{$item->economic_code}}</td>
                    <td>{{$item->item_name}}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->pa_budget }}</td>
                    <td>{{ $item->gob_budget }}</td>
                    <td>
                      <form class="delete" action="{{ route('financialitem.destroy', $item->id)}}" method="post">
                       <input type="hidden" name="_method" value="DELETE">
                       <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <a class="btn btn-info btn-sm  fa fa-edit "  href="{{route ('financialitem.edit',$item->id)}}" title="Edit"></a>
                         <button item="submit" class="btn btn-danger btn-sm  fa fa-trash" title="Delete"></button>
                      </form>
                    </td>
                </tr>
                @endforeach


            </tbody>
          </table>
        <div class="mt-4 text-center">{{ $financial_items->links() }}</div>
        </div>
      </section>

    </div>
  </div>
@endsection

@push('script')
<script>
    $(".delete").on("submit", function(){
        return confirm("Do you want to delete this Item?");
    });
</script>
@endpush
