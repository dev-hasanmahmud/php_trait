@extends('layouts.master')
@section('content')

<div class="main-content form-component mt-4 ">
      <div class="container">
        @include('sweetalert::alert')
        <div class="card mb-4 card-design">
          <div class="card-body">
            <div class="card-title bg-primary text-white">
              <h5>Add Financial Item</h5>
            </div>
            <form  method="POST" action="{{route('financialitem.store')}}" >
              @csrf
              @method('POST')
                
                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Economic Code</label>
                  <div class="col-sm-10">
                     <input type="text" name="economic_code" value="{{ old('economic_code') }}" required="" class="form-control "/>
                  </div>
                </div>

                 <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Item Name</label>
                  <div class="col-sm-10">
                     <input type="text" name="item_name" value="{{ old('item_name') }}" required="" class="form-control "/>
                  </div>
                </div>
  
                 <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Quantity</label>
                  <div class="col-sm-10">
                     <input type="text" name="quantity" value="{{ old('quantity') }}" required="" class="form-control "/>
                  </div>
                </div>

                 <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">PA Budget</label>
                  <div class="col-sm-10">
                     <input type="text" name="pa_budget" value="{{ old('pa_budget') }}" required="" class="form-control "/>
                  </div>
                </div>

                 <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">GOB Budget</label>
                  <div class="col-sm-10">
                     <input type="text" name="gob_budget" value="{{ old('gob_budget') }}" required="" class="form-control "/>
                  </div>
                </div>
               

                <div class="pull-right">
                  <button type="submit" id="submit"class="btn btn-primary">Submit</button>
                </div>
                
              </form>
          </div>
        </div>
      </div>
    </div>
@endsection


