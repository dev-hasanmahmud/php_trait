@extends('layouts.master')
@section('content')
<div class="sub-head header header2">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
        <div class="procurement-title">
          <h5 class="d-inline">
            <i class="fa fa-window-restore" aria-hidden="true"></i> Settings
          </h5>
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        <a class="active btn sub-btn float-right" href="{{ route('indicator.create') }}"><i class="fa fa-plus"> </i> Add
          Record </a>

      </div>
    </div>
  </div>
</div>

<div class="main-content form-component mt-4 ">
  <div class="container">
    <div class="card mb-4 card-design">
      <div class="card-body">
        <div class="card-title bg-primary text-white">
          <h5>Add Record</h5>
        </div>
        @include('sweetalert::alert')
        <form method="POST" action="{{route('settings.store')}}">
          @csrf
          @method('POST')
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Select Procurement Type</label>
            <div class="col-sm-10">
              <select name="type_id" class="form-control form-control-sm select2 custom-select2" id="procurement_type">
                <option value="0"> Select Procurement Type</option>
                @foreach ($procurement_types as $item)
                <option value="{{ $item->id }}">{{ $item->name_en }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Select Procurement Method</label>
            <div class="col-sm-10">
              <select name="procurement_method_id" id="procurement_method"
                class="form-control form-control-sm select2 custom-select2">
                <option value="0">Select Procurement Method</option>
                @foreach ($procurement_methods as $item)
                <option value="{{ $item->id }}">{{ $item->name_en }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Label Name</label>
            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9" id="label_group">

              <input type="text" name="label_name_1" value="{{ old('label_name') }}" required=""
                class="form-control " />

            </div>
            <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1 text-right">
              <div class="row">
                <a href="javascript:void(0)" class="btn btn-outline-success fa fa-plus" id="add_label"></a> &nbsp;
                <a href="javascript:void(0)" class="float-right btn btn-outline-danger delete" id="delete_label"> <i
                    class="fa fa-trash"></i> </a>
              </div>

            </div>
          </div>

          <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Identifier</label>
            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9" id="identifier_group">

              <input type="text" name="identifier_name_1" value="{{ old('identifier_name') }}" required=""
                class="form-control " />

            </div>
            {{-- <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1 text-right">
                       <div class="row">
                          <a href="javascript:void(0)"   class="btn btn-outline-success fa fa-plus" id="add_identifier"></a> &nbsp;
                          <a href="javascript:void(0)" class="float-right btn btn-outline-danger delete"  id="delete_identifier"> <i class="fa fa-trash"></i> </a>
                       </div>
                  
                  </div> --}}
          </div>


          <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Ordering Number</label>
            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9" id="ordering_group">

              <input type="text" name="ordering_1" value="{{ old('ordering_1') }}" required="" class="form-control " />

            </div>
          </div>

          <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Type</label>
            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9" id="type_group">

              <select name="type_1" id="type_1" class="form-control form-control-sm select2 custom-select2">
                <option value="0">Select Type</option>
                <option value="1">Date</option>
                <option value="2">Number</option>
                <option value="3">Text</option>
              </select>

            </div>

          </div>

          <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Is Mendatory?</label>
            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9" id="is_mendatory_group">

              <input type="radio" name="is_mendatory_1" value="1">Yes</input>
              <input type="radio" name="is_mendatory_1" value="0">No</input>

            </div>


          </div>

          <div class="pull-right">
            <button type="submit" id="submit" class="btn btn-lg btn-primary">Submit</button>
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
     $('#procurement_type').change(function(){
    //console.log('get indicator list')
    var procurement_type = $('#procurement_type').val()
   // console.log(procurement_type)

    var url =  " {{ url('ajax/get_unit_by_type_id') }}"+'/'+procurement_type;
    console.log(procurement_type)
    $.ajax({
      method:'POST',
      url: url,
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      success: (data)=>{
        show_procurement_method(data.data.method)
      },
      error: function(data){

      }
    });

  });

  function show_procurement_method(data){
      var html=''
      $.each(data,function(key,value){
        html+=`<option value= "${value.id}"> ${value.name_en}</option>`
      });
    $('#procurement_method').html(html);
  }

  //label
  var field=1;
  $('body').on('click', '#add_label', function () {
    field++;
    //console.log(label+" ");
    var label_name=`<div class="mt-2"><input type="text" name="label_name_${field}" value="{{ old('label_name') }}" required="" class="form-control" id="label_name_${field}" /></div>`

    var identifier=`<div class="mt-2"><input type="text" name="identifier_name_${field}" value="{{ old('identifier_name') }}" required="" class="form-control" id="identifier_name_${field}" /></div>`

    var ordering=`<div class="mt-2"><input type="text" name="ordering_${field}"
          value="{{ old('identifier_name') }}" required="" class="form-control" id="ordering_${field}" /></div>`
    


    var type=`<div class="mt-2"> <select name="type_${field}" id="type_${field}"  class="form-control form-control-sm select2      custom-select2">
                      <option value="0">Select Type</option>
                      <option value="1">Date</option>
                      <option value="2">Number</option>
                      <option value="3">Text</option>
                    </select></div>`
    
    var is_mendatory=`<div class="mt-2" id="mendatory_${field}"> <input type="radio" name="is_mendatory_${field}" value="1" >Yes</input><input type="radio" name="is_mendatory_${field}" value="0" >No</input></div>`
   
    $('#label_group').append(label_name);
    $('#identifier_group').append(identifier);
    $('#ordering_group').append(ordering);
    
    $('#type_group').append(type);
    $('#is_mendatory_group').append(is_mendatory);
      
  });

  $("#delete_label").on('click', function () {
      var last= field;
      //console.log(chk);
      $('#label_name_'+field).remove(); 
      $('#identifier_name_'+field).remove(); 
      $('#type_'+field).remove(); 
      $('#mendatory_'+field).remove(); 
      field--;
  });
  
}); 



                    
</script>

@endpush