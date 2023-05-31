@extends('layouts.master')
@section('content')
 
    <div class="main-content mt-4 ">
    <div class="container">
      @include('sweetalert::alert')
    <div class="programme-title">
        <h3 class="d-inline">
            <img src="{{custom_asset('assets/images/programme.png')}}" alt="" />Edit Department
        </h3>
        <div class="pull-right">
            <a class="btn btn-info" href="{{ route('department.index') }}">All Departments</a>
        </div>
    </div>
     <br>
    <form  action="{{ route('department.update',$department->id) }}" method="post">
        @csrf
        @method('PUT')
       <div class="form-row">
          <div class="col-md-6 mb-3">
            <label for="name">Name
              <span class="mendatory">*</span>
            </label>
          <input type="text" name="name" class="form-control" value="{{ $department->name }}" required />
          </div>

          <div class="col-md-6 mb-3">
            <label for="component_Id">Address
              
            </label>
               <input type="text" name="address" class="form-control" value="{{ $department->address }}" />
          </div>

          <div class="col-md-6 mb-3">
            <label for="progress_value"> Contact number 
              
            </label>
            <input type="text" name="contact_no" class="form-control"  value="{{ $department->contact_no }}" />
          </div>

          <div class="col-md-6 mb-3">
            <label for="progress_value">Choose a Type 
              <span class="mendatory">*</span>
            </label>
             {!! Form::select('is_department' , ['1' => 'Department','0' => 'Organization' ], old('is_department',$department->is_department), ['class' => 'form-control', 'id' => 'is_department', 'required' => 'required']) !!}
          </div>

          <button class="btn btn-success" type="submit">Create</button>
          
        </div>
      </form>
     

    </div>
  </div>
@endsection

