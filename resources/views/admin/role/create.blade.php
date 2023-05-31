@extends('layouts.master')
@section('content')
 <div class="sub-head header header2">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
        <div class="procurement-title">
          <h5 class="d-inline">
            <i class="fa fa-users" aria-hidden="true"></i> Add Role
          </h5>                
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        <a class="active btn sub-btn float-right" href="{{ route('role.create') }}" ><i class="fa fa-plus"> </i> Add  Role </a>
		<a class="btn sub-btn float-right" href="{{ route('role.index') }}" ><i class="fa fa-users"> </i> All Roles </a>
      </div>
    </div>
  </div>
</div>
<div class="main-content form-component mt-4 ">
  <div class="container">
	<div class="card mb-4 card-design">
      <div class="card-body">
			<div class="card-title bg-primary text-white"><h5>Add Role</h5></div>
			  @if ($errors->any())
			  <div class=”alert alert-danger”>
			  <ul>
			  @foreach ($errors->all() as $error)
			  <div class="alert alert-danger alert-block">
					<button type="button" class="close" data-dismiss="alert">×</button>	
						<strong>{{ $error }}</strong>
			  </div>
			  @endforeach
			  </ul>
			  </div>
			  @endif
			<form action="{{ route('role.store') }}"  method="post" >
				@csrf
				<div class="form-row">
				  <div class="col-md-6 mb-3">
					<label for="name_en">Identifier Name</label>
					<input type="text" name="name" class="form-control"  required />
				  </div>
				   <div class="col-md-6 mb-3">
					<label for="name_en">Display Name</label>
					<input type="text" name="display_name" class="form-control"  required />
				  </div>
				   <div class="col-md-6 mb-3">
					<label for="name_en"> Description</label>
					<input type="text" name="description" class="form-control"  required />
				  </div>
				  <div class="col-md-6 mb-3">
					
				  </div>
						<div class="text-right col-md-12 mb-3">
						<a type="button" class="btn-lg btn btn-warning" href="{{ route('role.index') }}">Cancel</a>
						<button class="btn-lg btn btn-primary" type="submit">Add</button>
					  </div>
				 </div>
			  </form>
	  
     </div>
	</div>
    </div>
  </div>
@endsection

