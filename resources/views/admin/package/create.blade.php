@extends('layouts.master')
@section('content')
<div class="sub-head header header2">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
                <div class="procurement-title">
                    <h5 class="d-inline">
                        <img src="{{ custom_asset('assets/images/icons/fecal.png') }}" alt="" />Create Package
                    </h5>
                </div>
            </div>
            {{-- <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <a class="active btn sub-btn float-right" href="{{ route('package.create') }}"><i
                class="fa fa-plus">
            </i> Add Package</a>
            <a class=" btn sub-btn float-right" href="{{ url('package_settings') }}"><i class="fa fa-cogs"> </i>
                Package Settings</a>
        </div> --}}
    </div>
</div>
</div>
<div class="main-content form-component mt-4 ">

    <div class="container">
        @include('sweetalert::alert')
        <div class="card mb-4 card-design">
            <div class="card-body">
                <div class="card-title bg-primary text-white">
                    <h5>Create Package</h5>
                </div>
                <form action="{{ route('package.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="package_no">Package Number <span class="mendatory">*</span> </label>
                                <input type="text" name="package_no" value="{{ old('package_no') }}"
                                    class="form-control form-control-sm" required />
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="component_name_en">Package Name <span class="mendatory">*</span> </label>
                                <input type="text" name="name_en" value="{{ old('name_en') }}"
                                    class="form-control form-control-sm" id="component_name_en" required />
                            </div>
                        </div>

                        {{-- <div class="col-4">
                                <div class="form-group">
                                    <label for="component_name_bn">Package Name in (Bangla)
                                    </label>
                                    <input type="text" name="name_bn" value="{{ old('name_bn') }}"
                        class="form-control form-control-sm" />
                    </div>
            </div> --}}

            <div class="col-4">
                <div class="form-group">
                    <label for="Type_Id">Procurement Type <span class="mendatory">*</span> </label>
                    <select name="type_id" class="form-control form-control-sm select2 custom-select2"
                        id="procurement_type">
                        <optgroup label="  ">
                            <option value="">Select Procurement Type</option>
                            @foreach ($type_id as $item)
                            <option value="{{ $item->id }}">{{ $item->name_en }}</option>
                            @endforeach
                        </optgroup>
                    </select>
                </div>
            </div>

            <div class="col-4">
                <div class="form-group">
                    <label for="exampleInputEmail1">DPP Head</label>
                    <input type="text" name="dpp_head" value="{{ old('dpp_head') }}"
                        class="form-control form-control-sm" />
                </div>
            </div>
            {{-- <div class="col-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Economic Code</label>
                                    <input type="text" name="economic_head" value="{{ old('economic_head') }}"
            class="form-control form-control-sm" />
        </div>
    </div> --}}

    <div class="col-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Unit</label>
            <select class="form-control form-control-sm select2 custom-select2" name="unit_id" id="unit">
                <option value="">Select Unit</option>
                {{-- @foreach ($unit_id as $item)
                                            <option value="{{ $item->id }}">{{ $item->name_en }}</option>
                @endforeach --}}
            </select>
        </div>
    </div>

    <div class="col-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Quantity <span class="mendatory">*</span> </label>
            <input type="text" name="quantity" required value="{{ old('quantity') }}"
                class="form-control form-control-sm" />
        </div>
    </div>

    <div class="col-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Procurement Method</label>
            <select class="form-control form-control-sm select2 custom-select2" name="proc_method_id"
                id="procurement_method">
                <option value="">Select Procurement Method</option>
                {{-- @foreach ($proc_method_id as $item)
                                            <option value="{{ $item->id }}">{{ $item->name_en }}</option>
                @endforeach --}}
            </select>
        </div>
    </div>

    <div class="col-4">
        <label for="">Review Type</label>
        {!! Form::select('review', ['1' => 'Post Review ', '0' => 'Prior Review'], old('review'),
        ['class' => 'form-control select2 custom-select2', 'id' => 'status', 'required' =>
        'required']) !!}
    </div>

    <div class="col-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Contract Approving Authority</label>
            <select name="approving_authority_id" class="form-control form-control-sm select2 custom-select2">
                <optgroup label=" Select Approving Authority ">
                    @foreach ($approving_authority_id as $item)
                    <option value="{{ $item->id }}">{{ $item->name_en }}</option>
                    @endforeach
                </optgroup>
            </select>
        </div>
    </div>

    <div class="col-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Source of Fund</label>
            <select name="source_of_fund_id[]" id="source_of_fund_id"
                class="form-control form-control-sm select2 custom-select2 " multiple="multiple">

                @foreach ($source_of_fund_id as $item)
                <option value="{{ $item->id }}">{{ $item->name_en }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- <div class="col-4">
                                <label for="">Budget as per DPP (BDT) </label>
                                <div class="form-group">
                                    <input name="dpp_cost" id="" class="form-control" cols="30" rows="2"></input>
                                </div>
                            </div> --}}

    <div class="col-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Budget Provision as per DPP(BDT) <span class="mendatory">*</span> </label>
            <input type="text" id="budget_dpp" name="cost_tk_act" value="{{ old('cost_tk_act') }}"
                class="taka form-control form-control-sm" required />
        </div>
    </div>

    <div class="col-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Estimated Cost ( USD) </label>
            <input type="text" id="budget_dpp_usd" name="cost_usd_est" readonly="" value="{{ old('cost_usd_est') }}"
                class="taka4 form-control form-control-sm" required />
        </div>
    </div>


    <div class="col-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Official Estimated Cost (BDT) </label>
            <input type="text" id="official_cost" name="cost_tk_est" value="{{ old('cost_tk_est') }}"
                class="taka1 form-control form-control-sm" />
        </div>
    </div>


    <div class="col-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Official Estimated Cost (USD) </label>
            <input type="text" id="official_cost_usd" class="taka5 form-control form-control-sm" readonly=""
                name="cost_usd_act" value="{{ old('cost_usd_act') }}" />
        </div>
    </div>

    <div class="seperate"> Necessary Date </div>

    <div class="col-12">
        <div class="row" id="input_group">
            @include('admin.package.common_group')
        </div>
    </div>



    <?------------Star New_Input--------------?>
    <div class="seperate"> Contract </div>

    <div class="col-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Actual Contract Price (BDT)</label>
            <input type="text" name="contract_price_act_bdt" value="{{ old('contract_price_act_bdt') }}" id="bdt_3"
                class="taka2 form-control form-control-sm" />
        </div>
    </div>

    <div class="col-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Actual Contract Price (USD) </label>
            <input type="text" name="contract_price_act_usd" value="{{ old('contract_price_act_usd') }}" id="usd_3"
                class="taka3 form-control form-control-sm" readonly />
        </div>
    </div>

    <div class="col-4">
    </div>

    <div class="col-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Actual date of Contract Signing </label>
            <div class="input-group datepicker-box">
                <input name="signing_of_contact_act" value="{{ old('signing_of_contact_act') }}"
                    class="form-control datepicker w-100" type="text" placeholder="YY-MM-DD"
                    id="signing_of_contact_act" />
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
            <label for="exampleInputEmail1" id="lb_completion_date">Actual date of Contract Completion</label>
            <div class="input-group datepicker-box">
                <input name="complition_of_contact_act" value="{{ old('complition_of_contact_act') }}"
                    class="form-control datepicker w-100" type="text" placeholder="YY-MM-DD" id="completion_date" />
            </div>
        </div>
    </div>

    <div class="col-4">
        <div class="form-group">
            <label for="source_of_fund_name_bn">Name of Contractor / supplier/ Consultant </label>
            {!! Form::select('contactors[]', \App\Contactor::pluck('name_en', 'id'), old('contactors',
            isset($package_progress[0]->contactors) ? json_decode($package_progress[0]->contactors) : null), ['multiple'
            => 'multiple', 'class' => 'form-control custom-select select2 full-width', 'data-init-plugin' => 'select2',
            'id' => '']) !!}
        </div>
    </div>
    <?------------End New_Input--------------?>

    <?------------Star second  New_Input--------------?>
    <div class="seperate"> Extension </div>

    <div class="col-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Days</label>
            <input type="number" name="extension_day_count" id="extension_day_count"
                class="form-control form-control-sm" />
        </div>
    </div>

    <div class="col-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Actual Date</label>
            <div class="input-group datepicker-box">
                <input name="extension_date_act" value="{{ old('extension_date_act') }}"
                    class="form-control datepicker w-100" type="text" placeholder="YY-MM-DD" id="extension_date_act" />
            </div>
        </div>
    </div>
    <?------------end second  New_Input--------------?>

    <div class="seperate"> Contract Agreement Document </div>
    <div class="col-12">
        <div class="row">
            <div class="col-4">
                <div class="form-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="agreement_1" onclick="change_file(50)"
                            id="file_50" />
                        <label class=" custom-file-label" for="inputGroupFile02"
                            aria-describedby="inputGroupFileAddon02">Choose
                            file</label>
                    </div>
                </div>
            </div>
            <div class="col-4" id="file_preview_container_50">
                <p>File Name </p>
            </div>
        </div>
    </div>


    <div class=" d-none seperate hide"> Contruct Management </div>

    <div class="d-none col-4 hide">
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
            old('assigned'),
            ['multiple' => 'multiple', 'class' => 'form-control custom-select select2 full-width', 'data-init-plugin' =>
            'select2', 'id' => '']
            ) !!}
        </div>
    </div>

    <div class=" d-none seperate hide"> Remark</div>
    <textarea name="remark" class="d-none hide form-control w-100 mb-2" id="" cols="30" rows="4"></textarea>

    <div class="d-none hide seperate"> Necessary File
        <div class="pull-right">
            <a href="javascript:void(0)" class="btn btn-outline-success fa fa-plus" id="add_file"></a>
        </div>
    </div>

