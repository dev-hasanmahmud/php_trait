@extends('layouts.master')
@section('content')

<div class="sub-head header header2">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
        <div class="procurement-title">
          <h5 class="d-inline">
            <i class="fa fa-window-restore" aria-hidden="true"></i> Data Acquisition Details
          </h5>                
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
      @if (isset($permission['AppImageController@create']))
        <a class=" btn sub-btn float-right" href="{{ route('app-image.create') }}" ><i class="fa fa-plus"> </i> Create Data Acquisition</a>
      @endif
      @if (isset($permission['AREReportController@index']))
        <a class=" btn sub-btn float-right" href="{{ url('are-reports') }}" ><i class="fa fa-plus"> </i> Data Acquisition ARE Report</a>
      @endif  
      </div>
    </div>
  </div>
</div>
   
    <div class="main-content mt-4 ">
    <div class="container">
      @include('sweetalert::alert')
    {{-- <div class="programme-title">
            <h3 class="d-inline">
              <img src="{{custom_asset('assets/images/programme.png')}}" alt="" /> Indicator Wise Progress
            </h3>
       
       <a href="{{ route('indicator_data.create') }}" type="submit" class="btn btn-success btn-sm d-inline fa fa-plus" title="Add Indicator Data"></a>

     </div> --}}

  <section class="package-table card card-body">

    <form  method="GET" action="{{ url('app-image') }}"  >
      <div class="form-row mb-2 row">
        @if(auth()->user()->role != 14 )
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
        @else 
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-5">
        @endif
          <select name="package_id" class="form-control form-control-sm select2 custom-select2">
            <option value="0">Select Package </option>
              @foreach ($package as $item)
                <option value="{{ $item->id }}" 
                  @if ($item->id == $search[0])
                    {{'selected= "selected" '}}
                  @endif
                  >{{ $item->package_no }}-{{ $item->name_en }}</option>
              @endforeach
          </select>
        </div>
        @if(auth()->user()->role != 14 )
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-2">
          <select name="user_id" class="form-control form-control-sm select2 custom-select2">
            <option value="0">Select Sender</option>
              @foreach ($user as $item)
                <option value="{{ $item->id }}" 
                  @if ($item->id == $search[1])
                    {{'selected= "selected" '}}
                  @endif
                  >{{ $item->name }}</option>
              @endforeach
          </select>
        </div>
        @endif
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-2">
            <select name="title_id" class="form-control form-control-sm select2 custom-select2">
              <option value="0">Select Activity</option>
                @foreach ($title as $item)
                  <option value="{{ $item->id }}" 
                    @if ($item->id == $search[2])
                      {{'selected= "selected" '}}
                    @endif
                    >{{ $item->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-1 col-lg-2">
            <div class="input-group datepicker-box">
                <input name="from_date"  class="form-control datepicker w-100" 
                    value="{{ $search[3] }}"
                    type="text" placeholder="From Date" />
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-1 col-lg-2">
            <div class="input-group datepicker-box">
                <input name="to_date"  class="form-control datepicker w-100" 
                    value="{{ $search[4] }}"
                    type="text" placeholder="To Date" />
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1">
          <button type="submit" class="btn btn-lg w-100 btn-info ">Find</button>
		    </div>
      </div>
    </form>
        <div class="table-responsive">
          <table class="table table-bordered bg-white">
            <thead>
              <tr>
                <td width="3%"  class="text-center">Id</td>
                <td width="25%" class="text-left">Package Name</td>
                <td width="13%" class="text-left">Activity </td>
                <td width="14%" class="text-left" >Data Sender</td>
                <td width="9%" class="text-left" >Date</td>
                <td width="8%" class="text-left" >Status</td>
                <td width="23%">Action</td>
              </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                <tr  class=" @if($item->is_publish==0 ) custom_class_for_color  @endif  ">
                    {{-- <td class="text-center  "  >{{ $loop->index+$data->firstItem()	}}</td> --}}
                    <td class="text-center  "  >{{ $item->id	}}</td>
                    <td class="text-left @if($item->is_publish==0 )   @endif  "  > {{isset($item->component->package_no)?$item->component->package_no.' '.$item->component->name_en:'-'}} </td>
                    <td class="text-left @if($item->is_publish==0 )  @endif  "  > {{isset($item->data_input_title->title)?$item->data_input_title->title:'-'}}</td>

                    <td class="text-left @if($item->is_publish==0 )   @endif  "  >{{isset($item->upload_by->name)?$item->upload_by->name:'-'}}</td>
                    <td class="text-left @if($item->is_publish==0 )   @endif "  >
                       {{ \Carbon\Carbon::parse( $item->created_at )->format('d M Y')  }}
                      </td>
                   

                    @if ( $item->is_publish==0 )
                      <td class="text-left @if($item->is_publish==0 ) text-danger  @endif " > Pending </td>
                    @elseif( $item->is_publish==1 )
                      <td class="text-left"  > Approve By DTL Pending For TL </td>    
                    @elseif( $item->is_publish==2  && (Auth::user()->role==1 || Auth::user()->role==6))
                      <td class="text-left"  > Recommended </td>
                    @else
                      <td class="text-left"  > Approved By TL </td>
                    @endif

                    {{-- <td class="text-center"  >  
                      @if(isset($permission['AppImageController@show']))
                        <a class="edit-service-type-modal btn btn-info btn-xs mr-1" href="{{route ('app-image.show',$item->id)}}" title="Show"><i class="fa fa-eye"></i> </a>
                      @endif

                     
                     
                      <a class="edit-service-type-modal btn btn-warning btn-xs"  href="{{route ('app-image.edit',$item->id)}}" title="Edit"><i class="fa fa-edit"></i>
                      </a> 
                     
                      <a href="javascript:void(0)" id="second_approve" data-id="{{ $item->id }}" class="edit-service-type-modal btn btn-success btn-xs" title="Approved"><i class="fa fa-check-circle" aria-hidden="true"></i> </a> 
         
                      <a href="javascript:void(0)" id="approve" data-id="{{ $item->id }}" class="edit-service-type-modal btn btn-info btn-xs" title="Approved"><i class="fa fa-check" aria-hidden="true"></i> </a> 
                       
                      <a href="javascript:void(0)" id="delete-user" data-id="{{ $item->id }}" class="edit-service-type-modal btn btn-danger btn-xs" title="Delete"><i class="fa fa-trash"></i></a> 
                      @endif

                    </td> --}}
                    
                    <td class="text-center"  >  
                      @if(isset($permission['AppImageController@show']))
                        <a class="edit-service-type-modal btn btn-info btn-xs mr-1" href="{{route ('app-image.show',$item->id)}}" title="Show"><i class="fa fa-eye"></i> </a>
                      @endif
                    @if( $editPermission[$item->id] )   
                      @if(isset($permission['AppImageController@edit']))
                        <a class="edit-service-type-modal btn btn-warning btn-xs"  href="{{route ('app-image.edit',$item->id)}}" title="Edit"><i class="fa fa-edit"></i>
                        </a> 
                      @endif

                      
                        @if( isset($permission['AppImageController@image_approve_second_layer']) && $item->is_publish==1 )
                        <a href="javascript:void(0)" id="second_approve" data-id="{{ $item->id }}" class="edit-service-type-modal btn btn-success btn-xs" title="Recommend"><i class="fa fa-check-circle" aria-hidden="true"></i> </a> 
                        @endif
                      
                        
                      @if( isset($permission['AppImageController@image_approve']) && $item->is_publish==0 )
                        <a href="javascript:void(0)" id="approve" data-id="{{ $item->id }}" class="edit-service-type-modal btn btn-info btn-xs" title="Recommend"><i class="fa fa-check" aria-hidden="true"></i> </a> 
                      @endif
                      
                      @if(isset($permission['AppImageController@destroy']))   
                        <a href="javascript:void(0)" id="delete-user" data-id="{{ $item->id }}" class="edit-service-type-modal btn btn-danger btn-xs" title="Delete"><i class="fa fa-trash"></i></a> 
                      @endif
                    @endif
                    </td>
                </tr>
               
                    
                @endforeach
              
           
            </tbody>
          </table>
          <div class="mt-4 text-center">{{ $data->links() }}</div>
        </div>
      </section>
  
    </div>
  </div>

  @php
    $url = "&package_id=".$search[0]."&user_id=".$search[1]."&title_id=".$search[2]."&from_date=".$search[3]."&to_date=".$search[4];
  @endphp

  <input type="text" hidden="" id="url" value="{{ $url }}">

@endsection

@push('script')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
$(document).ready(function () {

  $('body').on('click', '.page-link', function () {

    event.preventDefault(); 
    var url = $(this).attr('href')
    var url2 = $("#url").val()
    console.log(url+url2)
    window.location.assign(url+url2)

  });

  $('body').on('click', '#second_approve', function () {
        
        var approve_data_id   = $(this).data("id");

        console.log('fuunfsa  '+approve_data_id)

        swal({
            title: 'Are you sure?',
            text: 'Are you sure Recommend this data!',
            icon: 'warning',
            buttons: ["Cancel", "Yes!"],
        }).then(function(value) {
            if (value) {
              console.log('succes method')
              $.ajax({
                type: "GET",
                url: " {{ url('ajax/second_layer_app_image_approve') }}"+'/'+approve_data_id,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    console.log(data)
                    swal("Recommended !", "Your imaginary file has been Recommended", "success");
                    //var url = "/approval?component_id="+component_id+"&status="+status
                    let url = window.location.href
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

  $('body').on('click', '#approve', function () {
        
        var approve_data_id   = $(this).data("id");

        console.log('fuunfsa  '+approve_data_id)

        swal({
            title: 'Are you sure?',
            text: 'Are you sure Recommend this data!',
            icon: 'warning',
            buttons: ["Cancel", "Yes!"],
        }).then(function(value) {
            if (value) {
              console.log('succes method')
              $.ajax({
                type: "GET",
                url: " {{ url('ajax/app_image_approve') }}"+'/'+approve_data_id,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    console.log(data)
                    swal("Recommended !", "Your imaginary file has been Recommended", "success");
                    let url = window.location.href
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
   
    $('body').on('click', '#delete-user', function () {
        console.log('fuunfsa')
        var user_id = $(this).data("id");
        
        swal({
            title: 'Are you sure?',
            text: 'This record and it`s details will be permanantly deleted!',
            icon: 'warning',
            buttons: ["Cancel", "Yes!"],
        }).then(function(value) {
            if (value) {
              console.log('succes method')
              $.ajax({
                type: "DELETE",
                url: " {{ url('app-image') }}"+'/'+user_id,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    console.log(data)
                    swal("Deleted!", "Your imaginary file has been deleted.", "success");
                    let url = window.location.href
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
  }); 
  
</script>

@endpush



{{-- <form action="{{ route('indicator_data.destroy', $item->id)}}" method="post" class="delete">
  @csrf
  @method('DELETE')
  <a class="edit-service-type-modal btn btn-warning btn-xs"  href="{{route ('indicator_data.edit',$item->id)}}" title="Edit"><i class="fa fa-edit"></i>
  </a> 

  <button class="delete-service-type-modal btn btn-danger btn-xs" id="delete" title="Delete"><i class="fa fa-trash"></i> 
  </button>
</form>  --}}



