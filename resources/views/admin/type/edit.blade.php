@extends('layouts.master')
@section('content')
 
<div class="sub-head header header2">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
        <div class="procurement-title">
          <h5 class="d-inline">
            <i class="fa fa-file-text" aria-hidden="true"></i> Edit Type
          </h5>                
        </div>
      </div>
      
    </div>
  </div>
</div> 
    
    <div class="main-content mt-4 ">
    <div class="container">
    {{-- <div class="programme-title">
        <h3 class="d-inline">
            <img src="{{custom_asset('assets/images/programme.png')}}" alt="" />Edit  Type
        </h3>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('type.index') }}">Index Page</a>
        </div>
    </div>
     <br> --}}
    <form  action="{{ route('type.update',$type->id) }}" method="post">
        @csrf
        @method('PUT')
        <div class="form-row">
          <div class="col-md-6 mb-3">
            <label for="name_en">Type Name (English)</label>
          <input type="text" name="name_en" class="form-control" value="{{ $type->name_en }}"  required />
          </div>
           <div class="col-md-6 mb-3">
            <label for="name_en">Type Name (Bangla)</label>
            <input type="text" name="name_bn" class="form-control" value="{{ $type->name_bn }}" required />
          </div>
          
        <button class="btn btn-primary" type="submit">Update</button>
      </form>
     </div>

    </div>
  </div>
@endsection

