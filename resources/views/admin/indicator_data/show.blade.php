
@extends('layouts.master')
@section('content')
<div class="main-content form-component mt-4">
      <div class="container">
        @include('sweetalert::alert')
        <div class="card mb-5 card-design">
          <div class="card-body ">
            <div class="card-title bg-primary text-white text-center">
			  <h5>Indicator Data Details</h5>
            </div>
            <div>
			  
                <div class="payment-details-box form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="row">
							<h5>This data added by :</h5>
							<p>{{  isset($data->data_add_user->name)?$data->data_add_user->name:'-'}}</p>
						</div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="row">
							<h5>Package Name :</h5>
							<p>{{ $data->component->package_no.' - '.$data->component->name_en }}</p>
						</div>
                    </div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="row">
							<h5>Indicator Name :</h5>
							<p>{{ isset($data->indicator->name_en)? $data->indicator->name_en: '' }}</p>
						</div>
                    </div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="row">
							<h5>Progress Value in (%) :</h5>
							<p>{{ $data->progress_value }}</p>
						</div>
                    </div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="row">
							<h5>Achievement Quantity :</h5>
							{{-- <p>{{ convert_to_lakh($data->amount)  }} Lakh</p> --}}
							<p>{{ $data->achievement_quantity}}</p>
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
                            <h5>Status :</h5>
                            @if ($data->is_approve==0)
                            <p> Pending</p>
                            @elseif($data->is_approve==1)
                            <p>Approve by  <span class="font-weight-bold font-italic"> {{ $data->user->name }} </span> </p>    
                            @else
                            <p>Disapprove by <span class="font-weight-bold font-italic"> {{ $data->user->name }} </span> </p>   
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
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="row">
							<h5>Details :</h5> 
							<div class="table-responsive text-center">
								{!! $data->details !!}
							</div>

							{{-- <p>{!! $data->details !!}</p> --}}
							{{-- <td > {!!  $data->details  !!} </td> --}}
						</div>
                    </div>
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