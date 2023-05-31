@extends('layouts.master')
@section('content')

<div class="sub-head header header2">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
        <div class="procurement-title">
          <h5 class="d-inline">
            <img src="{{ custom_asset('assets/images/icons/fecal.png') }}" alt="" /> Edit Package
          </h5>
        </div>
      </div>

    </div>
  </div>
</div>
<div class="main-content form-component mt-4 ">
  <div class="container">
    @include('sweetalert::alert')
    {{-- <a class=" btn btn-primary" href="{{ route('package.index') }}">Index
    Page</a> --}}
    <div class="card mb-4 card-design">

      <div class="card-body">
        <div class="card-title bg-primary text-white">
          <h5>Update Component</h5>
        </div>
        <form action="{{ route('package.update', $component->id) }}" method="post" enctype="multipart/form-data">
          @csrf
          {{ method_field('Put') }}
          <div class="row">
            <div class="col-4">
              <div class="form-group">
                <label for="exampleInputEmail1">Package Number <span class="mendatory">*</span> </label>
                <input type="text" name="package_no" value="{{ $component->package_no }}"
                  class="form-control form-control-sm" required />
              </div>
            </div>
            <div class="col-4">
              <div class="form-group">
                <label for="component_name_en">Package Name <span class="mendatory">*</span> </label>
                <input type="text" name="name_en" value="{{ $component->name_en }}" class="form-control form-control-sm"
                  id="component_name_en" />

              </div>
            </div>

            {{-- <div class="col-4">
                                <div class="form-group">
                                    <label for="component_name_bn">Component Name in Bangla
                                    </label>
                                    <input type="text" name="name_bn" value="{{ $component->name_bn }}"
            class="form-control form-control-sm" />
          </div>
      </div> --}}

      <div class="col-4">
        <div class="form-group">
          <label for="Type_Id">Procurement Type <span class="mendatory">*</span> </label>

          <select name="type_id" class="form-control form-control-sm select2 custom-select2" id="procurement_type">
            <optgroup label=" Select Procurement Type ">
              @foreach ($type_id as $item)
              <option value="{{ $item->id }}" @if ($item->id == $component->type_id)
                {{ 'selected= "selected" ' }}
                @endif
                >{{ $item->name_en }}</option>
              @endforeach
            </optgroup>
          </select>

        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <label for="exampleInputEmail1">DPP Head</label>
          <input type="text" name="dpp_head" value="{{ $component->dpp_head }}" class="form-control form-control-sm" />
        </div>
      </div>
      {{-- <div class="col-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Economic Code</label>
                                    <input type="text" name="economic_head" value="{{ $component->economic_head }}"
      class="form-control form-control-sm" />
    </div>
  </div> --}}

  <div class="col-4">
    <div class="form-group">
      <label for="exampleInputEmail1">Unit</label>
      <select class="form-control form-control-sm select2 custom-select2" name="unit_id" id="unit">
        <optgroup label=" Select Unit Type ">
          @foreach ($unit_id as $item)
          <option value="{{ $item->id }}" @if ($item->id == $component->unit_id)
            {{ 'selected= "selected" ' }}
            @endif
            >{{ $item->name_en }}</option>
          @endforeach
        </optgroup>
      </select>
    </div>
  </div>

  <div class="col-4">
    <div class="form-group">
      <label for="exampleInputEmail1">Quantity <span class="mendatory">*</span> </label>
      <input type="text" name="quantity" value="{{ $component->quantity }}" class="form-control form-control-sm"
        required />
    </div>
  </div>

  <div class="col-4">
    <div class="form-group">
      <label for="exampleInputEmail1">Procurement Method</label>
      <select class="form-control form-control-sm select2 custom-select2" name="proc_method_id" id="procurement_method">
        <optgroup label=" Select Procurement Method ">
          @foreach ($proc_method_id as $item)
          <option value="{{ $item->id }}" @if ($item->id == $component->proc_method_id)
            {{ 'selected= "selected" ' }}
            @endif
            >{{ $item->name_en }}</option>
          @endforeach
        </optgroup>
      </select>
    </div>
  </div>

  <div class="col-4">
    <label for="">Review Type</label>
    {!! Form::select('review', ['1' => 'Prior Review', '2' => 'Post Review '], old('review',
    $component->review), ['class' => 'form-control select2 custom-select2', 'id' => 'status',
    'required' => 'required']) !!}
  </div>

  <div class="col-4">
    <div class="form-group">
      <label for="exampleInputEmail1">Contract Approving Authority</label>
      <select name="approving_authority_id" class="form-control form-control-sm select2 custom-select2">
        <optgroup label=" Select Approving Authority ">
          @foreach ($approving_authority_id as $item)
          <option value="{{ $item->id }}" @if ($item->id == $component->approving_authority_id)
            {{ 'selected= "selected" ' }}
            @endif
            >{{ $item->name_en }}</option>
          @endforeach
        </optgroup>
      </select>
    </div>
  </div>

  <div class="col-4">
    <div class="form-group">
      <label for="exampleInputEmail1">Source of Fund</label>
      {{-- {!! Form::select('source_of_fund_id[]',
                                    \App\Source_of_fund::pluck('name_en', 'id'), old('source_of_fund_id',
                                    isset($component->source_of_fund_id) ? json_decode($component->source_of_fund_id) :
                                    null), [
                                    'multiple' => 'multiple',
                                    'class' => 'form-control custom-select select2
                                    full-width',
                                    'data-init-plugin' => 'select2',
                                    'id' => '',
                                    ]) !!}
                                    --}}
      @php
      $id = json_decode($component->source_of_fund_id);
      $source_id = isset($id[0])?$id[0]:'';
      @endphp
      <select name="source_of_fund_id[]" id="source_of_fund_id"
        class="form-control form-control-sm select2 custom-select2" multiple="multiple">
        @foreach ($source_of_fund_id as $item)
        <option value="{{ $item->id }}" @if ($item->id == $source_id)
          {{ 'selected= "selected" ' }}
          @endif
          >{{ $item->name_en }}
        </option>
        @endforeach
      </select>
    </div>
  </div>

  {{-- <div class="col-4">
                                <label for="">Budget as per DPP (BDT) </label>
                                <div class="form-group">
                                    <input name="dpp_cost" id="" class="form-control"
                                        value="{{ $component->dpp_cost }}"></input>
</div>
</div> --}}

