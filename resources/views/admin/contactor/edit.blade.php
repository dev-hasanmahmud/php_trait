@extends('layouts.master')
@section('content')

<div class="sub-head header header2">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
        <div class="procurement-title">
          <h5 class="d-inline">
            <i class="fa fa-user" aria-hidden="true"></i> Edit {{ $contactor->type }}
          </h5>
        </div>
      </div>

    </div>
  </div>
</div>

<div class="main-content form-component mt-4 ">
  <div class="container">
    <div class="card mb-4 card-design">
      <div class="card-body">
        <div class="card-title bg-primary text-white">
          <h5>Edit {{ $contactor->type }}</h5>
        </div>
        @include('sweetalert::alert')
        {{-- <div class="programme-title">
        <h3 class="d-inline">
            <img src="{{custom_asset('assets/images/programme.png')}}" alt="" />Edit Contactor
        </h3>
        <div class="pull-right">
          <a class="btn btn-success" href="{{ route('contactor.index') }}">All Contactors</a>
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
      <form action="{{ route('contactor.update',$contactor->id) }}" method="post">
        @csrf
        @method('PUT')
        <div class="form-row">
          <div class="col-md-6 mb-3">
            <label for="name_en">Name (English)
              <span class="mendatory">*</span>
            </label>
            <input type="text" name="name_en" class="form-control" id="name_en" value="{{ $contactor->name_en }}"
              required />
          </div>

          {{-- <div class="col-md-6 mb-3">
            <label for="name_en"> Name (Bangla)</label>
            <input type="text" name="name_bn" class="form-control" value="{{ $contactor->name_bn }}" />
          </div> --}}
          <div class="col-md-6 mb-3">
            <label for="name_en">Contact Number</label>
            <input type="text" name="contact_number" class="form-control" value="{{ $contactor->contact_number }}"
              required />
          </div>
          <div class="col-md-6 mb-3">
            <label for="name_en">Address</label>
            <input type="text" name="address" class="form-control" value="{{ $contactor->address }}" />
          </div>

          <input type="text" name="type" value="{{ $type }}" hidden="">
          {{-- <div class="col-md-6 mb-3">
            <label for="type">Type</label>
            {!! Form::select('type' , ['1' => 'Contractor','2' => 'Consultant','3'=>'Consulting Firm','4'=>'Supplier' ],
            old('type', $contactor->type), ['class' => 'form-control select2', 'id' => 'status', 'required' =>
            'required']) !!}
          
          </div> --}}
{{-- 
          <div class="col-md-6 mb-3">
            <label for="name_en">Details</label>
            <textarea id="" cols="30" rows="5" name="details" class="form-control">{{ $contactor->details }}
            </textarea>
          
          </div> --}}

          <div class="text-right col-md-12 mb-3">
            <a type="button" class="btn-lg btn btn-warning" href="{{ route('contactor.index') }}">Cancel</a>
            <button class="btn-lg btn btn-primary" type="submit">Update</button>
          </div>


        </div>
      </form>
    </div>
  </div>

</div>
</div>
@endsection