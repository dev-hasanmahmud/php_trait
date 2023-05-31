@extends('layouts.master')
@section('content')
<div class="sub-head header header2">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
        <div class="procurement-title">
          <h5 class="d-inline">
            <i class="fa fa-window-restore" aria-hidden="true"></i>Edit Indicator Category
          </h5>                
        </div>
      </div>

    </div>
  </div>
</div>
  
    <div class="main-content mt-4 ">
    <div class="container">
      @include('sweetalert::alert')
    {{-- <div class="programme-title">
        <h3 class="d-inline">
            <img src="{{custom_asset('assets/images/programme.png')}}" alt="" />Edit  Indicator Category
        </h3>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('indicator_category.index') }}">Index Page</a>
        </div>
    </div>
     <br> --}}
    <form  action="{{ route('indicator_category.update',$Indicator_category->id) }}" method="post">
        @csrf
        @method('PUT')
        <div class="form-row">
          <div class="col-md-6 mb-3">
            <label for="name_en">Indicator Category Name (English) <span class="mendatory">*</span></label>
            <input type="text" name="name_en" class="form-control" value="{{ $Indicator_category->name_en }}"  required />
          </div>
          <div class="col-md-6 mb-3">
            <label for="name_en">Indicator Category Name (Bangla)</label>
            <input type="text" name="name_bn"  class="form-control" value="{{ $Indicator_category->name_en }}"  />
          </div>

          <div class="col-md-6 mb-3">
            <label for="name_en">Description</label>
            <textarea  id="" cols="30" rows="5" name="description" class="form-control">
              {{ $Indicator_category->description }}
            </textarea>
            {{-- <input type="text" name="description" class="form-control"  required /> --}}
          </div>
          
          <div class="col-md-6 mb-3">
          </div>
          
        <button class="btn btn-primary" type="submit">Update</button>
        </div>
      </form>
     

    </div>
  </div>
@endsection

