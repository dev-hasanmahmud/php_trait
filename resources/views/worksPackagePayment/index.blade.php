@extends('layouts.master')
@section('content')
<div class="main-content inner-page-content mt-4 ">
    <div class="container">

        <section class="payment">
            <div class="title">
                <div class="row">
                    <div class="col-3">
                        <h4 for="">Packages</h4>
                    </div>
                    <div class="col-4">
                        <select name="component_id" id="component" class="form-control select2 custom-select2">
                            @foreach ($component as $item)
                            <option value="{{ $item->id }}">{{ $item->name_en }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="package-table card card-body payment-box-1">
                <h5 class="box-title">Progress</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="progress">
                    </table>
                </div>
            </div>
            @include('worksPackagePayment.payment')
        </section>
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
    var url =  " {{ url('ajax/package_working_progrss/get_indicator') }}"+'/'+component_id;
    console.log(component_id)
    $.ajax({
      method:'POST',
      url: url,
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      success: (data)=>{
        show_indicator(data.data.indicator)
        get_payment_data(component_id)
        show_contractor(data.data.contractor)
        //console.log(data.data.contractor);        
      },
      error: function(data){

      }
    });
  }); 

  function show_indicator(data){
    //console.log(data);   
    var html=''
    var sum_progress=0;
    var count=0;
    $.each(data,function(key,value){
        //console.log(value.name_en)
        count++;
        if(value.progress_value===null) value.progress_value=0;

        html+=`<tbody>
                    <tr>
                        <td width="20%" >${value.name_en }</td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: ${value.progress_value}%;"
                                    aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                    ${value.progress_value}%
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>`
        sum_progress+=value.progress_value;
    });
    var total_progress=Math.round(sum_progress/count)
    html+=`<tfoot>
                <tr>
                    <td>Total Progress</td>
                    <td>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: ${total_progress}%;"
                                aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">
                                ${total_progress}%
                            </div>
                        </div>
                    </td>
                </tr>
            </tfoot>`
    $('#progress').html(html);

  }

  function show_contractor(data){
    //console.log(data);   
      var html=''
      $.each(data,function(key,value){
        //console.log(value.name_en)
        html+=`<option value= "${value.id}"> ${value.name_en}</option>`

      });
    $('#contractor').html(html);
  }

}); 
 
                       
 
</script>
    
@endpush