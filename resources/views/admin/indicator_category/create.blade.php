@extends('layouts.master')
@section('content')
<div class="sub-head header header2">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
        <div class="procurement-title">
          <h5 class="d-inline">
            <i class="fa fa-window-restore" aria-hidden="true"></i> Add Indicator Category
          </h5>                
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        <a class="active btn sub-btn float-right" href="{{ route('indicator_category.create') }}" ><i class="fa fa-plus"> </i> Add  Indicator Category </a>
        
      </div>
    </div>
  </div>
</div>

<div class="main-content form-component mt-4 ">
      <div class="container">
	  		<div class="card mb-4 card-design">
          <div class="card-body">
            <div class="card-title bg-primary text-white">
              <h5>Create  Indicator Category</h5>
            </div>
      @include('sweetalert::alert')
    {{-- <div class="programme-title">
        <h3 class="d-inline">
            <img src="{{custom_asset('assets/images/programme.png')}}" alt="" />Create Indicator Category
        </h3>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('indicator_category.index') }}">Index Page</a>
        </div>
    </div>
     <br> --}}
    <form action="{{ route('indicator_category.store') }}"  method="post">
        @csrf
        <div class="form-row">
          <div class="col-md-6 mb-3">
            <label for="name_en">Indicator Category Name (English) <span class="mendatory">*</span> </label>
            <input type="text" name="name_en" class="form-control" id="name_en"value="{{ old('name_en') }}"  required />
          </div>
          
          <div class="col-md-6 mb-3">
            <label for="name_en">Indicator Category Name (Bangla)</label>
            <input type="text" name="name_bn" class="form-control"   />
          </div>

          <div class="col-md-6 mb-3">
            <label for="name_en">Description</label>
            <textarea  id="" cols="30" rows="5" name="description" class="form-control"></textarea>
            {{-- <input type="text" name="description" class="form-control"  required /> --}}
          </div>
          
          <div class="col-md-6 mb-3">
            
          </div>
          <div class="text-right col-md-12 mb-3">
			<a href="{{ route('indicator_category.index') }}" class="btn-lg btn btn-warning">Cancel</a>
			<button class="btn-lg btn btn-primary" type="submit">Save</button>
          </div>
      
        </div>
    </form>
    </div>
  </div>
      </div>
  </div>
@endsection

