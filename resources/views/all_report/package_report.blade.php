@extends('layouts.master')
@section('content')


    @include('all_report.second_menu_tab')
    <div class="main-content mt-0 ">

        <section class="new-sec-1 pt-3">
            <div class="container">
                {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hom-sec-box px-0">
                    <a class="finance-das-box card box">
                        <div class="d-inline-flex">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <h4>Package Name: {{ $package_name->package_no }}--{{ $package_name->name_en }}</h4>
                            </div>
                        </div>
                    </a>
                </div> --}}
                <h4 class="card-title">Package Name: {{ $package_name->package_no }}--{{ $package_name->name_en }}</h4>
                <div class="row">
                    @foreach ($categories as $item)
                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 hom-sec-box">
                            <a class="finance-das-box card box report_tab" data-id="{{ $item->id }}">
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

                </div>

            </div>
        </section>
        <section class="new-sec-1 d-none" id="hide_section">
            <div class="container">
                <div class="package-table card card-body col-xs-12 col-sm-12 col-md-12 col-lg-12">


                    {{-- <form action="javascript:void(0)">
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
                    </form> --}}
                    <div class="table-responsive text-center" id="report_table">
                        @include('all_report.table')
                    </div>
                </div>

            </div>
        </section>
        <input type="text" value="{{ $package_id }}" id="hidden_package_id" hidden="">
    </div>

@endsection

@push('script')
    <script>
        $(document).ready(function() {

            // $('#addReport').click(function() {
            //     console.log('hi')
            // })
            var golobalCategoryId;

            $('body').on('click', '#addReport', function(e) {
                e.preventDefault();
                //var category_id = $("#category_id").val();

                var url =  $(this).attr('href');
                url = url + '&'+'category_id='+golobalCategoryId
                console.log(url)
                window.location.assign(url)
            })

           


            $('body').on('click', '.page-link', function(e) {
                e.preventDefault();
                var package_id = $("#package_id").val();
                var category_id = $("#category_id").val();
                var url = $(this).attr('href')
                console.log("pagination " + url)
                var url2 = url + '&package_id=' + package_id + '&category_id=' + category_id
                var package_id = $("#hidden_package_id").val();
                $.ajax({
                    method: 'GET',
                    url: url2,
                    success: function(data) {
                        console.log('success')
                        $('#report_table').html(data);
                    },
                    error: function(data) {}
                });
            });

            var catid;
            $('body').on('click', '.report_tab', function() {

                $('a').removeClass('active');
                $(this).addClass('active');
                var category_id = $(this).data("id");
                golobalCategoryId = category_id;
                var package_id = $("#hidden_package_id").val();

                //console.log("category " + category_id)

                $.ajax({
                    method: "get",
                    data: {
                        'package_id': package_id,
                        'category_id': category_id
                    },
                    url: " {{ url('ajax/package-wise-report-by-category') }}",
                    success: function(response) {
                        $('#hide_section').removeClass('d-none');
                        $(".select2").select2();
                        $('#report_table').html(response);
                    },
                    error: function(response) {
                        alert("Error");
                    }
                });
            });

            

            // $(document).on('click', '#paginationtraining a', function(event){
            //   event.preventDefault();
            //   var page = $(this).attr('href')
            //   console.log(page)
            //   //fetch_data(page,catid);
            // });


            //     $(document).on('click', '#paginationmonthlyprogress a', function(event){
            //       event.preventDefault();
            //       var page = $(this).attr('href').split('page=')[1];
            //       //alert(page);
            //       fetch_data(page,catid);
            //     });
            //     $(document).on('click', '#paginationprojectinfo a', function(event){
            //       event.preventDefault();
            //       var page = $(this).attr('href').split('page=')[1];
            //       //alert(page);
            //       fetch_data(page,catid);
            //     });

            //     $(document).on('click', '#paginationtrainingmanual a', function(event){
            //       event.preventDefault();
            //       var page = $(this).attr('href').split('page=')[1];
            //       //alert(page);
            //       fetch_data(page,catid);
            //     });
            //     $(document).on('click', '#paginationtrainingmaterial a', function(event){
            //       event.preventDefault();
            //       var page = $(this).attr('href').split('page=')[1];
            //       //alert(page);
            //       fetch_data(page,catid);
            //     });


            //  });

            $('body').on('click', '#filtering', function() {


                var catid = $('#category').val();
                var date = $("input[type='text']").val();
                var package_id = $("#hidden_package_id").val();
                var url = "{{ url('ajax/package-wise-report-by-filtering') }}";
                console.log("filter" + package_id)
                $.ajax({
                    method: "get",
                    url: url,
                    data: {
                        'catid': catid,
                        'date': date,
                        'package_id': package_id
                    },
                    success: function(response) {
                        $('#report_table').html(response);
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

    </script>
@endpush
