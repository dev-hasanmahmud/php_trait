@extends('layouts.master')
@section('content')
<div class="sub-head header header2">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
        <div class="procurement-title">
          <h5 class="d-inline">
            <i class="fa fa-window-restore" aria-hidden="true"></i> Add Activity Category
          </h5>                
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        <a class="active btn sub-btn float-right" href="{{ route('activitycategory.create') }}" ><i class="fa fa-plus"> </i> Add  Activity Category </a>
        
      </div>
    </div>
  </div>
</div>

<div class="main-content form-component mt-4 ">
      <div class="container">
	  		<div class="card mb-4 card-design">
          <div class="card-body">
            <div class="card-title bg-primary text-white">
              <h5>Add  Activity Category</h5>
            </div>
      @include('sweetalert::alert')
    {{--<div class="programme-title">
         <h3 class="d-inline">
            <img src="{{custom_asset('assets/images/programme.png')}}" alt="" />Add  Activity Category
        </h3>
        <div class="pull-right">
            <a class="btn btn-info" href="{{ route('activitycategory.index') }}">All Activity Category</a>
        </div>
    </div>
     <br> --}}
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
    <form action="{{ route('activitycategory.store') }}"  method="post">
        @csrf
        <div class="form-row">
          <div class="col-md-6 mb-3">
            <label for="name_en"> Name (English)
              <span class="mendatory">*</span>
            </label>
            <input type="text" name="name_en" class="form-control"  required/>
          </div>

          <div class="col-md-6 mb-3">
            <label for="name_en"> Name (Bangla)</label>
            <input type="text" name="name_bn" class="form-control" />
          </div>

          <div class="col-md-6 mb-3">
            <label for="name_en">Details</label>
            <input type="text" name="details" class="form-control" />
          </div>

          <div class="col-md-6 mb-3">
            <label for="component">Component 
              <span class="mendatory">*</span>
            </label>
            <select name="component_id" id="component" class="form-control form-control-sm select2 custom-select2" required="">
              <optgroup>
                @foreach ($components as $component)
                    <option value="{{ $component->id }}">{{ $component->name_en }}</option>
                @endforeach
              </optgroup>
            </select>

          </div>
          
          <div class="text-right col-md-12 mb-3">
            <a class="btn-lg btn btn-warning" href="{{ route('activitycategory.index') }}">Cancel</a>
           {{-- <button type="button" class="btn-lg btn btn-warning">Cancel</button> --}}
           <button class="btn-lg btn btn-primary" type="submit">Save</button>
          </div>
      
	      </div>
	    </form>
    </div>
  </div>
</div>
</div>
@endsection

