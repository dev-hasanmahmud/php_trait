@extends('layouts.master')
@section('content')
    <div class="main-content inner-page-content mt-4 ">
        <div class="container">
            <section class="package">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 box">
                        <div class="card">
                            <h4 class="card-title">Package :
                                {{ $details->package_no ? $details->package_no : $details->name_en }}
                            </h4>
                            <div class="content card-body">
                                <h5 class="icon_blue">
                                    Component :
                                </h5>
                                <p>
                                    {{ $details->name_en }}
                                </p>

                                <h5 class="icon_blue mt-2">
                                    Over all Progress :
                                </h5>
                                <div class="progress mt-2">
                                    <div class="progress-bar" role="progressbar"
                                        style="width:{{ $total_perchantage }}%; color:white;" aria-valuenow="50"
                                        aria-valuemin="50" aria-valuemax="100">
                                        {{ number_format($total_perchantage, 2, '.', '') }}%
                                    </div>
                                </div>
                                <h5 class="icon_blue mt-3">
                                    Total Payment :
                                </h5>


                                <div class="progress mt-2">
                                    <a href="" data-toggle="modal" data-id="{{ $details->id }}"
                                        class="progress-bar all_payment" role="progressbar"
                                        style="width:{{ $total_payment_percentage }}%; color:white;" aria-valuenow="50"
                                        aria-valuemin="50" aria-valuemax="100">
                                        {{ number_format($total_payment_percentage, 2, '.', '') }}%
                                        {{--
                                </div> --}}
                                </a>
                            </div>
                            <!--h5 class="icon_green">
                                                                          Contractor :
                                                                          <span>M/S Monir Traders(JV)</span>
                                                                        </h5-->
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 box">
                    <div class="card" style="min-height:213px">
                        {{-- <h4 class="card-title">Area Of Activity</h4>
                        <div class="content card-body">
                            <p> hello </p> --}}
                            {{-- <div class="card"> --}}
                                <h4 class="card-title">Details</h4>
                                <div class="content card-body mt-0 pt-0 package_modal">
                                    <ul>
                                        {{-- <li><span> <i class="fa fa-snowflake-o"
                                                    aria-hidden="true"></i> Package No. : </span> {{ $details->package_no }}
                                        </li>
                                        <li>
                                            <span> <i class="fa fa-snowflake-o" aria-hidden="true"></i> Package Description
                                                :
                                            </span> {{ $details->name_en }}
                                        </li> --}}
                                        <li>
                                            <span> <i class="fa fa-snowflake-o" aria-hidden="true"></i> Unit : </span>
                                            {{ $details->unit->name_en }}
                                        </li>
                                        <li>
                                            <span> <i class="fa fa-snowflake-o" aria-hidden="true"></i> Quantity : </span>
                                            {{ $details->quantity }}
                                        </li>
                                        <li>
                                            <span> <i class="fa fa-snowflake-o" aria-hidden="true"></i> Procurement Method &
                                                Type : </span> {{ $details->proc_method->name_en }}
                                        </li>
                                        <li>
                                            <span> <i class="fa fa-snowflake-o" aria-hidden="true"></i> Contract Approving
                                                Authority : </span> {{ $details->approving_authority->name_en }}
                                        </li>
                                        <!--li>
                                                                                <span> <i class="fa fa-snowflake-o" aria-hidden="true"></i> Source of Funds : </span> - </li>
                                                                              <li>
                                                                                <span> <i class="fa fa-snowflake-o" aria-hidden="true"></i> Estd. Cost (Taka in Lac) : </span>
                                                                                1,000.00
                                                                              </li-->
                                        <li>
                                            <fieldset class="scheduler-border">
                                                <legend class="scheduler-border">Indicative Dates :
                                                </legend>
                                                <p>
                                                    {{-- <span>Invitation for Tender: </span>
                                                    22-Dec-19
                                                <p> --}}
                                                    <span>Signing of Contract: </span>
                                                    {{ $details->signing_of_contact_act }}
                                                <p>
                                                    <span>Completion of Contract: </span>
                                                    {{ $details->complition_of_contact_act }}
                                                </p>
                                            </fieldset>
                                        <li>
                                    </ul>
                                </div>
                                {{--
                            </div> --}}
                            {{--
                        </div> --}}
                    </div>
                </div>
        </div>
        </section>
        <input type="text" hidden name="component_id" id="component_id" value="{{ $details->id }}">

        <div class="ajax"></div>

        <section class="procurement-page procurement" id="tabs">

            <ul class="p-tab mt-2 nav-justified">
                <li><a href="javascript:void(0)" class=" progress_tab" data-id="1"> work in progress</a></li>
                <li><a href="javascript:void(0)" class="progress_tab " data-id="2">o&m</a></li>
                <li><a href="javascript:void(0)" class=" progress_tab" data-id="3">File/Report</a></li>
                {{-- <li><a href="javascript:void(0)" class="progress_tab "
                        data-id="4">component data</a></li> --}}
                <li><a href='x' class="progress_tab " data-id="5">gallery</a></li>
                <li><a href='x' class="progress_tab " data-id="6">Drawing & Design</a></li>
            </ul>
        </section>

        <section class="package-table card card-body">

            <div class="table-responsive" id="table_content">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <td width="21%" class="text-left">Progress Stage</td>
                            <td width="8%">Ave Weightage</td>
                            <td width="8%">Target</td>
                            <td width="12%">In Progress</td>
                            <td width="50%">Achievement in %</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($indicator_list as $r)
                            <tr>
                                <td><a href="" data-toggle="modal" data-id="{{ $r->id }}" class="indicatormodal">
                                        {{ $r->name_en }}</a></td>
                                <td>{{ $r->ave_weightage }}</td>
                                <td>{{ $r->target }}</td>
                                <td>
                                    @if (isset($indicator_data[$r->id]['qty']))
                                        {{ $indicator_data[$r->id]['qty'] }}
                                    @endif
                                </td>
                                <td>
                                    <div class="progress">
                                        @if (isset($indicator_data[$r->id]['achivement']))
                                            <div class="progress-bar" role="progressbar"
                                                style="width: {{ $indicator_data[$r->id]['achivement'] }}%;"
                                                aria-valuenow="{{ $indicator_data[$r->id]['achivement'] }}"
                                                aria-valuemin="{{ $indicator_data[$r->id]['achivement'] }}" aria-valuemax="100">
                                                {{ $indicator_data[$r->id]['achivement'] }}%
                                            </div>
                                        @else
                                            <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0"
                                                aria-valuemin="0" aria-valuemax="100">
                                                0%
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>


        </section>

        {{--
        <section class="procurement">
            <div class=" swiper-container-slider" id="tabs">
                <ul class="swiper-wrapper">
                    <li class="swiper-slide">
                        <a href="#tabs-1">
                            <div class="card sub-box">
                                <div class="card-header">
                                    <h5>
                                        Construction of Exploratory Drilling (Observation well)
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <p>
                                        31 observation tubewell will belongs in 06 Water
                                        Distribution zone (WDZ). Now 10 Observation Tubewells were
                                        completed Successfully
                                    </p>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="swiper-slide">
                        <a href="#tabs-2">
                            <div class="card sub-box">
                                <div class="card-header">
                                    <h5>
                                        Installation of 200 mm dia Production Tube Well (PTW)
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <p>
                                        Targeted Scheme is 06 WDZ, Every WDZ must have one PTW.
                                        Some WDZ have more than one. In Scheme WDZ 19.1, there are
                                        two PTW
                                    </p>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="swiper-slide">
                        <a href="#tabs-3">
                            <div class="card sub-box">
                                <div class="card-header">
                                    <h5>Supply and Installation of Solar pump solution</h5>
                                </div>
                                <div class="card-body">
                                    <p>
                                        Each PTW have Solar pump solution. So with in 6 WDZ there
                                        are 7 PTW. So 7 solar system pump will be generated
                                    </p>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="swiper-slide">
                        <a href="#tabs-4">
                            <div class="card sub-box">
                                <div class="card-header">
                                    <h5>
                                        Installation of 200 mm dia Production Tube Well (PTW)
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <p>
                                        Targeted Scheme is 06 WDZ, Every WDZ must have one PTW.
                                        Some WDZ have more than one. In Scheme WDZ 19.1, there are
                                        two PTW
                                    </p>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="swiper-slide">
                        <a href="#tabs-5">
                            <div class="card sub-box">
                                <div class="card-header">
                                    <h5>Supply and Installation of Solar pump solution</h5>
                                </div>
                                <div class="card-body">
                                    <p>
                                        Each PTW have Solar pump solution. So with in 6 WDZ there
                                        are 7 PTW. So 7 solar system pump will be generated
                                    </p>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="swiper-slide">
                        <a href="#tabs-6">
                            <div class="card sub-box">
                                <div class="card-header">
                                    <h5>
                                        Installation of 200 mm dia Production Tube Well (PTW)
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <p>
                                        Targeted Scheme is 06 WDZ, Every WDZ must have one PTW.
                                        Some WDZ have more than one. In Scheme WDZ 19.1, there are
                                        two PTW
                                    </p>
                                </div>
                            </div>
                        </a>
                    </li>
                    <!-- Add Pagination -->
                    <!-- <div class="swiper-pagination-slider"></div> -->
                </ul>

                <div id="tabs-1" class="procurement-tab">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <td width="10%">SL No.</td>
                                <td>Indicators 1</td>
                                <td>
                                    Title
                                </td>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>01</td>
                                    <td>
                                        Site selection
                                    </td>
                                    <td>23,423</td>
                                </tr>
                                <tr>
                                    <td>02</td>
                                    <td>
                                        Mobilization Date
                                    </td>
                                    <td>2,34,345</td>
                                </tr>
                                <tr>
                                    <td>03</td>
                                    <td>
                                        Demobilization Date
                                    </td>
                                    <td>35,656</td>
                                </tr>
                                <tr>
                                    <td>04</td>
                                    <td>
                                        Material tasting
                                    </td>
                                    <td>56,545</td>
                                </tr>
                                <tr>
                                    <td>05</td>
                                    <td>
                                        Drilling Start Date
                                    </td>
                                    <td>45,356</td>
                                </tr>
                                <tr>
                                    <td>06</td>
                                    <td>
                                        Drilling Completed date
                                    </td>
                                    <td>45,67,456</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="tabs-2" class="procurement-tab">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <td width="10%">SL No.</td>
                                <td>Indicators 2</td>
                                <td>
                                    Title
                                </td>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>01</td>
                                    <td>
                                        Site selection
                                    </td>
                                    <td><i class="fa fa-check text-success"></i></td>
                                </tr>
                                <tr>
                                    <td>02</td>
                                    <td>
                                        Mobilization Date
                                    </td>
                                    <td>Yes</td>
                                </tr>
                                <tr>
                                    <td>03</td>
                                    <td>
                                        Demobilization Date
                                    </td>
                                    <td>Done</td>
                                </tr>
                                <tr>
                                    <td>04</td>
                                    <td>
                                        Material tasting
                                    </td>
                                    <td>No</td>
                                </tr>
                                <tr>
                                    <td>05</td>
                                    <td>
                                        Drilling Start Date
                                    </td>
                                    <td><i class="fa fa-times text-danger"></i></td>
                                </tr>
                                <tr>
                                    <td>06</td>
                                    <td>
                                        Drilling Completed date
                                    </td>
                                    <td>25.00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="tabs-3" class="procurement-tab">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <td width="10%">SL No.</td>
                                <td>Indicators 3</td>
                                <td>
                                    Title
                                </td>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>01</td>
                                    <td>
                                        Site selection
                                    </td>
                                    <td><i class="fa fa-check text-success"></i></td>
                                </tr>
                                <tr>
                                    <td>02</td>
                                    <td>
                                        Mobilization Date
                                    </td>
                                    <td>Yes</td>
                                </tr>
                                <tr>
                                    <td>03</td>
                                    <td>
                                        Demobilization Date
                                    </td>
                                    <td>Done</td>
                                </tr>
                                <tr>
                                    <td>04</td>
                                    <td>
                                        Material tasting
                                    </td>
                                    <td>No</td>
                                </tr>
                                <tr>
                                    <td>05</td>
                                    <td>
                                        Drilling Start Date
                                    </td>
                                    <td><i class="fa fa-times text-danger"></i></td>
                                </tr>
                                <tr>
                                    <td>06</td>
                                    <td>
                                        Drilling Completed date
                                    </td>
                                    <td>25.00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="tabs-4" class="procurement-tab">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <td width="10%">SL No.</td>
                                <td>Indicators 4</td>
                                <td>
                                    Title
                                </td>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>01</td>
                                    <td>
                                        Site selection
                                    </td>
                                    <td><i class="fa fa-check text-success"></i></td>
                                </tr>
                                <tr>
                                    <td>02</td>
                                    <td>
                                        Mobilization Date
                                    </td>
                                    <td>Yes</td>
                                </tr>
                                <tr>
                                    <td>03</td>
                                    <td>
                                        Demobilization Date
                                    </td>
                                    <td>Done</td>
                                </tr>
                                <tr>
                                    <td>04</td>
                                    <td>
                                        Material tasting
                                    </td>
                                    <td>No</td>
                                </tr>
                                <tr>
                                    <td>05</td>
                                    <td>
                                        Drilling Start Date
                                    </td>
                                    <td><i class="fa fa-times text-danger"></i></td>
                                </tr>
                                <tr>
                                    <td>06</td>
                                    <td>
                                        Drilling Completed date
                                    </td>
                                    <td>25.00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="tabs-5" class="procurement-tab">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <td width="10%">SL No.</td>
                                <td>Indicators 5</td>
                                <td>
                                    Title
                                </td>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>01</td>
                                    <td>
                                        Site selection
                                    </td>
                                    <td><i class="fa fa-check text-success"></i></td>
                                </tr>
                                <tr>
                                    <td>02</td>
                                    <td>
                                        Mobilization Date
                                    </td>
                                    <td>Yes</td>
                                </tr>
                                <tr>
                                    <td>03</td>
                                    <td>
                                        Demobilization Date
                                    </td>
                                    <td>Done</td>
                                </tr>
                                <tr>
                                    <td>04</td>
                                    <td>
                                        Material tasting
                                    </td>
                                    <td>No</td>
                                </tr>
                                <tr>
                                    <td>05</td>
                                    <td>
                                        Drilling Start Date
                                    </td>
                                    <td><i class="fa fa-times text-danger"></i></td>
                                </tr>
                                <tr>
                                    <td>06</td>
                                    <td>
                                        Drilling Completed date
                                    </td>
                                    <td>25.00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="tabs-6" class="procurement-tab">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <td width="10%">SL No.</td>
                                <td>Indicators 6</td>
                                <td>
                                    Title
                                </td>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>01</td>
                                    <td>
                                        Site selection
                                    </td>
                                    <td><i class="fa fa-check text-success"></i></td>
                                </tr>
                                <tr>
                                    <td>02</td>
                                    <td>
                                        Mobilization Date
                                    </td>
                                    <td>Yes</td>
                                </tr>
                                <tr>
                                    <td>03</td>
                                    <td>
                                        Demobilization Date
                                    </td>
                                    <td>Done</td>
                                </tr>
                                <tr>
                                    <td>04</td>
                                    <td>
                                        Material tasting
                                    </td>
                                    <td>No</td>
                                </tr>
                                <tr>
                                    <td>05</td>
                                    <td>
                                        Drilling Start Date
                                    </td>
                                    <td><i class="fa fa-times text-danger"></i></td>
                                </tr>
                                <tr>
                                    <td>06</td>
                                    <td>
                                        Drilling Completed date
                                    </td>
                                    <td>25.00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
        </section>

        --}}
        {{-- <section class="package">
            <div class="box">
                <div class="card">
                    <h4 class="card-title">Procurement</h4>
                    <div class="conten card-body mt-0 pt-2 package_modal">
                        <ul>
                            <li><span> <i class="fa fa-snowflake-o" aria-hidden="true"></i> Package No. : </span>
                                {{ $details->package_no }}
                            </li>
                            <li>
                                <span> <i class="fa fa-snowflake-o" aria-hidden="true"></i> Package Description :
                                </span> {{ $details->name_en }}
                            </li>
                            <li>
                                <span> <i class="fa fa-snowflake-o" aria-hidden="true"></i> Unit : </span>
                                {{ $details->unit->name_en }}
                            </li>
                            <li>
                                <span> <i class="fa fa-snowflake-o" aria-hidden="true"></i> Quantity : </span>
                                {{ $details->quantity }}
                            </li>
                            <li>
                                <span> <i class="fa fa-snowflake-o" aria-hidden="true"></i> Procurement Method & Type :
                                </span> {{ $details->proc_method->name_en }}
                            </li>
                            <li>
                                <span> <i class="fa fa-snowflake-o" aria-hidden="true"></i> Contract Approving Authority :
                                </span> {{ $details->approving_authority->name_en }}
                            </li>
                            <!--li>
                                                                          <span> <i class="fa fa-snowflake-o" aria-hidden="true"></i> Source of Funds : </span> - </li>
                                                                        <li>
                                                                          <span> <i class="fa fa-snowflake-o" aria-hidden="true"></i> Estd. Cost (Taka in Lac) : </span>
                                                                          1,000.00
                                                                        </li-->
                            <li>
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border">Indicative Dates :
                                    </legend>
                                    <p>
                                        <span>Invitation for Tender: </span> 22-Dec-19
                                    <p>
                                        <span>Signing of Contract: </span> 19-Feb-20
                                    <p>
                                        <span>Completion of Contract: </span> 20-Jul-20
                                    </p>
                                </fieldset>
                            <li>
                        </ul>
                    </div>
                </div>
            </div>
        </section> --}}
    </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="name"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <section class="package-table">
                        <div class="table-responsive ">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <td width="13%">Date</td>
                                        <td>Progress</td>
                                        <td>Achievement</td>
                                        <td>Details</td>
                                    </tr>
                                </thead>
                                <tbody id="tablebody">

                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{-- end modal --}}

    <!--empty Modal -->
    <div class="modal fade " id="emptymodal" role="dialog">
        <div class="modal-dialog modal-dialog-centered">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="name">Indicator Data Empty</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <h4>There is no approved data available for this selected indicator. </h4>
                    </div>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>

                </div>

            </div>

        </div>
    </div>
    {{-- end modal --}}

    <!-- Modal -->
    <div class="modal fade" id="payment_Modal" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="name">Payment Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <section class="package-table">
                        <div class="table-responsive ">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <td width="13%">Date</td>
                                        <td class="text-left" id="contactor_name">Contractor Name</td>
                                        <td class="text-left">Source Of Fund</td>
                                        <td class="text-left">Payment Amount (BDT)</td>
                                    </tr>
                                </thead>
                                <tbody id="payment_tablebody">

                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{-- end modal --}}
