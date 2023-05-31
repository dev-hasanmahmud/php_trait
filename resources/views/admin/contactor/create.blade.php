@extends('layouts.master')
@section('content')
<div class="sub-head header header2">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
        <div class="procurement-title">
          <h5 class="d-inline">
            <i class="fa fa-user" aria-hidden="true"></i> Add {{ $typeName }}
          </h5>                
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        {{-- <a class="active btn sub-btn float-right" href="{{ route('contactor.create') }}" ><i class="fa fa-plus"> </i> Add  Contractor </a> --}}
        
      </div>
    </div>
  </div>
</div>
<div class="main-content form-component mt-4 ">
      <div class="container">
	  		<div class="card mb-4 card-design">
          <div class="card-body">
            <div class="card-title bg-primary text-white">
              <h5>Add {{ $typeName }}</h5>
            </div>
      @include('sweetalert::alert')
    {{-- <div class="programme-title">
        <h3 class="d-inline">
            <img src="{{custom_asset('assets/images/programme.png')}}" alt="" />Add Contactor
        </h3>
        <div class="pull-right">
            <a class="btn btn-info" href="{{ route('contactor.index') }}">All Contactors</a>
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
    <form action="{{ route('contactor.store') }}"  method="post">
        @csrf
        <div class="form-row">
          <div class="col-md-6 mb-3">
            <label for="name_en">Name (English)
              <span class="mendatory">*</span>
            </label>
            <input type="text" name="name_en" class="form-control" id="name_en" required />
          </div>
          
          {{-- <div class="col-md-6 mb-3">
            <label for="name_en"> Name (Bangla)</label>
            <input type="text" name="name_bn" class="form-control"   />
          </div> --}}
          <div class="col-md-6 mb-3">
            <label for="name_en">Contact Number</label>
            <input type="text" name="contact_number" class="form-control"  required />
          </div>
          <div class="col-md-6 mb-3">
            <label for="name_en">Address</label>
            <input type="text" name="address" class="form-control" />
          </div>

          <div class="col-md-6 mb-3">
            {{-- <label for="type">Type</label>
            <select name="" id="type" class="form-control form-control-sm select2 custom-select2" required="">
              <optgroup>
                <option value="1">Contractor </option>
                <option value="2">Consultant </option>
                <option value="3">Consulting Firm </option>
                <option value="4">Supplier</option>
              </optgroup>
            </select> --}}

            <input type="text"  name="type" value="{{ $type }}" hidden="">

          </div>

          {{-- <div class="col-md-6 mb-3">
            <label for="name_en">Details</label>
            <textarea  id="" cols="30" rows="5" name="details" class="form-control"></textarea>
          </div> --}}
          
       
          <div class="text-right col-md-12 mb-3">
            <a type="button" class="btn-lg btn btn-warning" href="{{ route('contactor.index') }}">Cancel</a>
            <button class="btn-lg btn btn-primary" type="submit">Save</button>
          </div>
		  
        </div>
    </form>
    </div>
  </div>
      </div>
  </div>
@endsection

