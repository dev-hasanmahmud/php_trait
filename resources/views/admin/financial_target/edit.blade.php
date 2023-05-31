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

            <form  action="{{ route('financial-target.update',$financial->id) }}" method="post" >
              @csrf
              @method('PUT')
              @if ($financial->is_package==1)
                <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Package</label>
                <div class="col-sm-10">   
                  <select name="package_id" id="component"  class="form-control form-control-sm select2 custom-select2">
                   <optgroup>
                    @foreach ($component as $item)
                      <option value="{{ $item->id }}"
                        @if ($item->id==$financial->package_id)
                        {{'selected= "selected" '}}
                        @endif
                        >{{ $item->package_no }}- {{ $item->name_en }}</option>
                    @endforeach
                  </optgroup>
                  </select>
                </div>
              </div>
              @else 
               <div class="form-group row">
                  <label for="staticEmail" class="col-sm-2 col-form-label">Financial Item</label>
                  <div class="col-sm-10">   
                    <select name="package_id" id="component"  class="form-control form-control-sm select2 custom-select2">
                    <optgroup>
                      @foreach ($items as $item)
                        <option value="{{ $item->id }}"
                         @if ($item->id==$financial->package_id)
                        {{'selected= "selected" '}}
                        @endif
                        >{{ $item->item_name }}</option>
                      @endforeach
                    </optgroup>
                    </select>
                  </div>
                </div>
              @endif
             
              
              <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Target Quantity</label>
                <div class="col-sm-10">
                 <input type="text"name="target_qty" value="{{ $financial->target_qty }}"  required="" class="form-control"/>
                </div>
              </div>

              <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Govment Amount</label>
                <div class="col-sm-10">
                  <input type="text" name="gov_amount" value="{{ $financial->gov_amount }}" required="" class="taka form-control " />
                </div>
              </div>

              <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">World Bank Amount</label>
                <div class="col-sm-10">
                  <input type="text" name="pa_amount" value="{{ $financial->pa_amount }}" required="" class="taka1 form-control " />
                </div>
              </div>

              <input name="date" hidden   
              value="{{ $financial->date  }}">

              {{-- <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Date</label>
                <div class="col-sm-10">
                  <div class="input-group datepicker-box">
                    <input name="date"  class="form-control datepicker w-100" 
                    value="{{ $payment->date}}"
                    type="text" placeholder="YY-MM-DD" />
                  </div>
                </div>
              </div> --}}

              <div class="pull-right">
                <a class="btn  btn-warning" href="{{ route('financial-target.index') }}">Cancel</a>
                <button type="submit" class="btn btn-primary">Update</button>
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
   
  $('#component').change(function(){ 
    console.log('get indicator list')
    var component_id = $('#component').val()
    $("#package_id").val(component_id);
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

  var cleave = new Cleave('.taka1', {
		numeral: true,
		numeralThousandsGroupStyle: 'thousand'
  });

</script>
    
@endpush