@endsection


@push('script')
    <script>
        $(document).ready(function() {


            $body = $("body");

            $(document).on({
                ajaxStart: function() {
                    $body.addClass("loading");
                },
                ajaxStop: function() {
                    $body.removeClass("loading");
                }
            });


            $('body').on('click', '.progress_tab', function() {
                var component_id = $('#component_id').val();
                var id = $(this).data("id");
                //console.log($(this).data)
                //console.log('fuunfsa'+id+" "+component_id)
                if (id == 5) {
                    window.location.assign("/gallery?package_id=" + component_id)
                }
                if (id == 6) {
                    var link = "/dashboard/drawing-design-report?package_id=" + component_id
                    window.location.assign(link)
                }
                $.ajax({
                    type: "POST",
                    url: " {{ url('ajax/file_for_package_dashboard_page') }}",
                    data: {
                        "component_id": component_id,
                        "tab_id": id
                    },
                    dataType: 'JSON',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        console.log(data)
                        $('#table_content').html(data)
                    },
                    error: function(data) {
                        // console.log(data.responseText)
                        $('#table_content').html(data.responseText)
                    }
                });

            });


            $('body').on('click', '.all_payment', function() {
                console.log("all payment")
                var indicator_id = $(this).data('id');
                $.ajax({
                    type: "POST",
                    url: " {{ url('ajax/package_wise_payment') }}",
                    data: {
                        "indicator_id": indicator_id
                    },
                    // dataType:'JSON',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        var output = data.data
                        console.log(output)
                        payment_modal(data.data)
                        $body.removeClass("loading");
                        //$('#payment_tablebody').html(output);
                        //$('#payment_Modal').modal("show");
                    },
                    error: function(data) {
                        console.log(data)
                        $body.removeClass("loading");
                    }
                });
            });

            function payment_modal(data) {

                var output = ''
                var sumAmount = 0
                const formatter = new Intl.NumberFormat('en-BD', {
                    style: 'currency',
                    currency: 'BDT',
                    minimumFractionDigits: 2
                })
                var type=''
                $.each(data, function(key, value) {

                    //var details = data[i].details?data[i].details:'-';
                    sumAmount += (value.amount / 100000)
                    var date = date_format(value.date)
                    var amount = formatter.format(value.amount / 100000)
                    var contactor = value.contactor.name_en
                    var fund = value.source_of_fund.name_en
                    type = value.contactor.type ?value.contactor.type:type;
                    console.log(type);
                    output += ` <tr>
                                                                   
                        <td> ${date} </td>
                        <td class ="text-left" > ${contactor} </td>
                        <td class ="text-left" > ${fund} </td>
                        <td class ="text-left" > ${amount} Lakh </td>
                        </tr>
                        `;
                });
                sumAmount = formatter.format(sumAmount)
                output += ` <tr>
                                                                   
                    <td></td>
                    <td class ="text-left" >  </td>
                    <td class ="text-left" > Total Payment Amount </td>
                    <td class ="text-left" > ${sumAmount} Lakh </td>
                    </tr>
                    `;
                $('#payment_tablebody').html(output);

                $('#contactor_name').text(type);
                $('#payment_Modal').modal("show");
                console.log(sumAmount)
            }

            $('body').on('click', '.indicatormodal', function() {
                //$body = $("body");
                $("#loading").addClass("loading");
                var indicator_id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    url: " {{ url('ajax/indicator-details') }}",
                    data: {
                        "indicator_id": indicator_id
                    },
                    dataType: 'JSON',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {},
                    success: function(data) {
                        console.log(data)
                        if (!$.trim(data)) {
                            $('#emptymodal').modal("show");
                            $body.removeClass("loading");
                            die;
                        }
                        $('#name').html(data[0].indicator.name_en);
                        var output = '';

                        for (var i = 0; i < data.length; i++) {
                            var details = data[i].details ? data[i].details : '-';
                            var date = date_format(data[i].date)
                            var id = data[i].id
                            output += ` <tr>
                                                                   
                                                                    <td> ${date} </td>
                                                                    <td> ${data[i].progress_value} </td>
                                                                    <td> ${data[i].achievement_quantity} </td>
                                                                    <td class="text-center" > <a class="btn btn-info btn-xs mr-1 text-center" href="{{ url('/indicator_data/${id}') }}" > More Details</a> </td>
                                                                    </tr>
                                                                  `;
                        }
                        $('#tablebody').html(output);
                        $('#myModal').modal("show");
                    },
                    error: function(data) {
                        // console.log(data.responseText)
                        $body.removeClass("loading");
                        $('#table_content').html(data.responseText)
                    }

                });

            });

            function date_format(date1) {
                const date = new Date(date1)
                const dateTimeFormat = new Intl.DateTimeFormat('en', {
                    year: 'numeric',
                    month: 'short',
                    day: '2-digit'
                })
                const [{
                    value: month
                }, , {
                    value: day
                }, , {
                    value: year
                }] = dateTimeFormat.formatToParts(date)
                var new_date = `${day}-${month}-${year }`
                return new_date
            }
        });

    </script>

@endpush
