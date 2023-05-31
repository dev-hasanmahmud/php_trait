@extends('layouts.master')
@section('content')


<div class="main-content mt-4 ">
  <div class="container">
    <div class="programme-title">
      <h3 class="d-inline">
        <img src="{{custom_asset('assets/images/programme.png')}}" alt="" />Edit Activity Indicator
      </h3>
      <div class="pull-right">
        <a class="btn btn-info" href="{{ route('activityindicator.index') }}">All Activity Indicators</a>
      </div>
    </div>
    <br>
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
    <form action="{{ route('activityindicator.update',$data_input_title->id) }}" method="post">
      @csrf
      @method('PUT')
      <div class="form-row">

        <div class="col-md-6 mb-3">
          <label for="name_en"> Name (English)
            <span class="mendatory">*</span>
          </label>
          <input type="text" name="name_en" class="form-control" value="{{ $data_input_title->title }}" required />
        </div>

        {{-- <div class="col-md-6 mb-3">
            <label for="name_en"> Name (Bangla)</label>
            <input type="text" name="name_bn" class="form-control" value="{{ $activity_indicator->name_bn }}" />
      </div>

      <div class="col-md-6 mb-3">
        <label for="name_en">Activity Category
          <span class="mendatory">*</span>
        </label> --}}
        {{-- <select name="activity_category_id" class="custom-select"  required>
                @foreach ($activity_categories as $activity_category)
                    <option value="{{ $activity_category->id }}"
        @if ($activity_category->id==$activity_indicator->activity_category_id)
        {{'selected= "selected"'}}
        @endif
        >{{ $activity_category->name_en }}</option>
        @endforeach
        </select> --}}

        {{-- <select name="activity_category_id" id="component" class="form-control form-control-sm select2 custom-select2" required="">
              <optgroup>
                  @foreach ($activity_categories as $item)
                    <option value="{{ $item->id }}"
        @if ($item->id==$activity_indicator->activity_category_id)
        {{'selected= "selected" '}}
        @endif
        >{{ $item->name_en }}
        </option>
        @endforeach
        </optgroup>
        </select> --}}
      </div>

      <div class="col-md-6 mb-3">
        <label for="component">Component
          <span class="mendatory">*</span>
        </label>
        <select name="component_id" id="component" class="form-control form-control-sm select2 custom-select2"
          required="">
          <optgroup>
            @foreach ($components as $item)
            <option value="{{ $item->id }}" @if ($item->id==$data_input_title->component_id)
              {{'selected= "selected" '}}
              @endif
              >{{ $item->name_en }}
            </option>
            @endforeach
          </optgroup>
        </select>
      </div>

      <button class="btn btn-success" type="submit">Update</button>
  </div>
  </form>


</div>
</div>
@endsection