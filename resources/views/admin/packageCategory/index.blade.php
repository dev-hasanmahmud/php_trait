@extends('layouts.master')
@section('content')
    <div class="sub-head header header2">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
                    <div class="procurement-title">
                        <h5 class="d-inline">
                            <i class="fa fa-sitemap" aria-hidden="true"></i> Package Wise Category Order
                        </h5>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <a class=" btn sub-btn float-right" href="{{ route('file-manager-category.create') }}"><i
                            class="fa fa-plus"> </i> Add
                        Category</a>

                </div>
            </div>
        </div>
    </div>

    <div class="main-content mt-4 ">
        <div class="container">
            @include('sweetalert::alert')
            <section class="package-table card card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <td width="5%" class="text-center">Serial No.</td>
                                <td width="40%">Package Name</td>
                                {{-- <td width="25%">Parent Category</td>
                                --}}
                                <td width="15%">Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i=1;
                            @endphp
                            @foreach ($packages as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->index + $packages->firstItem() }}</td>
                                    <td class="text-left">{{ $item->package_no . ' ' . $item->name_en }}</td>



                                    <td>
                                        {{-- <a class="btn btn-warning btn-sm  fa fa-plus "
                                            href="{{ route('package-category-order.create', $item->id) }}"
                                            title="Add">Add</a> --}}
                                        <a class="btn btn-info btn-sm  fa fa-edit "
                                            href="{{ route('package-category-order.edit', $item->id) }}"
                                            title="Edit">Edit</a>
                                    </td>
                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                    <div class="mt-4 text-center">{{ $packages->links() }}</div>
                </div>
            </section>

        </div>
    </div>
@endsection

@push('script')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(".delete").on("submit", function() {
            return confirm("Do you want to delete this Type?");
        });

    </script>
@endpush
