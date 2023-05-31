@extends('layouts.master')
@section('content')
<div class="sub-head header header2">
      <div class="container">
        <div class="row">
			<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
				<div class="procurement-title">
                <h5 class="d-inline">
                    <img src="{{ custom_asset('assets/images/icons/training1.png') }}" alt="" /> Finance Status
                </h5>
            </div>
            </div>
            {{-- <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                <a class=" btn sub-btn float-right" href="{{ route('financialitem.create') }}" ><i class="fa fa-plus"> </i> Add Record </a>
                <a class=" btn sub-btn float-right" href="{{ route('report') }}" ><i class="fa fa-eye"> </i> Show Report </a>
            </div> --}}
			<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
				<a class="btn sub-btn float-right" href="{{ url('financial-report-upload') }}"  ><i class="fa fa-cloud"></i> Finance Report Upload</a>
                <a class="btn sub-btn float-right" href="{{ url('financial-file-manager') }}"  ><i class="fa fa-file"></i> Reports Archive</a>
                <a class="btn sub-btn float-right" href="{{route('dashboard')}}"> <i class="fa fa-dashboard"></i> Financial Dashboard</a>
			</div>
		</div>
	  </div>
</div>
<div class="main-content form-component mt-4 ">
      <div class="container">
           @include('sweetalert::alert')
        <div class="table-responsive text-center mb-2" id="show_file">
           <table class="table table-bordered bg-white report-table" >
            <thead>
                <tr>
                    <td width="5%" class="text-left"></td>
                    <td width="15%">Category</td>
                    <td width="15%">Date</td>
                    <td width="20%">Report Name</td>
                    <td width="10%">Action</td>
                </tr>
        </thead>       
        <tbody>
            @foreach ($files as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->date }}</td>
                    <td>{{ $item->name }}</td>
                   <td>   
                        <form class="delete" action="{{ route('report.delete',$item->id) }}" method="POST">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <a class="btn btn-info btn-sm  fa fa-edit " href="{{ route('report.edit',$item->id) }}" title="Edit"></a>
                            <button item="submit" class="btn btn-danger btn-sm  fa fa-trash" title="Delete"></button>
                        </form>
                    </td>
            
                </tr>
            @endforeach
            
        </tbody>
        
        </table>
             <div class="mt-4 text-center">{{ $files->links() }}</div>
        </div>
        
      </div>
    </div>
@endsection


@push('script')
<script>
    $(".delete").on("submit", function(){
        return confirm("Do you want to delete this Report?");
    });
</script>
@endpush