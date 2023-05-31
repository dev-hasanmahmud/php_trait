@extends('layouts.master')
@section('content')

<div class="sub-head header header2">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
        <div class="procurement-title">
          <h5 class="d-inline">
            <i class="fa fa-file-text" aria-hidden="true"></i> Add Type
          </h5>                
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        <a class="active btn sub-btn float-right" href="{{ route('type.create') }}" ><i class="fa fa-plus"> </i> Add Type</a>
      </div>
    </div>
  </div>
</div> 

    <div class="main-content mt-4 ">
    <div class="container">
    {{-- <div class="programme-title">
        <h3 class="d-inline">
            <img src="{{custom_asset('assets/images/programme.png')}}" alt="" />Add  Type
        </h3>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('type.index') }}">Index Page</a>
        </div>
    </div> --}}
     
    <form action="{{ route('type.store') }}"  method="post">
        @csrf
        <div class="form-row">
          <div class="col-md-6 mb-3">
            <label for="name_en">Type Name (English)</label>
            <input type="text" name="name_en" class="form-control"  required />
          </div>
           <div class="col-md-6 mb-3">
            <label for="name_en">Type Name (Bangla)</label>
            <input type="text" name="name_bn" class="form-control"  required />
          </div>
          
        <button class="btn btn-primary" type="submit">Create</button>
      </form>
     </div>

    </div>
  </div>
@endsection

