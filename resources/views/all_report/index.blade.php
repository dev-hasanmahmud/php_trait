@extends('layouts.master')
@section('content')

    <div class="sub-head header header2">
        <div class="container">
            @include('sweetalert::alert')
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
                    <div class="procurement-title">
                        <h5 class="d-inline">
                            <i class="fa fa-file-text-o" aria-hidden="true"></i> Reports Dashboard
                        </h5>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    {{-- <a class=" btn sub-btn float-right"
                        href="{{ url('dashboard/package-wise-report') }}"><i class="fa fa-check"> </i> Choose Package</a>
                    --}}

                    <a class=" btn sub-btn float-right" href="{{ url('dashboard/upload/all_report') }}"><i
                            class="fa fa-dashboard">
                        </i>Manage Reports</a>
                    <a class=" btn sub-btn float-right" href='{{ url('dashboard/gis/create') }}'><i class="fa fa-plus"> </i>
                        Add Reports </a>
                </div>
            </div>
        </div>
    </div>

    <div class="main-content mt-0 ">

        <section class="new-sec-1 pt-3">
            <div class="container">
                <div class="row">

                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 hom-sec-box">
                        <a class="finance-das-box card box " href="{{ url('/finance-dashboard') }}">
                            <div class="d-inline-flex">
                                <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
                                    <h4>Progress Reports (GOB)</h4>
                                </div>
                            </div>
                        </a>
                    </div>

                    @foreach ($categories as $item)
                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 hom-sec-box">
                            <a class="finance-das-box card box report_tab {{$item->id==request('reportId')?'active':''}}" data-id="{{ $item->id }}" >
                                <div class="d-inline-flex">
                                    <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
                                        <h4>{{ $item->title }}</h4>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                        <h4>
                                            @if (isset($file_count_array[$item->id]))
                                                {{ $file_count_array[$item->id] }}
                                            @else
                                                0
                                            @endif
                                        </h4>
                                    </div>
                                </div>
                            </a>
                        </div>
                        {{-- <div
                            class="report-sec col-xs-12 col-sm-6 col-md-3 col-lg-3 hom-sec-box">
                            <a class="card box report_tab" data-id="{{ $item->id }}">
                                <h4>{{ $item->title }}</h4>
                            </a>
                        </div> --}}
                    @endforeach
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 hom-sec-box">
                        <a class="finance-das-box card box" href="{{ url('dashboard/package-wise-report') }}">
                            <div class="d-inline-flex">
                                <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
                                    <h4>Package Wise Report</h4>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>

            </div>
        </section>

        @php
            $hideClass='d-none';
            if(request('reportId')){
                $hideClass='';
            }
        @endphp
        <section class="new-sec-1 {{$hideClass}}" id="hide_section">
            <div class="container">
                <div class="package-table card card-body col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <form action="javascript:void(0)">
                        <div class="form-row mb-2 row">

                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-6">
                                <select name="fm_category_id" id="category"
                                    class="form-control form-control-sm select2 custom-select2">
                                    <optgroup label="Select Package Type">
                                        @foreach ($categories as $item)
                                            <option value="{{ $item->id }}">{{ $item->title }}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-1 col-lg-5">
                                <div class="input-group datepicker-box">
                                    <input name="date" class="form-control datepicker w-100" value="{{ old('date') }}"
                                        type="text" placeholder="YY-MM-DD" />
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1">
                                <button type="submit" id="filtering" class="btn btn-lg w-100 btn-info ">Find</button>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive text-center" id="dashboard_table">
                        @include('gis.table')
                    </div>
                </div>

            </div>
        </section>

    </div>

@endsection

