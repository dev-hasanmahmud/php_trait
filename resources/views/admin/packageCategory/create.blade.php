@extends('layouts.master')
@push('cs')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        #sortable {
            list-style-type: none;
            margin: 0;
            padding: 0;
            width: 60%;
        }

        #sortable li {
            margin: 0 3px 3px 3px;
            padding: 0.4em;
            padding-left: 1.5em;
            font-size: 1.4em;
            height: 18px;
        }

        #sortable li span {
            position: absolute;
            margin-left: -1.3em;
        }

    </style>
@endpush

@section('content')
    <div class="sub-head header header2">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
                    <div class="procurement-title">
                        <h5 class="d-inline">
                            <i class="fa" aria-hidden="true"></i> Package Reports Category Order
                        </h5>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    {{-- <a class="active btn sub-btn float-right"
                        href="{{ route('contactor.create') }}"><i class="fa fa-plus"> </i> Add Contractor </a>
                    --}}

                </div>
            </div>
        </div>
    </div>
    <div class="main-content form-component mt-4 ">
        <div class="container">

            <h4 class="card-title">Package Name: {{ $package->package_no }}--{{ $package->name_en }}</h4>

            <div class="card mb-4 card-design">
                <div class="card-body">
                    <div class="card-title bg-primary text-white">
                        <h5>Package Reports Category Order</h5>
                    </div>
                    @include('sweetalert::alert')


                    <form action="{{ route('package-category-order.update', $categiryList[0]->package_id) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="form-row">

                            {{-- <div class="col-md-12 mb-3 " id="parent">
                                <label for="type">Select Package</label>
                                <select name="package_id" class="form-control form-control-sm select2 custom-select2"
                                    required="">
                                    <option value="0">Select Parent Category</option>
                                    @foreach ($packages as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->package_no . '-' . $item->name_en }}
                                        </option>
                                    @endforeach
                                </select>
                            </div> --}}



                            <div class="col-md-12 mb-3 " id="parent">
                                <label for="type">Add Report Category</label>
                                <select name="file_category_id[]" id="select2category"
                                    class="form-control form-control-sm select2 custom-select2" multiple required="">
                                    <option value="0">Select Parent Category</option>
                                    @foreach ($categories as $item)
                                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                                    @endforeach
                                </select>
                            </div>



                            <div class="text-right col-md-12 mb-3">
                                <a type="button" class="btn-lg btn btn-warning"
                                    href="{{ route('package-category-order.index') }}">Cancel</a>
                                <button class="btn-lg btn btn-primary" type="submit">Save</button>
                            </div>

                        </div>
                    </form>

                    <div class="alert alert-success alert-dismissible fade " role="alert" data-dismiss="alert"
                        aria-label="Close">
                        <strong>Package!</strong> Reports Category order updated successfully.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="">Sorting Report Category order</h5>

                                </div>
                                <div class="card-body">

                                    <ul class="list-group" id="sortable">
                                        @foreach ($ownCategory as $key => $value)
                                            <li class="list-group-item" data-id="{{ $value->id }}" id="list_id_{{ $key }}">
                                                {{ $value->title }}
                                            </li>
                                        @endforeach
                                    </ul>

                                    <button class="btn btn-success mt-3" id="save_order">Save Order</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')

    <script>
        var selectedValuesTest = <?php echo $list; ?>  // console.log(selectedValuesTest);
        $(document).ready(function() {


            $("#select2category").select2({
                multiple: true,
            });
            $('#select2category').val(selectedValuesTest).trigger('change');

            $("ul#sortable>li:odd").addClass("list-group-item-success");
            $("ul#sortable>li:even").addClass("list-group-item-light");

            $("#save_order").on("click", function(event) {
                var lists = $("ul#sortable").children();
                var categoryId = [];
                $.each(lists, function(key, value) {
                    var id = value.dataset.id;
                    categoryId.push(id);
                })

                id = <?php echo $categiryList[0]->package_id; ?>;            url = " {{ url('package-category-order') }}";
                console.log(url);
                $.ajax({
                    method: 'POST',
                    url: url,
                    data: {
                        'file_category_id': categoryId,
                        'package_id': id
                    },
                    dataType: 'JSON',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: (data) => {
                        console.log(data)
                        $('.alert').addClass('show');

                        setTimeout(() => {
                            $(".alert").alert('close')
                        }, 3000);
                    },
                    error: function(data) {}
                });

            });
        });

        $(function() {
            $("#sortable").sortable();
            $("#sortable").disableSelection();
        });

    </script>

@endpush
