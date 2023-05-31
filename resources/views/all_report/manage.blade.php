@extends('layouts.master')
@section('content')

    {{-- <div class="sub-head header header2">
        <div class="container">
            @include('sweetalert::alert')
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
                    <div class="procurement-title">
                        <h5 class="d-inline">
                            <i class="fa fa-file-text-o" aria-hidden="true"></i> Package Wise Report
                        </h5>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <a class=" btn sub-btn float-right" href="{{ route('report.home') }}"><i class="fa fa-check"> </i>
                        Choose Package</a>
                    <a class=" btn sub-btn float-right" href="{{ url('dashboard/report') }}"><i class="fa fa-dashboard">
                        </i> Report Dashboard</a>
                    <a class=" btn sub-btn float-right"
                        href='{{ url('dashboard/package-wise-report/create?package_id=') . $package_id }}'><i
                            class="fa fa-plus"> </i> Add Report </a>
                    <a class=" btn sub-btn float-right"
                        href='{{ url('dashboard/package-report?package_id=') . $package_id }}'><i class="fa fa-dashboard">
                        </i> All Package Report </a>
                    <a class=" btn sub-btn float-right" href="{{ url('report-file-approve') }}"><i class="fa fa-check"> </i>
                        Report Approval</a>
                </div>
            </div>
        </div>
    </div> --}}
    @include('sweetalert::alert')
    @include('all_report.second_menu_tab')

    <div class="main-content mt-4">

        <section class="new-sec-1">
            <div class="container">

                <h4 class="card-title mt-2">Package Name: {{ $package_name->package_no }}--{{ $package_name->name_en }}</h4>

                <div class="package-table card card-body col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="table-responsive text-center" id="report_table">
                        <table class="table table-bordered bg-white report-table">
                            <thead>
                                <tr>
                                    <td width="5%" class="text-center">SL</td>
                                    <td width="15%">Category</td>
                                    <td width="10%">Date</td>
                                    <td width="25%">Report Name</td>
                                    {{-- <td width="23%">Reference</td>
                                    --}}
                                    <td width="7%">Status </td>
                                    <td width="12%">Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($files as $item)
                                    <tr>
                                        <td>{{ $loop->index + $files->firstItem() }} </td>
                                        <td class="text-left">{{ $item->title }}</td>
                                        <td class="text-center">{{ $item->date }}</td>
                                        <td class="text-left">{{ $item->name }}</td>
                                        {{-- <td class="text-left">{{ $item->description }}
                                        </td> --}}

                                        @if ($item->is_approve == 0)
                                            <td class="text-left"> Pending </td>
                                        @elseif($item->is_approve==1)
                                            <td class="text-left"> Approve </td>
                                        @else
                                            <td class="text-left"> Disapprove </td>
                                        @endif
                                        <td class="text-center">
                                            <form class="delete" action="{{ route('package_Report.delete', $item->id) }}"
                                                method="POST">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                                <a class="btn btn-info btn-sm mr-1"
                                                    href="{{ route('package_Report.show', $item->id) }}" title="Show"><i
                                                        class="fa fa-eye"></i> </a>

                                                {{-- @if (!$item->is_approve) --}}
                                                    <a class="btn btn-warning btn-sm  fa fa-edit "
                                                        href="{{ route('package_Report.edit', $item->id) }}"
                                                        title="Edit"></a>
                                                {{-- @endif --}}

                                                {{-- <a item="submit"
                                                    class=" btn btn-danger btn-xs" title="Delete"><i
                                                        class="fa fa-trash"></i></a> --}}

                                                <button item="submit" class="btn btn-danger btn-sm  fa fa-trash"
                                                    title="Delete"></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>

                        </table>
                        <div class="mt-4 text-center">
                            {{-- {{ $files->links() }} --}}
                            @if ($files->lastPage() > 1)
                                <nav>
                                    <ul class="pagination">
                                        <li class="page-item {{ $files->currentPage() == 1 ? ' disabled' : '' }}">
                                            <a class="page-link"
                                                href="{{ $files->url($files->currentPage() - 1) . '&package_id=' . $package_id }}"
                                                rel="next" aria-label="Next &raquo;">&lsaquo;</a>
                                        </li>
                                        @for ($i = 1; $i <= $files->lastPage(); $i++)
                                            <li class="page-item {{ $files->currentPage() == $i ? ' active' : '' }}">
                                                <a class="page-link"
                                                    href="{{ $files->url($i) . '&package_id=' . $package_id }}">{{ $i }}</a>
                                            </li>
                                        @endfor
                                        <li
                                            class="page-item {{ $files->currentPage() == $files->lastPage() ? ' disabled' : '' }}">
                                            <a class="page-link"
                                                href="{{ $files->url($files->currentPage() + 1) . '&package_id=' . $package_id }}"
                                                rel="next" aria-label="Next &raquo;">&rsaquo;</a>
                                        </li>
                                    </ul>
                                </nav>
                            @endif
                        </div>

                    </div>
                </div>

            </div>
        </section>

    </div>

@endsection

@push('script')
    <script>
        $(".delete").on("submit", function() {
            return confirm("Do you want to delete this Report?");
        });

    </script>
@endpush