<div class="col-4">
  <div class="form-group">
    <label for="exampleInputEmail1">Budget Provision as per DPP (BDT) <span class="mendatory">*</span> </label>
    <input type="text" name="cost_tk_act" id="budget_dpp"
      value="{{ number_format($component->cost_tk_act, 2, '.', ',') }}" class="taka form-control form-control-sm" />
  </div>
</div>

<div class="col-4">
  <div class="form-group">
    <label for="exampleInputEmail1">Estimated Cost ( USD)</label>
    <input type="text" name="cost_usd_est" id="budget_dpp_usd" readonly=""
      value="{{ number_format($component->cost_usd_est, 2, '.', ',') }}" class="taka2 form-control form-control-sm" />
  </div>
</div>

<div class="col-4">
  <div class="form-group">
    <label for="exampleInputEmail1">Official Estimated Cost (BDT) </label>
    <input type="text" name="cost_tk_est" id="official_cost"
      value="{{ number_format($component->cost_tk_est, 2, '.', ',') }}" class="taka1 form-control form-control-sm" />
  </div>
</div>

<div class="col-4">
  <div class="form-group">
    <label for="exampleInputEmail1">Official Estimated Cost (USD)</label>
    <input type="text" class="taka3 form-control form-control-sm" id="official_cost_usd" readonly=""
      value="{{ number_format($component->cost_usd_act, 2, '.', ',') }}" name="cost_usd_act" />
  </div>
</div>

<div class="seperate"> Necessary Date </div>

<div class="col-12">
  <div class="row" id="input_group">
    @if ($data == null)
    @include('admin.package.edit_common_group')
    @else
    @php
    $data = json_decode($data['value']);
    @endphp
    @foreach ($lavel as $item)
    <div class="col-6">
      <div class="form-group">
        <label for="exampleInputEmail1">{{ $item->label_name }}</label>
        <div class="input-group datepicker-box" id="show">
          <input name="value_{{ $loop->iteration }}" class="form-control datepicker w-100"
            value="{{ isset($data[$loop->index])? $data[$loop->index]:null}}" type="text" placeholder="YY-MM-DD" />
        </div>
      </div>
    </div>
    @endforeach
    @endif

  </div>
</div>


