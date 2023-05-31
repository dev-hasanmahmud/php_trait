@extends('layouts.master')
@section('content')
<div class="sub-head header header2">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
        <div class="procurement-title">
          <h5 class="d-inline">
            <i class="fa fa-window-restore" aria-hidden="true"></i> Settings
          </h5>
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        <a class="active btn sub-btn float-right" href="{{ route('indicator.create') }}"><i class="fa fa-plus"> </i> Add
          Record </a>

      </div>
    </div>
  </div>
</div>

<div class="main-content form-component mt-4 ">
  <div class="container">
    <div class="card mb-4 card-design">
      <div class="card-body">
        <div class="card-title bg-primary text-white">
          <h5>Update Record</h5>
        </div>
        @include('sweetalert::alert')
        {{-- <div class="programme-title">
        <h3 class="d-inline">
            <img src="{{custom_asset('assets/images/programme.png')}}" alt="" /> Create Indicator
        List
        </h3>
        <div class="pull-right">
          <a class="btn btn-success" href="{{ route('indicator.index') }}">Index Page</a>
        </div>
      </div>
      <br> --}}
      <form method="POST" action="{{route('settings.update',$record->id)}}">
        @csrf
        @method('PUT')
        <div class="form-group row">
          <label for="staticEmail" class="col-sm-2 col-form-label">Select Procurement Type</label>
          <div class="col-sm-10">
            <select name="type_id" class="form-control form-control-sm select2 custom-select2" id="procurement_type">
              <option value="0"> Select Procurement Type</option>
              @foreach ($procurement_types as $item)
              <option value="{{ $item->id }}" @if ($item->id==$record->type_id)
                {{'selected= "selected" '}}
                @endif>{{ $item->name_en }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="form-group row">
          <label for="staticEmail" class="col-sm-2 col-form-label">Select Procurement Method</label>
          <div class="col-sm-10">
            <select name="procurement_method_id" id="procurement_method_id"
              class="form-control form-control-sm select2 custom-select2">
              <option value="0">Select Procurement Method</option>
              @foreach ($procurement_methods as $item)
              <option value="{{ $item->id }}" @if ($item->id==$record->procurement_method_id)
                {{'selected= "selected" '}}
                @endif>{{ $item->name_en }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="form-group row">
          <label for="inputPassword" class="col-sm-2 col-form-label">Label Name</label>
          <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9" id="file_group">

            <input type="text" name="label_name" value="{{ $record->label_name  }}" class="form-control " />

          </div>
        </div>

        <div class="form-group row">
          <label for="inputPassword" class="col-sm-2 col-form-label">Identifier</label>
          <div class="col-sm-10">
            <input type="text" name="identifier" value="{{ $record->identifier }}" required="" class="form-control " />
          </div>
        </div>

        <div class="form-group row">
          <label for="inputPassword" class="col-sm-2 col-form-label">Ordering Number</label>
          <div class="col-sm-10">
            <input type="text" name="ordering" value="{{ $record->ordering }}" required="" class="form-control " />
          </div>
        </div>


        <div class="form-group row">
          <label for="inputPassword" class="col-sm-2 col-form-label">Type</label>
          <div class="col-sm-10">
            <select name="type" id="type" class="form-control form-control-sm select2 custom-select2">
              <option value="0">Select Type</option>
              <option value="1">Date</option>
              <option value="2">Number</option>
              <option value="3">Text</option>
            </select>
          </div>
        </div>

        <div class="form-group row">
          <label for="inputPassword" class="col-sm-2 col-form-label">Is Mendatory?</label>
          <div class="col-sm-10">
            <input type="radio" name="is_mendatory" value="1">Yes</input>
            <input type="radio" name="is_mendatory" value="0">No</input>
          </div>
        </div>

        <div class="pull-right">
          <a href="{{route('settings.index')}}" class="btn btn-warning btn-lg">Cancel</a>
          <button type="submit" id="submit" class="btn btn-lg btn-primary">Update</button>
        </div>

      </form>

    </div>
  </div>
</div>
</div>
@endsection