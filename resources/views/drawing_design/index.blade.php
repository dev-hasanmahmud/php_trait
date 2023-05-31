@extends('layouts.master')
@section('content')

    <div class="sub-head header header2">
        <div class="container">
            @include('sweetalert::alert')
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
                    <div class="procurement-title">
                        <h5 class="d-inline">
                            <i class="fa fa-file-text-o" aria-hidden="true"></i> Drawing & Design
                        </h5>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    @if (isset($permission['DrawingDesignController@create']))
                        <a class=" btn sub-btn float-right"
                            href='{{ url('dashboard/drawing-design-report/create?package_id=') . $package_id }}'><i
                                class="fa fa-plus"> </i>
                            Add Record </a>
                    @endif

                    @if (isset($permission['DrawingDesignController@manage']))
                        <a class=" btn sub-btn float-right"
                            href='{{ url('dashboard/drawing-design-report/manage?package_id=') . $package_id }}'><i
                                class="fa fa-tasks">
                            </i> Manage Record </a>
                    @endif
                    {{-- <a class=" btn sub-btn float-right"
                        href='{{ url('dashboard/drawing-design-report?package_id=') . $package_id }}'><i
                            class="fa fa-dashboard"> </i> Drawing & Design Dashboard</a> --}}
                    <a class=" btn sub-btn float-right" href="{{ route('dd.home') }}"><i class="fa fa-check"> </i>
                        Choose
                        Package</a>
                </div>
            </div>
        </div>
    </div>

    <div class="main-content mt-0 ">

        <section class="new-sec-1 pt-3">
            <div class="container">
                {{-- <div class="card-body">
                    <form action="">
                        <div class="row show_package_box">
                            <div class="col-8">
                                <div class="form-group">
                                    <label for="package">
                                        <h4>Package Name</h4>
                                    </label>
                                    <h4>name</h4>
                                </div>
                            </div>
                        </div>

                    </form>
                </div> --}}
                <!--div class="row">
                                                                                                                                                     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hom-sec-box">
                                                                                                                                                           <a class="finance-das-box card box">
                                                                                                                                                           <div class="d-inline-flex">
                                                                                                                                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                                                                                                              </div>
                                                                                                                                                           </div>
                                                                                                                                                          </a>
                                                                                                                                                      </div>

                                                                                                                                                </div-->
                <h4 class="card-title">Package Name: {{ $package_name->package_no }}--{{ $package_name->name_en }}
                </h4>

                {{-- GIS Code --}}
                <div class="row">
                    @forelse ($categories as $item)

                        @if ((request('package_id') == 17 && $item->id == 42) || (request('package_id') == 18 && $item->id == 42))

                        @else
                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 hom-sec-box">
                                <a class="finance-das-box card box report_tab" data-id="{{ $item->id }}">
                                    <div class="d-inline-flex">
                                        <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
                                            <h4>{{ $item->title }}</h4>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                            {{-- GIS --}}
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
                        @endif

                        {{-- <div
                            class="report-sec col-xs-12 col-sm-6 col-md-3 col-lg-3 hom-sec-box">
                            <a class="card box report_tab" data-id="{{ $item->id }}">
                                <h4>{{ $item->title }}</h4>
                            </a>
                        </div> --}}
                    @empty

                    @endforelse
                </div>



                {{-- GIS Backup --}}


            </div>
        </section>
        <section class="new-sec-1 d-none" id="hide_section">
            <div class="container">
                <div class="package-table card card-body col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    {{-- <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <select name="fm_category_id" id="category"
                                        class="form-control form-control-sm select2 custom-select2">
                                        <option value="0">Select Category</option>
                                        @foreach ($categories as $item)
                                            <option value="{{ $item->id }}">{{ $item->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-1">OR</div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <div class="input-group datepicker-box">
                                        <input name="date" class="form-control datepicker w-100" value="{{ old('date') }}"
                                            type="text" placeholder="YY-MM-DD" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                            <button type="submit" id="submit" class="w-100 btn btn-lg btn-outline-success">Show
                                File</button>
                        </div>
                    </div> --}}

                    @include('drawing_design.table')
                </div>

            </div>
        </section>
        <input type="text" id="package_id" value="{{ $package_id }}" hidden="">
    </div>

@endsection

@push('script')
    <script>
        $(document).ready(function() {
            console.log('hi')
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
                        console.log('success')
                        console.log(data)
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
                var package_id = $('#package_id').val();

                console.log(package_id);
                $.ajax({
                    method: "get",
                    data: {
                        'package_id': package_id,
                        'catid': catid
                    },
                    url: " {{ url('ajax/drawing-design-report-by-category') }}" + '/' + catid +
                        '/' + package_id,
                    success: function(response) {
                        $('#hide_section').removeClass('d-none');
                        $(".select2").select2();
                        //console.log(response)
                        $('#report_table').html(response);
                    },
                    error: function(response) {
                        alert("Error");
                    }
                });
            });

            $('body').on('click', '#submit', function() {

                var catid = $('#category').val();
                var date = $("input[type='text']").val();
                var package_id = $('#package_id').val()
                var url = "{{ url('ajax/drawing-design-report-by-submit') }}";
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
                    }
                });
            });

        });
    </script>


@endpush