{{-- <div class="col-4">
                                <label for="">Estimate Cost of DPP Model</label>
                                <div class="form-group">
                                    <input name="dpp_cost" id="" value="{{ $component->dpp_cost }}"
class="form-control"
cols="30" rows="2"></input>
</div>
</div> --}}
<?------------Star New_Input----------------?>
<div class="seperate"> Contract </div>
<div class="col-4">
  <div class="form-group">
    <label for="exampleInputEmail1">Actual Contract Price (BDT)</label>
    <input type="text" name="contract_price_act_bdt"
      value="{{ number_format($component->contract_price_act_bdt, 2, '.', ',') }}"
      class="taka4 form-control form-control-sm" id="bdt_3" />
  </div>
</div>

<div class="col-4">
  <div class="form-group">
    <label for="exampleInputEmail1">Actual Contract Price (USD) </label>
    <input type="text" name="contract_price_act_usd" readonly
      value="{{ number_format($component->contract_price_act_usd, 2, '.', ',') }}"
      class="taka5 form-control form-control-sm" id="usd_3" />
  </div>
</div>

<div class="col-4">
</div>

<div class="col-4">
  <div class="form-group">
    <label for="exampleInputEmail1">Actual date of Contract Signing </label>
    <div class="input-group datepicker-box">
      <input name="signing_of_contact_act" class="form-control datepicker w-100" type="text"
        value="{{ $component->signing_of_contact_act }}" id="signing_of_contact_act" />
    </div>
  </div>
</div>

<div class="col-4">
  <div class="form-group">
    <label for="exampleInputEmail1">Days/Count for the actual completion date</label>
    <input type="number" id="day_count" class="form-control form-control-sm" />
  </div>
</div>

<div class="col-4">
  <div class="form-group">
    @if ($component->type_id == 1)
    <label for="exampleInputEmail1" id="lb_completion_date">Delivery Completion Date </label>
    @elseif($component->type_id==2)
    <label for="exampleInputEmail1" id="lb_completion_date">Intended Completion Date </label>
    @elseif($component->type_id==3)
    <label for="exampleInputEmail1" id="lb_completion_date">Contract Expiration Date </label>
    @else
    <label for="exampleInputEmail1" id="lb_completion_date">Actual date of Contract Completion </label>
    @endif
    <div class="input-group datepicker-box">
      <input name="complition_of_contact_act" class="form-control datepicker w-100" type="text"
        value="{{ $component->complition_of_contact_act }}" id="completion_date" />
    </div>
  </div>
</div>

<div class="col-4">
  <div class="form-group">
    <label for="source_of_fund_name_bn">Name of Contractor / supplier/ Consultant</label>
    {!! Form::select('contactors[]', \App\Contactor::pluck('name_en', 'id'), old('contactors',
    isset($component->contactors) ? json_decode($component->contactors) : null), ['multiple' => 'multiple', 'class' =>
    'form-control custom-select select2 full-width', 'data-init-plugin' => 'select2', 'id' => '']) !!}
  </div>
</div>
<?------------end   New_Input--------------?>


<?------------Star second  New_Input--------------?>
<div class="seperate"> Extension </div>

<div class="col-4">
  <div class="form-group">
    <label for="exampleInputEmail1">Days</label>
    <input type="number" name="extension_day_count" value="{{ $component->extension_day_count }}"
      id="extension_day_count" class="form-control form-control-sm" />
  </div>
</div>

<div class="col-4">
  <div class="form-group">
    <label for="exampleInputEmail1">Actual Date</label>
    <div class="input-group datepicker-box">
      <input name="extension_date_act" value="{{ $component->extension_date_act }}"
        class="form-control datepicker w-100" type="text" placeholder="YY-MM-DD" id="extension_date_act" />
    </div>
  </div>
</div>
<?------------end second  New_Input--------------?>

<div class="seperate"> Contract Agreement Document </div>
<div class="col-12">
  <div class="row">
    @php
    $id_array = array();
    $index = 0;
    @endphp

    @forelse ($agreement_file as $item)
    @php
    $file_size = $loop->iteration;
    $id_array[ $index++] = $item->id;
    $fileName = explode('-.-',$item->file_path);
    // $fileName=$item->file_path;
    @endphp
    <div class="col-4">
      <div class="form-group">
        <div class="custom-file">
          <input type="text" hidden name="agreement_id" value="{{ $item->id }}" />
          <input type="file" class="custom-file-input" name="agreement_1" onclick="change_file(50)" id="file_50" />
          <label class=" custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Choose
            file</label>
        </div>
      </div>
    </div>
    <div class="col-4" id="file_preview_container_50">
      <p>{{ isset($fileName[1]) ? $fileName[1] : null }}</p>
    </div>
    @empty
    <div class="col-4">
      <div class="form-group">
        <div class="custom-file">
          <input type="file" class="custom-file-input" name="agreement_1" onclick="change_file(50)" id="file_50" />
          <label class=" custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Choose
            file</label>
        </div>
      </div>
    </div>
    <div class="col-4" id="file_preview_container_50">
      <p>File Name </p>
    </div>
    @endforelse
  </div>
