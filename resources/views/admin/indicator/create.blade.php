@extends('layouts.master')


@section('content')
<div class="sub-head header header2">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
        <div class="procurement-title">
          <h5 class="d-inline">
            <i class="fa fa-window-restore" aria-hidden="true"></i> Add Indicator 
          </h5>                
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        <a class="active btn sub-btn float-right" href="{{ route('indicator.create') }}" ><i class="fa fa-plus"> </i> Add Indicator </a>
        <a class="btn sub-btn float-right" href="{{ route('indicator.index') }}" > All Indicator </a>
      </div>
    </div>
  </div>
</div>

<div class="main-content form-component mt-4 ">
      <div class="container">
		<div class="card mb-4 card-design">
          <div class="card-body">
            <div class="card-title bg-primary text-white">
              <h5>Create  Indicator</h5>
            </div>
      @include('sweetalert::alert')
    {{-- <div class="programme-title">
        <h3 class="d-inline">
            <img src="{{custom_asset('assets/images/programme.png')}}" alt="" /> Create  Indicator
            List
        </h3>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('indicator.index') }}">Index Page</a>
        </div>
    </div>
     <br> --}}
    <form action="{{ route('indicator.store') }}"  method="post">
        @csrf
        <div class="form-row">
          <div class="col-md-6 mb-3">
            <label for="name_en">Indicator Name (English) <span class="mendatory">*</span> </label>
            <input type="text" name="name_en" class="form-control" id="name_en"value="{{ old('name_en') }}"  required />
          </div>

          <div class="col-md-6 mb-3">
            <label for="name_en">Indicator Name (Bangla)</label>
            <input type="text" name="name_bn" class="form-control"   />
          </div>

          <div class="col-md-6 mb-3">
            <label for="indicator_category_Id">Indicator Category <span class="mendatory">*</span></label>
              <select name="indicator_category_id" class="form-control form-control-sm select2 custom-select2">
                <optgroup>
                  @foreach ($indicator_category as $item)
                    <option value="{{ $item->id }}">{{ $item->name_en }}</option>
                  @endforeach
                </optgroup>
              </select>
          </div>
          <div class="col-md-6 mb-3">
            <label for="component_Id">Package <span class="mendatory">*</span> </label>
              <select name="component_id" class="form-control form-control-sm select2 custom-select2">
                <optgroup>
                  @foreach ($component as $item)
                    <option value="{{ $item->id }}">{{ $item->package_no.' - '.$item->name_en }}</option>
                  @endforeach
                </optgroup>
              </select>
          </div>

          <div class="col-md-6 mb-3">
            <label for="name_en">Target Quantity <span class="mendatory">*</span> </label>
            <input type="text" name="target" class="form-control"  required="" />
          </div>

          <div class="col-md-6 mb-3">
            <label for="name_en">Ave Weightage</label>
            <input type="text" name="ave_weightage" class="form-control"  />
          </div>
          <div class="text-right col-md-12 mb-3">
            <a type="button" class="btn-lg btn btn-warning" href="{{ route('indicator.index') }}">Cancel</a>
            <button class="btn-lg btn btn-primary" type="submit">Save</button>
          </div>
          

        </div>
    </form>
	
	</div>
  </div>
    </div>
  </div>
@endsection

