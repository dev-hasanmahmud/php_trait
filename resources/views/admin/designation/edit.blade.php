@extends('layouts.master')
@section('content')
 
    <div class="main-content mt-4 ">
    <div class="container">
    <div class="programme-title">
        <h3 class="d-inline">
            <img src="{{custom_asset('assets/images/programme.png')}}" alt="" />Edit Designation
        </h3>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('designation.index') }}">Index Page</a>
        </div>
    </div>
     <br>
    <form  action="{{ route('designation.update',$designation->id) }}" method="post">
        @csrf
        @method('PUT')
        <div class="form-row">
          <div class="col-md-6 mb-3">
            <label for="name_en"> Designation Name (English)</label>
          <input type="text" name="name_en" class="form-control" value="{{ $designation->name_en }}"  required />
          </div>
           <div class="col-md-6 mb-3">
            <label for="name_en"> Designation Name (Bangla)</label>
            <input type="text" name="name_bn" class="form-control" value="{{ $designation->name_bn }}" required />
          </div>
          
        <button class="btn btn-primary" type="submit">Update</button>
      </form>
     </div>

    </div>
  </div>
@endsection

