
@extends('layouts.master')
@section('content')
<div class="main-content form-component mt-4">
      <div class="container">
        @include('sweetalert::alert')
        <div class="card mb-5 card-design">
          <div class="card-body ">
            <div class="card-title bg-primary text-white text-center">
			  <h5>Report Details</h5>
            </div>
            <div>

                <div class="payment-details-box form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="row">
							<h5>This Report Upload By:</h5>
							<p>{{  $data->created_by}}</p>
						</div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="row">
							<h5>Package Name :</h5>
							<p>{{ $data->package_no.' - '.$data->name_en }}</p>
						</div>
                    </div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="row">
							<h5>Category Name :</h5>
							<p>{{ $data->title }}</p>
						</div>
                    </div>


					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="row">
							<h5>Date :</h5>
							<p>{{ $data->date }}</p>
						</div>
                    </div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="row">
							<h5>Details :</h5>
							<p>{{ $data->description }} </p>
						</div>
                    </div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="row">
                            <h5>Status :</h5>
                            @if ($data->is_approve==0)
                            <p> Pending</p>
                            @elseif($data->is_approve==1)
                            <p>Approve by  <span class="font-weight-bold font-italic"> {{ $data->approve_by }} </span> </p>
                            @else
                            <p>Disapprove by <span class="font-weight-bold font-italic"> {{ $data->approve_by }} </span> </p>
                            @endif
						</div>
                    </div>

                    @php
                    $fileName = explode('-.-',$data->file_path);
                    @endphp

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="row">
                            <h5>Report File :</h5>
                            @if ( !$data->is_image )
                                <p> <a href="{{ route('package_Report.file_manager.download',['fileManagerId'=>$data->id]) }}" target="_blank"> {{ $fileName[1] }} </a> </p>
                            @else

                            <img src="{{ asset($data->file_path) }}"
                            alt="preview image"  class="img-thumbnail rounded ml-4 " style="position:relative;z-index:1; margin-top: 5px; height:180px; width:25%;" >
                            @endif

                        </div>
                    </div>




                    @if ($data->is_approve==2)
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="row">
							<h5> Reason of Disapprove :</h5>
							<p>{{ isset($dissapprove_data->details)?$dissapprove_data->details:'-' }}</p>

						</div>
					</div>
                    @endif
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection


@push('script')

<script>



</script>

@endpush
