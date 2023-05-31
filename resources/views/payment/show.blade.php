@extends('layouts.master')
@section('content')
    <div class="main-content form-component mt-4">
        <div class="container">
            @include('sweetalert::alert')
            <div class="card mb-5 card-design">
                <div class="card-body ">
                    <div class="card-title bg-primary text-white text-center">
                        <h5>Payment Details</h5>
                    </div>
                    <div>

                        <div class="payment-details-box form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="row">

                                    @if ($payment->is_package)
                                        <h5>Package Name :</h5>
                                        <p class="text-left">
                                            {{ isset($payment->component->name_en) ? $payment->component->package_no . ' - ' . $payment->component->name_en : null }}
                                        </p>
                                    @else
                                        <h5>Financial Item Name:</h5>
                                        <p class="text-left">
                                            {{ isset($payment->fiancial_item->item_name) ? $payment->fiancial_item->economic_code . ' ' . $payment->fiancial_item->item_name : null }}
                                        </p>
                                    @endif

                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="row">
                                    <h5>Contactor Name :</h5>
                                    <p>{{ $payment->contactor->name_en }}</p>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="row">
                                    <h5>Source of Fund:</h5>
                                    <p>{{ $payment->source_of_fund->name_en }}</p>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="row">
                                    <h5>Amount :</h5>
                                    {{-- <p>{{ convert_to_lakh($payment->amount) }} Lakh</p>
                                    --}}
                                    <p> {{ number_format(convert_to_lakh($payment->amount), 2, '.', ',') }} Lakh</p>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="row">
                                    <h5>Date :</h5>
                                    <p>{{ $payment->date }}</p>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="row">
                                    <h5>Quantity :</h5>
                                    <p>{{ $payment->quantity }} </p>
                                </div>
                            </div>
                            {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="row">
                                    <h5>Reference :</h5>
                                    <p>{{ $payment->details }}</p>
                                </div>
                            </div> --}}


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
