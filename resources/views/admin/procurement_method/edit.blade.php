@extends('layouts.master')
@section('content')
<div class="sub-head header header2">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
        <div class="procurement-title">
          <h5 class="d-inline">
            <i class="fa fa-bar-chart" aria-hidden="true"></i> Edit Procurement Method
          </h5>                
        </div>
      </div>
  
    </div>
  </div>
</div>

<div class="main-content form-component mt-4 ">
      <div class="container">
        {{-- /*sweet alert*/ --}}
        @include('sweetalert::alert') 

        <div class="card mb-4 card-design">
          <div class="card-body">
            <div class="card-title bg-primary text-white">
              <h5>Create Procurement Method </h5>
            </div>
            <form  method="POST" action="{{route("procurement_method.update",$source->id)}}"  >
                @csrf
                {{method_field("PATCH")}}
                <div class="border p-3 bg-white rounded">
                    <div class="form-group">
                        <label for="source_of_fund_name_en">Procurement Method Name In English <span class="mendatory">*</span> </label>
                        <input
                          type="text"
                          name="name_en"
                          required=""
                          value="{{$source->name_en}}"
                          class="form-control"
                          id="source_of_fund_name_en"
                          aria-describedby="textHelp"
                        />
                        {{-- <small id="emailHelp" class="form-text text-danger"
                          >We'll never share your email with anyone else.</small
                        > --}}
                      </div>
                      <div class="form-group">
                        <label for="source_of_fund_name_bn">Procurement Method Name In Bangli</label>
                        <input
                          type="text"
                          name="name_bn"
                          value="{{$source->name_bn}}"
                          class="form-control"
                          id="source_of_fund_name_bn"
                        />
                      </div>
                      <div class="form-group">
                        <label for="source_of_fund_name_bn">Procurement Method Type <span class="mendatory">*</span> </label>
                        {!! Form::select('type_id[]', \App\Type::pluck('name_en', 'id'), old('type_id',
                        isset($source->type_id) ? json_decode($source->type_id):null), [ 'multiple' =>
                        'multiple', 'class' => 'form-control custom-select select2 full-width', 'data-init-plugin'=>'select2', 'id' => '','required'=>'required']) !!}
                      </div>
                      <button type="submit" class="btn btn-primary">Update</button>
                </div>
                
              </form>
          </div>
        </div>
      </div>
    </div>


@endsection