@extends('layouts.master')
@section('content')
    
    <div class="sub-head header header2">
        <div class="container">
            @include('sweetalert::alert')
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
                    <div class="procurement-title">
                        <h5 class="d-inline">
                            <i class="fa fa-file-text-o" aria-hidden="true"></i>Reports Dashboard
                        </h5>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <a class=" btn sub-btn float-right" href='{{ url('dashboard/gis/create') }}'><i class="fa fa-plus"> </i>
                        Add Record </a>
                    <a class=" btn sub-btn float-right" href='{{ url('dashboard/report') }}'><i class="fa fa-dashboard"> </i>
                        Reports Dashboard</a>
                </div>
            </div>
        </div>
    </div>

    <div class="main-content mt-4">

        <section class="new-sec-1">
            <div class="container">
                <div class="package-table card card-body col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="table-responsive text-center" id="report_table">
                        <table class="table table-bordered bg-white report-table">
                            <thead>
                                <tr>
                                    <td width="5%">SL</td>
                                    <td width="15%">Category</td>
                                    <td width="10%">Date</td>
                                    <td width="30%">Report Name</td>
                                    <td width="30%">Reference</td>
                                    <td width="10%">Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($files as $item)
                                    <tr>
                                        <td>{{ $loop->index + $files->firstItem() }} </td>
                                        <td class="text-left">{{ $item->title }}</td>
                                        <td class="text-left">{{ $item->date }}</td>

                                        <td class="text-left">{{ $item->name }}</td>
                                        <td class="text-left">{{ $item->description }}</td>
                                        <td>
                                            <form class="delete" action="{{ route('gis.delete', $item->id) }}"
                                                method="POST">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <a class="btn btn-info btn-sm  fa fa-edit "
                                                    href="{{ route('gis.edit', $item->id) }}" title="Edit"></a>
                                                <button item="submit" class="btn btn-danger btn-sm  fa fa-trash"
                                                    title="Delete"></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>

                        </table>
                        <div class="mt-4 text-center">{{ $files->links() }}</div>
                    </div>
                </div>

            </div>
        </section>

    </div>

@endsection

@push('script')
    <script>
        $(".delete").on("submit", function() {
            return confirm("Do you want to delete this Record?");
        });

    </script>
@endpush
