@extends('layouts.master')
@section('content')
 
    <div class="main-content mt-4 ">
    <div class="container">
    <div class="programme-title">
        <h3 class="d-inline">
            <img src="{{custom_asset('assets/images/programme.png')}}" alt="" />Add Designation
        </h3>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('designation.index') }}">Index Page</a>
        </div>
    </div>
     <br>
    <form action="{{ route('designation.store') }}"  method="post">
        @csrf
        <div class="form-row">
          <div class="col-md-6 mb-3">
            <label for="name_en">Designation Name (English)</label>
            <input type="text" name="name_en" class="form-control"  required />
          </div>
           <div class="col-md-6 mb-3">
            <label for="name_en"> Designation Name (Bangla)</label>
            <input type="text" name="name_bn" class="form-control"  required />
          </div>
          
        <button class="btn btn-primary" type="submit">Add</button>
      </form>
     </div>

    </div>
  </div>
@endsection

