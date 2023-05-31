@extends('layouts.master')
@section('content')

    <div class="sub-head header header2">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
                    <div class="procurement-title">
                        <h5 class="d-inline">
                            <img src="{{ custom_asset('assets/images/icons/fecal.png') }}" alt="" /> Package
                        </h5>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    @if (isset($permission['PackageController@create']))
                        <a class=" btn sub-btn float-right" href="{{ route('package.create') }}"><i class="fa fa-plus"> </i>
                            Add
                            Package</a>
                    @endif

                    @if (isset($permission['PackageController@package_settings']))
                        <a class=" btn sub-btn float-right" href="{{ url('package_settings') }}"><i class="fa fa-cogs"> </i>
                            Package Settings</a>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <div class="main-content form-component mt-4 ">
        <div class="container">

            @include('sweetalert::alert')
            {{-- <div class=" programme-title ">

                <a href="{{ url('package_settigns') }}">
                    <button type="button" class="btn  btn-info ">Package Settigs</button>
                </a>

                <a href="{{ route('package.create') }}">
                    <button type="button" class="btn  btn-info">Add Package</button>
                </a>

            </div> --}}


            <section class="package-table card card-body">

                <form method="GET" action="{{ url('search_package/') }}">
                    <div class="form-row mb-2 row">
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <input type="text" name="package_no" class="form-control" placeholder="Package Number">
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                            <input type="text" name="name_en" class="form-control" placeholder="Package name">
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <select name="type_id" id="type_id" class="form-control form-control-sm select2 custom-select2">
                                {{-- <optgroup label="Select Package Type">
                                    --}}
                                    @foreach ($type as $item)
                                        <option value="{{ $item->id }}" @if ($item->id == $type_id)
                                            {{ 'selected= "selected" ' }}
                                    @endif
                                    >{{ $item->name_en }}</option>

                                    @endforeach


                            </select>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1">
                            <button type="submit" class="btn btn-lg w-100 btn-info ">Find</button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="package_data">
                        @if ($component->isEmpty())
                            <h2>No Package Found for Your Search Query. </h2>
                        @else
                        <thead>
                            <tr>
                                <td width="5%" class="text-left">SL</td>
                                <td>Package Number</td>
                                <td class="text-left">Package Name</td>
                                <td>Package Type</td>
                                <td width="15%">Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($component as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->index + $component->firstItem() }} </td>
                                    <td class="text-left">{{ $item->package_no }}</td>
                                    <td class="text-left">{{ $item->name_en }}</td>
                                    <td>{{ isset($item->type->name_en) ? $item->type->name_en : $item->type }}</td>

                                    <td>

                                        {{-- <a
                                            class="edit-service-type-modal btn btn-warning btn-xs"
                                            href=' {{ url("package_working_progrss/$item->id/package_progrss") }}'
                                            title="Work Progress Package"><i class="fa fa-wrench"></i></a>
                                        --}}
                                        <a class="edit-service-type-modal btn btn-info btn-xs"
                                            href="{{ route('package.show', $item->id) }}" title="Show"><i class="fa fa-eye"></i>
                                        </a>
                                        @if (isset($permission['PackageController@edit']))
                                            <a class="edit-service-type-modal btn btn-warning btn-xs"
                                                href="{{ route('package.edit', $item->id) }}" title="Edit"><i
                                                    class="fa fa-edit"></i></a>
                                        @endif
                                        @if (isset($permission['PackageController@destroy']))
                                            <a href="javascript:void(0)" id="delete-user" data-id="{{ $item->id }}"
                                                class="delete-service-type-modal btn btn-danger btn-xs button delete-confirm"
                                                title="Delete"><i class="fa fa-trash"></i></a>
                                        @endif
                                    </td>
                                </tr>
                            @empty

                            @endforelse

                        </tbody>
                        @endif
                    </table>
                    <div class="text-center">{{ $component->links() }}</div>
                </div>
            </section>
        </div>
    </div>
@endsection


@push('script')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {


            // $('#type_id').change(function() {
            //     alert('hi');
            // });
            $('body').on('click', '#delete-user', function() {
                console.log('fuunfsa')
                var package_id = $(this).data("id");

                swal({
                    title: 'Are you sure?',
                    text: 'This record and it`s details will be permanantly deleted!',
                    icon: 'warning',
                    buttons: ["Cancel", "Yes!"],
                }).then(function(value) {
                    if (value) {
                        console.log('succes method')
                        $.ajax({
                            type: "DELETE",
                            url: " {{ url('package') }}" + '/' + package_id,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(data) {
                                console.log(data)
                                swal("Deleted!",
                                    "Your imaginary file has been deleted.",
                                    "success");
                                window.location.assign("/package")
                            },
                            error: function(data) {
                                console.log('Error:', data);
                                swal("Cancelled", "Something went wrong :)", "error");
                            }
                        });
                    }
                });
            });
        });

    </script>
@endpush
