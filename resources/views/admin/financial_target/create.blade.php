@extends('layouts.master')
@section('content')

<div class="main-content form-component mt-4 ">
      <div class="container">
        @include('sweetalert::alert')
        <div class="card mb-4 card-design">
          <div class="card-body">
            <div class="card-title bg-primary text-white">
              <h5>Financial Target</h5>
            </div>
            <form  method="POST" action="{{route("financial-target.store")}}"  >
              @csrf
                <div class="form-group row">
                  <label for="staticEmail" class="col-sm-2 col-form-label">Package</label>
                  <div class="col-sm-10">   
                    <select name="package_id" id="component"  class="form-control form-control-sm select2 custom-select2">
                    <optgroup>
                      <option value="0">Select Package</option>
                      @foreach ($component as $item)
                        <option value="{{ $item->id }}">{{ $item->package_no }}- {{ $item->name_en }}</option>
                      @endforeach
                    </optgroup>
                    </select>
                  </div>
                </div>
                <div class="text-center mt-2 mb-2">
                    <span style="align: center">OR</span>
                </div>
                  <div class="form-group row">
                  <label for="staticEmail" class="col-sm-2 col-form-label">Financial Item</label>
                  <div class="col-sm-10">   
                    <select name="item_id" id="item_id"  class="form-control form-control-sm select2 custom-select2">
                    <optgroup>
                      <option value="0">Select Item</option>
                      @foreach ($items as $item)
                        <option value="{{ $item->id }}">{{ $item->item_name }}</option>
                      @endforeach
                    </optgroup>
                    </select>
                  </div>
                </div>
                
                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Target Quantity</label>
                  <div class="col-sm-10">
                   <input type="text"name="target_qty" value="{{ old('target_qty') }}"  required="" class="form-control"/>
                  </div>
                </div>
  
                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Govment Amount</label>
                  <div class="col-sm-10">
                    <input type="text" name="gov_amount" value="{{ old('gov_amount') }}" required="" class="taka form-control " />
                  </div>
                </div>
  
                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">World Bank Amount</label>
                  <div class="col-sm-10">
                    <input type="text" name="pa_amount" value="{{ old('pa_amount') }}" required="" class="taka1 form-control " />
                  </div>
                </div>

                <input name="date" hidden   
                      value="2020-04-30">

                {{-- <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Date</label>
                  <div class="col-sm-10">
                    <div class="input-group datepicker-box">
                      <input name="date" hidden  class="form-control datepicker w-100" 
                      value="{{old('date')}}"
                      type="text" placeholder="YY-MM-DD" />
                    </div>
                  </div>
                </div> --}}
  
                <div class="pull-right">
                  <a class="btn  btn-warning" href="{{ route('financial-target.index') }}">Cancel</a>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                
              </form>
          </div>
        </div>
      </div>
    </div>
@endsection


@push('script')

<script>

$(document).ready(function () {
   
    $('#item_id').change(function(){ 
    console.log('get financial_item list')
    //var financial_item_id = $('#financial_item').val()
    //$("#package_id").val(financial_item_id);
    $("#component").val(0).trigger('change')

  }); 
   
}); 
</script>

<script>
	var cleave = new Cleave('.taka', {
		numeral: true,
		numeralThousandsGroupStyle: 'thousand'
  });

  var cleave = new Cleave('.taka1', {
		numeral: true,
		numeralThousandsGroupStyle: 'thousand'
  });

</script>
    
@endpush