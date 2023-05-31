<div class="package-table card card-body payment-box-2">
    <h5 class="box-title">Payment</h5>
    <div class="table-responsive">
        <table class="table table-bordered table-striped" id="payment_data">
            
            
        </table>
    </div>

    <div class="pay-box mt-5">
        <form class="forms-sample" id="payment_form" action="javascript:void(0)">
         
            <input name="package_id" id="package_id" hidden/>
            <div class="form-group">
                <label for="amount">Contractor</label>
                <select name="contactor_id" id="contractor" class="form-control form-control-sm select2 custom-select2">
                  
                </select>
            </div>
              
            <div class="form-group">
                <label for="amount">Bill Amount (BDT)</label>
                <input name="amount"  class="form-control reset" type="text"  />
            </div>
            

            <div class="form-group">
                <label for="date">Date</label>
                <div class="input-group datepicker-box">
                   <input name="date"  class="form-control datepicker w-100 reset" type="text" placeholder="YY-MM-DD" />         
                </div> 
            </div>

            <div class="form-group">
                <label for="details">Details</label>
                <textarea name="details" id="" cols="30" class="form-control reset" rows="4"></textarea>
            </div>
         
            
            <button class="btn btn-primary" type="submit" onclick="store()">Create</button>
        </form>
    </div>
</div>

@push('script')
<script>

function get_payment_data(id){
    
    console.log("get paymetnt data")
    var url = "{{ url('payment') }}"+'/'+id;
    $.ajax({
        method:'get',
        url: url,
        dataType:'JSON',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: (data)=>{
          console.log('hafiz'+data);
          show_payment_data(data.data)
           
        },
        error: function(data){

        }
    });
}

function store(){
    var data=$('#payment_form').serialize();
    var component_id=$("#package_id").val()
    console.log(data)
    var url = "{{ url('payment') }}";
    $.ajax({
        method:'POST',
        url: url,
        data: data,
        dataType:'JSON',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: (data)=>{
          console.log(data);
          get_payment_data(component_id)
          $(".reset").val(null)
 
        },
        error: function(data){

        }
    }); 
}

function show_payment_data(data){
    var html=`<thead>
                <tr>
                    <td class="text-left">Date</td>
                    <td class="text-left">Amount</td>
                    <td class="text-left">Concern Person</td>
                </tr>
            </thead>`

      $.each(data,function(key,value){
        //console.log(value.name_en)
        html+=`<tbody>
                <tr>
                    <td>${value.date}</td>
                    <td>${value.amount}</td>
                    <td>${value.details}</td>
                </tr>
                
            </tbody>`

      });
    $('#payment_data').html(html);
}
</script>  
@endpush