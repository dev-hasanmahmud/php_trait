@extends('layouts.master')
@section('content')
    <div class="sub-head header header2">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
                    <div class="procurement-title">
                        <h5 class="d-inline">
                            <img src="{{ custom_asset('assets/images/icons/fecal.png') }}" alt="" /> Package Settings
                        </h5>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <a class=" btn sub-btn float-right" href="{{ route('package.create') }}"><i class="fa fa-plus"> </i> Add
                        Package</a>
                    <a class="active btn sub-btn float-right" href="{{ url('package_settings') }}"><i class="fa fa-cogs">
                        </i> Package and reports Settings</a>
                </div>
            </div>
        </div>
    </div>

    <div class="main-content mt-4 ">
        <section class="new-sec-1">
            <div class="container">
                <div class="row">

                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 hom-sec-box">
                        <a class="card box" href="{{ url('type') }}">
                            <h4>Type</h4>
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 hom-sec-box">
                        <a class="card box" href="{{ url('unit') }}">
                            <h4>Unit</h4>
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 hom-sec-box">
                        <a class="card box" href="{{ url('procurement_method') }}">
                            <h4>Procurement Method</h4>
                        </a>
					</div>
					

                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 hom-sec-box">
                        <a class="card box" href="{{ url('aprroveauthotities') }}">
                            <h4>Approving Authority</h4>
                        </a>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 hom-sec-box">
                        <a class="card box" href="{{ url('source_of_fund') }}">
                            <h4>Source of Fund</h4>
                        </a>
					</div>
				</div>
				
				<div class="row">
                    <div class="col-12"><hr><h5>Reports Category Setting</h5><hr></div>
					<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 hom-sec-box">
                        <a class="card box" href="{{ url('file-manager-category') }}">
                            <h4>Add Reports Category</h4>
                        </a>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 hom-sec-box">
                        <a class="card box" href="{{ url('package-category-order') }}">
                            <h4>Package report ordering</h4>
                        </a>
                    </div>
				</div>
            </div>
        </section>
    </div>
@endsection
