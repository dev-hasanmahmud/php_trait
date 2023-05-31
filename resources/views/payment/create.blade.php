@extends('layouts.master')
@section('content')
<div class="sub-head header header2">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
        <div class="procurement-title">
          <h5 class="d-inline">
            <i class="fa fa-credit-card-alt" aria-hidden="true"></i> Add Payment
          </h5>                
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        <a class="active btn sub-btn float-right" href="{{ route('payment.create') }}" ><i class="fa fa-plus"> </i> Add  Payment </a>
        
      </div>
    </div>
  </div>
</div>

<div class="main-content form-component mt-4 ">
      <div class="container">
        @include('sweetalert::alert')
        {{-- <a class=" btn btn-primary" href="{{ route('payment.index') }}">Index Page</a> --}}
        <div class="card mb-4 card-design">
          <div class="card-body">
            <div class="card-title bg-primary text-white">
              <h5>Payment</h5>
            </div>
            <form  method="POST" action="{{route("payment.store")}}"  >
              @csrf
                <div class="form-group row">
                  <label for="staticEmail" class="col-sm-2 col-form-label">Package <span class="mendatory">*</span></label>
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

                <div class="form-group row">
                  <label for="staticEmail" class="col-sm-2 col-form-label">OR</label>
                  <div class="col-sm-10">   
                    <select name="financial_item_id" id="financial_item"  class="form-control form-control-sm select2 custom-select2">
                      <optgroup>
                        <option value="0">Select Financial Item</option>
                        @foreach ($financial_item as $item)
                          <option value="{{ $item->id }}">{{ $item->economic_code }}-{{ $item->item_name }}</option>
                        @endforeach
                      </optgroup>
                    </select>
                  </div>
                </div>
                
                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Economic Code</label>
                  <div class="col-sm-10">
                   <input type="text"name="name_bn" readonly id="economic_code"class="form-control"id="source_of_fund_name_bn"/>
                  </div>
                </div>
  
                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Voucher Number <span class="mendatory">*</span> </label>
                  <div class="col-sm-10">
                    <input type="text" name="voucher_no" value="{{ old('voucher_no') }}" required="" class="form-control " id="source_of_fund_name_bn"/>
                  </div>
                </div>
  
                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Sourche Of Fund <span class="mendatory">*</span> </label>
                  <div class="col-sm-10">
                    <select name="source_of_fund_id" id="source"  class="form-control select2 custom-select2">
                      <option value="">Select Sourche Of Fund</option>
                    </select>
                   
                  </div>
                </div>
  
                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Contractor /  supplier/ Consultant <span class="mendatory">*</span> </label>
                  <div class="col-sm-10">
                    <select name="contactor_id" id="contractor"  class="form-control form-control-sm select2 custom-select2">
                      <option value="">Select Constractor</option>
                    </select>
                  </div>
                </div>
  
                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Amount <span class="mendatory">*</span> </label>
                  <div class="col-sm-10">
                    <input type="text" name="amount" required="" value="{{ old('amount')}}" class="taka form-control " id="source_of_fund_name_bn"/>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Date <span class="mendatory">*</span></label>
                  <div class="col-sm-10">
                    <div class="input-group datepicker-box">
                      <input name="date"  class="form-control datepicker w-100"  required=''
                      value="{{old('date')}}"
                      type="text" placeholder="YY-MM-DD" />
                    </div>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Quantity</label>
                  <div class="col-sm-10">
                    <input type="text" name="quantity"  value="{{ old('quantity')}}" class="form-control "/>
                  </div>
                </div>

                {{-- <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Reference</label>
                  <div class="col-sm-10">
                    <textarea name="details" id=""  class="form-control" cols="30" rows="2">{{ old('details') }}</textarea>
                  </div>
                </div> --}}
  
               
                <div class="pull-right">
                  <a class="btn  btn-warning" href="{{ route('payment.index') }}">Cancel</a>
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

  $('#financial_item').change(function(){ 
    console.log('get financial_item list')
    var financial_item_id = $('#financial_item').val()
    //$("#package_id").val(financial_item_id);
    $("#component").val(0).trigger('change')
    var url =  " {{ url('ajax/get_contractor_by_financial_item_id') }}"+'/'+financial_item_id;
    console.log(financial_item_id)
    $.ajax({
      method:'POST',
      url: url,
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      success: (data)=>{
        console.log(data)
        show_contractor(data.data.contractor)
        show_source(data.data.source)
        //console.log(data.data.package)
        $('#economic_code').val(data.data.package.economic_head);
      },
      error: function(data){
        var html=''
        
        //$('#economic_code').val(data.responseJSON.data.economic_head);
        $('#contractor').html(html);
      }
    });
  }); 
   
  $('#component').change(function(){ 
    console.log('get indicator list')
    var component_id = $('#component').val()
    $("#package_id").val(component_id)
    //$("#financial_item").val(0).trigger()
    var url =  " {{ url('ajax/get_contractor_by_package_id') }}"+'/'+component_id;
    console.log(component_id)
    $.ajax({
      method:'POST',
      url: url,
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      success: (data)=>{
        console.log(data)
        show_contractor(data.data.contractor)
        show_source(data.data.source)
        //console.log(data.data.package)
        $('#economic_code').val(data.data.package.economic_head);
      },
      error: function(data){
        var html=''
        
        $('#economic_code').val(data.responseJSON.data.economic_head);
        $('#contractor').html(html);
      }
    });
  }); 


  function show_contractor(data){
    //console.log(data);   
      var html=''
      $.each(data,function(key,value){
        //console.log(value.name_en)
        html+=`<option value= "${value.id}"> ${value.name_en}</option>`

      });
    $('#contractor').html(html);
  }

  function show_source(data){
    //console.log(data);   
      var html=''
      $.each(data,function(key,value){
        //console.log(value.name_en)
        html+=`<option value= "${value.id}"> ${value.name_en}</option>`

      });
    $('#source').html(html);
  }

}); 
 
                       
 
</script>
    
<script>
	var cleave = new Cleave('.taka', {
		numeral: true,
		numeralThousandsGroupStyle: 'thousand'
  });
</script>
@endpush