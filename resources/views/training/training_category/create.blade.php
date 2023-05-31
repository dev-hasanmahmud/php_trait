@extends('layouts.master')
@section('content')
<div class="sub-head header header2">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
        <div class="procurement-title">
                <h5 class="d-inline">
                    <img src="{{ custom_asset('assets/images/icons/training1.png') }}" alt="" /> Create Training Category
                </h5>                
            </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        <a class=" active btn sub-btn float-right" href="{{ route('training-category.create') }}"> <i class="fa fa-plus"> </i> Add Training Categoty</a>
        <a class=" btn sub-btn float-right" href="{{ url('training-category') }}">Training Category</a>
        
        
      </div>
    </div>
  </div>
</div>
<div class="main-content form-component mt-4 ">
      <div class="container">
	  		<div class="card mb-4 card-design">
          <div class="card-body">
            <div class="card-title bg-primary text-white">
              <h5>Add  Training Category</h5>
            </div>
    {{-- <div class="programme-title">
        <h3 class="d-inline">
            <img src="{{custom_asset('assets/images/programme.png')}}" alt="" />Add  Training Category
        </h3>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('training-category.index') }}">All Training Category</a>
        </div>
    </div>
     <br> --}}
    <form action="{{ route('training-category.store') }}"  method="post">
        @csrf
        <div class="form-row">
          <div class="col-md-12 mb-3">
            <label for="serial">Serial No:</label>
            <input type="text" name="serial_no" class="form-control"  required />
          </div>
          <div class="col-md-12 mb-3">

          </div>
           <div class="col-md-12 mb-3">
            <label for="name_en">Name</label>
            <input type="text" name="name" class="form-control"  required />
           </div>
           <div class="col-md-12 mb-3">

          </div>
          <div class="col-md-12 mb-3">
            <label for="parent_id">Parent Category (Optional)</label>
             {!! Form::select('parent_id', \App\TrainingCategory::pluck('name', 'id'),
              old('id'),['placeholder'=>'Select A Training Category','class' => 'form-control select2
             full-wparent_idth','data-init-plugin'=>'select2', 'id' => 'id'])!!}

           <div class="col-md-12 mb-3">

          </div>
               
	  </div>
	  <div class="text-right col-md-12 mb-3">
			<button type="button" class="btn-lg btn btn-warning">Cancel</button>
			<button class="btn-lg btn btn-primary" type="submit">Save</button>
          </div>
	  </form>
     
    </div>
  </div>
    </div>
  </div>
@endsection