</div>


<div class="d-none hide" id="file_group">
    <div class="my-3 form-group row">
        <label for="inputPassword" class="col-sm-1 col-form-label">File Title </label>
        <input type="text" name="file_title_1" class="mr-2 form-control col-sm-4 " />

        <div class="col-sm-6">
            <div class="row input-group ">
                <div class="col-sm-6 custom-file">
                    <input type="file" class="custom-file-input" name="file_1" onclick="change_file(1)" id="file_1" />
                    <label class="custom-file-label" for="inputGroupFile02"
                        aria-describedby="inputGroupFileAddon02">Choose
                        file</label>
                </div>
                <div class="col-sm-5" id="file_preview_container_1">
                    <p>File Name </p>
                </div>
            </div>
        </div>
        <a href="javascript:void(0)" class="pull-right btn btn-outline-danger delete btn-xs" id="delete_image"> X </a>
    </div>
</div>

<div class="text-right">
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
    $(document).ready(function() {

                            // $('.discount').keyup(function(){
                            //   console.log("hello")
                            //   var n = parseInt($(this).val().replace(/\D/g,''),10);
                            //   $(this).val(n.toLocaleString());

                            // });official_cost

                            $('#budget_dpp').keyup(function() {
                                var budget_tk = $(this).val();
                                budget_tk = budget_tk.replace(",", '');
                                budget_tk = budget_tk.replace(",", '');
                                budget_tk = budget_tk.replace(",", '');
                                budget_tk = budget_tk.replace(",", '');
                                budget_tk = budget_tk.replace(",", '');
                                budget_tk = budget_tk.replace(",", '');
                                budget_tk = parseInt(budget_tk, 10);
                                var convert_usd = (budget_tk / 84.84)

                                if(isNaN(convert_usd)){
                                    budget_dpp_usd.value = 0;
                                }else{
                                    budget_dpp_usd.value = convert_usd.toFixed(2);
                                }

                            });

                            $('#official_cost').keyup(function() {
                                var budget_tk = $(this).val();
                                budget_tk = budget_tk.replace(",", '');
                                budget_tk = budget_tk.replace(",", '');
                                budget_tk = budget_tk.replace(",", '');
                                budget_tk = budget_tk.replace(",", '');
                                budget_tk = budget_tk.replace(",", '');
                                budget_tk = budget_tk.replace(",", '');
                                budget_tk = parseInt(budget_tk, 10);

                                var convert_usd = (budget_tk / 84.84)
                                
                                if(isNaN(convert_usd)){
                                    official_cost_usd.value = 0;
                                }else{
                                    official_cost_usd.value = convert_usd.toFixed(2);
                                }

                            });

                            $('#bdt_3').keyup(function() {
                                console.log('typing')
                                var budget_tk = $(this).val();
                                budget_tk = budget_tk.replace(",", '');
                                budget_tk = budget_tk.replace(",", '');
                                budget_tk = budget_tk.replace(",", '');
                                budget_tk = budget_tk.replace(",", '');
                                budget_tk = budget_tk.replace(",", '');
                                budget_tk = budget_tk.replace(",", '');
                                budget_tk = parseInt(budget_tk, 10);
                                
                                var convert_usd = (budget_tk / 84.84)
                                
                                if(isNaN(convert_usd)){
                                    usd_3.value = 0;
                                }else{
                                    usd_3.value = convert_usd.toFixed(2);
                                }
                            
                            });

                            $('#procurement_method').change(function() {

                                var procurement_type = $('#procurement_type').val()
                                var procurement_method = $('#procurement_method').val()

                                console.log(procurement_type + " " + procurement_method)

                                var url = " {{ url('ajax/get_group_input_field_by_type_id') }}";
                                $.ajax({
                                    method: 'GET',
                                    url: url,
                                    data: {
                                        'type_id': procurement_type,
                                        'method_id': procurement_method
                                    },
                                    dataType: 'JSON',
                                    // headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    success: function(data) {
                                        console.log(data)
                                    },
                                    error: function(data) {

                                        console.log("error")
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


                            $('body').on('click', '#day_count', function() {
                                $("#day_count").keyup(function() {
                                    var day = $("#day_count").val()
                                    var date1 = $("#signing_of_contact_act").val()
                                    //console.log(date1)
                                    var date = new Date(date1);
                                    day = parseInt(day)
                                    //console.log(day)
                                    var d = date.getDate() + day
                                    date.setDate(d);
                                    date2 = date.toISOString()
                                    date2 = date2.split('T')
                                    //console.log(date2[0])
                                    $("#completion_date").val(date2[0])
                                })
                            });

                            $('body').on('click', '#extension_day_count', function() {
                                $("#extension_day_count").keyup(function() {
                                    var day = $("#extension_day_count").val()
                                    var date1 = $("#completion_date").val()
                                    console.log(date1)
                                    var date = new Date(date1);
                                    day = parseInt(day)
                                    console.log(day)
                                    var d = date.getDate() + day
                                    date.setDate(d);
                                    date2 = date.toISOString()
                                    date2 = date2.split('T')
                                    console.log(date2[0])
                                    $("#extension_date_act").val(date2[0])
                                })
                            });


                            $('#procurement_type').change(function() {
                                console.log('get indicator list')
                                var procurement_type = $('#procurement_type').val()
                                if (procurement_type == 1) {
                                    $('#lb_completion_date').text("Delivery Completion Date")
                                } else if (procurement_type == 2) {
                                    $('#lb_completion_date').text("Intended Completion Date")
                                } else if (procurement_type == 3) {
                                    $('#lb_completion_date').text("Contract Expiration Date")
                                } else {
                                    $('#lb_completion_date').text("Actual date of Contract Completion")
                                }

                                if(procurement_type == 1 || procurement_type == 2){
                                    $(".hide").removeClass('d-none');
                                    $(".select2").select2();
                                }else{
                                    $(".hide").addClass('d-none');
                                }


                                var url = " {{ url('ajax/get_unit_by_type_id') }}" + '/' + procurement_type;
                                console.log(procurement_type)
                                $.ajax({
                                    method: 'POST',
                                    url: url,
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    success: (data) => {
                                        show_unit(data.data.unit)
                                        //source_of_fund_id
                                        show_procurement_method(data.data.method)
                                        show_source_of_fund(data.data.source)
                                    },
                                    error: function(data) {

                                    }
                                });

                            });

                            function show_unit(data) {
                                var html = '<optgroup label=" Select Unit ">'
                                $.each(data, function(key, value) {
                                    html += `<option value= "${value.id}"> ${value.name_en}</option>`
                                });
                                html += '</optgroup>'
                                $('#unit').html(html);
                            }

                            function show_procurement_method(data) {
                                var html = '<option value="" > Select procurement method</option>'
                                $.each(data, function(key, value) {
                                    html += `<option value= "${value.id}"> ${value.name_en}</option>`
                                });
                                html += "</optgroup>"
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

                            var file_count = 1;
                            $('body').on('click', '#add_file', function() {
                                file_count++;
                                console.log(file_count + " ");
                                var html =
                                    ` <div class="my-3 form-group row">
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

                            $("#file_group").on('click', '.delete', function() {
                                console.log("delete");
                                $(this).parent().remove();
                            });

                        });

                        function change_file(file_id) {
                            console.log('preview file start' + file_id)
                            $('#file_' + file_id).change(function(e) {
                                console.log(this.files[0].name)
                                html = `<p> ${this.files[0].name}</p>`
                                $('#file_preview_container_' + file_id).html(html)
                            });
                        }

</script>

<script>
    var cleave = new Cleave('.taka', {
                            numeral: true,
                            numeralThousandsGroupStyle: 'lakh'
                        });

                        var cleave = new Cleave('.taka1', {
                            numeral: true,
                            numeralThousandsGroupStyle: 'lakh'
                        });

                        var cleave = new Cleave('.taka2', {
                            numeral: true,
                            numeralThousandsGroupStyle: 'lakh'
                        });

                        var cleave = new Cleave('.taka3', {
                            numeral: true,
                            numeralThousandsGroupStyle: 'lakh'
                        });
                        var cleave = new Cleave('.taka4', {
                            numeral: true,
                            numeralThousandsGroupStyle: 'lakh'
                        });

                        var cleave = new Cleave('.taka5', {
                            numeral: true,
                            numeralThousandsGroupStyle: 'lakh'
                        });

</script>
@endpush