@extends('layouts.master')
@section('content')
<div class="sub-head header header2">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
          <div class="procurement-title">
            <h5 class="d-inline">
              <i class="fa fa-window-restore" aria-hidden="true"></i> Notifications Details
            </h5>                
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
         
          
        </div>
      </div>
    </div>
</div>
<div class="main-content form-component mt-4 ">

    <div class="container">

        <section class="package-table card card-body">

            <div class="table-responsive">
                <table class="table table-bordered bg-white">
                    <thead>
                        <tr>
                            <td width="10%"  class="text-center">Sl</td>
                            <td width="70%" class="text-left">Notification Message</td>
                            <td width="20%" class="text-center">Date </td>
                            
                        </tr>
                    </thead>
                        @foreach ($notification as $item)
                        <tr>
                            <td class="text-center">{{ $loop->index+$notification->firstItem() }} </td>
                            
                            <td class="text-left">
                                <a href="{{ $item->link }}">
                                    {{  $item->messege  }} 
                                </a>
                            </td>
                            
                            <td class="text-center">
                                {{ \Carbon\Carbon::parse( $item->created_at )->format('D, d M Y')  }}
                            </td>
                            
                        </tr>
                        @endforeach
                        
                    <tbody>


                    </tbody>
                </table>       
            </div>

            <div class="mt-4 text-center">{{ $notification->links() }}</div>

        </section>

    </div>
</div>
@endsection


@push('script')


@endpush