@push('script')
    <script>
        $(document).ready(function() {


            $('body').on('click', '.main-pagination', function() {

                var page_no = $(this).data('id')
                //var url = $("#url_"+page_no).val()
                var url = $(this).attr('action')
                console.log("pagination " + url)

                //var package_id = {{ $package_id }}
                //var url =  " {{ url('ajax/dashboard/package-report?page=') }}"+page_no+'&'+'package_id='+package_id;
                $.ajax({
                    method: 'GET',
                    url: url,
                    // headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function(data) {
                        console.log('success')
                        $('#dashboard_table').html(data);
                    },
                    error: function(data) {
                        // console.log(data.responseText)
                        // $('#report_table').html(data.responseText);
                    }
                });

            });

            var category_id;
            $('body').on('click', '.report_tab', function() {

                $('a').removeClass('active');
                $(this).addClass('active');

                var category_id = $(this).data("id");
                // var package_id= {{ $package_id }};
                console.log("category ")
                $.ajax({
                    method: "get",
                    data: {
                        // 'package_id': package_id,
                        'category_id': category_id
                    },
                    url: " {{ url('ajax/report-by-category') }}" + '/' + category_id,
                    // url: " {{ url('ajax/report-by-category') }}",
                    success: function(response) {
                        console.log('hide')
                        $('#hide_section').removeClass('d-none');
                        $(".select2").select2();
                        $('#dashboard_table').html(response);
                    },
                    error: function(response) {
                        alert("Error");
                    }
                });
            });

            $('body').on('click', '#filtering', function() {


                var catid = $('#category').val();
                var date = $("input[type='text']").val();
                var url = "{{ url('ajax/dashboard-report-filtering') }}";
                $.ajax({
                    method: "get",
                    url: url,
                    data: {
                        'catid': catid,
                        'date': date,
                        //'package_id': package_id
                    },
                    success: function(response) {
                        $('#dashboard_table').html(response);
                    },
                    error: function(response) {
                        alert("Error");
                        //$('#report_table').html(response.responseText);
                    }
                });
            });

            //  function fetch_data(page,catid){
            //    console.log(page+" "+catid)
            //    var url= "{{ url('ajax/dashboard-report-package-wise-pagination?page=') }}"+page+"&catid="+catid;
            //    var package_id = {{ $package_id }}
            //    console.log(url)
            //     $.ajax({
            //     data: {
            //       'catid':catid,
            //       'package_id':package_id
            //     },
            //     url: url,
            //     success:function(data)
            //     {
            //       if(catid==16){
            //          $('#inception').html(data);
            //       }
            //       if(catid==17){
            //          $('#monthly_progress').html(data);
            //       }
            //        if(catid==18){
            //          $('#project_completion').html(data);
            //       }
            //       if(catid==19){
            //          $('#manual').html(data);
            //       }
            //        if(catid==20){
            //          $('#material').html(data);
            //       }

            //     }
            //     });
            //   }
        });
        //  $(document).ready(function(){
        //    var catid;
        //    $('.report_tab').on('click',function(){

        //        $('a').removeClass('active');
        //        $(this).addClass('active');

        //       var catid = $(this).data("id");
        //      // var package_id= {{ $package_id }};
        //      // alert(package_id);
        //       $.ajax({
        //           method:"get",
        //           data: {
        //             'catid': catid
        //           },
        //           url: " {{ url('ajax/report-by-category') }}"+'/'+catid,
        //           success: function(response){
        //               $('#report_table').html(response);
        //           },
        //           error: function(response){
        //               alert("Error");
        //           }
        //       });
        //       $(document).on('click', '#paginationtraining a', function(event){
        //         event.preventDefault();
        //         var page = $(this).attr('href').split('page=')[1];
        //         //alert(page);
        //         fetch_data(page,catid);
        //       });

        //       $(document).on('click', '#paginationfinance a', function(event){
        //         event.preventDefault();
        //         var page = $(this).attr('href').split('page=')[1];
        //         //alert(page);
        //         fetch_data(page,catid);
        //       });
        //   });

        //    $('body').on('click','#submit',function(){

        //       var catid= $('#category').val();
        //       var date = $("input[type='text']").val();
        //       //var package_id= {{ $package_id }};
        //       var url= "{{ url('ajax/report-by-submit') }}";
        //       $.ajax({
        //           method: "get",
        //           url: url,
        //           data: {
        //               'catid': catid,
        //               'date': date
        //           },
        //           success: function(response){
        //               $('#report_table').html(response);
        //           },
        //           error: function(response){
        //               alert("Error");
        //           }
        //       });
        //         $(document).on('click', '#paginationtraining a', function(event){
        //         event.preventDefault();
        //         var page = $(this).attr('href').split('page=')[1];
        //         //alert(page);
        //         fetch_data(page,catid);
        //       });

        //       $(document).on('click', '#paginationfinance a', function(event){
        //         event.preventDefault();
        //         var page = $(this).attr('href').split('page=')[1];
        //         //alert(catid);
        //         fetch_data(page,catid);
        //       });
        //    });

        //   function fetch_data(page,catid)
        //     {
        //       $.ajax({
        //       data: catid,
        //       url:"/dashboard/report-pagination?page="+page+"&catid="+catid,
        //       success:function(data)
        //       {
        //         if(catid==1){
        //            $('#report_table').html(data);
        //         }
        //         if(catid==2){
        //            $('#finance_table').html(data);
        //         }
        //       }
        //       });
        //     }

        //  });

    </script>
@endpush
