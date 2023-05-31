@extends('layouts.master')
@section('content')
<div class="sub-head header header2">
  <div class="container">
    <div class="row">
  <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
    <div class="procurement-title">
            <h5 class="d-inline">
                <img src="{{ custom_asset('assets/images/icons/training1.png') }}" alt="" /> Create Training 
            </h5>                
        </div>
  </div>
  <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
    <a class="active btn sub-btn float-right" href="{{ route('training.create') }}">  <i class="fa fa-plus"> </i> Add Training</a>
    <a class="  btn sub-btn float-right" href="{{ url('training') }}"  >Training</a>
    
  </div>
</div>
</div>
</div>   
<div class="main-content form-component mt-4 ">
      <div class="container">
        @include('sweetalert::alert')
        <div class="card mb-4 card-design">
          <div class="card-body">
            <div class="card-title bg-primary text-white">
              <h5>Create Training</h5>
            </div>
            <form  method="POST" action="{{route("training.store")}}"  >
              @csrf

              <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Title</label>
                <div class="col-sm-10">
                 <input type="text"name="title" value="{{ old('title') }}" class="form-control"/>
                </div>
              </div>

              <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Training Category</label>
                <div class="col-sm-10">  
                {!! Form::select('training_category_id', \App\TrainingCategory::select(DB::raw('CONCAT(serial_no, " - ", name) AS name, id'))->pluck('name', 'id'), old('area_of_activities'), [  'class' => 'form-control custom-select select2 full-width', 'data-init-plugin'=>'select2', 'id' => '']) !!}
                </div>
              </div>
                
               
  
              <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Serial Number</label>
                <div class="col-sm-10">
                  <input type="text" name="serial_number" value="{{ old('serial_number') }}" required="" class="form-control " id="source_of_fund_name_bn"/>
                </div>
              </div>
  
  
  
              <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Total Number of Events</label>
                <div class="col-sm-10">
                  <input type="text" name="total_event" required="" value="{{ old('total_event')}}" class="form-control"/>
                </div>
              </div>

               

              <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Total Number of Training Batches</label>
                <div class="col-sm-10">
                  <input type="text" name="toatal_batch" required="" value="{{ old('toatal_batch')}}" class="form-control"/>
                </div>
              </div>
  
               
                <div class="pull-right">
                  <a class="btn  btn-warning" href="{{ route('training.index') }}">Cancel</a>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                
              </form>
          </div>
        </div>
      </div>
    </div>
@endsection

