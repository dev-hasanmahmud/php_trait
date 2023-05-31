@extends('layouts.master')
@section('content')

<div class="sub-head header header2">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
        <div class="procurement-title">
          <h5 class="d-inline">
            <i class="fa fa-sitemap" aria-hidden="true"></i> Add Unit
          </h5>                
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        <a class="active btn sub-btn float-right" href="{{ route('unit.create') }}" ><i class="fa fa-plus"> </i> Add Unit</a>
        
      </div>
    </div>
  </div>
</div> 
<div class="main-content form-component mt-4 ">
      <div class="container">
	  		<div class="card mb-4 card-design">
          <div class="card-body">
            <div class="card-title bg-primary text-white">
              <h5>Create Unit</h5>
            </div>
    {{-- <div class="programme-title">
        <h3 class="d-inline">
            <img src="{{custom_asset('assets/images/programme.png')}}" alt="" />Create Unit
        </h3>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('unit.index') }}">Index Page</a>
        </div>
    </div>
     <br> --}}
    <form action="{{ route('unit.store') }}"  method="post">
        @csrf
        <div class="form-row">

          <div class="col-md-6 mb-3">
            <label for="name_en">Unit Name (English) <span class="mendatory">*</span>  </label>
            <input type="text" name="name_en" class="form-control"  required />
          </div>

           <div class="col-md-6 mb-3">
            <label for="name_en">Unit Name (Bangla)</label>
            <input type="text" name="name_bn" class="form-control" />
          </div>

          <div class="col-md-6 mb-3">
            <label for="name_en">Unit Type <span class="mendatory">*</span>  </label>
            {!! Form::select('type_id[]', \App\Type::pluck('name_en', 'id'), old('type'), [ 'multiple' =>
            'multiple', 'class' => 'form-control custom-select select2 full-width', 'data-init-plugin'=>'select2', 'id' => '','required'=>'required']) !!}
          </div>
          
         <div class="text-right col-md-12 mb-3">
            <a type="button" class="btn-lg btn btn-warning" href="{{ route('unit.index') }}">Cancel</a>
            <button class="btn-lg btn btn-primary" type="submit">Save</button>
          </div>
		</div>     
	 </form>
     
    </div>
  </div>
    </div>
  </div>
@endsection

