@extends('layouts.master')
@section('content')

    <div class="sub-head header header2">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
                    <div class="procurement-title">
                        <h5 class="d-inline">
                            <i class="fa fa-window-restore" aria-hidden="true"></i> ARE Data Acquisition Report Details
                        </h5>
                    </div>
                </div>

                @php
                    // Generate URL For ARE Report Download
                    $areReportExportUrl = url('are-reports-download')."?package_id=".$search[0]."&user_id=".$search[1]."&from_date=".$search[2]."&to_date=".$search[3];
                @endphp

                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <a class="btn sub-btn float-right"
                       href="{{ $areReportExportUrl }}">
                        <i class="fa fa-download"> </i>
                        Export ARE Report
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="main-content mt-4 ">
        <div class="container">
            @include('sweetalert::alert')
            @if(auth()->user()->role != 14 )
                <form method="GET" action="{{ route('are-reports.index') }}">
                    <div class="form-row mb-2 row">

                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
                            <select name="package_id" class="form-control form-control-sm select2 custom-select2">
                                <option value="0">Select Package</option>
                                @foreach ($packages as $item)
                                    <option value="{{ $item->id }}"
                                    @if ($item->id == $search[0])
                                        {{'selected= "selected" '}}
                                        @endif
                                    >{{ $item->package_no }}-{{ $item->name_en }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
                            <select name="user_id"
                                    class="form-control form-control-sm select2 custom-select2">
                                <option value="0">Select ARE</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{$user->id == $search[1]?'selected':''}}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-1 col-lg-2">
                            <div class="input-group datepicker-box">
                                <input name="from_date" class="form-control datepicker w-100"
                                       value="{{ $search[2] }}"
                                       type="text" placeholder="From Date"/>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-1 col-lg-2">
                            <div class="input-group datepicker-box">
                                <input name="to_date" class="form-control datepicker w-100"
                                       value="{{ $search[3] }}"
                                       type="text" placeholder="To Date"/>
                            </div>
                        </div>


                        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                            <button type="submit" class="btn btn-lg w-100 btn-info ">Find</button>
                        </div>
                    </div>
                </form>
            @endif


            <section class="package-table card card-body">

                <div class="table-responsive">
                    <table class="table table-bordered bg-white">
                        <thead>
                        <tr>
                            <td width="5%" class="text-center">ID</td>
                            <td width="3%" class="text-center">Package No</td>
                            <td width="25%" class="text-left">Package Name</td>
                            <td width="10%" class="text-left">Title</td>
                            <td width="15%" class="text-left">Description</td>
                            <td width="8%" class="text-left">Location</td>
                            <td width="5%" class="text-left">Is Publish</td>
                            <td width="5%" class="text-left">Status</td>
                            <td width="10%" class="text-left">Date</td>
                            <td width="10%" class="text-left">Created At</td>
                        </thead>
                        <tbody>
                        @if($data->count()>0)
                            @foreach ($data as $item)
                                <tr class=" @if($item->is_publish==0 ) custom_class_for_color  @endif">
                                    <td class="text-center">{{ $item->id }}</td>
                                    <td class="text-center">{{ $item->component->package_no??"-"	}}</td>
                                    <td class="text-left"> {{ $item->component->name_en??"-" }} </td>
                                    <td class="text-left"> {{$item->data_input_title->title??'-'}}</td>
                                    <td class="text-left"> {{$item->description}}</td>
                                    <td class="text-left">
                                        <a target="_blank"
                                           href="{{ 'https://www.google.com/maps?q=' . $item->location }}">{{ $item->location }}</a>
                                    </td>
                                    <td class="text-left"> {{$item->is_publish??"-"}}</td>

                                    <td class="text-left @if($item->is_publish==0 ) text-danger  @endif ">
                                        {{getDataAcquisitionStatus($item->is_publish)}}
                                    </td>

                                    <td class="text-left">
                                        {{dateFormatter($item->date)}}
                                    </td>
                                    <td class="text-left">
                                        {{dateTimeFormatter($item->created_at)}}
                                    </td>
                                </tr>


                            @endforeach
                        @else
                            <tr>
                                <td width="100%" class="text-center" colspan="9">
                                    <h5 class="text-danger">No Acquisition Report For Selected ARE</h5>
                                </td>
                            </tr>
                        @endif

                        </tbody>
                    </table>
                    <!-- To Paginate Enable -->
                    {{--
                          <div class="mt-4 text-center">{{ $data->links() }}</div>--}}
                </div>
            </section>

        </div>
    </div>

    @php
        $url = "&package_id=".$search[0]."&user_id=".$search[1]."&from_date=".$search[2]."&to_date=".$search[3];
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
                console.log(url + url2)
                window.location.assign(url + url2)

            });
        });

    </script>

@endpush
