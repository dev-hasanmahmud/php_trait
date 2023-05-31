@extends('layouts.master')
@section('content')

<div class="sub-head header header2">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
        <div class="procurement-title">
                <h5 class="d-inline">
                    <img src="{{ custom_asset('assets/images/icons/training1.png') }}" alt="" /> Training Category List
                </h5>                
            </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        <a class="  btn sub-btn float-right" href="{{ route('training-category.create') }}"> <i class="fa fa-plus"> </i> Add Training Categoty</a>
        <a class="active btn sub-btn float-right" href="{{ url('training-category') }}">Training Category</a>
        
        
      </div>
    </div>
  </div>
</div>  

<div class="main-content mt-4 ">
    <div class="container">
   @include('sweetalert::alert')
    {{-- <div class="programme-title">
            <h3 class="d-inline">
              <img src="{{custom_asset('assets/images/programme.png')}}" alt="" /> Training Category
            </h3>
       
        <a href="{{ route('training-category.create') }}" type="submit" class="btn btn-success btn-sm d-inline fa fa-plus" title="Add Training Category"></a>

     </div> --}}

  <section class="package-table card card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <td width="5%" class="text-left"></td>
                <td width="5%" >Serial No:</td>
                <td width="62%" >Name</td>
                <td width="15%" >Parent Category</td>
                <td width="13%">Action</td>
              </tr>
            </thead>
            <tbody>
                @php
                    $i=1;
                @endphp
                @foreach ($training_categories as $item)
                <tr>    
                    <td>{{ $loop->index+$training_categories->firstItem() }}</td>
                    <td>{{$item->serial_no}}</td>
                    <td>{{$item->name}}</td>
                    <td>
                     @if($item->parent_id!=null)
                       @foreach ($training_categories as $r)
                        @if($r->id==$item->parent_id)
                         {{$r->name}}
                        @endif
                      @endforeach
                      @else 
                       <p>This is a Parent Category</p>
                     @endif
                   

                  
                    </td>
                    <td>   
                        <form class="delete" action="{{ route('training-category.destroy',$item->id) }}" method="POST">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <a class="btn btn-info btn-sm  fa fa-edit " href="{{ route('training-category.edit',$item->id) }}" title="Edit"></a>
                            <button item="submit" class="btn btn-danger btn-sm  fa fa-trash" title="Delete"></button>
                        </form>
                    </td>
                </tr>
                @endforeach
              
           
            </tbody>
          </table>
          <div class="mt-4 text-center">{{ $training_categories->links() }}</div>
        </div>
      </section>
  
    </div>
  </div>
@endsection

@push('script')
<script>
    $(".delete").on("submit", function(){
        return confirm("Do you want to delete this Training Category?");
    });
</script>
@endpush