</div>


<?-----------End New_input------------------?>
@if ($component->type_id == 1 || $component->type_id == 2)


<div class="seperate "> Contruct Management </div>

<div class="col-4 ">
  <div class="form-group">
    <label for="source_of_fund_name_bn">Assigned Firm/Consultant </label>
    {!! Form::select(
    'assigned[]',
    App\Contactor::where(function ($query) {
    $query
    ->where('type', 'Consultant')
    ->orWhere('type', 'Consulting Firm')
    ->get();
    })->pluck('name_en', 'id'),
    old('assigned', isset($component->assigned) ? json_decode($component->assigned) : null),
    ['multiple' => 'multiple', 'class' => 'form-control custom-select select2 full-width', 'data-init-plugin' =>
    'select2', 'id' => '']
    ) !!}
  </div>
</div>

<div class="  seperate"> Remark</div>
<textarea name="remark" class=" form-control w-100 mb-2" id="" cols="30" rows="4">{{ $component->remark }} 
                                </textarea>

<div class=" seperate"> Necessary File
  <div class="pull-right">
    <a href="javascript:void(0)" class="btn btn-outline-success fa fa-plus" id="add_file"></a>
  </div>
</div>

</div>

<div class="" id="file_group">
  @php
  $id_array = array();
  $index = 0;
  @endphp
  @foreach ($file_list as $item)
  @php
  $file_size = $loop->iteration;
  $id_array[ $index++] = $item->id;
  $fileName = explode('-.-',$item->file_path);
  // $fileName=$item->file_path;
  @endphp

  <div class="my-3 form-group row">
    <label for="inputPassword" class="col-sm-1 col-form-label">File Title </label>
    <input type="text" name="file_title_{{ $loop->iteration }}" class="mr-2 form-control col-sm-4"
      value="{{ $item->name }}" />

    <div class="col-sm-6">
      <div class="row input-group ">
        <div class="col-sm-6 custom-file">
          <input type="text" hidden name="file_id_{{ $loop->iteration }}" value="{{ $item->id }}" />
          <input type="file" class="custom-file-input" name="file_{{ $loop->iteration }}"
            onclick="change_file({{ $loop->iteration }})" id="file_{{ $loop->iteration }}" />
          <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Choose
            file</label>
        </div>
        <div class="col-sm-5" id="file_preview_container_{{ $loop->iteration }}">
          <p>{{ isset($fileName[1]) ? $fileName[1] : null }} </p>
        </div>
      </div>
    </div>
    <a href="javascript:void(0)" class="pull-right btn btn-outline-danger delete btn-xs" id="delete_image"> X </a>
  </div>
  @endforeach

  <input type="text" id="file_size" hidden value="{{ isset($file_size) ? $file_size : 0 }}">
  <input type="text" hidden name="file_id" value="{{ json_encode($id_array, true) }}">

</div>
@else
</div>
@endif
<div class="text-right">
  <button type="submit" class="btn btn-primary">Update</button>
</div>
</form>
</div>
</div>
</div>
</div>

<input id="hidden_type_id" type="text" value="{{ $component->type_id }}" hidden="">
@endsection

@push('script')

