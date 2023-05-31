@php
$url = Request::url() ;
$url = explode('/',$url);
@endphp

<div class="sub-head header header2">
    <div class="container">
        {{-- @include('sweetalert::alert') --}}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-2 pt-1">
                <div class="procurement-title">
                    <h5 class="d-inline">
                        <i class="fa fa-file-text-o" aria-hidden="true"></i> Package Wise Report
                    </h5>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-10">
                @if (isset($permission['PackagewiseReportController@package_home']))<a
                        class="btn sub-btn float-right @if (in_array('report', $url)) active @endif " href=" {{ route('report.home') }}"><i
                            class="fa fa-check"> </i> Choose Package</a>@endif

                @if (isset($permission['PackagewiseReportController@home']))<a
                        class="btn sub-btn float-right" href="{{ url('dashboard/report') }}"><i class="fa fa-dashboard">
                        </i> Report Dashboard</a>@endif

                @if (isset($permission['PackagewiseReportController@create']))<a id="addReport"
                        class=" btn sub-btn float-right @if (in_array('create', $url)) active @endif " href='{{ url('dashboard/package-wise-report/create?package_id=') . $package_id }}' id="addReport" ><i class="
                        fa fa-plus" > </i> Add Report </a>@endif

                @if (isset($permission['PackagewiseReportController@manage']))<a
                        class="btn sub-btn float-right @if (in_array('manage', $url)) active @endif " href='{{ url('dashboard/package-wise-report/manage?package_id=') . $package_id }}' ><i class="
                        fa fa-tasks"> </i> Manage Report </a>@endif

                @if (isset($permission['PackagewiseReportController@index']))<a
                        class=" btn sub-btn float-right @if (in_array('package-report', $url)) d-none @endif " href='{{ url('dashboard/package-report?package_id=') . $package_id }}' ><i class=" fa
                        fa-dashboard"> </i> All Package Report </a> @endif

                @if (isset($permission['ApprovalController@report_file_approve_index'])) <a
                        class="btn sub-btn float-right @if (in_array('report-file-approve',
                        $url)) active @endif " href=" {{ url('report-file-approve') }}"> <i
                            class="fa fa-check"> </i> Report Approval</a>@endif
            </div>
        </div>
    </div>
</div>
