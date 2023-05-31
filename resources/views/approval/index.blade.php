@extends('layouts.master')
@section('content')

<div class="sub-head header header2">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
        <div class="procurement-title">
          <h5 class="d-inline">
            <img src="{{ custom_asset('assets/images/icons/fecal.png') }}" alt="" /> Package
          </h5>                
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        <a class=" btn sub-btn float-right" href="{{route("package.create")}}"><i class="fa fa-plus"> </i> Add Package</a>
        <a class=" btn sub-btn float-right" href="{{url("package_settings")}}"><i class="fa fa-cogs"> </i> Package Settings</a>
      </div>
    </div>
  </div>
</div>   

<div class="main-content form-component mt-4 ">
  <div class="container">
    @include('sweetalert::alert')

    <section class="package-table card card-body">
       <form  method="GET" action="{{ url('approval/') }}"  >
      
      <div class="form-row mb-2 row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
          <select name="component_id" class="form-control form-control-sm select2 custom-select2" id="component_id">
            <optgroup>
              @foreach ($component as $item)
                <option value="{{ $item->id }}"
                    @if ($item->id==$search[0])
                        {{'selected= "selected" '}}
                    @endif
                >{{ $item->package_no." - ".$item->name_en}}
              </option>
              @endforeach
            </optgroup>
          </select>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
          
            {{-- <optgroup>
              <option value="0" >Pending</option>
              <option value="1">Approved</option>
              <option value="2">Disaproved</option>
            </optgroup> --}}
            {!! Form::select('status',['0'=>"Pending",'1'=>'Approved','2'=>'Disaproved'], old('area_of_activities',$search[1]), [  'class' => 'form-control form-control-sm select2', 'data-init-plugin'=>'select2', 'id' => 'status']) !!}
         
        </div>
		<div class="col-xs-12 col-sm-12 col-md-1 col-lg-1">
        <button type="submit" class="btn btn-lg w-100 btn-info ">Find</button>
		</div>
      </div>
    </form>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <td width="5%" class="text-center">Id</td>
                    <td width="20%" class="text-left">Package Name</td>
                    <td width="15%" class="text-left">Indicator Name</td>
                    <td width="10%">Progress Value</td>
                    <td width="10%">Achievement Quantity</td>
                    <td width="10%">Date</td>
                    <td width="10%">Data Added By</td>
                    <td width="20%">Action</td>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($indicator_data as $item)
                    <tr>
                      <td class="text-center" >{{ $loop->index+$indicator_data->firstItem() }}</td>
                        @if ($is_filter)
                            <td class="text-left" >{{$item->package_no.'-'.$item->package}}</td>
                            <td class="text-left" >{{$item->indicator_name}}</td>
                            <td>{{$item->progress_value}}</td>
                            <td>{{$item->achievement_quantity}}</td>
                            <td>{{$item->date}}</td>
                            <td>{{$item->user}}</td>
                        @else
                            <td class="text-left" >{{isset($item->component->name_en)?$item->component->package_no.'-'.$item->component->name_en:null}}</td>
                            <td class="text-left" >{{isset($item->indicator->name_en)?$item->indicator->name_en:null}}</td>
                            <td>{{$item->progress_value}}</td>
                            <td>{{$item->achievement_quantity}}</td>
                            <td>{{$item->date}}</td>
                            <td>{{isset($item->data_add_user->name)?$item->data_add_user->name:null}}</td>
                        @endif
                    <td>
                    {{-- <a href="javascript:void(0)" id="approve" data-id="{{ $item->id }}"  class="btn btn-warning btn-xs @if($item->is_approve ==1) disabled @endif" title="Approve" >Approve</a>
                    <a href="javascript:void(0)" id="dis-approve" data-id="{{ $item->id }}"  class="btn btn-danger btn-xs  @if($item->is_approve ==2) disabled @endif" title="Disapprove" >Disapprove</a> --}}

                    @if( Auth::user()->role == 1 || Auth::user()->role == 6 )
                    <a href="javascript:void(0)" id="approve" data-id="{{ $item->id }}"  class="btn btn-warning btn-xs @if($item->is_approve ==1) disabled @endif" title="Recommend" >Recommend</a>
                  @else
                  <a href="javascript:void(0)" id="approve" data-id="{{ $item->id }}"  class="btn btn-warning btn-xs @if($item->is_approve ==1) disabled @endif" title="Approve" >Approve</a>
                  <a href="javascript:void(0)" id="dis-approve" data-id="{{ $item->id }}"  class="btn btn-danger btn-xs  @if($item->is_approve ==2) disabled @endif" title="Disapprove" >Disapprove</a>
                  @endif

                  </td>
                  </tr>
                @endforeach


            </tbody>
          </table>
          {{-- <div class="text-center">{{ $indicator_data->links() }}</div> --}}
          @include('approval.data_pagination')
        </div>
      </section>
  </div>  
</div>
@endsection


@push('script')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
$(document).ready(function () {
   
    $('body').on('click', '#approve', function () {
        console.log('fuunfsa')
        var approve_data_id   = $(this).data("id");
        var component_id = $('#component_id').val()
        var status       = $('#status').val()

        swal({
            title: 'Are you sure?',
            text: 'Are you sure recommend this data!',
            icon: 'warning',
            buttons: ["Cancel", "Yes!"],
        }).then(function(value) {
            if (value) {
              console.log('succes method')
              $.ajax({
                type: "GET",
                url: " {{ url('ajax/approve') }}"+'/'+approve_data_id,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    console.log(data)
                    swal("Recommended !", "Your imaginary file has been Recommended", "success");
                    var url = "/approval?component_id="+component_id+"&status="+status
                    window.location.assign(url)
                },
                error: function (data) {
                    console.log('Error:', data);
                    swal("Cancelled", "Something went wrong :)", "error");
                }
              });
            }
        });   
    });  


    $('body').on('click', '#dis-approve', function () {
        console.log('fuunfsa')
        var package_id = $(this).data("id");
        var component_id = $('#component_id').val()
        var status       = $('#status').val()
        
        swal({
            title: 'Disapprove?',
            text: 'Reason of disapprove !',
            content: "input",
            icon: 'warning',
            buttons: ["Cancel", "Yes!"],
        }).then(function(value) {
          console.log('name '+value)
            if (value) {
              console.log('succes method')
              $.ajax({
                type: "GET",
                url: " {{ url('ajax/dis_approve') }}"+'/'+package_id,
                data:{text:value},
                //dataType: "json",
                //headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    console.log(data)
                    swal("Disapproved !", "Your imaginary file has been disapproved", "success");
                    var url = "/approval?component_id="+component_id+"&status="+status
                    window.location.assign(url)
                },
                error: function (data) {
                  console.log('Error:', data);
                    //swal("Cancelled", "Something went wrong :)", "error");
                }
              });
            }
        });   
    });  

  }); 

  //$(".select2").select2();
  
</script>
@endpush