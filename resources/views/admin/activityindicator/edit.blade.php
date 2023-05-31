@extends('layouts.master')
@section('content')
<div class="sub-head header header2">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
                <div class="procurement-title">
                    <h5 class="d-inline">
                        <i class="fa fa-window-restore" aria-hidden="true"></i> Add App Activity
                    </h5>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                <a class="active btn sub-btn float-right" href="{{ route('activityindicator.create') }}"><i
                        class="fa fa-plus"> </i> Add App Activity </a>

            </div>
        </div>
    </div>
</div>

<div class="main-content form-component mt-4 ">
    <div class="container">
        <div class="card mb-4 card-design">
            <div class="card-body">
                <div class="card-title bg-primary text-white">
                    <h5>Add App Activity</h5>
                </div>
                {{-- <div class="programme-title">
                        <h3 class="d-inline">
                            <img src="{{ custom_asset('assets/images/programme.png') }}" alt="" />Add Activity
                Indicator
                </h3>
                <div class="pull-right">
                    <a class="btn btn-info" href="{{ route('activityindicator.index') }}">All Activity
                        Indicators</a>
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
            <form action="{{ route('activityindicator.update',$data_input_title->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="form-row">

                    <div class="col-md-6 mb-3">
                        <label for="name_en"> Name (English)
                            <span class="mendatory">*</span>
                        </label>
                        <input type="text" name="title" class="form-control" value="{{ $data_input_title->title }}"
                            required />
                    </div>

                    {{-- <div class="col-md-6 mb-3">
                                <label for="name_bn"> Name (Bangla)</label>
                                <input type="text" name="name_bn" class="form-control" />
                            </div> --}}
                    {{-- <div class="col-md-6 mb-3">
                                <label for="name_en">Activity Category
                                    <span class="mendatory">*</span>
                                </label>
                                <select name="activity_category_id" class="custom-select" required>
                                    @foreach ($activity_categories as $activity_category)
                                        <option value="{{ $activity_category->id }}">{{ $activity_category->name_en }}
                    </option>
                    @endforeach
                    </select>

                    <select name="activity_category_id" class="form-control form-control-sm select2 custom-select2"
                        required="">
                        <optgroup>
                            @foreach ($activity_categories as $item)
                            <option value="{{ $item->id }}">{{ $item->package_no . ' - ' . $item->name_en }}
                            </option>
                            @endforeach
                        </optgroup>
                    </select>

                </div> --}}
                <div class="col-md-6 mb-3">
                    <label for="component">Component
                        <span class="mendatory">*</span>
                    </label>
                    <select name="component_id" id="component"
                        class="form-control form-control-sm select2 custom-select2" required="">
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

                <div class="text-right col-md-12 mb-3">
                    <button type="button" class="btn-lg btn btn-warning">Cancel</button>
                    <button class="btn-lg btn btn-primary" type="submit">Update</button>
                </div>

        </div>
        </form>

    </div>
</div>
</div>
</div>
@endsection