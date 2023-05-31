@extends('layouts.master')
@section('content')
 
    
    <div class="main-content mt-4 ">
    <div class="container">
    <div class="programme-title">
        <h3 class="d-inline">
            <img src="{{custom_asset('assets/images/programme.png')}}" alt="" />Edit  Training Category
        </h3>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('training-category.index') }}">All Training Category</a>
        </div>
    </div>
     <br>
    <form  action="{{ route('training-category.update',$training_category->id) }}" method="post">
        @csrf
        @method('PUT')
       <div class="form-row">
          <div class="col-md-6 mb-3">
            <label for="serial">Serial No:</label>
          <input type="text" name="serial_no" class="form-control" value="{{ $training_category->serial_no }}" required />
          </div>
          <div class="col-md-6 mb-3">

          </div>
           <div class="col-md-6 mb-3">
            <label for="name_en">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $training_category->name }}" required />
           </div>
           <div class="col-md-6 mb-3">

          </div>
          <div class="col-md-6 mb-3">
            <label for="parent_id">Parent Category (Optional)</label>
             @if($training_category->parent_id!=null)
             <select name="parent_id" class="form-control form-control-sm select2 custom-select2">
               <optgroup>
                  @foreach ($training_categories as $item)
                    <option value="{{ $item->id }}"
                        @if ($item->id==$training_category->parent_id)
                        {{'selected= "selected" '}}
                        @endif
                        >{{ $item->name }}</option>
                  @endforeach
                </optgroup>
             </select>
             @else
            {!! Form::select('parent_id', \App\TrainingCategory::pluck('name', 'id'),
              old('parent_id'),['placeholder'=>'Select A Training Category','class' => 'form-control select2
              full-wparent_idth','data-init-plugin'=>'select2', 'parent_id' => 'parent_id'])!!}
            @endif
           <div class="col-md-6 mb-3">

          </div>
        <button class="btn btn-primary" type="submit">Update</button>
      </form>
     </div>

    </div>
  </div>
@endsection

