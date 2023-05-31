@extends('layouts.master')
@section('content')

    <div class="sub-head header header2">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
                    <div class="procurement-title">
                        <h5 class="d-inline">
                            <img src="{{ custom_asset('assets/images/icons/fecal.png') }}" alt="" /> Show Package
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
                        <h5>Show Component</h5>
                    </div>
                    <form>
                        <div class="row show_package_box">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Package Number</label>
                                    <h4>{{ $component->package_no }}</h4>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="component_name_en">Package Name</label>
                                    <h4>{{ $component->name_en }}</h4>
                                </div>
                            </div>

                            {{-- <div class="col-4">
                                <div class="form-group">
                                    <label for="component_name_bn">Component Name in English
                                    </label>
                                    <h4>{{ $component->name_en }}</h4>
                                </div>
                            </div> --}}

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="Type_Id">Procurement Type </label>
                                    <h4>{{ isset($component->type->name_en) ? $component->type->name_en : '-' }}</h4>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">DPP Head</label>
                                    <h4>{{ $component->dpp_head }}</h4>
                                </div>
                            </div>

                            {{-- <div class="col-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Economic Code</label>
                                    <h4>{{ $component->economic_head }}</h4>
                                </div>
                            </div> --}}

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Unit</label>
                                    <h4>{{ $component->unit->name_en }}</h4>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Quantity</label>
                                    <h4>{{ $component->quantity }}</h4>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Procurement Method</label>
                                    <h4>{{ isset($component->proc_method->name_en) ? $component->proc_method->name_en : '-' }}
                                    </h4>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="">Review Type</label>
                                    <h4>{{ $component->review }}</h4>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Contract Approving Authority</label>
                                    <h4> {{ isset($component->approving_authority->name_en) ? $component->approving_authority->name_en : '-' }}
                                    </h4>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Source of Fund</label>
                                    @foreach ($source as $item)
                                        <h4>{{ $item->name_en }}</h4>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Budget Provision as per DPP (BDT) </label>
                                    <h4>{{ number_format(convert_to_lakh($component->cost_tk_act), 2, '.', ',') }} Lakh</h4>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Estimated Cost ( USD)</label>
                                    <h4>{{ number_format($component->cost_usd_est) }} </h4>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Official Estimated Cost (BDT) </label>
                                    <h4>{{ number_format(convert_to_lakh($component->cost_tk_est), 2, '.', ',') }} Lakh</h4>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Official Estimated Cost (USD)</label>
                                    <h4>{{ number_format($component->cost_usd_act, 2, '.', ',') }}</h4>
                                </div>
                            </div>

                            <div class="seperate"> Necessary Date </div>

                            <div class="col-12">
                                <div class="row" id="input_group">
                                    @if ($data == null)
                                        @include('admin.package.show_common_group')
                                    @else
                                        @php
                                        $data = json_decode($data['value']);
                                        @endphp
                                        @foreach ($lavel as $item)
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">{{ $item->label_name }}</label>
                                                    <h4>{{ isset($data[$loop->index])?$data[$loop->index]:null }}</h4>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif

                                </div>
                            </div>
                            <?------------Star New_Input----------------?>
                        <div class="seperate">  Contract </div>
                        <div class="col-4">
                          <div class="form-group">
                            <label for="exampleInputEmail1">Actual Contract Price (BDT)</label>
                            <h4>{{ number_format(convert_to_lakh($component->contract_price_act_bdt), 2, '.', ',') }} Lakh</h4>
                          </div>
                        </div>

                        <div class="col-4">
                          <div class="form-group">
                            <label for="exampleInputEmail1">Actual Contract Price (USD) </label>
                            <h4>{{ number_format($component->contract_price_act_usd, 2, '.', ',') }} </h4>
                          </div>
                        </div>

                        <div class="col-4">
                        </div>

                        <div class="col-4">
                          <div class="form-group">
                            <label for="exampleInputEmail1">Actual date of Contract Signing  </label>
                            <h4 id="signing_of_contact_act">{{ $component->signing_of_contact_act }}</h4>
                          </div>
                        </div>
                        @php
                          $date1 = strtotime($component->complition_of_contact_act);
                          $date2 = strtotime($component->signing_of_contact_act);  
                          $diff = abs($date1  - $date2);
                        @endphp
                        <div class="col-4">
                          <div class="form-group">
                            <label for="exampleInputEmail1">Days/Count for the actual completion date</label>
                            <h4 id="day_count" >{{ $diff / (60 * 60 * 24) }}</h4>
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
                            <h4 id="completion_date">{{ $component->complition_of_contact_act }}</h4>
                          </div>
                        </div>

                        <div class="col-4">
                          <div class="form-group">
                            <label for="source_of_fund_name_bn">Contractors / Suplier / Consultent</label>
                            <h4>
                @foreach ($contractor as $item)
                                {{ $item->name_en }}
                             @endforeach
               </h4>
                          </div>
                        </div>

                        <div class="seperate">  Extension </div>

                        <div class="col-4">
                          <div class="form-group">
                            <label for="exampleInputEmail1">Days</label>
                            <h4 id="completion_date">{{ $component->extension_day_count }}</h4>
                          </div>
                        </div>

                        <div class="col-4">
                          <div class="form-group">
                            <label for="exampleInputEmail1">Actual Date</label>
                            <h4 id="completion_date">{{ $component->extension_date_act }}</h4>
                          </div>
                        </div>

                        <div class="seperate">  Contract Agreement Document </div>

                        
                            <div class="col-4">
                <div class="form-group">
                              <label for="source_of_fund_name_bn">Document Name </label>
                              <h4>
                @if ($agreement_file != null)
                                @php
                                $fileName = explode('-.-',$agreement_file[0]->file_path);
                                @endphp
                                <a href="{{ $agreement_file[0]->file_path }}">{{ $fileName[1] }} </a> 
                              @endif
                </h4>
                               </div>
                            </div>
                          

                        <?-----------End New_input------------------?>
                        <div class="seperate"> Contruct Management </div>

                        <div class="col-4">
                          <div class="form-group">
                            <label for="source_of_fund_name_bn">Assigned Firm/Consultant </label>
                            <h4>
                              @foreach ($assigned as $item)
                                {{ $item->name_en }}
                              @endforeach
                </h4>
                          </div>
                        </div>

                        <div class="seperate"> Necessary File </div>
                      <div class="col-12">
                        <div class="row">
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

                          <div class="col-4" id="file_group">
               <div class="form-group">
                              <label for="inputPassword" class="">File Title </label>
                              <h4>{{ $item->name }}</h4> 
                           </div>
               </div>

                          <div class="col-4" id="file_group">
                <div class="form-group">
                            <label for="inputPassword" class="">File Name </label>
                            <h4> <a href="{{ $item->file_path }}">{{ $fileName[1] }} </a></h4> 
                </div>
               </div>
                          @endforeach
                        </div>
                      </div>

                      <div class="seperate"> Remarks </div>
                      <div class="form-group">
                      <label for="exampleInputEmail1" class="c-width-remark">Reamk details</label>
                        <h4 class="c-width-remark-h4" >{{ $component->remark }}</h4>
                      </div>

                      <div class="seperate"> Payment Details </div>
                      <div class="col-4">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Total Payment (BDT)</label>
                          <h4>{{ number_format(convert_to_lakh($payment[0]->total), 2, '.', ',') }} Lakh</h4>
                        </div>
                      </div>

                      <div class="col-4">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Remaining Payment (BDT) </label>
                          <h4>{{ number_format(convert_to_lakh($component->contract_price_act_bdt - $payment[0]->total), 2, '.', ',') }} Lakh</h4>
                        </div>
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
              
              /*Initialize javascript */
                var d1 = $("#signing_of_contact_act").val()
                var d2 = $("#completion_date").val()
                console.log("INIT "+d1);
                var d1 = new Date(d1); 
                var d2 = new Date(d2); 
                const diffTime = Math.abs(d2 - d1);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
                $("#day_count").val(diffDays)
              
              /*end this section javascript */
              });
              
              
              
              
              number_format = function (number, decimals, dec_point, thousands_sep) {
                    number = number.toFixed(decimals);

                    var nstr = number.toString();
                    nstr += '';
                    x = nstr.split('.');
                    x1 = x[0];
                    x2 = x.length > 1 ? dec_point + x[1] : '';
                    var rgx = /(\d+)(\d{3})/;

                    while (rgx.test(x1))
                        x1 = x1.replace(rgx, '$1' + thousands_sep + '$2');

                    return x1 + x2;
                }
            </script>
@endpush
