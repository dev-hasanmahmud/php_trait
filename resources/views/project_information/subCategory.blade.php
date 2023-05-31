@extends('layouts.master')
@section('content')
    <div class="sub-head header header2">
        <div class="container">
            @include('sweetalert::alert')
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
                    <div class="procurement-title">
                        <h5 class="d-inline">
                            <i class="fa fa-file-text-o" aria-hidden="true"></i> {{ $mainCategory->title }}
                        </h5>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <a class=" btn sub-btn float-right" href='{{ url('dashboard/emcrp-project-information-dphe') }}'><i
                            class="fa fa-dashboard"> </i> Project Information Dashboard </a>

                    <a class=" btn sub-btn float-right"
                        href='{{ url('dashboard/emcrp-project-information-dphe/create',$mainCategory->id) }}'><i class="fa fa-plus"> </i> Add
                        Record </a>
                    <a class=" btn sub-btn float-right"
                        href='{{ url('dashboard/emcrp-project-information-dphe/manage',$mainCategory->id) }}'><i class="fa fa-tasks"> </i>
                        Manage Record </a>
                </div>
            </div>
        </div>
    </div>
    <div class="main-content mt-0 ">

        <section class="new-sec-1 pt-3">
            <div class="container">
                <div class="row">
                    @foreach ($subCategories as $item)
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
                <div class="package-table card card-body col-xs-12 col-sm-12 col-md-12 col-lg-12" id="report_table">


                    {{-- @include('project_information.table')
                    --}}
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
                var package_id = $('#package_id').val();

                //url = url + '/' + package_id;
                console.log("pagination " + url)
                console.log(package_id)
                //var url =  " {{ url('ajax/dashboard/package-report?page=') }}"+page_no+'&'+'package_id='+package_id;
                $.ajax({
                    method: 'GET',
                    url: url,
                    // headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function(data) {
                        //console.log('success')
                        // console.log(data)
                        $('#report_table').html(data);
                    },
                    error: function(data) {
                        // console.log(data.responseText)
                        // $('#report_table').html(data.responseText);
                    }
                });

            });

            $('.report_tab').on('click', function() {

                $('a').removeClass('active');
                $(this).addClass('active');

                var catid = $(this).data("id");
                console.log(catid);
                $.ajax({
                    method: "get",
                    url: " {{ url('ajax/emcrp-project-information-dphe-by-category') }}" + '/' +
                        catid,
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


        });

    </script>
@endpush
