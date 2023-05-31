@extends('layouts.master')
@section('content')
    <div class="sub-head header header2">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
                    <div class="procurement-title">
                        <h5 class="d-inline">
                            <i class="fa fa-sitemap" aria-hidden="true"></i> File Manager Category
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
            {{-- <div class="programme-title">
                <h3 class="d-inline">
                    <img src="{{ custom_asset('assets/images/programme.png') }}" alt="" /> Unit
                </h3>

                <a href="{{ route('unit.create') }}" type="submit" class="btn btn-success btn-sm d-inline fa fa-plus"
                    title="Add Unit"></a>

            </div> --}}


            <section class="package-table card card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <td width="10%" class="text-center">Serial No.</td>
                                <td width="25%">Category Name</td>
                                <td width="25%">Parent Category</td>
                                <td width="15%">Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i=1;
                            @endphp
                            @foreach ($categories as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->index + $categories->firstItem() }}</td>
                                    <td class="text-left">{{ $item->title }}</td>
                                    @if ($item->parent)
                                        <td class="text-left">{{ $item->parent->title }}</td>
                                    @else
                                        <td class="text-left">{{ '-' }}</td>
                                    @endif


                                    <td>
                                        <form class="delete"
                                            action="{{ route('file-manager-category.destroy', $item->id) }}" method="POST">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <a class="btn btn-info btn-sm  fa fa-edit "
                                                href="{{ route('file-manager-category.edit', $item->id) }}"
                                                title="Edit"></a>
                                            <button type="submit" class="btn btn-danger btn-sm  fa fa-trash"
                                                title="Delete"></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                    <div class="mt-4 text-center">{{ $categories->links() }}</div>
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