<script>
  $(document).ready(function () {


      // var type_id = $("#hidden_type_id").val();
      // console.log(type_id);
      // if(type_id == 1 || type_id==2){
      //   $(".select2").select2();
      //   $(".hide").removeClass('d-none');
      // }

      $('#budget_dpp').keyup(function() {
                                                                        var budget_tk = $(this).val();
                                                                        budget_tk = budget_tk.replace(",", '');
                                                                        budget_tk = budget_tk.replace(",", '');
                                                                        budget_tk = budget_tk.replace(",", '');
                                                                        budget_tk = parseInt(budget_tk, 10);

                                                                        budget_dpp_usd.value = (budget_tk / 84.84).toFixed(2);

                                                                    });

                                                                    $('#official_cost').keyup(function() {
                                                                        var budget_tk = $(this).val();
                                                                        budget_tk = budget_tk.replace(",", '');
                                                                        budget_tk = budget_tk.replace(",", '');
                                                                        budget_tk = budget_tk.replace(",", '');
                                                                        budget_tk = parseInt(budget_tk, 10);

                                                                        official_cost_usd.value = (budget_tk / 84.84).toFixed(2);

                                                                    });

                                          $('#bdt_3').keyup(function() {
                                            var budget_tk = $(this).val();
                                            budget_tk = budget_tk.replace(",", '');
                                            budget_tk = budget_tk.replace(",", '');
                                            budget_tk = budget_tk.replace(",", '');
                                            budget_tk = budget_tk.replace(",", '');
                                            budget_tk = budget_tk.replace(",", '');
                                            budget_tk = parseInt(budget_tk, 10);
                                            
                                            usd_3.value = (budget_tk / 84.84).toFixed(2);
                                            
                                            });                                                                    

                                                                    /*Initialize javascript */
                                                                      var d1 = $("#signing_of_contact_act").val()
                                                                      var d2 = $("#completion_date").val()
                                                                      var d1 = new Date(d1); 
                                                                      var d2 = new Date(d2); 
                                                                      const diffTime = Math.abs(d2 - d1);
                                                                      const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
                                                                      $("#day_count").val(diffDays)

                                                                    /*end this section javascript */

                                                                    $('#procurement_method').change(function(){
                                                                        console.log('get indicator list')
                                                                        var procurement_type   = $('#procurement_type').val()
                                                                        var procurement_method = $('#procurement_method').val()
                                                                        console.log(procurement_type +" "+procurement_method)

                                                                        var url =  " {{ url('ajax/get_group_input_field_by_type_id') }}";
                                                                        $.ajax({
                                                                          method:'GET',
                                                                          url: url,
                                                                          data:{'type_id':procurement_type,'method_id':procurement_method},
                                                                          dataType:'JSON',
                                                                          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                                                          success: (data)=>{
                                                                            console.log("sucees\n"+data)
                                                                          },
                                                                          error: function(data){
                                                                            
                                                                            var html = data.responseText
                                                                            console.log(html)
                                                                            $("#input_group").html(html)
                                                                            $('.datepicker').bootstrapMaterialDatePicker({
                                                                              weekStart: 0,
                                                                              time: false,
                                                                              format: 'YYYY-MM-DD'
                                                                            });
                                                                          }
                                                                        });

                                                                      });

                                                                      $('body').on('click', '#day_count', function (){
                                                                        $("#day_count").keyup(function(){
                                                                          var day = $("#day_count").val()
                                                                          var date1 = $("#signing_of_contact_act").val()
                                                                          //console.log(date1)
                                                                          var date = new Date(date1); 
                                                                          day = parseInt(day)
                                                                          //console.log(day)
                                                                          var d = date.getDate()+day
                                                                          date.setDate(d);
                                                                          date2 = date.toISOString() 
                                                                          date2 = date2.split('T')
                                                                          //console.log(date2[0])
                                                                          $("#completion_date").val(date2[0])
                                                                        })
                                                                      });

                                                                      $('body').on('click', '#extension_day_count', function (){
                                                                        $("#extension_day_count").keyup(function(){
                                                                          var day = $("#extension_day_count").val()
                                                                          var date1 = $("#completion_date").val()
                                                                          console.log(date1)
                                                                          var date = new Date(date1);
                                                                          day = parseInt(day)
                                                                          console.log(day)
                                                                          var d = date.getDate()+day
                                                                          date.setDate(d);
                                                                          date2 = date.toISOString()
                                                                          date2 = date2.split('T')
                                                                          console.log(date2[0])
                                                                          $("#extension_date_act").val(date2[0])
                                                                        })
                                                                      });


                                                                      $('#procurement_type').change(function(){ 
                                                                        console.log('get indicator list')
                                                                        var procurement_type = $('#procurement_type').val()
                                                                        if(procurement_type==1){
                                                                          $('#lb_completion_date').text("Delivery Completion Date")
                                                                        }else if(procurement_type==2){
                                                                          $('#lb_completion_date').text("Intended Completion Date")
                                                                        }
                                                                        else if(procurement_type==3){
                                                                          $('#lb_completion_date').text("Contract Expiration Date")
                                                                        }else{
                                                                          $('#lb_completion_date').text("Actual date of Contract Completion")
                                                                        }

                                                                        console.log(procurement_type)

                                                                        var url =  " {{ url('ajax/get_unit_by_type_id') }}"+'/'+procurement_type;
                                                                        console.log(procurement_type)
                                                                        $.ajax({
                                                                          method:'POST',
                                                                          url: url,
                                                                          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                                                          success: (data)=>{
                                                                            show_unit(data.data.unit)
                                                                            show_procurement_method(data.data.method)
                                                                            show_source_of_fund(data.data.source)
                                                                          },
                                                                          error: function(data){
                                                                            
                                                                          }
                                                                        });

                                                                      });

                                                                      function show_unit(data){
                                                                          var html=''
                                                                          $.each(data,function(key,value){
                                                                            html+=`<option value= "${value.id}"> ${value.name_en}</option>`
                                                                          });
                                                                        $('#unit').html(html);
                                                                      }

                                                                      function show_procurement_method(data){
                                                                          var html='<option value=0> Select procurement method </option>'
                                                                          $.each(data,function(key,value){
                                                                            html+=`<option value= "${value.id}"> ${value.name_en}</option>`
                                                                          });
                                                                        $('#procurement_method').html(html);
                                                                      }

                                                                      function show_source_of_fund(data) {
                                                                            var html = '<optgroup label=" Select source of fund" >'
                                                                            $.each(data, function(key, value) {
                                                                                html += `<option value= "${value.id}"> ${value.name_en}</option>`
                                                                            });
                                                                            html += "</optgroup>"
                                                                            $('#source_of_fund_id').html(html);
                                                                        }

                                                                      
                                                                      var file_count=$("#file_size").val();
                                                                      $('body').on('click', '#add_file', function () {
                                                                        file_count++;
                                                                        console.log(file_count+" ");
                                                                        var html=` <div class="my-3 form-group row">
                                                                                  <label for="inputPassword" class="col-sm-1 col-form-label">File Title </label>
                                                                                  <input type="text" name="file_title_${file_count}" class="mr-2 form-control col-sm-4 "/>
                                                                                  <div class="col-sm-6">
                                                                                    <div class="row input-group ">
                                                                                      <div class="col-sm-6 custom-file">
                                                                                        <input type="file" class="custom-file-input" name="file_${file_count}" onclick="change_file(${file_count})"  id="file_${file_count}"/>
                                                                                        <label class=" custom-file-label"  for="inputGroupFile02" aria-describedby="inputGroupFileAddon02"  >Choose
                                                                                        file</label>
                                                                                      </div>
                                                                                      <div class="col-sm-5" id="file_preview_container_${file_count}"><p>File Name  </p></div>
                                                                                    </div>
                                                                                  </div>
                                                                                  <a href="javascript:void(0)"  class="pull-right btn btn-outline-danger delete btn-xs"  id="delete_image"> X </a>
                                                                                </div>`
                                                                        $('#file_group').append(html);
                                                                          
                                                                      });

                                                                      $("#file_group").on('click', '.delete', function () {
                                                                        console.log("delete");
                                                                        $(this).parent().remove(); 
                                                                      });

                                                                    });

                                                                    function change_file(file_id){
                                                                        console.log('preview file start'+file_id)
                                                                        $('#file_'+file_id).change(function(e){
                                                                            console.log(this.files[0].name)
                                                                            html=`<p> ${this.files[0].name}</p>`
                                                                            $('#file_preview_container_'+file_id).html(html)
                                                                        });
                                                                    }
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

                                                                      var cleave = new Cleave('.taka2', {
                                                                      numeral: true,
                                                                      numeralThousandsGroupStyle: 'thousand'
                                                                      });

                                                                      var cleave = new Cleave('.taka3', {
                                                                      numeral: true,
                                                                      numeralThousandsGroupStyle: 'thousand'
                                                                      });
                                                                      var cleave = new Cleave('.taka4', {
                                                                      numeral: true,
                                                                      numeralThousandsGroupStyle: 'thousand'
                                                                      });

                                                                      var cleave = new Cleave('.taka5', {
                                                                      numeral: true,
                                                                      numeralThousandsGroupStyle: 'thousand'
                                                                      });

</script>



@endpush