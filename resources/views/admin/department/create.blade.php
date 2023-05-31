@extends('layouts.master')
@section('content')
 
    
    <div class="main-content mt-4 ">
    <div class="container">
      @include('sweetalert::alert')
    <div class="programme-title">
        <h3 class="d-inline">
            <img src="{{custom_asset('assets/images/programme.png')}}" alt="" />Create Department
        </h3> 
        <div class="pull-right">
            <a class="btn btn-info" href="{{ route('department.index') }}">All Departments</a>
        </div>
    </div>
     <br>
    <form action="{{ route('department.store') }}"  method="post">
        @csrf
        <div class="form-row">
          <div class="col-md-6 mb-3">
            <label for="name">Name
              <span class="mendatory">*</span>
            </label>
               <input type="text" name="name" class="form-control"  required />
          </div>

          <div class="col-md-6 mb-3">
            <label for="component_Id">Address
              
            </label>
               <input type="text" name="address" class="form-control"  />
          </div>

          <div class="col-md-6 mb-3">
            <label for="progress_value"> Contact number 
              
            </label>
            <input type="text" name="contact_no" class="form-control"  />
          </div>

          <div class="col-md-6 mb-3">
            <label for="progress_value">Choose a Type 
              <span class="mendatory">*</span>
            </label>
            <select name="is_department" class="form-control form-control-sm select2 custom-select2" >
                 
                    <option>.............</option>
                    <option value="0">Organization</option>
                    <option value="1">Department</option>
                 
              </select>
          </div>

          <button class="btn btn-success" type="submit">Create</button>

        </div>
    </form>
    </div>
  </div>
@endsection

