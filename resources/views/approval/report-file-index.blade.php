@extends('layouts.master')
@section('content')

<div class="sub-head header header2">
    <div class="container">
        @include('sweetalert::alert')
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
          <div class="procurement-title">
            <h5 class="d-inline">
                <i class="fa fa-file-text-o" aria-hidden="true"></i> Report File Approve
            </h5>                
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
          <a class=" btn sub-btn float-right" href="{{ route('report.home') }}" ><i class="fa fa-check"> </i> Choose  Package</a>
          <a class=" btn sub-btn float-right" href="{{ url('dashboard/report') }}" ><i class="fa fa-dashboard"> </i> Report Dashboard</a>
          @if(isset($permission['ApprovalController@report_file_approve_index']))<a class="btn sub-btn float-right active " href="{{ url('report-file-approve') }}"> <i class="fa fa-check"> </i>Report Approval</a>@endif 	
        </div>
      </div>
    </div>
</div> 

<div class="main-content form-component mt-4 ">
  <div class="container">
    @include('sweetalert::alert')

    <section class="package-table card card-body">
        <form  method="GET" action="{{ url('report-file-approve/') }}"  >
        
        <div class="form-row mb-2 row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                <select name="package_id" class="form-control form-control-sm select2 custom-select2" id="package_id">
                    <option value="0">Select Package</option>
                    <optgroup>
                        @foreach ($package as $item)
                        <option value="{{ $item->id }}"
                            @if ($item->id==$search[2])
                                {{'selected= "selected" '}}
                            @endif
                            >{{ $item->package_no.'-'.$item->name_en }}</option>
                        @endforeach
                    </optgroup>
                </select>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                <select name="fm_id" class="form-control form-control-sm select2 custom-select2" id="fm_id">
                    <optgroup>
                        @foreach ($categories as $item)
                        <option value="{{ $item->id }}"
                            @if ($item->id==$search[0])
                                {{'selected= "selected" '}}
                            @endif
                            >{{ $item->title }}</option>
                        @endforeach
                    </optgroup>
                </select>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-3">
                {!! Form::select('status',['0'=>"Pending",'1'=>'Approved','2'=>'Disaproved'], old('area_of_activities',$search[1]), [  'class' => 'form-control form-control-sm select2 custom-select2', 'data-init-plugin'=>'select2', 'id' => 'status']) !!}
            
            </div>
            <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1">
            <button type="submit" class="btn btn-lg w-100 btn-info ">Find</button>
            </div>
        </div>
        </form>
        <div class="table-responsive">
            <table class="table table-bordered bg-white report-table  ">
                <thead>
                        <tr>
                            <td width="2%" class="text-left">SL</td>
                            <td width="21%" class="text-left">Package Name</td>
                            <td width="13%" class="text-left">Category</td>
                            <td width="15%" class="text-left">Report Name</td>
                            {{-- <td width="10%">Reference</td> --}}
                            <td width="9%">Date</td>
                            <td width="9%">View</td>
                            <td width="20%">Action</td>
                        </tr>
                </thead>       
                <tbody  >
                    @foreach ($files as $item)
                        <tr>
                            <td class="text-center" >{{ $loop->index+$files->firstItem() }}</td>
                            <td class="text-left" >{{ $item->package_no.'-'.$item->name_en}}</td>
                            <td class="text-left" >{{ $item->title}}</td>
                            <td class="text-left" >{{ $item->name}}</td>
                            {{-- <td class="text-left">{{ $item->description}}</td> --}}
                            <td>{{ $item->date}}</td>
                            <td >
                                <a  class="btn btn-outline-primary btn-xs group1"  href="{{ url($item->file_path) }}" target="_blank">
                                    <i class="fa fa-eye" aria-hidden="true"></i>View</a>
                            </td>
                            <td>
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
        <div class=" text-center">{{ $files->links() }}</div>
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
        var data_id = $(this).data("id");
        var package_id = $("#package_id").val()
        var fm_id      = $("#fm_id").val()
        var status     = $("#status").val()

        swal({
            title: 'Are you sure?',
            text: 'Are you sure recommended this file!',
            icon: 'warning',
            buttons: ["Cancel", "Yes!"],
        }).then(function(value) {
            if (value) {
              console.log('succes method')
              $.ajax({
                type: "GET",
                url: " {{ url('ajax/report-file-approve') }}"+'/'+data_id,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    console.log(data)
                    swal("Recommended !", "Your imaginary file has been recommended", "success");
                    var url = "/report-file-approve?package_id="+ package_id +"&fm_id="+ fm_id +"&status="+status
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
        var data_id = $(this).data("id");
        var package_id = $("#package_id").val()
        var fm_id      = $("#fm_id").val()
        var status     = $("#status").val()
        
        swal({
            title: 'Disapprove?',
            text: 'Reason of disapprove !',
            content: "input",
            icon: 'warning',
            buttons: ["Cancel", "Yes!"],
        }).then(function(value) {
            if (value) {
              console.log('succes method')
              $.ajax({
                type: "GET",
                url: " {{ url('ajax/report-file-dis_approve') }}"+'/'+data_id,
                data:{text:value},
                //headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    console.log(data)
                    swal("Disapproved !", "Your imaginary file has been disapproved", "success");
                    var url = "/report-file-approve?package_id="+ package_id +"&fm_id="+ fm_id +"&status="+status
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

    

    $('body').on('click', '.page-link', function () {
        event.preventDefault(); 
        var url = $(this).attr('href')
        var package_id = $('#package_id').val()
        var fm_id      = $('#fm_id').val()
        var status     = $('#status').val()
        var url = url+ "&package_id="+package_id+"&fm_id="+ fm_id+"&status="+status
        //console.log("pagination "+url)
        window.location.assign(url)
    });

}); 

  
  
</script>
@endpush